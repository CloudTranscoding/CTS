<div class="user-dashboard">
    <h1>视频上传
        <div class="pull-right">
            <button type="button" class="btn btn-primary btn-sm" onClick="window.location.reload()">刷新</button>
        </div>
    </h1>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 gutter">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <br>
                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">

                                <form id="upload_form" class="form-inline" enctype="multipart/form-data" method="post">
                                    <div class="form-group">
                                        <input type="file" name="v_field" id="v_field"><br>
                                    </div>
                                    <input type="button" value="上传文件" class="btn btn-primary" onclick="uploadFile()">
                                    <p class="text-danger">仅支持视频文件后缀,视频文件不要超过5Gb</p>
                                    <p><progress id="progressBar" value="0" max="100" style="width:300px;"></progress></p>
                                    <h4 id="status"></h4>
                                    <p id="loaded_n_total"></p>
                                </form>

                            </div>
                        </div>
                        <script>
                            function _(el) {
                                return document.getElementById(el);
                            }
                            function uploadFile() {
                                var file = _("v_field").files[0];
                                // alert(file.name+" | "+file.size+" | "+file.type);
                                var formdata = new FormData();
                                formdata.append("v_field", file);
                                var ajax = new XMLHttpRequest();
                                ajax.upload.addEventListener("progress", progressHandler, false);
                                ajax.addEventListener("load", completeHandler, false);
                                ajax.addEventListener("error", errorHandler, false);
                                ajax.addEventListener("abort", abortHandler, false);
                                ajax.open("POST", "/api/upload");
                                ajax.send(formdata);
                            }

                            function progressHandler(event) {
                                _("loaded_n_total").innerHTML = " 进度 " + event.loaded + " / " + event.total;
                                var percent = (event.loaded / event.total) * 100;
                                _("progressBar").value = Math.round(percent);
                                _("status").innerHTML = Math.round(percent) + "% 已上传,请等待...";
                            }

                            function completeHandler(event) {
                                var response = JSON.parse(event.target.responseText);
                                console.log(response);

                                if (response.status = 'OK') {
                                    $("#fid").val(response.data.file_id);
                                    $("#date").val(response.data.file_date);
                                    $("#hash").val(response.data.file_hash);
                                    $("#size").val(response.data.file_size);
                                    $("#inpath").val(response.data.file_inpath);
                                    $("#title").val(response.data.file_title);
                                    $("#desc").val(response.data.file_title);
                                }
                                else {
                                    alert('Upload Fail......');
                                }
                                //_("status").innerHTML = event.target.responseText;
                                _("progressBar").value = 0;
                            }

                            function errorHandler(event) {
                                _("status").innerHTML = "Upload Failed";
                            }

                            function abortHandler(event) {
                                _("status").innerHTML = "Upload Aborted";
                            }
                        </script>

                        <hr>
                        <form class="form-horizontal" id="Queue" method="post" action="/api/create">
                            <input type="hidden" name="video_key" id="fid" value="">
                            <input type="hidden" name="video_hash" id="hash" value="">
                            <input type="hidden" name="video_createddate" id="date" value="">
                            <input type="hidden" name="video_filename" id="inpath" value="">
                            <input type="hidden" name="video_filesize" id="size" value="">

                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="textinput">视频分类</label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="video_categoryid" id="category"></select>
                                </div>
                                <div class="col-sm-6"><p class="form-control-static text-primary">请选择一个分类便于区分</p></div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="textinput">视频标题</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="video_title" id="title" value="">
                                </div>
                                <div class="col-sm-6"><p class="form-control-static text-primary">起个拉风的名字,可以获得更多点击</p></div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="textinput">视频标签</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control"  name="video_tags" id="tag" value="">
                                </div>
                                <div class="col-sm-6"><p class="form-control-static text-primary">这个视频的主要关键词,逗号分割</p></div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="textinput">视频介绍</label>
                                <div class="col-sm-4">
                                    <textarea class="form-control" name="video_description" id="desc" rows="3"></textarea>
                                </div>
                                <div class="col-sm-6"><p class="form-control-static text-primary">留下一点介绍吧......</p></div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" id="Button" class="btn btn-primary">确认添加</button>
                                </div>
                            </div>

                        </form>
                    </div>

                    <div class="panel-footer">
                        <div class="alert alert-success" id="MSG" role="alert" style="display: none">
                            视频已经加入队列,等待转码中.......  <button type="button" class="btn btn-primary btn-sm" onClick="window.location.reload()">点击继续上传</button>
                        </div>
                    </div>

                </div>
            <!-- <div class="sales"></div> -->
        </div>
    </div>
</div>
<script language="javascript">
$.ajax({
    url: "/api/category/list",
    dataType: "json",
    success: function (data) {
        var result = "<option value='0'>无分类</option>";
        for (var i = 0; i < data.length; i++) {
            result += "<option value='" + data[i].category_id + "'>" + data[i].category_name + "</option>"
        }
        $("#category")
            .change(function () {
                var str = "";
                $("select option:selected").each(function () {
                    str += $(this).text();
                });
            })
            .change();
        $("#category").html(result)
    }
})
</script>
<script language="javascript" type="text/javascript">
$(function() {
    $("#Queue").submit(function(e) {
        e.preventDefault();
        var actionurl = e.currentTarget.action;
        $.ajax({
            url: actionurl,
            type: 'post',
            //dataType: 'application/json',
            data: $("#Queue").serialize(),
            success: function(data) {
                $('#Button').attr('disabled','disabled');
                $("#MSG").show();
            }
        });
    });
});
</script>