<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/min/dropzone.min.css" />

<script src="https://cdn.jsdelivr.net/npm/jquery@3.3.1/dist/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/min/dropzone.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/clipboard@2/dist/clipboard.min.js"></script>

<main class="main">
    <div class="container">
        <div class="alert alert-danger mb-0" role="alert">
            <strong></strong>
            <p class="mt-0">

            </p>
        </div>

        <div class="card">
            <div class="card-header h4">Transcode Queue
                <div class="float-right">
                    <button type="button" class="btn btn-primary btn-sm" onClick="window.location.reload()">Reload</button>
                </div>
            </div>
            <div class="card-body">
                <div class="btn-group" role="group" aria-label="Basic example">
                    <a href="/queue?taskid=9" class="btn btn-outline-secondary">等待转码</a>
                    <a href="/queue?taskid=8" class="btn btn-outline-primary">正在转码</a>
                    <a href="/queue?taskid=2" class="btn btn-outline-success">完成任务</a>
                    <a href="/queue?taskid=4" class="btn btn-outline-danger">失败任务</a>
                </div>
                <table id="QT" class="table table-sm table-striped table-bordered">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">#ID</th>
                        <th scope="col">Title</th>
                        <th scope="col">Date</th>
                        <th scope="col">Progress</th>
                        <th scope="col">Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if( count($datas) >0 ) {
                        foreach ($datas as $data) {
                            $id = $data['video_id'];
                            $title = $data['video_title'];
                            $date = $data['video_createddate'];
                            $status = $data['video_status'];
                            echo '<tr>';
                            echo '<th scope="row">'.$id.'</th>';
                            echo '<td>'.$title.'</td>';
                            echo '<td>'.date("Y/m/d", strtotime($date)).'</td>';
                            echo '<td id="s'.$id.'"><span class="badge badge-dark">等待检查......</span></td>';
                            echo '<td>'.get_txtstatus($status).'</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<div class="alert alert-success" role="alert">All  Task  Done......</div>';
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</main>

<script>
    $(function() {

        $('#QT').find('tbody').find('tr').find('td').each(function(){
            var qid = $(this).attr('id');
            if (typeof qid === 'undefined' || !qid) {
                //console.log(qid);
            } else {
                var divid = qid;
                var queryid = qid.replace('s','');
                //console.log(queryid);
                setInterval(function()
                {
                    $.ajax({
                        type:"get",
                        url:"/api/queryprogress?id=" + queryid,
                        datatype:"html",
                        success:function(data)  {
                            if(data.PROGRESS === 0) {
                                $("#"+divid).html('<span class="badge badge-dark">排队中</span>');
                            } else {
                                $("#"+divid).html('<div class="progress"><div class="progress-bar" role="progressbar" style="width: '+data.PROGRESS+'%;" aria-valuenow="'+data.PROGRESS+'" aria-valuemin="'+data.PROGRESS+'" aria-valuemax="100">'+data.PROGRESS+'%</div></div>');
                            }
                        }
                    });
                }, 10000);//time in milliseconds
            }
        })
    });

</script>





