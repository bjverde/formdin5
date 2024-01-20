<?php
if (version_compare(PHP_VERSION, '7.1.0') == -1)
{
    die ('The minimum version required for PHP is 7.1.0');
}

if (!file_exists('app/config/application.ini'))
{
    die('Application configuration file not found');
}

// define the autoloader
require_once 'lib/adianti/core/AdiantiCoreLoader.php';
spl_autoload_register(array('Adianti\Core\AdiantiCoreLoader', 'autoload'));
Adianti\Core\AdiantiCoreLoader::loadClassMap();

$loader = require 'vendor/autoload.php';
$loader->register();

// read configurations
$ini = parse_ini_file('app/config/application.ini', true);
date_default_timezone_set($ini['general']['timezone']);
AdiantiCoreTranslator::setLanguage( $ini['general']['language'] );
ApplicationTranslator::setLanguage( $ini['general']['language'] );
AdiantiApplicationConfig::load($ini);
AdiantiApplicationConfig::apply();

// define constants
define('APPLICATION_NAME', $ini['general']['application']);
define('OS', strtoupper(substr(PHP_OS, 0, 3)));
define('PATH', dirname(__FILE__));
define('LANG', $ini['general']['language']);

//--- FORMDIN 5 START ---------------------------------------------------------
FormDinHelper::verifyFormDinMinimumVersion('5.1.0');
FormDinHelper::verifyMinimumVersionAdiantiFrameWorkToSystem('7.5.1b2');

if(!defined('SYSTEM_VERSION') )  { define('SYSTEM_VERSION', $ini['system']['version']); }
if(!defined('DS')  ) { define('DS', DIRECTORY_SEPARATOR); }
if(!defined('EOL') ) { define('EOL', "\n"); }
if(!defined('ESP') ) { define('ESP', chr(32).chr(32).chr(32).chr(32) ); }
if(!defined('TAB') ) { define('TAB', chr(9)); }

define('SYSTEM_VERSION', $ini['system']['version']);
define('SYSTEM_NAME', $ini['system']['system_name']);
// ---FIM FORMDIN 5 -----------------------

// ============= SysGen For Adianti  =================//
define('ROOT_PATH', '../');
if(!defined('ROWS_PER_PAGE') ) { 
    define('ROWS_PER_PAGE', 20); 
}
if(!defined('ENCODINGS') ) { 
    define('ENCODINGS', 'UTF-8'); 
}
// ============================================//

// custom session name
session_name('PHPSESSID_'.$ini['general']['application']);

setlocale(LC_ALL, 'C');

new TSession;

//--- FormDin 5, mostrar Documentos
if (isset($_REQUEST['class'])){
    if($_REQUEST['class'] != 'DocumentationView'){
        TSession::setValue('classCode', $_REQUEST['class']);
    }
}
