<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/video.js@6.7.3/dist/video-js.min.css">
    <title>Video</title>
    <style>

    </style>
</head>
<body>

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="/index">
            <img src="https://www.wowza.com/uploads/images/icon-transcode-150x150.png" width="30" height="30" class="d-inline-block align-top" alt="">
            Cloud Transcoding System
        </a>

        <form class="form-inline">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit" disabled>Search</button>
        </form>
        <span class="navbar-text">
            <a class="btn btn-outline-light" href="/index/upload">Upload</a>
        </span>

    </div>
</nav>

<div class="container">

    <div class="card">
        <h4 class="card-header bg-dark text-white"><strong>Latest Video Upload....</strong>   <span style="font-size: 12px;">All video has review! </span></h4>
    </div>

    <div class="row">
        <?php
        use Khill\Duration\Duration;
        foreach ($datas as $v) {
            $P = '/cloud/';
            $ID = $v['video_id'];
            $VK = $v['video_relid'];
            $VT = $v['video_title'];
            $VDT = new Duration($v['video_duration']);
            $VD = $VDT->humanizec();
            //$VD = $v['video_description'];
            $VP = $P.$v['video_output'].'/img/'.rand(2,10).'.jpg';
            $VM = $P.$v['video_output'].'/mozaique.jpg';
            $VS = $P.$v['video_output'].'/slide.jpg';
            $V1 = $P.$v['video_output'].'/index.m3u8';
            $V2 = $P.$v['video_output'].'/'.$VK.'.mp4';
            $str = '
            <div class="col-sm-4">
                <a class="view" data-id="'.$ID.'" data-name="'.$VT.'" data-hls="'.$V1.'" data-mp4="'.$V2.'" data-poster="'.$VM.'">
                    <img class="img-thumbnail img-fluid" src="'.$VP.'" alt="'.$VD.'">
                    <div style="position: absolute; top: 3px; right: 22px;"><span class="badge badge-dark">'.$VD.'</span></div>
                    <figcaption class="figure-caption text-right text-truncate">'.$VT.'</figcaption>
                </a>
            </div>
            ';
            $c[] = $str;
        }
        echo implode("\r\n",$c);

        ?>
    </div>


    <hr class="featurette-divider">
    <div class="text-center"><?php echo isset($pager) ? $pager : ''; ?></div>

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
<div class="modal fade" id="VIPModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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

                        <div class="form-group">
                            <label for="exampleFormControlTextarea1"><b>Share Text</b> (分享至其他论坛进行引流) </label>
                            <textarea class="form-control" id="sharetext" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary mb-2" data-clipboard-action="copy" data-clipboard-target="#sharetext">Copy</button>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a id="VIPDownload" href="#" onclick="alert('No Enable!');" class="btn btn-primary">Download Videos</a>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/jquery@3.3.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/clipboard@2/dist/clipboard.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/video.js@6.7.3/dist/video.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/videojs-contrib-hls@5.14.1/dist/videojs-contrib-hls.min.js"></script>
<script>
    var clipboard = new ClipboardJS('.btn');
    clipboard.on('success', function(e) {
        console.info('Action:', e.action);
        console.info('Text:', e.text);
        console.info('Trigger:', e.trigger);
        e.clearSelection();
    });
    clipboard.on('error', function(e) {
        console.error('Action:', e.action);
        console.error('Trigger:', e.trigger);
    });

</script>
<script>
    'use strict';
    videojs.options.hls.overrideNative = true; //Remove if not use HLS, Fix the
    var options = {
        html5: {
            nativeAudioTracks: false,
            nativeVideoTracks: false
        }
    };
    var player = videojs("VIP",options);
    var timestamp = Math.round(new Date().getTime()/1000);
    jQuery(".view").click(function() {
        var name = jQuery(this).data('name');
        //var img = jQuery(this).find("img").attr("src");
        var poster = jQuery(this).data('poster');
        var hls = jQuery(this).data('hls');
        var mp4 = jQuery(this).data('mp4');
        var sources = [//{type: "video/mp4", src: url }
            {type: "application/x-mpegURL", src: hls}
        ];
        $("#Title").html(name);
        $("#m3u8url").val( hls.replace('/cloud','<?php echo $public; ?>'));
        $.get( "/api/getsharetext?id="+jQuery(this).data('id'), function(data){$("#sharetext").val(data);});
        player.pause();
        player.poster(poster);
        player.src(sources);
        player.load();
        jQuery('#VIPModal').modal('show');
        //player.play();
    });
    $('#VIPModal').on('hidden.bs.modal', function (e) { //close Modal stop video backed player....
        //console.log('hide');
        player.pause();
    })
</script>


</body>
</html>


