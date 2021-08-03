

<div class="user-dashboard">
    <?php echo (!empty($msg)) ? $msg : ''; ?>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 gutter">
            <h2>系统配置</h2>
            <div class="sales">

                <div>
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#s" aria-controls="home" role="tab" data-toggle="tab">系统配置</a></li>
                        <li role="presentation"><a href="#c" role="tab" data-toggle="tab">转码配置</a></li>
                        <li role="presentation"><a href="#h" role="tab" data-toggle="tab">HLS配置</a></li>
                        <li role="presentation"><a href="#w" role="tab" data-toggle="tab">水印配置</a></li>
                        <li role="presentation"><a href="#o" role="tab" data-toggle="tab">其他配置</a></li>
                    </ul>

                    <form class="form-horizontal" id="SET" role="form" method="post" action="">
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="s">
                                <fieldset>
                                    <legend>全局默认设置</legend>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="textinput">系统名称</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="sys_name" id="" value="<?php echo $SYS['sys_name']; ?>">
                                        </div>
                                        <div class="col-sm-6"><p class="form-control-static text-primary">您的系统名称......</p></div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="textinput">授权密匙</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="sys_license" id="" value="<?php echo $SYS['sys_license']; ?>">
                                        </div>
                                        <div class="col-sm-6"><p class="form-control-static text-primary">您的授权密匙......</p></div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="textinput">系统域名</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="sys_domain" id="" value="<?php echo $SYS['sys_domain']; ?>">
                                        </div>
                                        <div class="col-sm-6"><p class="form-control-static text-primary">转码系统域名......</p></div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="textinput">目录结构</label>
                                        <div class="col-sm-4">
                                            <select name="dir_output" class="form-control">
                                                <option value="Ymd" <?php echo ($SYS['dir_output'] == 'Ymd') ? 'selected' : '';  ?>>年月日</option>
                                                <option value="Y/m/d" <?php echo ($SYS['dir_output'] == 'Y/m/d') ? 'selected' : '';  ?>>年/月/日</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-6"><p class="form-control-static text-primary">推荐默认,<kbd>20180101</kbd> 年月日格式</p></div>
                                    </div>

                                </fieldset>

                        </div>
                        <div role="tabpanel" class="tab-pane" id="c">
                            <fieldset>
                                <legend>转码参数设置</legend>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="textinput">视频码率</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="cov_vbit" id="" value="<?php echo $SYS['cov_vbit']; ?>">
                                    </div>
                                    <div class="col-sm-6"><p class="form-control-static text-primary">码率的计算方式见这里......</p></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="textinput">音轨码率</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="cov_abit" id="" value="<?php echo $SYS['cov_abit']; ?>">
                                    </div>
                                    <div class="col-sm-6"><p class="form-control-static text-primary">音轨建议码率<kbd>96 / 128 </kbd>,建议128</p></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="textinput">输出尺寸</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="cov_size" id="" value="<?php echo $SYS['cov_size']; ?>">
                                    </div>
                                    <div class="col-sm-6"><p class="form-control-static text-primary">建议尺寸的有 <kbd>480:-1 和 720:-1  </kbd>其中的"-1",代表视频高度自动计算平衡比例.</p></div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="textinput">跳过片头</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="cov_skiptime" id="" value="<?php echo $SYS['cov_skiptime']; ?>">
                                    </div>
                                    <div class="col-sm-6"><p class="form-control-static text-primary">跳过指定时常的视频 比如 <kbd>00:05:00</kbd> 跳过前5分钟</p></div>
                                </div>

                            </fieldset>

                        </div>
                        <div role="tabpanel" class="tab-pane" id="h">
                            <fieldset>
                                <legend>HLS高级设置</legend>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="textinput">HLS格式</label>
                                    <div class="col-sm-4">
                                        <label class="radio-inline"><input type="radio" name="cov_hls" id="" value="off" <?php echo ($SYS['cov_hls'] == 'off') ? 'checked' : '';  ?>>不转换</label>
                                        <label class="radio-inline"><input type="radio" name="cov_hls" id="" value="on" <?php echo ($SYS['cov_hls'] == 'on') ? 'checked' : '';  ?>>转换</label>
                                    </div>
                                    <div class="col-sm-6"><p class="form-control-static text-primary">是否输出HLS格式的视频? </p></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="textinput">视频加密</label>
                                    <div class="col-sm-4">
                                        <label class="radio-inline"><input type="radio" name="cov_hlsaes" id="" value="off" <?php echo ($SYS['cov_hlsaes'] == 'off') ? 'checked' : '';  ?>>关闭</label>
                                        <label class="radio-inline"><input type="radio" name="cov_hlsaes" id="" value="on" <?php echo ($SYS['cov_hlsaes'] == 'on') ? 'checked' : '';  ?>>开启</label>
                                    </div>
                                    <div class="col-sm-6"><p class="form-control-static text-primary">开启视频AES-128加密(没什么用处)</p></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="textinput">切片时长</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="cov_hlststime" id="" value="<?php echo $SYS['cov_hlststime']; ?>">
                                    </div>
                                    <div class="col-sm-6"><p class="form-control-static text-primary">TS切片时长,建议<kbd>10</kbd>,默认10</p></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="textinput">切片伪装</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="cov_hlsfake" id="" value="<?php echo $SYS['cov_hlsfake']; ?>" disabled>
                                    </div>
                                    <div class="col-sm-6"><p class="form-control-static text-primary">伪装ts的后缀,注意: 伪装后部分老版本浏览器可能误会播放,默认关闭</p></div>
                                </div>
                            </fieldset>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="w">
                            <fieldset>
                                <legend>视频水印设置</legend>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="textinput">视频水印</label>
                                    <div class="col-sm-4">
                                        <label class="radio-inline"><input type="radio" name="cov_watermark" id="" value="off" <?php echo ($SYS['cov_watermark'] == 'off') ? 'checked' : '';  ?>>关闭</label>
                                        <label class="radio-inline"><input type="radio" name="cov_watermark" id="" value="on" <?php echo ($SYS['cov_watermark'] == 'on') ? 'checked' : '';  ?>>开启</label>
                                    </div>
                                    <div class="col-sm-6"><p class="form-control-static text-primary">是否开启视频水印,默认关闭 <kbd>暂时不要开启,可能会导致非标准视频出现转码错误的问题</kbd></p></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="textinput">水印位置</label>
                                    <div class="col-sm-4">

                                        <table class="table table-bordered table-hover">
                                            <tr>
                                                <td><input type="radio" name="cov_position" id="" value="TR" <?php echo ($SYS['cov_position'] == 'TR') ? 'checked' : '';  ?>>左上角</td>
                                                <td></td>
                                                <td><input type="radio" name="cov_position" id="" value="TL" <?php echo ($SYS['cov_position'] == 'TL') ? 'checked' : '';  ?>>右上角</td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td><input type="radio" name="cov_position" id="" value="CC" <?php echo ($SYS['cov_position'] == 'CC') ? 'checked' : '';  ?>>居中</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td><input type="radio" name="cov_position" id="" value="BR" <?php echo ($SYS['cov_position'] == 'BR') ? 'checked' : '';  ?>>左下角</td>
                                                <td></td>
                                                <td><input type="radio" name="cov_position" id="" value="BL" <?php echo ($SYS['cov_position'] == 'BL') ? 'checked' : '';  ?>>右下角</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-sm-6"><p class="form-control-static text-primary">水印的位置</p></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="textinput">水印图片</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="cov_watermarkpic" id="" value="<?php echo $SYS['cov_watermarkpic']; ?>">
                                    </div>
                                    <div class="col-sm-6"><p class="form-control-static text-primary">水印Logo的名称, 放到默认目录 <kbd>/app/watermark/</kbd>下面</p></div>
                                </div>
                            </fieldset>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="h">
                            <fieldset>
                                <legend>其它设置</legend>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="textinput">HLS格式</label>
                                    <div class="col-sm-4">
                                        <label class="radio-inline"><input type="radio" name="cov_hls" id="" value="off" <?php echo ($SYS['cov_hls'] == 'off') ? 'checked' : '';  ?>>不转换</label>
                                        <label class="radio-inline"><input type="radio" name="cov_hls" id="" value="on" <?php echo ($SYS['cov_hls'] == 'on') ? 'checked' : '';  ?>>转换</label>
                                    </div>
                                    <div class="col-sm-6"><p class="form-control-static text-primary">是否输出HLS格式的视频? </p></div>
                                </div>
\
                            </fieldset>
                        </div>
                    </div>

                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="pull-left">
                                    <button type="submit" class="btn btn-primary">保存</button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>

            </div>
        </div>

        <div class="col-md-12 col-sm-12 col-xs-12 gutter">

        </div>

    </div>
    <div class="row">

    </div>
</div>

<script>
    jQuery(document).submit(function(e){
        var form = jQuery(e.target);
        if(form.is("#SET")){ // check if this is the form that you want (delete this check to apply this to all forms)
            e.preventDefault();
            jQuery.ajax({
                type: "POST",
                url: form.attr("action"),
                data: form.serialize(), // serializes the form's elements.
                success: function(data) {
                    location.reload();
                    //console.log(data); // show response from the php script. (use the developer toolbar console, firefox firebug or chrome inspector console)
                }
            });
        }
    });
</script>







