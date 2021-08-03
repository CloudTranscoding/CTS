<?php

Flight::route('/api/read', function() {
    try {


        die();
        $db = Flight::db();
        $id = $_GET['id'];
        $_vkey = "video_id";
        $_vtable = "cts_video";

        $row = $db->where('video_id', $id)->getOne($_vtable);

        $row['video_mp4'] = 'http://192.154.101.106:1024/cloud/'.$row['video_output'].'/'.$row['video_relid'].'.mp4';
        $row['video_hls'] = 'http://192.154.101.106:1024/cloud/'.$row['video_output'].'/index.m3u8';

        //var_dump($row);

        $jTableResult = array();
        $jTableResult['Result'] = "OK";
        $jTableResult['Record'] = $row;
        print json_encode($jTableResult);
        die();
    } catch (Exception $e) {
        echo 'Caught exception: ', $e->getMessage(), "\n";
    }
});




?>