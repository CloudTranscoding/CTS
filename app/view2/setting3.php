<div class="user-dashboard">

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 gutter">
            <h2>系统配置</h2>
            <div class="sales">
                <form class="form-horizontal" role="form" method="post">
                    <fieldset>
                        <legend>转码设置</legend>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="textinput">速度设置</label>
                            <div class="col-sm-4">
                                <select name="cov_preset" class="form-control">
                                    <option value="medium">推荐模式</option>
                                    <option value="ultrafast">极速模式</option>
                                    <option value="superfast">超快</option>
                                    <option value="veryfast">非常快</option>
                                    <option value="faster">很快</option>
                                    <option value="fast">快</option>
                                    <option value="slow">慢</option>
                                    <option value="slower">很慢</option>
                                    <option value="veryslow">贤者模式</option>
                                </select>
                            </div>
                            <div class="col-sm6"><p class="form-control-static text-primary">推荐默认的,选择越快的模式,视频清晰度越低,反之越慢清晰度越高</p></div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="textinput">硬件编码</label>
                            <div class="col-sm-4">
                                <select name="cov_preset" class="form-control">
                                    <option value="cpu">默认CPU处理器模式</option>
                                    <option value="cuda">N卡 CUDA/CUVID/NVENC模式</option>
                                    <option value="opencl">I卡 OpenCL模式</option>
                                </select>
                            </div>
                            <div class="col-sm6"><p class="form-control-static text-primary">需要GPU支持,否则会报错,(如果使用N卡,注意并发任务不要超2个)</p></div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="textinput">输出码率</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="cov_vrate" id="" value="700k">
                            </div>
                            <div class="col-sm6"><p class="form-control-static text-primary">码率的计算方式见这里......</p></div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="textinput">跳过片头</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="cov_skiptiome" id="" value="00:00:00">
                            </div>
                            <div class="col-sm6"><p class="form-control-static text-primary">跳过指定时常的视频 比如 <kbd>00:05:00</kbd> 跳过前5分钟</p></div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="textinput">转码开关</label>
                            <div class="col-sm-4">
                                    <label class="radio-inline"><input type="radio" name="1" id="" value="off">关闭</label>
                                    <label class="radio-inline"><input type="radio" name="1" id="" value="on">开启</label>
                            </div>
                            <div class="col-sm-6"><p class="form-control-static text-primary"></p></div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="pull-left">
                                    <button type="submit" class="btn btn-primary">保存</button>
                                </div>
                            </div>
                        </div>

                    </fieldset>
                </form>
            </div>
        </div>

        <div class="col-md-12 col-sm-12 col-xs-12 gutter">

        </div>

    </div>
    <div class="row">

    </div>
</div>





