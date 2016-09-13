<?php

# Protect against web entry
if (!defined('MEDIAWIKI')) {
	exit;
}

// Uncomment this to disable output compression
// $wgDisableOutputCompression = true;
$wgUseGzip = true;

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

$wgScript = '/wiki/index.php';
$wgArticlePath = '/wiki/$1';
$wgResourceBasePath = $wgScriptPath;

$actions = [
    'edit',
    'watch',
    'unwatch',
    'delete',
    'revert',
    'rollback',
    'protect',
    'unprotect',
    'markpatrolled',
    'render',
    'submit',
    'history',
    'purge',
    'info'
];
foreach ($actions as $action) {
  $wgActionPaths[$action] = '/wiki/$1/' . $action;
}
$wgActionPaths['view'] = '/wiki/$1';
$wgArticlePath = $wgActionPaths['view'];

// The relative URL path to the skins directory
$wgStylePath = $wgScriptPath . '/skins';

// The relative URL path to the logo.  Make sure you change this from the default,
// or else you'll overwrite your logo when you upgrade!
$wgLogo = $wgScriptPath . '/theme/burnerpedia-logo.png';

// Enable subpages in the main namespace
$wgNamespacesWithSubpages[NS_MAIN] = true;

// UPO means: this is also a user preference option

$wgJobRunRate = 0;
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
$wgDBTableOptions = 'ENGINE=InnoDB, DEFAULT CHARSET=binary';
$wgSQLMode = null;

// Experimental charset support for MySQL 5.0.
$wgDBmysql5 = true;
$wgDisableCounters = true;
$wgMiserMode = true;

// Shared memory settings
$wgMainCacheType = CACHE_MEMCACHED;
$wgMemCachedServers = [ $_ENV['MEMCACHED_HOST'] ];
$wgMemCachedPersistent = true;
$wgEnableSidebarCache = true;
$wgCacheDirectory = '/tmp';
$wgUseLocalMessageCache = true;
$wgMessageCacheType = CACHE_MEMCACHED;
$wgParserCacheType = CACHE_MEMCACHED;

// Text cache
$wgCompressRevisions = true; // use with care (see talk page)
$wgRevisionCacheExpiry = 3*24*3600;
$wgParserCacheExpireTime = 14*24*3600;

// Varnish
$wgUseSquid       = true;
$wgSquidServers   = ['127.0.0.1', 'varnish'];
$wgUsePrivateIPs  = true;
$wgShowIPinHeader = false;

// To enable image uploads, make sure the 'images' directory
// is writable, then set this to true:
$wgEnableUploads = true;
$wgUploadPath       = '/uploads';
$wgUploadDirectory  = '/var/www/html/uploads';
$wgHashedUploadDirectory = true;

$wgUseImageResize = true;
$wgUseImageMagick = true;
$wgImageMagickConvertCommand = '/usr/bin/convert';
$wgFileExtensions = ['png', 'gif', 'jpg', 'jpeg', 'svg', 'pdf'];

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
$wgEnableCreativeCommonsRdf = true;
$wgEnableDublinCoreRdf = true;

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

wfLoadSkin('Vector');
$wgVectorUseSimpleSearch = true;
$wgVectorUseIconWatch = true;

// Extensions
wfLoadExtension('Cite');
wfLoadExtensions(['ConfirmEdit', 'ConfirmEdit/ReCaptchaNoCaptcha']);
wfLoadExtension('ParserFunctions');
wfLoadExtension('SpamBlacklist');
wfLoadExtension('TitleBlacklist');
wfLoadExtension('WikiEditor');
wfLoadExtension('AbuseFilter');
require_once $IP . '/extensions/googleAnalytics/googleAnalytics.php';

// Extensions - ConfirmEdit
$wgCaptchaClass = 'ReCaptchaNoCaptcha';
$wgReCaptchaPublicKey = $_ENV['RECAPTCHA_PUBLIC_KEY'];
$wgReCaptchaPrivateKey = $_ENV['RECAPTCHA_PRIVATE_KEY'];

// Extensions - ParserFunctions
$wgPFEnableStringFunctions = true;

// Extensions - WikiEditor
$wgDefaultUserOptions['usebetatoolbar']     = 1;
$wgDefaultUserOptions['usebetatoolbar-cgd'] = 1;
$wgDefaultUserOptions['wikieditor-preview'] = 1;
$wgDefaultUserOptions['wikieditor-publish'] = 0;

// Extensions - googleAnalytics
$wgGoogleAnalyticsAccount = $_ENV['GOOGLE_ANALYTICS_ID'];

// Debug
if ('debug' === $_ENV['DEBUG']) {
    $wgDebugComments        = true;
    $wgShowSQLErrors        = true;
    $wgDebugDumpSql         = true;
    $wgShowExceptionDetails = true;
    $wgShowDBErrorBacktrace = true;
}

// Logs
$wgDBerrorLog     = '/dev/stderr';
$wgRateLimitLog   = '/dev/stdout';
$wgDebugLogFile   = '/dev/stdout';
$wgDebugLogGroups = [
	'resourceloader' => '/dev/stdout',
	'exception'      => '/dev/stderr',
	'error'          => '/dev/stderr'
];
