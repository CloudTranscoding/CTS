<?php
use voku\helper\Paginator;

Flight::route('/index', function() use($_PATH) {
    try {
        /*
        //$taskid =  (int) isset(Flight::request()->query['taskid']) ? Flight::request()->query['taskid'] : '';
        */
        $db = Flight::db();
        $table = 'cts_video';
        $page = (int) isset($_GET['page']) ? $_GET['page'] : '1';

        $db->pageLimit = 9;
        $total = $db->where("video_status",2)->getValue($table, "count(video_id)");
        $db->orderBy("video_id",'Desc');
        //$data = $db->get($table, $limit);
        $data = $db->where("video_status",2)->arraybuilder()->paginate($table, $page);

        $pages = new Paginator($db->pageLimit,'page');
        $pages->set_total($total); //or a number of records
        $pages->set_paginatorUlCssClass('justify-content-center');
        $pager = $pages->page_links();

        $value = [
            'public' => $_PATH["EPUB_URL"],
            'datas' => $data,
            'pager' => $pager,
            'total' => $total,
        ];

        Flight::render('index', $value);

    } catch (Exception $e) {
        echo 'Caught exception: ', $e->getMessage(), "\n";
    }

});

?>