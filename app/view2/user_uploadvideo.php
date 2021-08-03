<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/video.js@6.7.3/dist/video-js.min.css">
    <title>Upload Video</title>
    <style>

    </style>
</head>
<body>

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="/index">
            <img src="https://www.wowza.com/uploads/images/icon-transcode-150x150.png" width="30" height="30" class="d-inline-block align-top" alt="">
            Cloud Transcoder System
        </a>

        <form class="form-inline">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
        <span class="navbar-text">
            <a class="btn btn-outline-light" href="">Upload</a>
        </span>

    </div>
</nav>

<div class="container">
    <div class="card">
        <h4 class="card-header bg-dark text-white"><strong>Upload You Video to Us....</strong>   <span style="font-size: 12px;">All video has review! </span></h4>
    </div>


    <div class="row justify-content-center">

    <style>
        .uploader {
            position: relative;
            overflow: hidden;
            display: inline-block;
            padding-top: 20px;
        }
    </style>

        <div class="uploader">
            <form id="upload_form" class="form-inline" enctype="multipart/form-data" method="post">
                <div class="form-group mb-2">
                    <input type="file" name="v_field" id="v_field">
                </div>
                <input type="button" value="上传视频" class="btn btn-primary btn-sm" onclick="uploadFile()">
            </form>
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
                        $('#Button').prop("disabled", false);
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
    </div>


    <div class="text-center">
        <p class="text-danger">仅支持视频文件后缀,视频文件不要超过5Gb<br>仅测试模式,内容可能需要审核后显示,请勿上传非法内容!</p>
        <p><progress id="progressBar" value="0" max="100" style="width:300px;"></progress></p>
        <h4 id="status"></h4>
        <p id="loaded_n_total"></p>
    </div>

    <div class="row justify-content-center">
        <div class="col-sm-10">
            <hr>
            <form id="Queue" method="post" action="/api/create">
                <input type="hidden" name="video_key" id="fid" value="">
                <input type="hidden" name="video_hash" id="hash" value="">
                <input type="hidden" name="video_createddate" id="date" value="">
                <input type="hidden" name="video_filename" id="inpath" value="">
                <input type="hidden" name="video_filesize" id="size" value="">

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="textinput"><b>视频分类</b></label>
                    <div class="col-sm-4">
                        <select class="form-control" name="video_categoryid" id="category"></select>
                    </div>
                    <div class="col-sm-6 col-form-label"><small id="passwordHelpInline" class="text-muted">请选择一个分类便于区分</small></div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="textinput"><b>视频标题</b></label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="video_title" id="title" value="">
                    </div>
                    <div class="col-sm-6 col-form-label"><small class="text-muted">起个拉风的名字,可以获得更多点击</small></div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="textinput"><b>视频标签</b></label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control"  name="video_tags" id="tag" value="">
                    </div>
                    <div class="col-sm-6 col-form-label"><small class="text-muted">这个视频的主要关键词,逗号分割</small></div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="textinput"><b>视频介绍</b></label>
                    <div class="col-sm-4">
                        <textarea class="form-control" name="video_description" id="desc" rows="3"></textarea>
                    </div>
                    <div class="col-sm-6 col-form-label"><small class="text-muted">留下一点介绍吧......</small></div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="textinput"><b></b></label>
                    <div class="col-sm-8"><button type="submit" id="Button" class="btn btn-primary" disabled>发布视频</button></div>
                </div>

            </form>

            <div class="alert alert-success" id="MSG" role="alert" style="display: none">
                The Video has add to queue, wait trancoding done.......  <button type="button" class="btn btn-primary btn-sm" onClick="window.location.reload()">Upload More......</button>
            </div>

        </div>

    </div>
<!--
    <hr class="featurette-divider">
    <div class="text-center"><?php echo isset($pager) ? $pager : ''; ?></div>
-->

    <footer class="pt-4 my-md-5 pt-md-5 border-top">
        <div class="row">
            <div class="col-12 col-md">
                <small class="d-block mb-3 text-muted">&copy; 2018 Cloud Transcoder System (Beta) </small>
            </div>
        </div>
    </footer>
</div>

</div>

<!-- Modal -->
<div class="modal fade" id="UPLOADModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="Title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <div id="Player">
                            <video id="VIP" class="video-js vjs-16-9 vjs-default-skin vjs-big-play-centered" poster="" fluid="true" controls preload="auto">
                                <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that
                                    <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
                                </p>
                            </video>
                        </div>
                        <form class="form-inline">
                            <div class="form-group mb-2">
                                <label for="staticEmail2" class="sr-only">HLS URL</label>
                                <input type="text" readonly class="form-control" id="m3u8url" style="width: 700px;">
                            </div>
                            <button type="submit" class="btn btn-primary mb-2" data-clipboard-action="copy" data-clipboard-target="#m3u8url">Copy</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a id="VIPDownload" href="#" onclick="alert('Not VIP,No Access!');" class="btn btn-primary">Download Videos</a>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/jquery@3.3.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/clipboard@2/dist/clipboard.min.js"></script>

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


</body>
</html>


