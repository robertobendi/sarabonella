// scripts/admin-smoke-test.mjs — drive the admin end to end against a local
// server and check that an edit actually reaches the public page.
//
//   php scripts/setup-admin.php && php scripts/seed-content.php
//   php -S 127.0.0.1:8123 -t .
//   npx playwright-core@latest install chromium   # once
//   node scripts/admin-smoke-test.mjs
//
// It edits seeded content and puts it back; run it against a development
// database, not a live one.

import { chromium } from 'playwright-core';
const B = 'http://127.0.0.1:8123';
const b = await chromium.launch();
const c = await b.newContext({ viewport: { width: 1400, height: 1000 } });
const p = await c.newPage();
const errs = [];
p.on('pageerror', e => errs.push('pageerror: ' + e.message));
p.on('response', r => { if (r.status() >= 500) errs.push(r.status() + ' ' + r.url()); });
let pass = 0, fail = 0;
const step = async (name, fn) => {
  try { await fn(); console.log('PASS  ' + name); pass++; }
  catch (e) { console.log('FAIL  ' + name + ' :: ' + e.message.split('\n')[0]); fail++; }
};

// The entry form's own submit, not the sign-out button that also sits in a form.
const saveEntry = async () => {
  const btn = await p.$('form[action*="/admin/collections/"] button[type=submit]');
  if (!btn) throw new Error('no save button in the entry form');
  await Promise.all([p.waitForNavigation({ waitUntil: 'networkidle' }).catch(() => {}), btn.click()]);
};
const editLinks = async coll => {
  await p.goto(B + '/admin/collections/' + coll, { waitUntil: 'networkidle' });
  const hrefs = await p.$$eval('a[href]', a => a.map(x => x.getAttribute('href')));
  const re = new RegExp('/admin/collections/' + coll + '/\\d+$');
  const edit = [...new Set(hrefs.filter(h => re.test(h)))];
  if (!edit.length) throw new Error('no edit links');
  return { href: edit[0], count: edit.length, all: edit };
};

