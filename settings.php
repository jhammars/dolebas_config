<?php

/**
 * Load services definition file.
 */
$settings['container_yamls'][] = __DIR__ . '/services.yml';

/**
 * Include the Pantheon-specific settings file.
 *
 * n.b. The settings.pantheon.php file makes some changes
 *      that affect all envrionments that this site
 *      exists in.  Always include this file, even in
 *      a local development environment, to insure that
 *      the site settings remain consistent.
 */
include __DIR__ . "/settings.pantheon.php";

/**
 * If there is a local settings file, then include it
 */
$local_settings = __DIR__ . "/settings.local.php";
if (file_exists($local_settings)) {
  include $local_settings;
}
$settings['install_profile'] = 'standard';

// Require HTTPS, www.
if (isset($_SERVER['PANTHEON_ENVIRONMENT']) &&
  ($_SERVER['PANTHEON_ENVIRONMENT'] === 'live') &&
  // Check if Drupal is running via command line
  (php_sapi_name() != "cli")) {
  if ($_SERVER['HTTP_HOST'] != 'www.dolebas.com' ||
      !isset($_SERVER['HTTP_X_SSL']) ||
      $_SERVER['HTTP_X_SSL'] != 'ON' ) {
    header('HTTP/1.0 301 Moved Permanently');
    header('Location: https://www.dolebas.com'. $_SERVER['REQUEST_URI']);
    exit();
  }
}