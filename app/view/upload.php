


<main class="main">
    <div class="container">
        <div class="alert alert-danger mb-0" role="alert">
            <strong></strong>
            <p class="mt-0">
                Please Don't Upload (Child Porn/underage) illegal content, We will forward You IP Log to FBI
            </p>
        </div>

        <div class="row">
            <div class="col align-self-center">
                <form class="dropzone" id="my-awesome-dropzone"></form>
            </div>
        </div>

        <hr>

        <div class="card">
            <div class="card-header">Video Public
                <div class="float-right">
                    <button type="button" class="btn btn-primary btn-sm" onClick="window.location.reload()">Reload Upload More</button>
                </div>
            </div>
            <div class="card-body">
                <form id="Queue" method="post" action="/api/create">
                    <input type="hidden" name="video_key" id="fid" value="">
                    <input type="hidden" name="video_hash" id="hash" value="">
                    <input type="hidden" name="video_createddate" id="date" value="">
                    <input type="hidden" name="video_filename" id="inpath" value="">
                    <input type="hidden" name="video_filesize" id="size" value="">

                    <div class="row">
                        <div class="col">
                            <label for="exampleFormControlSelect1">Categories</label>
                            <select name="video_categoryid" class="form-control" id="exampleFormControlSelect1">
                                <option value="1">Default</option>
                                <option value="2">Chinese</option>
                                <option value="3">USA</option>
                            </select>
                        </div>
                        <div class="col">
                            <!--
                            <div class="form-group">
                                <label for="Title">Video Duriton</label>
                                <input class="form-control" readOnly="true" type="text" name="dur" id="dur" value="" size="45">
                            </div>
                            -->
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Title">Video Title</label>
                        <input class="form-control" type="text" name="video_title" id="title" value="" size="45">
                    </div>


                    <div class="form-group">
                        <label for="Title">Video Tag</label>
                        <input class="form-control" type="text" name="video_tags" id="tag" value="" size="45">
                    </div>

                    <div class="form-group">
                        <label for="Desc">Video Desc</label>
                        <textarea class="form-control" name="video_description" id="desc" rows="3"></textarea>
                    </div>

                    <div class="alert alert-success" id="MSG" role="alert" style="display: none">
                        Video has uploaded and added to the transcoding queue!
                    </div>

                    <button type="submit" class="btn btn-primary">Public Video to Queue</button>

                </form>
            </div>
        </div>

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
                            $("#MSG").show();
                        }
                    });
                });
            });
        </script>
    </div>
</main>
<script>
    /*
    Dropzone.prototype.defaultOptions.dictDefaultMessage = "<button type=\"button\" class=\"btn btn-primary\">点击这里</button><br>或者<br>拖拽您的文件到这里";
    Dropzone.prototype.defaultOptions.dictFallbackMessage = "您的浏览器不支持拖拽......";
    Dropzone.prototype.defaultOptions.dictFallbackText = "Please use the fallback form below to upload your files like in the olden days.";
    Dropzone.prototype.defaultOptions.dictFileTooBig = "你传的玩意有 ({{filesize}}MiB)这么大.但是我就允许你传: {{maxFilesize}}MiB.";
    Dropzone.prototype.defaultOptions.dictInvalidFileType = "你不能上传这个文件类型.......";
    Dropzone.prototype.defaultOptions.dictResponseError = "服务器返回 {{statusCode}} 代码.";
    Dropzone.prototype.defaultOptions.dictCancelUpload = "取消上传";
    Dropzone.prototype.defaultOptions.dictCancelUploadConfirmation = "你确认取消上传吗?";
    Dropzone.prototype.defaultOptions.dictRemoveFile = "删除视频";
    Dropzone.prototype.defaultOptions.dictMaxFilesExceeded = "您不能上传更多啦......";
    */
    Dropzone.autoDiscover = false;
    $(function(){
        uploader = new Dropzone(".dropzone",{
            url: "/api/upload",
            paramName : "v_field",
            uploadMultiple :false,
            acceptedFiles : "video/*",
            addRemoveLinks: false,
            forceFallback: false,
            maxFilesize:100000,
            parallelUploads: 100,
        });

        uploader.on("success", function(file,response) {

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
        });

    });
</script>