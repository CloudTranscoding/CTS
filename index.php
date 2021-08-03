<?php
ob_start();
session_start();
require 'init.php';

/*
if( isset($_SESSION['valid']) AND !$_SESSION['valid']) {
    Flight::redirect('/login');
}

Flight::map('notFound', function(){

});

Flight::route('/accessdeny', function() {
    //Flight::render('accessdeny');
});

*/

Flight::route('/logout', function() {
	session_destroy();
	Flight::redirect('/login');
});

Flight::route('/login', function() {
	//var_dump($_SESSION['valid']);
	$_G = Flight::get('_G');
    $msg = '';
    if (isset($_POST['login']) && !empty($_POST['username']) && !empty($_POST['password'])) {
        if ( $_G['site_adminuser']  === $_POST['username'] AND $_G['site_adminpass']  === $_POST['password'] ) {
			$_SESSION['valid'] = true;
            Flight::redirect('/overview');
        }else {
            $msg = 'Wrong username or password';
        }
    }
    Flight::render('login',array($msg));
});

Flight::route('/', function() {
	var_dump($_SESSION['valid']);
    if(!isset($_SESSION['valid']) && !$_SESSION['valid'] ) {
		Flight::redirect('/login');
	} else {
		Flight::redirect('/overview');
	}
});



/*

	//$_G = Flight::get('_G');
	//var_dump($_G);
	//auth_check();    

function get_setting() {
    global  $db;
    $_vtable = "cts_config";
    $_S = $db->get($_vtable);
    foreach ($_S as $v){
        $a = [$v['name'] => $v['value'] ];
    }
    Flight::set('id',$a);
}

//$id = Flight::get('id');

//var_dump($id);
//get_setting();

*/

Flight::route('/s', function() {
    $db = Flight::db();
    $_vtable = "cts_config";
    $_S = $db->get($_vtable);
    //var_dump($_S);
    //die('Access Deny!');
    //Flight::redirect('/login');
});

//Loader Route
foreach (glob(APP_ROOT. 'app' . DS . 'route' . DS . '*.php') as $filename) {
    @include $filename;
}
Flight::start();
?>