<?php

function get_txtstatus($id) {
    switch ($id) {
        case '9':
            return '<span class="badge badge-secondary">排队中</span>';
            break;
        case '8':
            return '<span class="badge badge-info">转码中</span>';
            break;
        case '4':
            return '<span class="badge badge-warning">已残废</span>';
            break;
        case '2':
            return '<span class="badge badge-primary">已完成</span>';
            break;
        case '1':
            return '<span class="badge badge-success">已发布</span>';
            break;
        default:
            break;
    }

}

function path_dir($video_id)
{
    $vid = md5($video_id);
    return  substr(md5($video_id),0,2)."/".substr(md5($video_id),16,4)."/".substr(md5($video_id),28,32);
}

function make_dir($dir){
    return is_dir($dir) or (make_dir(dirname($dir)) and @mkdir($dir,0755));
}

function modproc($cmd){
    $cmd = str_replace(" ;", " 2>&1 ;", $cmd)." 2>&1";
    $nl = "=========================================================\n";
    echo "\n".$nl."Command:\n".$nl.$cmd."\n\n";
    exec($cmd,$out);
    foreach($out as $outd){
        $outs .= $outd."\n";
    }
    echo "Output:\n".$outs."\n\n";
}

function run_in_background($Command, $Priority = 0){
    if($Priority) {
        $PID = shell_exec("nohup nice -n $Priority $Command 2> /dev/null & echo $!");
    } else {
        $PID = shell_exec("nohup $Command 2> /dev/null & echo $!");
    }
    return($PID);
}

function Generate_Key($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function formatBytes($bytes, $precision = 2) {
    $unit = ["B", "KB", "MB", "GB"];
    $exp = floor(log($bytes, 1024)) | 0;
    return round($bytes / (pow(1024, $exp)), $precision).$unit[$exp];
}

function get_duration($videofile) {
    //Get Duration
    $result = shell_exec('ffmpeg -i "' . $videofile . '" 2>&1');
    preg_match('/(?<=Duration: )(\d{2}:\d{2}:\d{2})\.\d{2}/', $result, $match);
    $dur = $match['0'];
    //var_dump($dur);
    list($hours, $minutes, $seconds,$fractions) = sscanf($dur, "%d:%d:%d:%d");
    $totalDurationSeconds = $hours * 3600 + $minutes * 60 + $seconds + doubleval($fractions) / 100.0;
    $totalDuratioHours = doubleval($totalDurationSeconds) / 3600.0;
    $duration = $totalDurationSeconds;
    return (int) $duration;
}

function get_ecfg($val) {
    $config = new Config_Lite(APP_ROOT.'config/encoder.json');
    return  $config['encoder'][$val];
}

?>