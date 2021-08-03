<?php

Flight::route('/index/upload', function() {
    try {
        $G_DATA = Flight::get('_G');
        $L_DATA = Flight::get('_L');
        $P_DATA = [
            "PT" => '',
            "PK" => '页面关键词',
            "PD" => '页面介绍',
        ];
        Flight::render('user_uploadvideo',$P_DATA);
    } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }

});

?>