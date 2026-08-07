<?php

declare(strict_types=1);

/**
 * scripts/seed-content.php — put the site's content into the database.
 *
 * The theme was built with its copy written straight into the Twig templates,
 * which meant the admin had nothing to edit: every list fell back to a
 * hardcoded block because no entries existed. This seeds those blocks as real
 * entries so they can be edited, reordered, unpublished or added to from
 * /admin without touching a template.
 *
 * Idempotent: entries are matched on collection + slug and updated in place,
 * so running it again after editing content will overwrite those entries back
 * to the seeded values. Run it once on a new install, not on a live site.
 *
 *   php scripts/seed-content.php            # seed content
 *   php scripts/seed-content.php --status   # report what is in the database
 */

use Pebblestack\Core\App;
use Pebblestack\Services\EntryRepository;

$root = dirname(__DIR__);
require $root . '/vendor/autoload.php';

$app = new App($root);
$repo = new EntryRepository($app->db);

/** Insert or update by slug so the script can be re-run. */
$put = static function (string $collection, string $slug, array $data) use ($repo): string {
    $existing = $repo->findBySlug($collection, $slug);
    if ($existing !== null) {
        $repo->update($existing->id, $slug, 'published', $data, null);
        return 'updated';
    }
    $repo->create($collection, $slug, 'published', $data, null);
    return 'created';
};

/* ---------------------------------------------------------------- publications
   Every field the publication cards and the detail pages read. The images are
   diagrams of each paper's subject drawn in the site's palette — replace any of
   them from the admin by pointing `image` at another file. */
$publications = [
    [
        'slug' => 'electrically-driven-first-order-phase-transition-2d-ionic-crystal',
        'title' => 'Electrically driven first-order phase transition of a 2D ionic crystal at the electrode/electrolyte interface',
        'authors' => 'F. Angiolari, A. Coretti, M. Salanne & S. Bonella',
        'venue' => 'Proceedings of the National Academy of Sciences 122',
        'year' => 2025,
        'doi_url' => 'https://doi.org/10.1073/pnas.2520026122',
        'category' => 'Electrochemical interfaces',
        'image' => '/uploads/publications/pub-electrode-interface.webp',
        'image_alt' => 'Diagram: ions ordering into a two-dimensional lattice against a charged electrode surface',
        'featured' => true,
        'display_order' => 1,
    ],
    [
        'slug' => 'mass-zero-constrained-molecular-dynamics-electrostatic-interactions',
        'title' => 'mass-zero constrained molecular dynamics for electrostatic interactions',
        'authors' => 'F. Troni, D. Grassano, J. Narayan, B. Roux & S. Bonella',
        'venue' => 'The Journal of Chemical Physics 163',
        'year' => 2025,
        'doi_url' => 'https://doi.org/10.1063/5.0283356',
        'category' => 'Molecular simulation',
        'image' => '/uploads/publications/pub-mass-zero.webp',
        'image_alt' => 'Diagram: massive sites joined by rigid constraints to the mass-zero sites that carry the electrostatics',
        'featured' => true,
        'display_order' => 2,
    ],
    [
        'slug' => 'a-tale-of-two-codes-cuda-vs-openacc',
        'title' => 'A tale of two codes: CUDA vs OpenACC for mass-zero constrained dynamics',
        'authors' => 'A. Vignolo et al.',
        'venue' => 'International Journal of High Performance Computing Applications',
        'year' => 2025,
        'doi_url' => 'https://doi.org/10.1177/10943420251331673',
        'category' => 'Open tools & infrastructure',
        'image' => '/uploads/publications/pub-cuda-openacc.webp',
        'image_alt' => 'Diagram: two compute grids side by side, the same work mapped onto them at different occupancy',
        'featured' => true,
        'display_order' => 3,
    ],
    [
        'slug' => 'jupyter-widgets-and-extensions-for-education-and-research',
        'title' => 'Jupyter widgets and extensions for education and research in computational physics and chemistry',
        'authors' => 'D. Du et al.',
        'venue' => 'Computer Physics Communications 305',
        'year' => 2024,
        'doi_url' => 'https://doi.org/10.1016/j.cpc.2024.109353',
        'category' => 'Open tools & infrastructure',
        'image' => '/uploads/publications/pub-jupyter-widgets.webp',
        'image_alt' => 'Diagram: notebook cells with an interactive plot between them',
        'featured' => true,
        'display_order' => 4,
    ],
    [
        'slug' => 'inferring-free-energy-barriers-and-kinetic-rates',
        'title' => 'Inferring free-energy barriers and kinetic rates from molecular dynamics via underdamped Langevin models',
        'authors' => 'D. Girardier, H. Vroylandt, S. Bonella & F. Pietrucci',
        'venue' => 'The Journal of Chemical Physics 159',
        'year' => 2023,
        'doi_url' => 'https://doi.org/10.1063/5.0169050',
        'category' => 'Statistical physics',
        'image' => '/uploads/publications/pub-langevin-barriers.webp',
        'image_alt' => 'Diagram: a trajectory crossing the barrier between the two basins of a double-well free-energy profile',
        'featured' => true,
        'display_order' => 5,
    ],
    [
        'slug' => 'osscar-an-open-platform-for-collaborative-development',
        'title' => 'OSSCAR, an open platform for collaborative development of computational tools for education in science',
        'authors' => 'D. Du, T. J. Baird, S. Bonella & G. Pizzi',
        'venue' => 'Computer Physics Communications 282',
        'year' => 2023,
        'doi_url' => 'https://doi.org/10.1016/j.cpc.2022.108546',
        'category' => 'Open tools & infrastructure',
        'image' => '/uploads/publications/pub-osscar.webp',
        'image_alt' => 'Diagram: contributors around a shared platform at the centre',
        'featured' => true,
        'display_order' => 6,
    ],
];

