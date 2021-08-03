$(function(){

    //导航菜单
    $(".nklart, .bjjls, .header1-nav ul li a").click(function(){
        if($(".nklart").hasClass("auon")){
            $("html, body").css("height","").css("overflow","");
            $(".nklart").removeClass("auon");
            $(".bjjls, .header1-nav").removeClass("auyon");
        }else{
            $("html, body").css("height","100%").css("overflow","hidden");
            $(".nklart").addClass("auon");
            $(".bjjls, .header1-nav").addClass("auyon");
        }
    });

    //点击弹出二维码
    $(".erwma").click(function(){

        //获取播放地址
        var erherf = $(this).parent().parent().siblings(".share").attr('href');
        $(".kllse-aon2").attr('href',erherf);

        //获取标题
        var ertitle = $(this).parent().siblings(".short2").text();
        $(".kllse-left-lsr h3").text(ertitle);

        //获取视频大小
        var erdaxi = $(this).parent().parent().siblings(".share").find("#size").text();
        $(".kllse-left-lsr .daxiao").text(erdaxi);

        //获取时长
        var ertime = $(this).parent().parent().siblings(".share").find("#time").text();
        $(".kllse-left-lsr .ertime").text(ertime);

        //获取二维码地址
        var erwma = $(this).find("a").attr("name");
        $(".kllse-right img")[0].src = erwma;

        $(".tvdge").fadeIn();
        $(".zilsamt").fadeIn();
    });

    //点击关闭按钮后隐藏
    $(".zilkd p, .kllse-aon1, .tvdge").click(function(){
        $(".tvdge").fadeOut();
        $(".zilsamt").fadeOut();
    });

    //判断图片地址是否有效
    $(function(){
        $(".ldmoa").bind("error",function(){
            this.src="./skin/images/mytp3.png";
        });
    });

})