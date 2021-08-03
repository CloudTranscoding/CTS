<?php
Flight::route('/api/queryprogress', function() {
    header("Content-Type: application/json");
    header("Expires: 0");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");

    try {
        $db = Flight::db();
        $id = (int) Flight::request()->query['id'];
        $logs = APP_ROOT.'tmp/logs/'.$id.'.log';
        if(file_exists($logs)) {
            $content = @file_get_contents($logs);
            preg_match("/Duration: (.*?), start:/", $content, $matches);
            $rawDuration = $matches[1];
            //rawDuration is in 00:00:00.00 format. This converts it to seconds.
            $ar = array_reverse(explode(":", $rawDuration));
            $duration = floatval($ar[0]);
            if (!empty($ar[1])) $duration += intval($ar[1]) * 60;
            if (!empty($ar[2])) $duration += intval($ar[2]) * 60 * 60;
            preg_match_all("/time=(.*?) bitrate/", $content, $matches);
            $rawTime = array_pop($matches);
            if (is_array($rawTime)){$rawTime = array_pop($rawTime);}
            $ar = array_reverse(explode(":", $rawTime));
            $time = floatval($ar[0]);
            if (!empty($ar[1])) $time += intval($ar[1]) * 60;
            if (!empty($ar[2])) $time += intval($ar[2]) * 60 * 60;
            if (preg_match("/Starting second pass/i", $content)) {
                $progress = 100;
            } else {
                $progress = round(($time/$duration) * 100);
            }
            $jsondata = [
                "STATUS" => 'WAITING',
                "MESSAGE" => '',
                "DUR" => gmdate("H:i:s", $duration) ,
                "CUR" => gmdate("H:i:s", $time) ,
                "PROGRESS" => $progress,
                "TIME" => time(),
            ];
        } else {
            $jsondata = [
                "STATUS" => 'NOTSTART',
                "PROGRESS" => 0,
            ];
        }
        Flight::json($jsondata);
    } catch (Exception $e) {
        echo 'Caught exception: ', $e->getMessage(), "\n";
    }
});
?>