
<div class="user-dashboard">
    <h1>队列管理</h1>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 gutter">
            <div class="sales">

                <div class="btn-group" role="group" aria-label="">
                    <a href="/vtask?taskid=9" class="btn btn-info">等待转码</a>
                    <a href="/vtask?taskid=8" class="btn btn-primary">正在转码</a>
                    <a href="/vtask?taskid=2" class="btn btn-success">完成任务</a>
                    <a href="/vtask?taskid=4" class="btn btn-danger">失败任务</a>
                </div>
                <table id="QT" class="table table-sm table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">标题</th>
                            <th scope="col">日期</th>
                            <th scope="col">进度</th>
                            <th scope="col">状态</th>
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
                        echo '<tr><td colspan="5"><div class="alert alert-success well-sm" role="alert"><b>空空如也,毛都没有一根!</b></div></td></tr>';
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    function getQueryParams(qs) {
        qs = qs.split('+').join(' ');
        var params = {},
            tokens,
            re = /[?&]?([^=]+)=([^&]*)/g;
        while (tokens = re.exec(qs)) {
            params[decodeURIComponent(tokens[1])] = decodeURIComponent(tokens[2]);
        }
        return params;
    }

    $(function() {
        var query = getQueryParams(document.location.search);
        var taskid = query.taskid;
        if (taskid != 8) die();

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

