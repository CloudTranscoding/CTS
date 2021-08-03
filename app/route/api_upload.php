<?php

Flight::route('/api/upload', function() {
    try {
        $db = Flight::db();
        $APP = Flight::get('_PATH');
        $handle = new upload($_FILES['v_field']);
        if ($handle->uploaded) {
            $handle->allowed = array('video/*');
            $file_hash = md5_file($handle->file_src_pathname);
            $file_name = uniqid();
            $handle->file_new_name_body = $file_name;
            $handle->process($APP['VORG_ROOT']);

            if ($handle->processed) {
                //var_dump($handle);

                $vfile = $handle->file_dst_pathname;

                $jsondata = [
                    'status' => 'OK',
                    "data" => [
                        'file_id'       => $file_name,
                        'file_hash'     => $file_hash,
                        'file_date'     => date("Ymd",strtotime("now")),
                        'file_title'    => $handle->file_src_name_body,
                        'file_ext'      => $handle->file_src_name_ext,
                        'file_size'     => $handle->file_src_size,
                        'file_inpath'     => $handle->file_dst_pathname,
                    ],
                ];

                $handle->clean();
            } else {
                $jsondata = [
                    'status' => 'fail',
                    'msg' =>  $handle->error,
                ];
            }

            Flight::json($jsondata);

        }








        /*
        if ($handle->uploaded) {
            $handle->allowed = array('image/*');
            $file_md5 = md5_file($handle->file_src_pathname);

            $db->where("file_md5", $file_md5);

            if($db->has("images")) {
                $res = $db->where("file_md5", $file_md5)->getOne("images");
                $cleanuri = $res['file_path'].$res['file_name'];
                $jsondata = [
                    'status' => 'success',
                    'msg' => '',
                    'img_gid' => $res['id'],
                    'img_name' => $res['file_name'],
                    'img_thumb' => str_replace('images','thumb',$cleanuri),
                    'img_path' => $res['file_path'],
                    'img_puburl' => $APP['EPUB_URL'].'/'.$cleanuri,
                ];
            } else {

                $data = [
                    'file_rname'    => $handle->file_src_name,
                    //'file_name'     => $handle->file_src_name_body,
                    'file_ext'      => $handle->file_src_name_ext,
                    'file_size'     => $handle->file_src_size,
                    'file_path'     => 'images/'.$GPATH,
                    'file_userip'   => get_clientip(),
                    'file_md5'      => $file_md5,
                ];
                //var_dump($data);
                $id = $db->insert ('images', $data);
                $filename = Base62::encode($id);
                $handle->file_new_name_body = $filename;
                $handle->process($ORGDIR);
                @$db->where("id",$id)->update('images', ["file_name" => $handle->file_dst_name ] );
                if ($handle->processed) {
                    $cleanuri = str_replace(APP_ROOT,'',$handle->file_dst_pathname);

                    $jsondata = [
                        'status' => 'success',
                        'msg' => '',
                        'img_gid' => $filename,
                        'img_name' => $handle->file_dst_name,
                        'img_thumb' => str_replace('images','thumb',$cleanuri),
                        'img_path' =>  $cleanuri,
                        'img_puburl' => $APP['EPUB_URL'].'/'.$cleanuri,
                    ];

                    $handle->clean();
                } else {
                    $jsondata = [
                        'status' => 'fail',
                        'msg' =>  $handle->error,
                    ];
                }
            }

            Flight::json($jsondata);

        } else {
            $jsondata = [
                'status' => 'fail',
                'msg' =>  'miss file',
            ];
            Flight::json($jsondata);
        }
        */
    } catch (Exception $e) {
        echo 'Caught exception: ', $e->getMessage(), "\n";
    }

});





?>