await step('login page loads', async () => {
  await p.goto(B + '/admin/login', { waitUntil: 'networkidle' });
  if (!(await p.$('input[name=email]'))) throw new Error('no email field');
});
await step('login with the default credentials', async () => {
  await p.fill('input[name=email]', 'admin@sarabonella.local');
  await p.fill('input[name=password]', 'sarabonella-admin');
  await Promise.all([p.waitForNavigation({ waitUntil: 'networkidle' }), p.click('form[action*="login"] button[type=submit]')]);
  if (await p.$('input[name=password]')) throw new Error('still on the login form');
});
await step('dashboard lists the collections', async () => {
  const txt = await p.textContent('body');
  for (const want of ['Publications', 'Research areas']) if (!txt.includes(want)) throw new Error('missing ' + want);
});
let first;
await step('publications list shows the 6 seeded entries', async () => {
  const r = await editLinks('publications');
  // Pick a known seeded entry by title: whatever sorts first is not guaranteed
  // to be one of them, and an unfeatured entry never reaches the public list.
  for (const href of r.all) {
    await p.goto(B + href, { waitUntil: 'networkidle' });
    if ((await p.inputValue('[name="title"]')).startsWith('Inferring free-energy')) { first = href; break; }
  }
  if (!first) throw new Error('seeded entry not found');
  if (r.count !== 6) throw new Error('expected 6, saw ' + r.count);
});
await step('research areas list shows the 4 seeded entries', async () => {
  const r = await editLinks('research_areas');
  if (r.count !== 4) throw new Error('expected 4, saw ' + r.count);
});
await step('edit form exposes every publication field', async () => {
  await p.goto(B + first, { waitUntil: 'networkidle' });
  for (const f of ['title', 'image', 'image_alt', 'display_order', 'featured', 'doi_url', 'year', 'authors', 'venue'])
    if (!(await p.$('[name="' + f + '"]'))) throw new Error('no field ' + f);
});
await step('seeded entry is published and featured', async () => {
  if (await p.inputValue('[name="_status"]') !== 'published') throw new Error('not published');
  if (!(await p.isChecked('[name="featured"]'))) throw new Error('not featured');
});
await step('editing the title round-trips and reaches the public page', async () => {
  const before = await p.inputValue('[name="title"]');
  await p.fill('[name="title"]', before + ' ZZTEST');
  await saveEntry();
  await p.goto(B + first, { waitUntil: 'networkidle' });
  const saved = await p.inputValue('[name="title"]');
  if (!saved.includes('ZZTEST')) throw new Error('the form did not persist the edit');
  const pub = await c.newPage();
  await pub.goto(B + '/publications?cb=' + Date.now(), { waitUntil: 'networkidle' });
  const seen = (await pub.textContent('body')).includes('ZZTEST');
  await pub.close();
  if (!seen) throw new Error('saved, but not visible on /publications');
});
await step('reverting restores the public page', async () => {
  await p.goto(B + first, { waitUntil: 'networkidle' });
  const t = await p.inputValue('[name="title"]');
  await p.fill('[name="title"]', t.replace(' ZZTEST', ''));
  await saveEntry();
  const pub = await c.newPage();
  await pub.goto(B + '/publications?cb=' + Date.now(), { waitUntil: 'networkidle' });
  const seen = (await pub.textContent('body')).includes('ZZTEST');
  await pub.close();
  if (seen) throw new Error('revert did not take');
});
await step('changing the card image changes the public page', async () => {
  await p.goto(B + first, { waitUntil: 'networkidle' });
  const before = await p.inputValue('[name="image"]');
  await p.fill('[name="image"]', '/uploads/publications/pub-osscar.webp');
  await saveEntry();
  const pub = await c.newPage();
  await pub.goto(B + '/publications?cb=' + Date.now(), { waitUntil: 'networkidle' });
  // Match the card by its own heading: index 0 is a different publication.
  const src = await pub.$$eval('.selected-paper', (cards, want) => {
    const card = cards.find(el => (el.querySelector('h3')?.textContent || '').startsWith(want));
    return card ? card.querySelector('img')?.getAttribute('src') : 'card not found';
  }, 'Inferring free-energy');
  await pub.close();
  await p.goto(B + first, { waitUntil: 'networkidle' });
  await p.fill('[name="image"]', before);
  await saveEntry();
  if (src !== '/uploads/publications/pub-osscar.webp') throw new Error('image not applied, got ' + src);
});
await step('unpublishing removes it from the public page', async () => {
  await p.goto(B + first, { waitUntil: 'networkidle' });
  const title = await p.inputValue('[name="title"]');
  await p.selectOption('[name="_status"]', 'draft');
  await saveEntry();
  await p.goto(B + first, { waitUntil: 'networkidle' });
  const nowStatus = await p.inputValue('[name="_status"]');
  const pub = await c.newPage();
  await pub.goto(B + '/publications?cb=' + Date.now(), { waitUntil: 'networkidle' });
  const gone = !(await pub.textContent('body')).includes(title.slice(0, 40));
  await pub.close();
  if (nowStatus !== 'draft') { await p.goto(B + first, { waitUntil: 'networkidle' }); throw new Error('status did not persist, still ' + nowStatus); }
  await p.goto(B + first, { waitUntil: 'networkidle' });
  await p.selectOption('[name="_status"]', 'published');
  await saveEntry();
  if (!gone) throw new Error('draft still public');
});
await step('creating and deleting an entry works', async () => {
  await p.goto(B + '/admin/collections/publications/new', { waitUntil: 'networkidle' });
  await p.fill('[name="title"]', 'Temporary test entry');
  const stamp = 'tmp-' + Math.floor(Math.random()*1e6);
  await p.fill('[name="slug"]', stamp);
  await saveEntry();
  // Creating redirects to the collection list, so find the new entry by its
  // title. Taking the last link once deleted a seeded publication instead.
  const r = await editLinks('publications');
  if (r.count !== 7) throw new Error('create did not add an entry (' + r.count + ')');
  let target = null;
  for (const href of r.all) {
    await p.goto(B + href, { waitUntil: 'networkidle' });
    if ((await p.inputValue('[name="title"]')) === 'Temporary test entry') { target = href; break; }
  }
  if (!target) throw new Error('created entry not found');
  // The Delete button sits inside the save form and targets the delete form
  // via its form attribute, so it is found by label rather than by ancestor.
  const del = await p.$('button:has-text("Delete")');
  if (!del) throw new Error('no delete button');
  p.on('dialog', d => d.accept());
  await Promise.all([p.waitForNavigation({ waitUntil: 'networkidle' }).catch(() => {}), del.click()]);
  const after = await editLinks('publications');
  if (after.count !== 6) throw new Error('delete did not remove it (' + after.count + ')');
});
await step('media library loads', async () => {
  await p.goto(B + '/admin/media', { waitUntil: 'networkidle' });
  if (!(await p.$('body'))) throw new Error('no body');
});
await step('settings page loads', async () => {
  await p.goto(B + '/admin/settings', { waitUntil: 'networkidle' });
  if (!(await p.$('form'))) throw new Error('no form');
});
console.log('\n' + pass + ' passed, ' + fail + ' failed');
console.log('server 5xx: ' + (errs.length ? errs.join(' | ') : 'none'));
await b.close();
