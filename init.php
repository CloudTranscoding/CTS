<?php
session_start();
header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Connection: close");

date_default_timezone_set('Asia/Hong_Kong');
ini_set('memory_limit', '1024M');
define("DS", DIRECTORY_SEPARATOR);
define("APP_ROOT", realpath(__DIR__) . DS);
define("VENDORDIR", APP_ROOT . "vendor" . DS);
require APP_ROOT.'vendor/autoload.php';
include APP_ROOT.'config.php';

//RR 改写IP
if(isset($_SERVER['HTTP_CF_CONNECTING_IP'])){
    $_SERVER['REMOTE_ADDR']=$_SERVER['HTTP_CF_CONNECTING_IP'];
    $_SERVER['HTTP_CLIENT_IP']=$_SERVER['HTTP_CF_CONNECTING_IP'];
    $_SERVER['HTTP_X_FORWARDED_FOR']=$_SERVER['HTTP_CF_CONNECTING_IP'];
    $_SERVER['HTTP_X_FORWARDED']=$_SERVER['HTTP_CF_CONNECTING_IP'];
}

// Debug
if(isset($_SERVER['HTTP_CF_CONNECTING_IP']) AND $_SERVER['HTTP_CF_CONNECTING_IP'] == '68.64.169.78') {
    define('DEBUG', true);
}else{
    define('DEBUG', false);
}

if(DEBUG) {
    error_reporting(E_ALL);
    ini_set('display_errors', 'on');
}else{
    error_reporting(0);
    ini_set('display_errors', 0);
}

/*
 *  Ban Country IP
 */
if (isset($_SERVER["HTTP_CF_IPCOUNTRY"]) AND $_SERVER["HTTP_CF_IPCOUNTRY"] == 'CN') {
    //Flight::redirect('/accessdeny');
    //if($_SERVER["HTTP_CF_IPCOUNTRY"] == 'CN') {
    //$cur_times = date("H");
    //$allow_hours = array('22','23','00','01','02');
    //if (!in_array($cur_times, $allow_hours)) {
    //}
    //}
}

/*
	Register All Class
*/
// require_once(APP_ROOT.'app/class/class.tagengine.php');
Flight::register('db', 'MysqliDb', array($_D['host'], $_D['username'], $_D['password'], $_D['database']), function($db2) { });
//Flight::register('tagEngine', 'TagEngine');
$db = Flight::db();
//$tagEngine = Flight::tagEngine();
//Flight::register('upload', 'Upload');
//$hupload = Flight::upload();

/*
	Global variables
*/
$CC = isset($_SERVER["HTTP_CF_IPCOUNTRY"]) ? $_SERVER["HTTP_CF_IPCOUNTRY"] : 'NA';
Flight::set('flight.views.path', 'app/view2');
Flight::set('_G', $_G);
Flight::set('_L', $_L);
Flight::set('_PATH', $_PATH);
Flight::set('CC', $CC);

function MEMU_URLPART($URI) {
    //$directoryURI = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
    $directoryURI=$URI;
    $path = parse_url($directoryURI, PHP_URL_PATH);
    $components = explode('/', $path);
    $first_part = $components[1];
    return $first_part;
}

// GET Client IP
function get_clientip() {
    $ipaddress = '';
    if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
        $ipaddress = $_SERVER["HTTP_CF_CONNECTING_IP"];
    } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    } elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } elseif(isset($_SERVER['HTTP_X_FORWARDED'])) {
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    } elseif(isset($_SERVER['HTTP_FORWARDED_FOR'])){
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    } elseif(isset($_SERVER['HTTP_FORWARDED'])) {
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    }  elseif(isset($_SERVER['REMOTE_ADDR'])) {
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    } else {
        $ipaddress = '0.0.0.0';
    }
    return $ipaddress;
}

// 加密解密
//Base62::encode($id);
//Base62::decode($code);
class Base62 {
    const CHARS_SYMBOLS = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    /**
     * @param $id
     * @return string
     */
    public static function encode($id){
        $l = strlen(self::CHARS_SYMBOLS);
        $chars = self::CHARS_SYMBOLS;
        $hash='';
        while($id > 0) {
            $i = fmod($id,$l);
            $hash= ($chars[intval($i)]) . $hash;
            $id=floor($id/$l);
        }
        return $hash;
    }
    /**
     * @param $code
     * @return string
     */
    public static function decode($code)
    {
        $l = strlen(self::CHARS_SYMBOLS);
        $id=0;
        $arr = array_flip(str_split(self::CHARS_SYMBOLS));
        for($i=0,$len = strlen($code); $i < $len; ++$i) {
            $id += $arr[$code[$i]] * pow($l, $len-$i-1);
        }
        return (string)$id;
    }
}

include APP_ROOT.'app/function.php';
?>