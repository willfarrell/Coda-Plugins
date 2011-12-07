#!/usr/bin/php
<?php
/**
 * Plugin to use Pear's 
 * PHP_Beautifier to beautify
 * php files.
 *
 * PHP version 5
 *
 * @category   Coda Plugins
 * @package    Pear PHP
 * @subpackage PHP_Beautifier
 * @author     Sofia Cardita <sofiacardita@gmail.com> 
 *
 */
chdir('/Applications/MAMP/bin/php/php5.3.6/share/pear/');
error_reporting(E_ALL);

$path = 'PHP/Beautifier.php';

if (!file_exists($path)) {
    echo 'File not found: ' .$path.
            '. Pear must be in your path. If not 
            you need to set the correct path to Pear\'s Beautifier.php. '.
            'Included paths: '.get_include_path().
            '. Change it in this file: '.__FILE__;
    die();
}
require($path);

$source = '';
while ($inp = fread(STDIN,8192)) {
    $source .= $inp;
}

$oToken = new PHP_Beautifier();
$oToken->addFilter('Pear');
$oToken->addFilter('DocBlock');
$oToken->addFilter('ArrayNested');
$oToken->addFilter('EqualsAlign');
//add other filters here
$oToken->setInputString($source);
$oToken->process(); // required
echo $oToken->show();

?>