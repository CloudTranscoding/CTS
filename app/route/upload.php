<?php
use voku\helper\Paginator;

Flight::route('/vupload', function() {
    try {

        $G_DATA = Flight::get('_G');
        $L_DATA = Flight::get('_L');
        $P_DATA = [
            "PT" => '',
            "PK" => '页面关键词',
            "PD" => '页面介绍',
        ];

        Flight::render('header',array($G_DATA,$L_DATA,$P_DATA));
        Flight::render('upload',$P_DATA);
        Flight::render('footer',$G_DATA);

    } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }

    /*
    $db = Flight::db();
    $total = $db->where ("video_status", 1)->where("video_active",1)->getValue("video_db", "count(video_id)");
    $limit = 12;
    $db->where("video_status",1)->where("video_active",1)->orderBy("video_id",'DESC');
    $data  = $db->get ("video_db", $limit);

    $value = [
        'datas' => $data,
        'pager' => '',
        'total' => $total,
    ];

    $EXT = Flight::get('_G');
    $EXT['PT'] = '你好';
    $EXT['PK'] = '你好,世界';
    $EXT['PD'] = '关于你好世界.......';

    Flight::render('header', $EXT);
    Flight::render('index', $value);
    Flight::render('footer');
    */
});

?>