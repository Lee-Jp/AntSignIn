<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:100:"F:\phpStudy\PHPTutorial\WWW\signIn\public/../application/admin\view\coursetable\coursetablelist.html";i:1554460280;}*/ ?>
﻿
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
	<script type="text/javascript" src="lib/DD_belatedPNG_0.0.8a-min.js" ></script>
	<script>DD_belatedPNG.fix('*');</script>
	<![endif]-->
	<title>课程表列表</title>
</head>
<body>
<nav class="breadcrumb">
	<i class="Hui-iconfont">&#xe67f;</i> 首页
	<span class="c-gray en">&gt;</span> 课程表管理
	<span class="c-gray en">&gt;</span> 课程表列表
	<a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
	<!--<div class="text-c"> 日期范围：-->
		<!--<input type="text" class="input-text" style="width:250px" placeholder="输入课程表名称" id="" name="">-->
		<!--<button type="submit" class="btn btn-success" id="" name=""><i class="Hui-iconfont">&#xe665;</i> 搜用户</button>-->
	<!--</div>-->
	<div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l">
		<button  onclick="deletaAll()" class="btn btn-danger radius">
				<i class="Hui-iconfont">&#xe6e2;</i> 批量删除</button>
		<a href="<?php echo url('coursetable/coursetableadd'); ?>" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加课程表</a></span>
		<span class="r">共有数据：<strong><?php echo $count; ?></strong> 条</span> </div>
	<table class="table table-border table-bordered table-bg">
		<thead>
		<tr>
			<th scope="col" colspan="9">课程表列表</th>
		</tr>
		<tr class="text-c">
			<th width="25"><input type="checkbox" id="allChecks" onclick="ckAll()"></th>
			<th width="40">ID</th>
			<th width="150">课程名称</th>
			<th width="150">班级</th>
			<th width="150">教室</th>
			<th width="150">星期</th>
			<th width="150">开始时间</th>
			<th width="150">结束时间</th>
			<th width="100">操作</th>
		</tr>
		</thead>
		<tbody>
		<?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
		<tr class="text-c">
			<td><input type="checkbox" value="<?php echo $vo['couid']; ?>" name="check"></td>
			<td><?php echo $vo['couid']; ?></td>
			<td><?php echo $vo['subname']; ?></td>
			<td><?php echo $vo['cname']; ?></td>
			<td><?php echo $vo['classroom']; ?></td>
			<td><?php if($vo['week'] == 'Mon'): ?>星期一
				<?php elseif($vo['week'] == 'Tues'): ?>星期二
				<?php elseif($vo['week'] == 'Wed'): ?>星期三
				<?php elseif($vo['week'] == 'Thur'): ?>星期四
				<?php elseif($vo['week'] == 'Fri'): ?>星期五
				<?php endif; ?>
			</td>
			<td><?php if($vo['starttime'] == '1'): ?>第一节课
				<?php elseif($vo['starttime'] == '2'): ?>第二节课
				<?php elseif($vo['starttime'] == '3'): ?>第三节课
				<?php elseif($vo['starttime'] == '4'): ?>第四节课
				<?php elseif($vo['starttime'] == '5'): ?>第五节课
				<?php elseif($vo['starttime'] == '6'): ?>第六节课
				<?php elseif($vo['starttime'] == '7'): ?>第七节课
				<?php elseif($vo['starttime'] == '8'): ?>第八节课
				<?php elseif($vo['starttime'] == '9'): ?>第九节课
				<?php elseif($vo['starttime'] == '10'): ?>第十节课
				<?php endif; ?>
			</td>
			<td><?php if($vo['endtime'] == '1'): ?>第一节课
				<?php elseif($vo['endtime'] == '2'): ?>第二节课
				<?php elseif($vo['endtime'] == '3'): ?>第三节课
				<?php elseif($vo['endtime'] == '4'): ?>第四节课
				<?php elseif($vo['endtime'] == '5'): ?>第五节课
				<?php elseif($vo['endtime'] == '6'): ?>第六节课
				<?php elseif($vo['endtime'] == '7'): ?>第七节课
				<?php elseif($vo['endtime'] == '8'): ?>第八节课
				<?php elseif($vo['endtime'] == '9'): ?>第九节课
				<?php elseif($vo['endtime'] == '10'): ?>第十节课
				<?php endif; ?>
			</td>
			<td class="td-manage">
				<a title="编辑" href="coursetableedit/couid/<?php echo $vo['couid']; ?>"  class="ml-5" style="text-decoration:none">
					<i class="Hui-iconfont">&#xe6df;</i></a>
				<a title="删除" href="del/couid/<?php echo $vo['couid']; ?>" class="ml-5" style="text-decoration:none">
					<i class="Hui-iconfont">&#xe6e2;</i></a>
			</td>
		</tr>
		<?php endforeach; endif; else: echo "" ;endif; ?>
		</tbody>
	</table>
</div>
<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="/signIn/public/static/admin/h-ui.admin/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/signIn/public/static/admin/h-ui.admin/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/signIn/public/static/admin/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="/signIn/public/static/admin/h-ui.admin/js/H-ui.admin.js"></script> <!--/_footer 作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/signIn/public/static/admin/h-ui.admin/lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="/signIn/public/static/admin/h-ui.admin/lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/signIn/public/static/admin/h-ui.admin/lib/laypage/1.2/laypage.js"></script>
<script type="text/javascript">
    //全选
    function ckAll(){
        var flag=document.getElementById("allChecks").checked;
        var cks=document.getElementsByName("check");
        for(var i=0;i<cks.length;i++){
            cks[i].checked=flag;
        }
    }
    /*资讯-批量删除*/
    function deletaAll() {
        var cks=document.getElementsByName("check");
        var str="";
        //拼接所有的id
        for(var i=0;i<cks.length;i++) {
            if (cks[i].checked) {
                str += cks[i].value + "&";
            }
        }
        //去掉字符串末尾的‘&’
        str = str.substring(0, str.length - 1);
        $.ajax({
            url: "<?php echo url('coursetable/delall'); ?>",
            type: "POST",
            data: {"str": str},
            dataType: "json",
            success: function (res) {
                console.log(res);
                if(res.code == 200){
                    alert(res.msg);
                    window.location.reload();
                }

            }
        });
    }
</script>
</body>
</html>