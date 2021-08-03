<?php
use voku\helper\Paginator;

Flight::route('/overview', function() {
    try {
        $G_DATA = Flight::get('_G');
        $L_DATA = Flight::get('_L');
        $P_DATA = [
            "PT" => '',
            "PK" => '页面关键词',
            "PD" => '页面介绍',
        ];

        Flight::render('header', array($G_DATA, $L_DATA, $P_DATA));
        Flight::render('upload', $P_DATA);
        Flight::render('footer', $G_DATA);

    } catch (Exception $e) {
        echo 'Caught exception: ', $e->getMessage(), "\n";
    }

});

?>