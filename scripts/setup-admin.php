<?php

declare(strict_types=1);

/**
 * scripts/setup-admin.php — create or reset the admin account.
 *
 * The site ships with a known default so a fresh clone can be opened and used
 * immediately. It is a development default, not a secret: change it before the
 * admin is reachable from anywhere but localhost. The password is printed once
 * here rather than hidden, so there is no illusion that it is private.
 *
 *   php scripts/setup-admin.php                       # create/reset the default admin
 *   php scripts/setup-admin.php you@example.com pass  # use your own credentials
 */

use Pebblestack\Core\App;
use Pebblestack\Core\Auth;
use Pebblestack\Services\UserRepository;

$root = dirname(__DIR__);
require $root . '/vendor/autoload.php';

const DEFAULT_EMAIL = 'admin@sarabonella.local';
const DEFAULT_PASSWORD = 'sarabonella-admin';
const DEFAULT_NAME = 'Site admin';

$email = $argv[1] ?? DEFAULT_EMAIL;
$password = $argv[2] ?? DEFAULT_PASSWORD;

if (strlen($password) < 8) {
    fwrite(STDERR, "Password must be at least 8 characters.\n");
    exit(1);
}

$app = new App($root);

// install() runs the migrations as well as creating the first user, so on an
// empty database this is the whole setup; on an existing one it is a reset.
if (!$app->installer->isInstalled()) {
    $app->installer->install($email, $password, DEFAULT_NAME, 'Sara Bonella');
    $action = 'created';
} else {
    $users = new UserRepository($app->db);
    $existing = $users->findByEmail($email);
    if ($existing === null) {
        $users->create($email, DEFAULT_NAME, Auth::hash($password), 'admin');
        $action = 'created';
    } else {
        $users->setPassword($existing->id, Auth::hash($password));
        $action = 'password reset';
    }
}

echo "Admin {$action}.\n";
echo "  email:    {$email}\n";
echo "  password: {$password}\n";
if ($password === DEFAULT_PASSWORD) {
    echo "\nThis is the shipped default. Change it in /admin/settings before the\n";
    echo "admin is reachable from anywhere other than localhost.\n";
}
