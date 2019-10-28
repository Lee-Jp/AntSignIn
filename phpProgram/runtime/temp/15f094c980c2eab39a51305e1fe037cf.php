<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:84:"F:\phpStudy\PHPTutorial\WWW\signIn\public/../application/admin\view\index\index.html";i:1554542248;s:69:"F:\phpStudy\PHPTutorial\WWW\signIn\application\admin\view\layout.html";i:1555402866;}*/ ?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="Bookmark" href="/favicon.ico" >
    <link rel="Shortcut Icon" href="/favicon.ico" />
    <!--[if lt IE 9]>
    <script type="text/javascript" src="/signIn/public/static/admin/h-ui.admin/lib/html5shiv.js"></script>
    <script type="text/javascript" src="/signIn/public/static/admin/h-ui.admin/lib/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="/signIn/public/static/admin/h-ui/css/H-ui.min.css" />
    <link rel="stylesheet" type="text/css" href="/signIn/public/static/admin/h-ui.admin/css/H-ui.admin.css" />
    <link rel="stylesheet" type="text/css" href="/signIn/public/static/admin/h-ui.admin/lib/Hui-iconfont/1.0.8/iconfont.css" />
    <link rel="stylesheet" type="text/css" href="/signIn/public/static/admin/h-ui.admin/skin/default/skin.css" id="skin" />
    <link rel="stylesheet" type="text/css" href="/signIn/public/static/admin/h-ui.admin/css/style.css" />
    <!--[if IE 6]>
    <script type="text/javascript" src="/signIn/public/static/admin/h-ui.admin/lib/DD_belatedPNG_0.0.8a-min.js" ></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->
    <title>蚂蚁考勤后台管理系统</title>
    <meta name="keywords" content="H-ui.admin v3.1,H-ui网站后台模版,后台模版下载,后台管理系统模版,HTML后台模版下载">
    <meta name="description" content="H-ui.admin v3.1，是一款由国人开发的轻量级扁平化网站后台模板，完全免费开源的网站后台管理系统模版，适合中小型CMS后台系统。">
</head>
<body>
<header class="navbar-wrapper">
    <div class="navbar navbar-fixed-top">
        <div class="container-fluid cl"> <a class="logo navbar-logo f-l mr-10 hidden-xs">蚂蚁考勤后台管理系统</a>
            <a aria-hidden="false" class="nav-toggle Hui-iconfont visible-xs" href="javascript:;">&#xe667;</a>
            <nav id="Hui-userbar" class="nav navbar-nav navbar-userbar hidden-xs">
                <ul class="cl">
                    <li>
                        <p id="time">
                            //当前时间
                            <script language="javascript">
                                function showTime(){
                                    var $dt = document.getElementById("time"); // 得到容器对象
                                    var dt = new Date(); // 得到当前时间
                                    var y = dt.getFullYear(); // 当前年份
                                    var m = dt.getMonth() + 1; // 当前月份，getMonth 返回值是 0-11 对应 admin-12月，因此全部加1
                                    var d = dt.getDate();
                                    var h = dt.getHours();
                                    if(h<10) h='0' + h;
                                    var i = dt.getMinutes();
                                    if(i<10) i='0' + i;
                                    var s = dt.getSeconds();
                                    if(s<10) s='0' + s;
                                    var str = y + '年' + m + '月' + d + '日 ' + h + '时' + i + '分' + s + '秒';
                                    $dt.innerHTML = str; // 将格式化后的内容装载到容器中
                                }
                                showTime();
                                setInterval("showTime()",1000);
                            </script>
                        </p>
                    </li>
                    <li class="dropDown dropDown_hover">
                        <a href="#" class="dropDown_A"><?php echo \think\Session::get('username'); ?> <i class="Hui-iconfont">&#xe6d5;</i></a>
                        <ul class="dropDown-menu menu radius box-shadow">
                            <li><a href="javascript:;" onClick="myselfinfo()">个人信息</a></li>
                            <li><a href="<?php echo url('login/log'); ?>">切换账户</a></li>
                            <li><a href="<?php echo url('login/logout'); ?>">退出</a></li>
                        </ul>
                    </li>
                    <li id="Hui-msg"> <button onclick="zp()" title="清除缓存" class="	btn btn-warning radius ">清除缓存</button> </li>
                    <li id="Hui-skin" class="dropDown right dropDown_hover"> <a href="javascript:;" class="dropDown_A" title="换肤"><i class="Hui-iconfont" style="font-size:18px">&#xe62a;</i></a>
                        <ul class="dropDown-menu menu radius box-shadow">
                            <li><a href="javascript:;" data-val="default" title="默认（黑色）">默认（黑色）</a></li>
                            <li><a href="javascript:;" data-val="blue" title="蓝色">蓝色</a></li>
                            <li><a href="javascript:;" data-val="green" title="绿色">绿色</a></li>
                            <li><a href="javascript:;" data-val="red" title="红色">红色</a></li>
                            <li><a href="javascript:;" data-val="yellow" title="黄色">黄色</a></li>
                            <li><a href="javascript:;" data-val="orange" title="橙色">橙色</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</header>
