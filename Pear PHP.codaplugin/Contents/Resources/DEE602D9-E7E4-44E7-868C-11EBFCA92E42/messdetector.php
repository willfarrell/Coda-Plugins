#!/usr/bin/php
<?php
/**
 * Plugin to use Pear's 
 * Php Mess Detector.
 *
 * @category   Coda Plugins
 * @package    Pear PHP
 * @subpackage PHP_PMD
 * @author     Sofia Cardita <sofiacardita@gmail.com> 
 * 
 */

error_reporting(0);
chdir('/Applications/MAMP/bin/php/php5.3.6/share/pear/');
$values[0] = '/usr/bin/phpmd';//path to pmd

//tmp report file
$values[1] = '--reportfile';
$values[2] = '/tmp/mess.html';

//current file being edited
$values[3] = getenv('CODA_FILEPATH');

//report format: text,xml,html
$values[4] =  'html';

//rulesets: codesize,unusedcode,naming,design 
//or path to custom ruleset
$values[5] =  'codesize,unusedcode,naming,design'; 

//END OF USER CONFIGURABLE OPTIONS///

$path = 'PHP/PMD/TextUI/Command.php';
if (!file_exists($path)) {
    echo 'File not found: ' .$path.
            '. Pear must be in your path. If not 
            you need to set the correct path to Pear\'s PMD. '.
            'Included paths: '.get_include_path().
            '. Change it in this file: '.__FILE__;
    die();
}

require_once($path);

// Run command line interface
$error = PHP_PMD_TextUI_Command::main($values);

if ($error) { 
    echo file_get_contents($values[2]);	  
} else {
    echo 'PMD says Ok! :)';
}