/* ------------------------------------------------------------- research areas
   The four method-and-system areas listed on the research page. */
$researchAreas = [
    [
        'slug' => 'quantum-and-mixed-quantum-classical-methods',
        'title' => 'Quantum and mixed quantum-classical methods',
        'summary' => 'Practical descriptions of time-dependent behaviour and nuclear quantum effects.',
        'category' => 'Quantum dynamics',
        'display_order' => 1,
    ],
    [
        'slug' => 'non-equilibrium-systems-and-rare-events',
        'title' => 'Non-equilibrium systems and rare events',
        'summary' => 'Fluctuation relations, free-energy reconstruction, transport, and driven matter.',
        'category' => 'Statistical physics',
        'display_order' => 2,
    ],
    [
        'slug' => 'maze-and-constrained-molecular-dynamics',
        'title' => 'MaZe and constrained molecular dynamics',
        'summary' => 'Algorithms for electronic, polarization, and multiscale variables with separated time scales.',
        'category' => 'Molecular simulation',
        'display_order' => 3,
    ],
    [
        'slug' => 'condensed-phases-and-electrochemistry',
        'title' => 'Condensed phases and electrochemistry',
        'summary' => 'Molecular organisation and phase behaviour where electrolytes meet metallic electrodes.',
        'category' => 'Electrochemical interfaces',
        'display_order' => 4,
    ],
];

/* ------------------------------------------------------------------- settings
   Values the theme repeats in several places; editable under /admin/settings
   once they are here rather than being retyped in each template. */
$settings = [
    'site_name' => 'Sara Bonella',
    'contact_email' => 'sara.bonella@epfl.ch',
    'contact_phone' => '+41 21 693 19 79',
    'contact_address' => "EPFL CECAM · BCH 3103\nAvenue de Forel 3\nCH-1015 Lausanne",
    'orcid_url' => 'https://orcid.org/0000-0003-4131-2513',
    'epfl_profile_url' => 'https://people.epfl.ch/sara.bonella?lang=en',
    'cecam_url' => 'https://www.cecam.org/lausanne-hq',
];

if (in_array('--status', $argv, true)) {
    foreach (['publications', 'research_areas', 'pages', 'leadership_pages', 'contact_pages'] as $name) {
        printf("%-20s %d entries\n", $name, $repo->countByCollection($name));
    }
    foreach (array_keys($settings) as $key) {
        printf("setting %-22s %s\n", $key, $app->settings->get($key) ?? '(unset)');
    }
    exit(0);
}

$counts = ['created' => 0, 'updated' => 0];
foreach ($publications as $row) {
    $slug = $row['slug'];
    unset($row['slug']);
    $counts[$put('publications', $slug, $row)]++;
}
foreach ($researchAreas as $row) {
    $slug = $row['slug'];
    unset($row['slug']);
    $counts[$put('research_areas', $slug, $row)]++;
}
foreach ($settings as $key => $value) {
    $app->settings->set($key, $value);
}

printf(
    "publications + research areas: %d created, %d updated\nsettings: %d written\n",
    $counts['created'],
    $counts['updated'],
    count($settings)
);
