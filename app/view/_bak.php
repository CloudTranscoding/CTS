

<link rel="stylesheet" type="text/css" href="/dist/webuploader-0.1.5/webuploader.css">
<script type="text/javascript" src="/dist/webuploader-0.1.5/webuploader.js"></script>
<script type="text/javascript" src="/dist/md5.js"></script>
<!--
<script type="text/javascript" src="/dist/upload.js"></script>
-->
<script language="javascript">
    var hostname = window.location.hostname
    var port = window.location.port || '80';
    var ServerUrl = "http://" + hostname + ":" + port + "/uploads";
    if (port == 80) { ServerUrl = "http://" + hostname + "/uploads"; }
</script>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.3.1/dist/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/min/dropzone.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/clipboard@2/dist/clipboard.min.js"></script>
<script type="text/javascript" src="/dist/uploader.js"></script>
<script type="text/javascript" src="/dist/md5.js"></script>
<script type="text/javascript" src="/dist/upload.js"></script>
<script src="/dist/z.js"></script>
<script language="javascript">
    /*
    $.ajax({
        url: "/category",
        dataType: "json",
        success: function (data) {
            var result = "<option value=''>默认</option>";
            for (var i = 0; i < data.length; i++) {
                result += "<option value='" + data[i] + "'>" + data[i] + "</option>"

            }
            $("#category")
                .change(function () {
                    var str = "";
                    $("select option:selected").each(function () {
                        str += $(this).text();
                    });
                    userInfo.category = str;
                })
                .change();
            $("#category").html(result)
        }
    })
    */
</script>
<script>




</script>


<script language="javascript">
    //上传地址
    var hostname = window.location.hostname
    var port = window.location.port || '80';
    var ServerUrl = "http://" + hostname + ":" + port + "/uploads";
    if (port == 80) {
        ServerUrl = "http://" + hostname + "/uploads";
    }
</script>

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
                分类: <select name="category" id="category"></select>
            </div>
        </div>

        <div class="lksmrh-coke">



            <!--视频信息
            <div class="klspjx">
                <div class="klspjx-kalw">
                    <div class="klspjx-cker">

                        <h3>视频信息</h3>

                        <div class="alkmst">
                            <div class="srkmsy"><span>标题：</span>
                                <p><input readOnly="true" type="text" name="title" id="title" value="" size="45"></p>
                            </div>
                            <div class="srkmsy"><span>缩略图：</span>
                                <p><input readOnly="true" type="text" name="titlepic" id="titlepic" value="" size="45"></p>
                            </div>
                            <div class="srkmsy"><span>动图：</span>
                                <p><input readOnly="true" type="text" name="titlegif" id="titlegif" value="" size="45"></p>
                            </div>
                            <div class="srkmsy"><span>视频地址：</span>
                                <p><input readOnly="true" type="text" name="odownpath1" id="odownpath1" value="" size="45"></p>
                            </div>
                            <div class="srkmsy"><span>下载地址：</span>
                                <p><input readOnly="true" type="text" name="downpath1" id="downpath1" value="" size="45"></p>
                            </div>
                            <div class="srkmsy"><span>分享地址：</span>
                                <p><input readOnly="true" type="text" name="share" id="share" value="" size="45"></p>
                            </div>
                            <div class="srkmsy"><span>视频ID：</span>
                                <p><input readOnly="true" type="text" name="vid" id="vid" value="" size="45"></p>
                            </div>
                            <div class="srkmsy"><span>视频时长：</span>
                                <p><input readOnly="true" type="text" name="videotime" id="playtime" value="" size="45"></p>
                            </div>
                            <div class="srkmsy"><span>视频码率：</span>
                                <p><input readOnly="true" type="text" name="videobitrate" id="videobitrate" value="" size="45"></p>
                            </div>
                            <div class="srkmsy"><span>视频帧率：</span>
                                <p><input readOnly="true" type="text" name="videoframerate" id="videoframerate" value="" size="45"></p>
                            </div>
                            <div class="srkmsy"><span>视频分辨率：</span>
                                <p><input readOnly="true" type="text" name="videoresolution" id="videoresolution" value="" size="45"></p>
                            </div>

                            <div class="srkmsy"><span>文件大小：</span>
                                <p><input readOnly="true" type="text" name="sizeview" id="sizeview" value="" size="45"></p>
                            </div>
                            <div class="srkmsy"><span>文件后缀：</span>
                                <p><input readOnly="true" type="text" name="suffix" id="suffix" value="" size="45"></p>
                            </div>
                            <div class="srkmsy"><span>二维码：</span>
                                <p><input readOnly="true" type="text" name="erweima" id="erweima" value="" size="45"></p>
                            </div>
                            <div class="srkmsy"><span>视频源文件地址：</span>
                                <p><input readOnly="true" type="text" name="videofileurl" id="videofileurl" value="" size="45"></p>
                            </div>
                            <div class="srkmsy"><span>源文件地址：</span>
                                <p><input readOnly="true" type="text" name="fileurl" id="fileurl" value="" size="45"></p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            -->
            <!--/视频信息-->



        </div>
</main>




