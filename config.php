<?php

$_G = [
    "site_name" => 'Transcode System',
    "site_domain" => 'https://www.test.com',
    "site_keyword" => 'CTS',
    "site_desc" => 'CTS!',
    "site_template" => 'tpl',
    "site_debug" => 'on',
    "site_copyright" => '© 2008-2018',
	"site_adminuser" => "ADMIN",   // 账户
	"site_adminpass" => "XXOO",    // 密码
];

$_L = [
    "lang1" => '注意: 请不要上传违反当地法律法规的图片资源,会记录IP并且举报至相关部门!',
];

$_PATH = [
    "EPUB_URL" => 'https://cdn001.domains.com.',  // 外链的域名,需要服务器允许cors跨域
    "ALLOW_FT" => 'jpg,gif,jpeg,webp,png,ico,bmp',
    "ALLOW_FS" => '102400000', //1024 = 1k 1024000=1M
    "APP_ROOT" => APP_ROOT,
    "IMG_ROOT" => APP_ROOT.'images',
    "TMB_ROOT" => APP_ROOT.'thumb',
    "TMP_ROOT" => APP_ROOT.'tmp',
    "C2P_ROOT" => APP_ROOT.'tmp/temp',
    "VTMP_ROOT" => APP_ROOT.'upload/temp',
    "VORG_ROOT" => APP_ROOT.'upload/original',
    "VOUT_ROOT" => APP_ROOT .'upload/video',
];

$_D = [
    'host'      => 'localhost',
    'username'  => 'user',
    'password'  => 'pass',
    'database'  => 'system'
];

function auth_check() {   //auth_check();
    if(!isset($_SESSION['valid']) && $_SESSION['valid'] === false ) {
		echo "<script>window.location='/login';</script>";
	}
}

?>