<aside class="Hui-aside">
    <div class="menu_dropdown bk_2">
        <?php if(\think\Session::get('isadmin') == '1'): ?>
        <dl id="menu-article">
            <dt><i class="Hui-iconfont">&#xe616;</i> 学生管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
            <dd>
                <ul>
                    <li><a data-href="<?php echo url('students/studentslist'); ?>" data-title="学生管理" href="javascript:void(0)">学生管理</a></li>
                </ul>
            </dd>
        </dl>
        <dl id="menu-picture">
            <dt><i class="Hui-iconfont">&#xe613;</i>老师管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
            <dd>
                <ul>
                    <li><a data-href="<?php echo url('coursetable/mycoursetable'); ?>" data-title="课表管理" href="javascript:void(0)">我的课表</a></li>
                    <li><a data-href="<?php echo url('coursetable/coursetablelist'); ?>" data-title="课表管理" href="javascript:void(0)">课表管理</a></li>
                </ul>
            </dd>
        </dl>
        <dl id="menu-product">
            <dt><i class="Hui-iconfont">&#xe620;</i> 班级管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
            <dd>
                <ul>
                    <li><a data-href="<?php echo url('classes/classeslist'); ?>" data-title="班级管理" href="javascript:void(0)">班级管理</a></li>
                    <li><a data-href="<?php echo url('subject/subjectlist'); ?>" data-title="课程管理" href="javascript:void(0)">课程管理</a></li>
                </ul>
            </dd>
        </dl>
        <dl id="menu-admin">
            <dt><i class="Hui-iconfont">&#xe62d;</i> 管理员管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
            <dd>
                <ul>
                    <li><a data-href="<?php echo url('manager/managerlist'); ?>" data-title="管理员列表" href="javascript:void(0)">管理员列表</a></li>
                </ul>
            </dd>
        </dl>
        <dl id="menu-system">
            <dt><i class="Hui-iconfont">&#xe62e;</i> 信息统计<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
            <dd>
                <ul>
                    <li><a data-href="<?php echo url('statistics/statisticslist'); ?>" data-title="数据展示" href="javascript:void(0)">数据展示</a></li>
                    <li><a data-href="<?php echo url('statistics/statisticsadminecharts'); ?>" data-title="考勤报表" href="javascript:void(0)">考勤报表</a></li>
            </dd>
        </dl>
        <?php else: ?>
        <dl id="menu-">
            <dt><i class="Hui-iconfont">&#xe613;</i>老师管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
            <dd>
                <ul>
                    <li><a data-href="<?php echo url('coursetable/mycoursetable'); ?>" data-title="我的课表" href="javascript:void(0)">我的课表</a></li>
                    <li><a data-href="<?php echo url('coursetable/coursetablelist'); ?>" data-title="课表管理" href="javascript:void(0)">课表管理</a></li>
                    <li><a data-href="<?php echo url('statistics/statisticstealist'); ?>" data-title="数据展示" href="javascript:void(0)">数据展示</a></li>
                    <li><a data-href="<?php echo url('statistics/statisticsteaecharts'); ?>" data-title="考勤报表" href="javascript:void(0)">考勤报表</a></li>
                </ul>
            </dd>
        </dl>
        <?php endif; ?>
    </div>
