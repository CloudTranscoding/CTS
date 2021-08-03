<?php

Flight::route('/vsetting', function() {
    try {
        $db = Flight::db();

        $_vkey = 'configid';
        $_vtable = "cts_config";

        $confs = $db->get ($_vtable, null, ["name", "value"]);

        $a = array_column($confs, 'name');
        $b = array_column($confs,'value');
        $sys = array_combine($a,$b);
        $msg = '';
        if ($_SERVER['REQUEST_METHOD']=='POST') {

            $input = filter_input_array(INPUT_POST);

            //var_dump($input);

            foreach ($input as $k => $v) {
                //$db->insert($_vtable, [ 'name' => $k , 'value' => $v]);
                //$data= [ $k => $db->escape($v) ] ;
                //var_dump($data);
                //echo "Last executed query was ". $db->getLastQuery();
                @$db->where ('name', $k)->update($_vtable, ["value" => $db->escape($v)] );
                //echo 'update failed: ' . $db->getLastError();
            }
            $msg = '<div class="alert alert-success" role="alert">保存成功!</div>';

            //重新获取参数
            $confs = $db->get ($_vtable, null, ["name", "value"]);
        }

        $G_DATA = Flight::get('_G');
        $L_DATA = Flight::get('_L');
        $P_DATA = [
            "PT" => '',
            "PK" => '页面关键词',
            "PD" => '页面介绍',
            "SYS" => $sys,
            "MSG" => $msg,
        ];

        Flight::render('header', array($G_DATA, $L_DATA, $P_DATA));
        Flight::render('setting8', $P_DATA);
        Flight::render('footer', $G_DATA);

    } catch (Exception $e) {
        echo 'Caught exception: ', $e->getMessage(), "\n";
    }
});

?>