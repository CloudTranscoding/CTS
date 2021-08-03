<?php
use voku\helper\Paginator;

Flight::route('/vlist', function() {
    try {
        $db = Flight::db();
        $table = 'cts_video';
        $taskid =  (int) isset(Flight::request()->query['taskid']) ? Flight::request()->query['taskid'] : '';
        $total = $db->where ("video_status", $taskid)->getValue($table, "count(video_id)");
        $limit = 12;
        //$db->where("video_status",'')
        $db->orderBy("video_id",'ASC');
        $data  = $db->get($table, $limit);

        $value = [
            'datas' => $data,
            'pager' => '',
            'total' => $total,
        ];

        $EXT = Flight::get('_G');
        $EXT['PT'] = '你好';
        $EXT['PK'] = '你好,世界';
        $EXT['PD'] = '关于你好世界.......';

        //var_dump($value);

        Flight::render('header', $EXT);
        Flight::render('list', $value);
        Flight::render('footer');
    } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
});


?>