</aside>
<div class="dislpayArrow hidden-xs"><a class="pngfix" href="javascript:void(0);" onClick="displaynavbar(this)"></a></div>



<div class="contextMenu" id="Huiadminmenu">
    <ul>
        <li id="closethis">关闭当前 </li>
        <li id="closeall">关闭全部 </li>
    </ul>
</div>

<section class="Hui-article-box">
    <div id="Hui-tabNav" class="Hui-tabNav hidden-xs">
        <div class="Hui-tabNav-wp">
            <ul id="min_title_list" class="acrossTab cl" style="width: 133px; left: 0px;">
                <li class="active">
                    <span title="我的桌面" data-href="">我的桌面</span>
                    <em></em></li>
            </ul>
        </div>
        <div class="Hui-tabNav-more btn-group" style="display: none;"><a id="js-tabNav-prev" class="btn radius btn-default size-S" href="javascript:;"><i class="Hui-iconfont"></i></a><a id="js-tabNav-next" class="btn radius btn-default size-S" href="javascript:;"><i class="Hui-iconfont"></i></a></div>
    </div>
    <div id="iframe_box" class="Hui-article">
        <div class="show_iframe">
            <div style="display:none" class="loading"></div>
            <iframe scrolling="yes" frameborder="0" src="<?php echo url('index/welcome'); ?>"></iframe>
        </div>
    </div>
</section>
<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="/signIn/public/static/admin/h-ui.admin/lib/jquery/1.9.1/jquery.js"></script>
<script type="text/javascript" src="/signIn/public/static/admin/h-ui.admin/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/signIn/public/static/admin/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="/signIn/public/static/admin/h-ui.admin/js/H-ui.admin.js"></script> <!--/_footer 作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/signIn/public/static/admin/h-ui.admin/lib/jquery.contextmenu/jquery.contextmenu.r2.js"></script>
<script type="text/javascript">
    $(function(){
        $("#min_title_list li").contextMenu('Huiadminmenu', {
            bindings: {
                'closethis': function(t) {
                    console.log(t);
                    if(t.find("i")){
                        t.find("i").trigger("click");
                    }
                },
                'closeall': function(t) {
                    alert('Trigger was '+t.id+'\nAction was Email');
                },
            }
        });
    });
    /*个人信息*/
    function myselfinfo(){
        layer.open({
            type: 1,
            area: ['300px','200px'],
            fix: false, //不固定
            maxmin: true,
            shade:0.4,
            title: '查看信息',
            content: '<div>管理员信息</div>'
        });
    }

    /*资讯-添加*/
    function article_add(title,url){
        var index = layer.open({
            type: 2,
            title: title,
            content: url
        });
        layer.full(index);
    }
    /*图片-添加*/
    function picture_add(title,url){
        var index = layer.open({
            type: 2,
            title: title,
            content: url
        });
        layer.full(index);
    }
    /*产品-添加*/
    function product_add(title,url){
        var index = layer.open({
            type: 2,
            title: title,
            content: url
        });
        layer.full(index);
    }
    /*用户-添加*/
    function member_add(title,url,w,h){
        layer_show(title,url,w,h);
    }

    function zp(){
        $.ajax({
            type: "POST",
            url:"<?php echo url('index/clearRuntime'); ?>",
            data:{user:1},
            success:function(r){
                if(r==1){
                    alert('清除成功！');
                }
            }
        })
    }

</script>
<script>
</script>
</body>
</html>