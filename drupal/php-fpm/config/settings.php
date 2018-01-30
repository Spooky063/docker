<?php

/**
 * Location of the site configuration files.
 */
$config_directories = [];
$config_directories['sync'] = $_SERVER['DRUPAL_SYNC_DIR'];

/**
 * Salt for one-time login links, cancel links, form tokens, etc.
 */
$settings['hash_salt'] = $_SERVER['DRUPAL_HASH_SALT'];

/**
 * Access control for update.php script.
 */
$settings['update_free_access'] = FALSE;

/**
 * Load services definition file.
 */
$settings['container_yamls'][] = __DIR__ . '/services.yml';

/**
 * The active installation profile.
 */
$settings['install_profile'] = 'minimal';

/**
 * Production trusted host configuration.
 */
$settings['trusted_host_patterns'] = [
  '^'.$_SERVER['DRUPAL_DOMAIN_NAME'].'$',
  '^www\.'.$_SERVER['DRUPAL_DOMAIN_NAME'].'$',
];

/**
 * The default list of directories that will be ignored by Drupal's file API.
 */
$settings['file_scan_ignore_directories'] = [
  'node_modules',
  'bower_components',
];

/**
 * Database settings
 */
$databases['default']['default'] = [
  'database'  => $_SERVER['MYSQL_DATABASE'],
  'username'  => $_SERVER['MYSQL_USER'],
  'password'  => $_SERVER['MYSQL_PASSWORD'],
  'prefix'    => $_SERVER['MYSQL_PREFIX'],
  'host'      => $_SERVER['MYSQL_HOST'],
  'port'      => $_SERVER['MYSQL_PORT'],
  'namespace' => 'Drupal\\Core\\Database\\Driver\\mysql',
  'driver'    => 'mysql',
];
