



if (typeof window.console != 'object') {
    window.console = { log: function () { } };
}
//#################################################
var BASE_URL = "";
var chunkSize = 10 * 1024 * 1024; //分块大小
var userInfo = {
    userId: "the_user",
    md5: "",
    category: "",
    uniqueFileName: ""
}; //用户会话信息

var _cache = {};
//#################################################
var uniqueFileName = null; //文件唯一标识符
var md5Mark = null;
var uploader;
jQuery(function () {
    //#############################################
    WebUploader.Uploader.register({
            "before-send-file": "beforeSendFile",
            "before-send": "beforeSend",
            "after-send-file": "afterSendFile"
        },
        {
            beforeSendFile: function (file) {
                var task = new $.Deferred();
                var start = new Date().getTime();
                $("#" + file.id).attr("data-time", new Date().getTime());
                (new WebUploader.Uploader()).md5File(file, 0, 40 * 1024 * 1024).progress(function (percentage) {
                    console.log(percentage);
                }).then(function (val) {
                    console.log("总耗时: " + ((new Date().getTime()) - start) / 1000);
                    md5Mark = val;
                    userInfo.md5 = val;
                    $.ajax({
                        type: "GET",
                        url: ServerUrl,
                        data: {
                            status: "md5Check",
                            md5: val,
                            uploadkey : userInfo.userId,
                            name: file.name.replace("." + file.ext, "")
                        },
                        cache: false,
                        timeout: 3000,
                        //todo 超时的话，只能认为该文件不曾上传过
                        dataType: "json"
                    }).then(function (data, textStatus, jqXHR) {
                            if(data.err_code ) {
                                task.reject("上传密钥错误!");

                                return;
                            }
                            // alert(JSON.stringify(data));
                            if (data.ifExist) { //若存在，这返回失败给WebUploader，表明该文件不需要上传
                                //task.reject();
                                $(".progressBarInProgress").css("width", "100%");
                                $(".percent_str").html("秒传成功");
                                //alert(JSON.stringify(data));
                                if (data.share) {
                                    $("#title").val(data.title);
                                    $("#titlepic").val(data.pic);
                                    $("#titlegif").val(data.gif);
                                    $("#share").val(data.share);
                                    $("#odownpath1").val(data.url);
                                    $("#downpath1").val(data.mp4);
                                    $("#playtime").val(data.duration);
                                    $("#fileurl").val(data.orgfile);
                                    $("#sizeview").val(data.sizeview);
                                    $("#videofileurl").val(data.orgfile);
                                    $("#erweima").val(data.qr);
                                    var id = data.share.substring(data.share.lastIndexOf("/") + 1, data.share.length);
                                    $("#vid").val(id);
                                } else {
                                    $("#fileurl").val(data.orgfile);
                                }
                                task.resolve();
                                uploader.skipFile(file);
                            } else {
                                task.resolve();
                                //拿到上传文件的唯一名称，用于断点续传
                                uniqueFileName = md5('' + userInfo.userId + file.name + file.type + file.lastModifiedDate + file.size);
                                _cache[file.name] = uniqueFileName;

                                userInfo.uniqueFileName = uniqueFileName;
                            }
                        },
                        function (jqXHR, textStatus, errorThrown) { //任何形式的验证失败，都触发重新上传
                            task.resolve();
                            //拿到上传文件的唯一名称，用于断点续传
                            uniqueFileName = md5('' + userInfo.userId + file.name + file.type + file.lastModifiedDate + file.size);
                            userInfo.uniqueFileName = uniqueFileName;
                        });
                });
                return $.when(task);
            },
            beforeSend: function (block) {
                //分片验证是否已传过，用于断点续传

                var task = new $.Deferred();
                $.ajax({
                    type: "GET",
                    url: ServerUrl,
                    data: {
                        status: "chunkCheck",
                        name: uniqueFileName,
                        chunkIndex: block.chunk,
                        size: block.end - block.start
                    },
                    cache: false,
                    timeout: 1000,
                    //todo 超时的话，只能认为该分片未上传过
                    dataType: "json"
                }).then(function (data, textStatus, jqXHR) {
                        if (data.ifExist) { //若存在，返回失败给WebUploader，表明该分块不需要上传
                            task.reject();
                        } else {
                            task.resolve();
                        }
                    },
                    function (jqXHR, textStatus, errorThrown) { //任何形式的验证失败，都触发重新上传
                        task.resolve();
                    });
                return $.when(task);
            },
            afterSendFile: function (file) {
                var chunksTotal = 0;
                //alert(_cache[file.name] );
                //alert( uniqueFileName)
                chunksTotal = Math.ceil(file.size / chunkSize)
                //console.log("chunksTotal : " + chunksTotal);
                if (chunksTotal >= 1) {
                    //合并请求
                    var task = new $.Deferred();
                    $.ajax({
                        type: "GET",
                        url: ServerUrl,
                        data: {
                            status: "chunksMerge",
                            category: userInfo.category ? userInfo.category : "",
                            name: uniqueFileName,
                            chunks: chunksTotal,
                            ext: file.ext,
                            fileoldname: file.name.replace("." + file.ext, ""),
                            md5: md5Mark
                        },
                        cache: false,
                        dataType: "json"
                    }).then(function (data, textStatus, jqXHR) {
                            //todo 检查响应是否正常
                            task.resolve();
                            file.path = data.path;
                            UploadComlate(file);
                            var file_old_name = $.trim($("#" + file.id).find(".progressName").text());
                            if (data.title) {
                                if (data.share) {
                                    $("#title").val(data.title);
                                    $("#titlepic").val(data.pic);
                                    $("#titlegif").val(data.gif);
                                    $("#share").val(data.share);
                                    $("#odownpath1").val(data.url);
                                    $("#downpath1").val(data.mp4);
                                    $("#playtime").val(data.duration);

                                    $("#videoframerate").val(data.metadata.fps);
                                    $("#videoresolution").val(data.metadata.resolution);
                                    $("#videobitrate").val(data.metadata.bitrate );
                                    $("#suffix").val(data.suffix );

                                    $("#sizeview").val(data.sizeview);
                                    $("#videofileurl").val(data.orgfile);
                                    $("#fileurl").val(data.orgfile);
                                    $("#sizeview").val(data.sizeview);
                                    var id = data.share.substring(data.share.lastIndexOf("/") + 1, data.share.length);
                                    $("#vid").val(id);
                                    $("#erweima").val(data.qr);
                                } else {
                                    $("#fileurl").val(data.orgfile);
                                }
                            }
                            $("#moviesay").val(file.name.replace("." + file.ext, ""));
                        },
                        function (jqXHR, textStatus, errorThrown) {
                            task.reject();
                        });
                    return $.when(task);
                } else {
                    UploadComlate(file);
                }
            }
        });
    //#############################################
    var $ = jQuery,
        $list = $('#divFileProgressContainer'),
        state = 'pending';
    //alert(ServerUrl);
    uploader = WebUploader.create({
        dnd: "#chosevideo",
        paste: document.body,
        auto: true,
        resize: false,
        // 不压缩image
        swf: BASE_URL + '/upload/js/Uploader.swf',
        // swf文件路径
        server: ServerUrl,
        // 文件接收服务端。
        pick: {
            id: '#chosevideo',
        },
        accept: {
            title: 'Files',
            extensions: 'ass,srt,rmvb,flv,vob,mp4,mov,3gp,wmv,mp3,mkv,mpg,ts,avi,mpeg,avi,rm,wav,asf,divx,mpg,mpe,vod,mts',
            mimeTypes: '.ass,.srt,.rmvb,.flv,.vob,.mp4,.mov,.3gp,.wmv,.mp3,.mkv,.mpg,.ts,.avi,.mpeg,.avi,.rm,.wav,.asf,.divx,.mpg,.mpe,.vod,.mts'
        },
        duplicate: false,
        chunked: true,
        chunkSize: chunkSize,
        threads: 1,
        multiple: false, //多文件选择
        formData: function () {
            return $.extend(true, {},
                userInfo);
        }
    });
    // 当有文件添加进来的时候
    uploader.on('fileQueued',
        function (file) {
            console.log("有文件添加进来了" + file.name + "," + file.id + file.size);
            var file_size_M = roundNumber(((file.size / 1024) / 1024), 1);
            var html = "";
            html += "<div style=\"height:100px;\" id=\"" + file.id + "\" data-size=\"" + file.size + "\" data-time=\"" + new Date().getTime() + "\">";
            html += "    <div class=\"progressWrapper\" id=\"divFileProgress\" style=\"opacity: 1;\">";
            html += "        <div class=\"progressContainer green\">";
            html += "            <div class=\"progressName\">" + file.name + "<a href=\"javascript:upload_cancle('" + file.id + "');\">取消上传</a></div>";
            html += "            <div class='jindu'><div class=\"progressBarInProgress\" style=\"width: 0.01%;\"></div></div>";
            html += "            <div class=\"progressBarStatus\"><ul>";
            html += "                <li class='first'><b><font color=\"red\" class=\"uploaded_size\"></font></b>MB/" + file_size_M + "MB</li>";
            html += "                <li>上传速度:<b><font color=\"red\" class=\"uploaded_speed\">0</font></b>KB/秒</li>";
            html += "                <li><span class=\"time_name\">剩余时间</span>:<b><font color=\"red\" class=\"time_left\"></font></b></li>";
            html += "                <li class='last'><span class=\"percent_str\">总进度:<b><font color=\"red\" class=\"percent_num\"></font></b></span></li>";
            html += "            </ul></div>";
            html += "        </div>";
            html += "    </div>";
            html += "</div>";
            $list.append(html);
        });
    // 文件上传过程中创建进度条实时显示。
    uploader.on('uploadProgress',
        function (file, percentage) {
            console.log("文件上传进度：" + file.id + "," + percentage);
            var $li = $('#' + file.id);
            //$li.find('p.state').text('上传中');
            $li.find('.progressBarInProgress').css('width', percentage * 100 + '%');
            $li.find('.percent_num').html((percentage * 100).toFixed(2) + '%');
            var total_size = parseFloat($li.attr("data-size"));
            var uploaded_size = total_size * percentage;
            var uploaded_size_show = roundNumber(((uploaded_size / 1024) / 1024), 1).toFixed(1);
            $li.find('.uploaded_size').html(uploaded_size_show);
            var currentTime = new Date().getTime();
            var start_time = parseInt($li.attr("data-time"));
            var used_time = (Math.ceil(currentTime - start_time) / 1000);
            var uploaded_speed = Math.floor(roundNumber(((uploaded_size / used_time) / 1024), 2));
            $li.find('.uploaded_speed').html(uploaded_speed);
            var tempTime = roundNumber(((((total_size - uploaded_size) / uploaded_speed) / 60) / 10), 2);
            var time_left = "";
            if (tempTime != "Infinity") {
                if (tempTime > 0) {
                    time_left = minsec("m", tempTime) + "分:" + minsec("s", tempTime) + '秒';
                } else {
                    time_left = "请等待...";
                }
            } else {
                time_left = "请等待...";
            }
            $li.find('.time_left').html(time_left);
        });
    //文件上传错误
    uploader.on('uploadError',
        function (file, reason) {
            console.log("Error！" + file.id);
            if (state != 'stoped' && state != 'finished') {
                //jError("上传错误，可能是网络原因，请稍后重试",{HorizontalPosition : 'center',VerticalPosition:'center'});
                if(reason)
                    alert("上传错误:" + reason);
                else
                    alert(file.name + " 上传错误，可能是网络原因，请稍后重试" + reason);
            }
        });
    //文件上传成功
    uploader.on('uploadSuccess',
        function (file) {
            console.log("Done！" + file.id);
            var $li = $('#' + file.id);
            var currentTime = new Date().getTime();
            var start_time = parseInt($li.attr("data-time"));
            var used_time = (Math.ceil(currentTime - start_time) / 1000);
            var used_time_str = minsec("m", used_time) + "分:" + minsec("s", used_time) + '秒';
            $li.find('.time_name').html("总用时");
            $li.find('.time_left').html(used_time_str);
            $li.find('.percent_str').html("上传完成，请提交");
            $li.find('.cancle').hide();
        });
    uploader.on('uploadComplete',
        function (file) {
            console.log("Complete！" + file.id);
        });
    uploader.on('all', function (type) {
        console.log(type);
        if (type === 'startUpload') {
            state = 'started';
            console.log("开始上传了~");
        } else if (type === 'stopUpload') {
            state = 'stoped';
            console.log("开始暂停了~");
        } else if (type === 'uploadFinished') {
            state = 'finished';
            console.log("开始结束了~");
        }
    });
});
function UploadComlate(file) {
    console.log("done###" + file.id);
}
function roundNumber(num, dec) {
    var result = Math.round(num * Math.pow(10, dec)) / Math.pow(10, dec);
    return result;
}
function minsec(time, tempTime) {
    var ztime;
    if (time == "m") {
        ztime = Math.floor(tempTime / 60);
        if (ztime < 10) {
            ztime = "0" + ztime;
        }
    } else if (time == "s") {
        ztime = Math.ceil(tempTime % 60);
        if (ztime < 10) {
            ztime = "0" + ztime;
        }
    } else {
        ztime = "minsec error...";
    }
    return ztime;
}
function upload_cancle(id) {
    uploader.stop(id);
    $("#" + id).remove();
}