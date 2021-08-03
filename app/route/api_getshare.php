<?php
use Khill\Duration\Duration;

Flight::route('/api/getsharetext', function() use($_PATH) {
    try {
        $db = Flight::db();
        $id = (int) $_GET['id'];
        $_vkey = "video_id";
        $_vtable = "cts_video";
        $row = $db->where('video_id', $id)->getOne($_vtable);
        $VT = $row['video_title'];
        $VS = formatBytes($row['video_filesize']);
        $VDT = new Duration($row['video_duration']);
        $VD = $VDT->formatted();
        $VA = $_PATH["EPUB_URL"].'/share/'.$row['video_key'];
        $VN = $_PATH["EPUB_URL"].'cloud/'.$row['video_output'].'/';
        $VP1 = $VN.'mozaique.jpg';
        $VP2 = $VN.'preview.gif';

        $sharetxt = file_get_contents(APP_ROOT.'config/share.txt');
        //var_dump($sharetxt);
        $sharetext = sprintf($sharetxt,$VT,$VS,$VD,$VA,$VA,$VP1,$VA,$VP2);
        echo $sharetext;
        //var_dump($sharetext);
    } catch (Exception $e) {
        echo 'Caught exception: ', $e->getMessage(), "\n";
    }
});

Flight::route('/api/getshare', function() use ($_PATH){
    try {
        $db = Flight::db();
        $id = $_GET['id'];
        $_vkey = "video_id";
        $_vtable = "cts_video";

        $row = $db->where('video_id', $id)->getOne($_vtable);

        $row['video_mp4'] = $_PATH["EPUB_URL"].'/cloud/'.$row['video_output'].'/'.$row['video_relid'].'.mp4';
        $row['video_hls'] = $_PATH["EPUB_URL"].'/cloud/'.$row['video_output'].'/index.m3u8';

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