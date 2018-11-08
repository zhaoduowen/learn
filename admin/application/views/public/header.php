<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo $this->title ? $this->title: '后台管理';?></title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1" />
	<meta http-equiv="X-UA-Compatible" content="IE=9" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="<?php echo W_STATIC_URL; ?>bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo W_STATIC_URL; ?>bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css">
	<link rel="stylesheet" href="<?php echo W_STATIC_URL; ?>css/nuoyh.css">
	<script src="<?php echo W_STATIC_URL; ?>js/jquery/jquery-1.11.3.min.js"></script>
	<script src="<?php echo W_STATIC_URL; ?>bootstrap/js/bootstrap.js"></script>
	<!-- 日历插件 -->
	<script src="<?php echo W_STATIC_URL; ?>bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
	<script src="<?php echo W_STATIC_URL; ?>bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js"></script>
	<!-- 日历插件 -->
	<!-- 弹出插件 -->
	<script src="<?php echo W_STATIC_URL; ?>js/sco/sco.message.js"></script>
    <script src="<?php echo W_STATIC_URL; ?>js/layer/layer.js"></script>
    <!-- 分页插件 -->
    <script src="<?php echo W_STATIC_URL; ?>js/jqpaginator.min.js"></script>
	<!--[if lt IE 9]>
	  <script src="<?php echo W_STATIC_URL; ?>js/ltie9/html5shiv.min.js"></script>
	  <script src="<?php echo W_STATIC_URL; ?>js/ltie9/respond.min.js"></script>
	<![endif]-->
    <!-- jq公共方法 -->
    <script src="<?php echo W_STATIC_URL; ?>js/public.js"></script>
</head>
<body>

<div class="container-fluid wrap">
	<div class="row">
		<div class="menu col-sm-3 col-md-2 ">
			<?php  $this->load->view('public/left');?>
		</div>
		<div class="right-main col-sm-9 col-md-10">
			<div class="head">
				<div class="container-fluid">
				<h4 class="pull-left">后台管理系统</h4>
				<div class="login pull-right">
					<h4 class="">
						<span><?php echo $_SESSION['zhimei_username'];?></span>&emsp;&emsp;
 						<a class="" href="/user/editpass?id=<?php echo $_SESSION['zhimei_uid'];?>">修改密码</a>&nbsp;&nbsp;
						<a class="" href="/user/logout">退出登录</a>
					 </h4>
					</div>
				</div>
			</div>