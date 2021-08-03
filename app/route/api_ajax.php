<?php
Flight::route('/api/ajax', function() {
    try {
        $db = Flight::db();

        /*
            if ($_SERVER['REQUEST_METHOD']=='POST') {
                $input = filter_input_array(INPUT_POST);
            } else {
                $input = filter_input_array(INPUT_GET);
            }
        */

        if(isset($_GET['api']) && !empty($_GET['action']) ) {
            $_vkey = "video_id";
            $_vtable = "cts_video";

            if (isset($_GET['action']) && $_GET['action'] == 'c') {
                $data = filter_input_array(INPUT_POST);
                $lastid = $db->insert($_vtable, $data);
                $row = $db->where($_vkey, $lastid)->getOne($_vtable);
                $jTableResult = array();
                $jTableResult['Result'] = "OK";
                $jTableResult['Record'] = $row;
                print json_encode($jTableResult);
                die();
            } elseif (isset($_GET['action']) && $_GET['action'] == 'u') {
                $data = filter_input_array(INPUT_POST);
                $db->where($_vkey, $data[$_vkey]);
                if ($db->update($_vtable, $data)) {
                    $jTableResult = array();
                    $jTableResult['Result'] = "OK";
                    echo json_encode($jTableResult);
                }
                die();
            } elseif (isset($_GET['action']) && $_GET['action'] == 'd') {
                $data = filter_input_array(INPUT_POST);
                $datas = $db->where($_vkey, $data[$_vkey])->getOne($_vtable);
                $command = sprintf("rm -rf %s", escapeshellarg(APP_ROOT."cloud/".$datas['video_output'])); //删除文件夹
                @shell_exec($command);
                @unlink(APP_ROOT.'tmp/log/'.$datas['video_id'].'.log'); //删除日志
                @unlink($datas['video_filename']); //删除源片
                //var_dump($datas);
                //var_dump($command);
                //die();
                if($db->where($_vkey, $data[$_vkey])->delete($_vtable)) {
                    $jTableResult = array();
                    $jTableResult['Result'] = "OK";
                    echo json_encode($jTableResult);
                }
                die();
            } elseif (isset($_GET['action']) && $_GET['action'] == 'l') {
                /*
                    $offset = 10;
                    $count = 15;
                    $data = $db->withTotalCount()->get('users', Array ($offset, $count));
                    echo "Showing {$count} from {$db->totalCount}";
                    $_GET["jtSorting"]

                    //echo "Showing {$count} from {$db->totalCount}";
                    // $data = $db->arraybuilder()->paginate($_vtable, $page);
                    // var_dump($db->totalPages);
                    // $data = $db->get($_vtable);
                */
                //$db->setTrace (true);
                $offset = (isset($_GET["jtStartIndex"]) AND $_GET['jtStartIndex'] != false ) ? $_GET["jtStartIndex"]  : '0' ;
                //var_dump($offset);
                $count = isset($_GET["jtPageSize"]) ? $_GET["jtPageSize"] : '10';

                if ($db->escape($_POST['Search'])){
                    $search = $db->escape($_POST['Search']);
                    $db->where ("video_title", '%'.$db->escape($_POST['video_title']).'%', 'like');
                }

                if(isset($_GET['jtSorting'])){
                    $sort = $db->escape($_GET['jtSorting']);
                    $sorts = explode(' ',$sort);
                    $db->orderBy($sorts['0'],$sorts['1']);
                } else {
                    $db->orderBy("video_id","desc");
                }
                $data = $db->withTotalCount()->get($_vtable, array ($offset, $count));
                $count = $db->getValue($_vtable, "count(*)");
                if ($db->count <= 0) die('');
                $json_data = [
                    "Result" => 'OK',
                    "Records" => $data,
                    "TotalRecordCount" => $count,
                ];
                //print_r ($db->trace);
                echo json_encode($json_data);  // send data as json format*/
                die();
            }

        }

        /*
        //var_dump($input);
        $id = $db->insert ('cts_video', $input);
        $jsondata = [
            'status' => 'OK',
            'msg' =>   'Video ' . $id,
        ];
        if($id)  Flight::json($jsondata);
        */

    } catch (Exception $e) {
        echo 'Caught exception: ', $e->getMessage(), "\n";
    }
});
?>