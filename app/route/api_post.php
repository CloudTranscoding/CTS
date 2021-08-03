<?php
Flight::route('/api/create', function() {
    try {
        $db = Flight::db();
        // CHECK REQUEST METHOD
        if ($_SERVER['REQUEST_METHOD']=='POST') {
            $input = filter_input_array(INPUT_POST);
        } else {
            $input = filter_input_array(INPUT_GET);
        }
        //var_dump($input);
        $vkey = Generate_Key();
        $input['video_relid'] = $vkey;
        $input['video_output'] = date("Ymd/",strtotime("now")).$vkey;
        $id = $db->insert ('cts_video', $input);
        $jsondata = [
            'status' => 'OK',
            'msg' =>   'Video ' . $id,
        ];
        if($id)  Flight::json($jsondata);

    } catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}
});
?>