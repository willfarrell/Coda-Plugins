#!/usr/bin/php
<?php
/**
 * Plugin to use Pear's 
 * DocBlock Generator.
 *
 * @category   Coda Plugins
 * @package    Pear PHP
 * @subpackage PHP_DocBlockGenerator
 * @author     Sofia Cardita <sofiacardita@gmail.com> 
 * 
 */

//because compat_info prints
//its output we need to capture
//so it doesnt get sent to stdout
ob_start();
chdir('/Applications/MAMP/bin/php/php5.3.6/share/pear/');
error_reporting(0);

//USER CONFIGURABLE OPTIONS///
$values['author'] = 'Sofia Cardita';
$values['email'] = 'sofiacardita@gmail.com';
$values['license'] = '';
$values['category'] = '';
$values['link'] = '';
$values['package'] = '';
$values['see'] = '';
$values['version'] = '';
$values['year'] = '';
//END OF USER CONFIGURABLE OPTIONS///

//current file being edited
$file = getenv('CODA_FILEPATH');
$outFile = '/tmp/docblock.txt';
$path = 'PHP/DocBlockGenerator.php';
if (!file_exists($path)) {
    echo 'File not found: ' .$path.
            '. Pear must be in your path. If not
            you need to set the correct path to Pear\'s PHP_DocBlockGenerator. '.
            'Included paths: '.get_include_path().
            '. Change it in this file: '.__FILE__;
    exit(1);
}

require_once($path);

// Run command line interface
$pdocblock = new PHP_DocBlockGenerator();
$pdocblock->generate($file,$values,$outFile);
$str = @file_get_contents($outFile);

$contents = ob_get_contents();
ob_end_clean();

//print just the file
//contents with the new
//docblocks
echo $str;
exit(0);