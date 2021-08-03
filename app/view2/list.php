
<script src="https://cdn.bootcss.com/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="/dist/lib/jquery.jtable.js"></script>
<link href="https://cdn.bootcss.com/jqueryui/1.12.1/jquery-ui.min.css" rel="stylesheet">
<link href="/dist/lib/themes/basic/jtable_basic.min.css" rel="stylesheet" type="text/css" />
<link href="/dist/lib/custom.css" rel="stylesheet" type="text/css" />
<style>
    table th.text-center, table td.text-center {
        text-align: center;
    }
    tr.custom_centered td {
        text-align: center;
    }
    tr.custom_centered th {
        text-align: center;
    }
</style>
<div class="user-dashboard">
    <h1>视频管理</h1>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 gutter">

            <div class="filtering">
                <form class="form-inline">
                    <input type="hidden" name="Search" value="true" />
                    <div class="form-group">
                        <label class="sr-only" for="exampleInputEmail3">Keyword</label>
                        <input type="text" class="form-control" id="title" placeholder="keyword">
                    </div>
                    <div class="form-group">
                        <select class="form-control" id="video_status" name="video_status">
                            <option selected="selected" value="">状态</option>
                        </select>
                    </div>
                    <button type="submit" id="LoadRecordsButton" class="btn btn-primary">搜索</button>
                </form>
            </div>

            <div id="tableContainer"></div>
            <button id="DeleteAllButton" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false">
                <span class="ui-button-text">删除所有</span>
            </button>

            <div class="sales">
            </div>
        </div>
    </div>
</div>
<script>var cdn_domain = "<?php echo get_ecfg("dir_domain"); ?>";</script>
<script type="text/javascript">
    function formatBytes(a,b){if(0==a)return"0 Bytes";var c=1024,d=b||2,e=["Bytes","KB","MB","GB","TB","PB","EB","ZB","YB"],f=Math.floor(Math.log(a)/Math.log(c));return parseFloat((a/Math.pow(c,f)).toFixed(d))+" "+e[f]}

    $(document).ready(function () {
        $('#tableContainer').jtable({
            title: '视频列表',
            paging: true, //Enable paging
            pageSize: 10, //Set page size (default: 10)
            sorting: true,
            defaultSorting: 'video_id Desc', //Set default sorting
            selecting: true, //Enable selecting
            multiselect: true, //Allow multiple selecting
            selectingCheckboxes: true, //Show checkboxes on first column
            actions: {
                listAction: '/api/ajax?api=1&action=l',
                //createAction: '/api/ajax?api=1&action=c',
                updateAction: '/api/ajax?api=1&action=u',
                deleteAction: '/api/ajax?api=1&action=d'
            },
            fields: {
                video_id: {
                    title: "ID",
                    width: '5%',
                    key: true,
                    create: false,
                    edit: false,
                    display: function(data) {
                        var sum = parseInt(data.record.video_id); // + parseInt(8000);
                        return sum;
                    }
                },
                video_title: {
                    title: '标题',
                    width: '60%',
                    edit: true
                },
                video_categoryid: {
                    title: '分类',
                    width: '5%',
                    options: '/api/category/list?opt=1',
                    edit: true
                },
                video_description: {
                    title: '摘要',
                    type: 'textarea',
                    list: false,
                    edit: true
                },
                video_filesize: {
                    title: '大小',
                    edit: false ,
                    display: function(data) {
                        var size = data.record.video_filesize;
                        return formatBytes(size);
                        //var sum = parseInt(data.record.video_id); // + parseInt(8000);
                        //return sum;
                    }
                },
                video_status: {
                    title: '状态',
                    width: '5%',
                    type: 'radiobutton',
                    options: { '9': '<span class="label label-default">待转码</span>', '8': '<span class="label label-info">转码中</span>', '4': '<span class="label label-danger">已失败</span>', '2': '<span class="label label-info">已完成</span>','1': '<span class="label label-success">已发布</span>' },
                    edit: true
                },
                video_outurl: {
                    title: '',
                    width: '5%',
                    sorting: false,
                    edit: false,
                    create: false,
                    display: function (data) {
                        console.log(data);
                        var vid = parseInt(data.record.video_id);
                        var hash = data.record.video_relid;
                        var path = data.record.video_output;
                        var m3u8 = cdn_domain +'/'+ path + '/index.m3u8';
                        var $img = $('<img src="/dist/share.jpg" style="max-width: 128px; max-height: 25px;" title="">');
                        $img.click(function () {
                            $('#m3u8url').val(m3u8);
                            $('#ExModal').modal('show');
                            //alert(m3u8);
                            /*
                            $('#tableContainer').jtable('openChildTable',
                                $img.closest('tr'),
                                {
                                    title: data.record.video_title + ' 外链',
                                    actions: {
                                        listAction: '/api/getshare?id=' + data.record.video_id,
                                    },
                                    fields: {
                                        video_id: {
                                            type: 'hidden',
                                        },
                                        video_hls: {
                                            type: 'textarea',
                                            title: 'HLS Link',
                                            //width: '50%',
                                            display: function (data) {
                                                return '<input type="text"  value="'+ data.record.video_hls + '"/>';
                                            }
                                        }
                                    }
                                }, function (data) { //opened handler
                                    data.childTable.jtable('load');
                                });
                                */
                        });
                        //Return image to show on the person row
                        return $img;
                    }
                }
            }
        });

        //Re-load records when user click 'load records' button.
        $('#LoadRecordsButton').click(function (e) {
            e.preventDefault();
            $('#tableContainer').jtable('load', {
                Search: true,
                video_title: $('#title').val(),
                //switch_relid: $('#cityId').val()
            });
        });

        //Delete selected students
        $('#DeleteAllButton').button().click(function () {
            var $selectedRows = $('#tableContainer').jtable('selectedRows');
            $('#tableContainer').jtable('deleteRows', $selectedRows);
        });

        //Load all records when page is first shown
        $('#LoadRecordsButton').click();

        //Load student list from server
        //$('#tableContainer').jtable('load');

    });
</script>

<!-- Modal -->
<div class="modal fade" id="ExModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" style="color:red;">关闭</span></button>
                <h4 class="modal-title">获取外链</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="col-sm-8"><input type="text" class="form-control" id="m3u8url" readonly></div>
                    <div class="col-sm-4"><button type="button" data-clipboard-action="copy" data-clipboard-target="#m3u8url" class="btn btn-success">复制到剪贴板</button></div>
                </div>
            </div>
            <hr>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

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
    jQuery(".view").click(function() {
        var name = jQuery(this).data('name');
        var img = jQuery(this).find("img").attr("src");
        var url = jQuery(this).data('url');
        var hls = jQuery(this).data('hls');
        var durl = jQuery(this).data('durl');
        var sources = [
            {type: "video/mp4", src: url}
        ];
        //{type: "video/mp4", src: url }
        var width = jQuery(this).data('width');
        var height = jQuery(this).data('height');
        //var durl = url.replace('/mp4/','/download/mp4/');
        //console.log(durl);
        //$('#VIPDownload').attr('onclick', 'location.href =\"' + durl + '\" ');
        player.pause();
        player.src(sources);
        player.load();
        jQuery('#VIPModal').modal('show');
        //player.play();
    });

</script>