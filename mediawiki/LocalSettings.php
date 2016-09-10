<?php

# Protect against web entry
if (!defined('MEDIAWIKI')) {
	exit;
}

// Uncomment this to disable output compression
// $wgDisableOutputCompression = true;

$wgSitename = 'Burnerpedia';

// The URL base path to the directory containing the wiki;
// defaults for all runtime URL paths are based off of this.
// For more information on customizing the URLs
// (like /w/index.php/Page_title to /wiki/Page_title) please see:
// https://www.mediawiki.org/wiki/Manual:Short_URL
$wgScriptPath = '/wiki';
$wgScriptExtension = '.php';

// The protocol and server name to use in fully-qualified URLs
$wgServer = 'https://burnerpedia.org';
$wgCanonicalServer = 'https://burnerpedia.org';

$wgArticlePath = '/wiki/$1';
$wgResourceBasePath = $wgScriptPath;

// The relative URL path to the skins directory
$wgStylePath = $wgScriptPath . '/skins';

// The relative URL path to the logo.  Make sure you change this from the default,
// or else you'll overwrite your logo when you upgrade!
$wgLogo = $wgScriptPath . '/theme/burnerpedia-logo.png';

// UPO means: this is also a user preference option

$wgEnableEmail = false;
$wgEnableUserEmail = false; # UPO

$wgEmergencyContact = 'keri.burnerpedia@henare.co.nz';
$wgPasswordSender = 'keri.burnerpedia@henare.co.nz';

$wgEnotifUserTalk = false; # UPO
$wgEnotifWatchlist = false; # UPO
$wgEmailAuthentication = true;

// Database settings
$wgDBtype = 'mysql';
$wgDBserver = $_ENV['MYSQL_HOST'];
$wgDBname = $_ENV['MYSQL_DATABASE'];
$wgDBuser = $_ENV['MYSQL_USER'];
$wgDBpassword = $_ENV['MYSQL_PASSWORD'];

// MySQL specific settings
$wgDBprefix = '';

// MySQL table options to use during installation or update
$wgDBTableOptions = 'ENGINE=InnoDB, DEFAULT CHARSET=binary';

// Experimental charset support for MySQL 5.0.
$wgDBmysql5 = true;

// Shared memory settings
$wgMainCacheType = CACHE_MEMCACHED;
$wgMemCachedServers = [ $_ENV['MEMCACHED_HOST'] ];

// To enable image uploads, make sure the 'images' directory
// is writable, then set this to true:
$wgEnableUploads = true;
$wgUploadPath       = '/uploads';
$wgUploadDirectory  = '/var/www/html/uploads';

$wgUseImageResize = true;
$wgUseImageMagick = true;
$wgImageMagickConvertCommand = '/usr/bin/convert';

// InstantCommons allows wiki to use images from http://commons.wikimedia.org
$wgUseInstantCommons = false;

// If you use ImageMagick (or any other shell command) on a
// Linux server, this will need to be set to the name of an
// available UTF-8 locale
$wgShellLocale = 'C.UTF-8';

// If you want to use image uploads under safe mode,
// create the directories images/archive, images/thumb and
// images/temp, and make them all writable. Then uncomment
// this, if it's not already uncommented:
// $wgHashedUploadDirectory = false;

// Set $wgCacheDirectory to a writable directory on the web server
// to make your wiki go slightly faster. The directory should not
// be publically accessible from the web.
// $wgCacheDirectory = $IP . '/cache';

// Site language code, should be one of the list in ./languages/Names.php
$wgLanguageCode = 'en';
$wgHtml5Version = 'XHTML+RDFa 1.0';

$wgSecretKey = $_ENV['MEDIAWIKI_SECRET_KEY'];

// Site upgrade key. Must be set to a string (default provided) to turn on the
// web installer while LocalSettings.php is in place
$wgUpgradeKey = $_ENV['MEDIAWIKI_UPGRADE_KEY'];

// For attaching licensing metadata to pages, and displaying an
// appropriate copyright notice / icon. GNU Free Documentation
// License and Creative Commons licenses are supported so far.
$wgRightsPage = ''; # Set to the title of a wiki page that describes your license/copyright
$wgRightsUrl  = 'http://creativecommons.org/licenses/by-nc-sa/3.0/';
$wgRightsText = 'Creative Commons Attribution-NonCommercial-ShareAlike';
$wgRightsIcon = $wgResourceBasePath . '/resources/assets/licenses/cc-by-nc-sa.png';

// Path to the GNU diff3 utility. Used for conflict resolution.
$wgDiff  = '/usr/bin/diff';
$wgDiff3 = '/usr/bin/diff3';

// The following permissions were set based on your choice in the installer
$wgGroupPermissions['*']['createaccount'] = false;
$wgGroupPermissions['*']['edit'] = false;

// Default skin: you can change the default skin. Use the internal symbolic
// names, ie 'vector', 'monobook':
$wgDefaultSkin = 'vector';

// Enabled skins.
// The following skins were automatically enabled:
// require_once $IP . '/skins/CologneBlue/CologneBlue.php';
// require_once $IP . '/skins/Modern/Modern.php';
// require_once $IP . '/skins/MonoBook/MonoBook.php';
require_once $IP . '/skins/Vector/Vector.php';
