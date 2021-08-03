<?php
Flight::route('/api/category/create', function() {
    try {
        $db = Flight::db();
        // CHECK REQUEST METHOD
        if ($_SERVER['REQUEST_METHOD']=='POST') {
            $input = filter_input_array(INPUT_POST);
        } else {
            $input = filter_input_array(INPUT_GET);
        }
        //var_dump($input);
        $id = $db->insert ('cts_categories', $input);
        $jsondata = [
            'status' => 'OK',
            'msg' =>   'Category Created ' . $id,
        ];
        if($id)  Flight::json($jsondata);

    } catch (Exception $e) {
        echo 'Caught exception: ', $e->getMessage(), "\n";
    }
});

Flight::route('/api/category/list', function() {
    try {
        $db = Flight::db();
        $cols = Array ("category_id", "category_name");
        $categorys = $db->get ("cts_categories", null, $cols);
        if ($db->count <= 0) die();

        if($_GET['opt']){
            $row = [];
            foreach ($categorys as $c){
                $row['DisplayText'] = $c['category_name'];
                $row['Value'] =  $c['category_id'];
                $rows[] = $row;
            }
            $jTableResult = array();
            $jTableResult['Result'] = "OK";
            $jTableResult['Options'] = $rows;
            print json_encode($jTableResult);
        }else{
            Flight::json($categorys);
        }
    } catch (Exception $e) {
        echo 'Caught exception: ', $e->getMessage(), "\n";
    }
});

?>