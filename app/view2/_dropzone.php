


<form class="dropzone" id="my-awesome-dropzone" enctype="multipart/form-data"></form>
<!---->

<script>

    Dropzone.prototype.defaultOptions.dictDefaultMessage = "<button type=\"button\" class=\"btn btn-primary\"><i class=\"fa fa-cloud-upload\" aria-hidden=\"true\"></i> 点击这里</button><br>或者<br>拖拽您的视频到这里";
    Dropzone.prototype.defaultOptions.dictFallbackMessage = "您的浏览器不支持拖拽......";
    Dropzone.prototype.defaultOptions.dictFallbackText = "Please use the fallback form below to upload your files like in the olden days.";
    Dropzone.prototype.defaultOptions.dictFileTooBig = "你传的玩意有 ({{filesize}}MiB)这么大.但是我就允许你传: {{maxFilesize}}MiB.";
    Dropzone.prototype.defaultOptions.dictInvalidFileType = "你不能上传这个文件类型.......";
    Dropzone.prototype.defaultOptions.dictResponseError = "服务器返回 {{statusCode}} 代码.";
    Dropzone.prototype.defaultOptions.dictCancelUpload = "取消上传";
    Dropzone.prototype.defaultOptions.dictCancelUploadConfirmation = "你确认取消上传吗?";
    Dropzone.prototype.defaultOptions.dictRemoveFile = "删除视频";
    Dropzone.prototype.defaultOptions.dictMaxFilesExceeded = "您不能上传更多啦......";

    Dropzone.autoDiscover = false;
    $(function(){
        uploader = new Dropzone(".dropzone",{
            url: "/api/upload",
            paramName : "v_field",
            uploadMultiple :false,
            acceptedFiles : "video/*",
            addRemoveLinks: false,
            forceFallback: false,
            maxFilesize:5196,
            //parallelUploads: 100,
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
    /**/
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
                    $("#MSG").show();
                }
            });
        });
    });
</script>

