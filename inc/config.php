<?php
$startScriptTime=microtime(TRUE);
session_start();
ini_set('display_errors', 1);
@ini_set('zlib.output_compression', 1);
error_reporting(E_ERROR | E_PARSE | E_WARNING);

define('SITE_URL', 'http://'.$_SERVER['HTTP_HOST'].'/atpitstop.com/');
define('PHP_FILE', end(explode('/', $_SERVER['PHP_SELF'])));

require_once dirname(__FILE__) . "/PublicFunction.php";

$ubig_option = array(
    "AppKeyNews" => "8Tj4Dt82m73P16Mdl01R",
    "AppScreetNews" => "64510fd9cd38da52a1ac7d234d24e3f9",
    "SiteIDNews" => "56284b64096f2031c02bb6a6",
    "SiteCountryNews" => "id",
    "AppKeyPrice" => "8Tj4Dt82m73P16Mdl01R",
    "AppScreetPrice" => "64510fd9cd38da52a1ac7d234d24e3f9",
    "SiteIDPrice" => "555e8f32b05097100cb1741e",
    "SiteCountryPrice" => "id",
);

$database = array(
	'host' => 'localhost',
	'username' => 'root',
	'password' => '',
	'database' => 'db_atpitstop',
	'prefix' => 'azki_');

define('MAIN_PATH', realpath(__DIR__ . '/..'));


