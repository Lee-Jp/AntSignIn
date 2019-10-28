<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:104:"F:\phpStudy\PHPTutorial\WWW\signIn\public/../application/admin\view\statistics\statisticsteaecharts.html";i:1554972010;}*/ ?>

<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="renderer" content="webkit|ie-comp|ie-stand">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
		<meta http-equiv="Cache-Control" content="no-siteapp" />
		<link rel="Bookmark" href="/favicon.ico">
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
		<title>信息统计</title>
	</head>
	<body>
		<nav class="breadcrumb">
			<i class="Hui-iconfont">&#xe67f;</i> 首页
			<span class="c-gray en">&gt;</span> 信息统计
			<span class="c-gray en">&gt;</span> 信息统计
			<a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);"
			 title="刷新"><i class="Hui-iconfont">&#xe68f;</i></a></nav>
		<div class="page-container">
			<div class="text-c">
				<div>
					开始日期：<input type="date" class="input-text" style="width:200px" name="creattimestart" id="creattimestart">
					结束日期：<input type="date" class="input-text" style="width:200px" name="creattimeend" id="creattimeend">
					班级名称：<select name="className"  id="className" type="text" class="input-text" style="width:200px">
						<option value="">请选择内容</option>
						
					</select>
					课程名称：<select name="kName" id="kName" type="text" class="input-text" style="width:200px">
						<option value="">请选择内容</option>
						
					</select>
					<button type="submit" class="btn btn-success" id="searchBtn"><i class="Hui-iconfont">&#xe665;</i> 搜索</button>
				</div>
			</div>
			<div class="echartsData">
				<div id="echartsData" style="width: 100%;height:400px;"></div>
			</div>
		</div>
		<!--_footer 作为公共模版分离出去-->
		<script type="text/javascript" src="/signIn/public/static/admin/h-ui.admin/lib/jquery/1.9.1/jquery.min.js"></script>
		<script type="text/javascript" src="/signIn/public/static/admin/h-ui.admin/lib/layer/2.4/layer.js"></script>
		<script type="text/javascript" src="/signIn/public/static/admin/h-ui/js/H-ui.min.js"></script>
		<script type="text/javascript" src="/signIn/public/static/admin/h-ui.admin/js/H-ui.admin.js"></script>
		<!--/_footer 作为公共模版分离出去-->

		<!--请在下方写此页面业务相关的脚本-->
		<script type="text/javascript" src="/signIn/public/static/admin/h-ui.admin/lib/My97DatePicker/4.8/WdatePicker.js"></script>
		<script type="text/javascript" src="/signIn/public/static/admin/h-ui.admin/lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
		<script type="text/javascript" src="/signIn/public/static/admin/h-ui.admin/lib/laypage/1.2/laypage.js"></script>
		<script type="text/javascript" src="/signIn/public/static/admin/h-ui.admin/js/echarts.js"></script>
		<script type="text/javascript">
			$(function() {
								
				$.ajax({
					url: 'http://localhost/signin/public/admin/coursetable/ajaxGetCourse',
					type: 'post',
					data: {},
					success:function(res){
						let cName=[],kName=[],kNameList='',cNameList='';
						res.data.map(function(item,index){
							cName.push(item.cname);
							kName.push(item.subname);
						});
						let cNameArr=cName.filter((item,index,self)=>{return self.indexOf(item) == index;});
						let kNameArr=kName.filter((item,index,self)=>{return self.indexOf(item) == index;});
						cNameArr.map(function(item){cNameList+="<option>"+item+"</option>"})
						kNameArr.map(function(item){kNameList+="<option>"+item+"</option>"})
						$('#className').append(cNameList);
						$('#kName').append(kNameList);
					}
				});
				$('#searchBtn').click(function(){
					option.xAxis[0].data=[];
					option.series[0].data=[];//签到成功
					option.series[1].data=[];//迟到
					option.series[3].data=[];//旷课
					option.series[2].data=[];//请假
					if($('#creattimestart').val()==""){
						alert('请选择时间');
						return;
					}else if($('#className').val()==""){
						alert('请选择班级');
						return;
					}else if($('#kName').val()==""){
						alert('请选择课程');
						return;
					}else{
						if($('#creattimeend').val()==$('#creattimestart').val()||$('#creattimeend').val()==""){
							$('#creattimeend').val($('#creattimestart').val());
						}
						$.ajax({
							url: 'http://localhost/signin/public/admin/statistics/teacherGetStatistics',
							type: 'post',
							data: {
								creattimestart:$('#creattimestart').val(),
								creattimeend: $('#creattimeend').val(), //可选（结束时间）
								subname:$('#kName').val(),
								cname:$('#className').val()
							},
							success(res) {
								if(res.code==200&&res.data.length!=0){
									res.data.map(function(item){
										option.xAxis[0].data.push(item.sname);
										option.series[0].data.push(item.num1);//签到成功
										option.series[1].data.push(item.num2);//迟到
										option.series[3].data.push(item.num3);//旷课
										option.series[2].data.push(item.num4);//请假
									});	
								}
								chart.setOption(option);
							}
						});
					}
					
					
				});
				
			});
			var chart = echarts.init(document.getElementById('echartsData'));
			var labelOption = {
				normal: {
					show: true,
					position: 'top',
					rotate: 0,
					distance: 10,
					textStyle: {
						align: 'center',
						verticalAlign: 'middle',
						fontSize:20
					}
				}
			};
			var option = {
				color: ['#1ead4a', '#cacf3f', '#4782dc', '#e43a3a'],
				tooltip: {
					trigger: 'axis',
					axisPointer: { // 坐标轴指示器，坐标轴触发有效
						type: 'shadow' // 默认为直线，可选为：'line' | 'shadow'
					}
				},
				legend: {
					data: ['签到', '迟到', '请假', '旷课']
				},
// 				toolbox:,
// 						dataView: {show: true, readOnly: false},
// 						magicType: {show: true, type: ['line', 'bar', 'stack', 'tiled']},
// 						restore: {show: true},
// 						saveAsImage: {show: true}
// 					}
// 				},
				calculable: true,
				xAxis: [{
					type: 'category',
					axisTick: {
						show: false
					},
					data: []
				}],
				yAxis: [{
					type: 'value'
				}],
				series: [{
						name: '签到',
						type: 'bar',
						barGap: 0,
						label: labelOption,
						data: []
					},
					{
						name: '迟到',
						type: 'bar',
						label: labelOption,
						data: []
					},
					{
						name: '请假',
						type: 'bar',
						label: labelOption,
						data: []
					},
					{
						name: '旷课',
						type: 'bar',
						label: labelOption,
						data: []
					}
				],
				dataZoom: {
					realtime: true, //拖动滚动条时是否动态的更新图表数据
					height: 25, //滚动条高度
					start: 1, //滚动条开始位置（共100等份）
					end: 50 //结束位置（共100等份）
				}
			}

			
		</script>
	</body>
</html>
