#!/usr/bin/php
<?php
/**
 * Plugin to use Pear's 
 * Code_Sniffer to check
 * style guidelines.
 *
 * PHP version 5
 *
 * @category   Coda Plugins
 * @package    Pear PHP
 * @subpackage Code_Sniffer
 * @author     Sofia Cardita <sofiacardita@gmail.com> 
 *
 *
 * 
 */

error_reporting(E_ALL);
chdir('/Applications/MAMP/bin/php/php5.3.6/share/pear/');
//USER CONFIGURABLE OPTIONS///
$values['verbosity'] = 0;
$values['tabWidth'] = 4;
$values['encoding'] = 'utf-8';
$values['standard'] = 'PEAR';
$values['generator'] = '';
//END OF USER CONFIGURABLE OPTIONS///

$path = 'PHP/CodeSniffer/CLI.php';

if (!file_exists($path)) {
    echo 'File not found: ' .$path.
            '. Pear must be in your path. If not
             you need to set the correct path to Pear\'s CodeSniffer. '.
            'Included paths: '.get_include_path().
            '. Change it in this file: '.__FILE__;
    die();
}

$file  = getenv('CODA_FILEPATH');
$files = array($file);
$values['files'] = $files;
$values['reportFile'] = '/tmp/checkstyle.txt';
$values['interactive'] = false;
$values['sniffs'] = array();
$values['extensions'] = array();
$values['ignored'] = array();
$values['reports'] = array();
$values['errorSeverity'] = '';
$values['warningSeverity'] = '';
$values['local'] = '';
$values['reportWidth'] = '';
$values['showProgress'] = '';
$values['showSources'] = '';

require($path);

$phpcs = new PHP_CodeSniffer_CLI();
$phpcs->checkRequirements();

$numErrors = $phpcs->process($values);
echo file_get_contents($values['reportFile']);

