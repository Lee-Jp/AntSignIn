<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:86:"F:\phpStudy\PHPTutorial\WWW\signIn\public/../application/admin\view\index\welcome.html";i:1555498346;}*/ ?>
﻿
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
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
<script type="text/javascript" src="lib/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<title>我的桌面</title>
</head>
<body>
<div class="page-container">
	<p class="f-20 text-success">欢迎使用蚂蚁考勤后台管理系统！</p>
	<p><?php echo \think\Session::get('username'); ?>，
		<span id="time">
	</span></p>
	<p>
		<script src="http://www.zzsky.cn/code/mrmy/mrmy.asp" charset="gb2312">

		</script>
	</p>
	<table class="table table-border table-bordered table-bg mt-20">
		<thead>
			<tr>
				<th colspan="2" scope="col">服务器信息</th>
			</tr>
		</thead>
		<tbody>
			<?php if(is_array($info) || $info instanceof \think\Collection || $info instanceof \think\Paginator): $i = 0; $__LIST__ = $info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
			<tr>
				<td width="30%"><?php echo $key; ?>：</td>
				<td><?php echo $v; ?></td>
			</tr>
			<?php endforeach; endif; else: echo "" ;endif; ?>
		</tbody>
	</table>
</div>
<footer class="footer mt-20">
	<div class="container">
		<p>感谢H-ui、jQuery、layer、laypage、Validform、UEditor、My97DatePicker、iconfont、Datatables、WebUploaded、icheck、highcharts、bootstrap-Switch<br>
			Copyright &copy;2019 河北工程技术学院 All Rights Reserved.<br>
			本系统由<a href="mailto:95333@sohu.com" target="_blank" title="智达工作室">智达工作室</a>提供技术支持</p>
	</div>
</footer>
<script type="text/javascript" src="/signIn/public/static/admin/h-ui.admin/lib/jquery/1.9.1/jquery.js"></script>
<script type="text/javascript" src="/signIn/public/static/admin/h-ui/js/H-ui.min.js"></script>
<script>
    $(function(){
        var $dt = document.getElementById("time"); // 得到容器对象
        var dt = new Date(); // 得到当前时间
        var h = dt.getHours();
        var str = '';
        if(h<9){
            str = '早上好';
        }else if(h<12){
            str = '上午好';
        }else if(h<18){
            str = '下午好';
        }else{
            str = '晚上好';
        }
        $dt.innerHTML = str; // 将格式化后的内容装载到容器中
    })
</script>
</body>
</html>