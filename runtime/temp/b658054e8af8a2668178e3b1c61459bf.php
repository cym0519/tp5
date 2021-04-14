<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:74:"/usr/local/apache/htdocs/tp5/public/../application/api/view/api/login.html";i:1617595845;}*/ ?>

<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1  maximum-scale=1 user-scalable=no">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-touch-fullscreen" content="yes">
	<meta name="HandheldFriendly" content="True">

	<link rel="stylesheet" href="/static/api/css/materialize.css">
	<link rel="stylesheet" href="/static/api/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="/static/api/css/normalize.css">
	<link rel="stylesheet" href="/static/api/css/owl.carousel.css">
	<link rel="stylesheet" href="/static/api/css/owl.theme.css">
	<link rel="stylesheet" href="/static/api/css/owl.transitions.css">
	<link rel="stylesheet" href="/static/api/css/fakeLoader.css">
	<link rel="stylesheet" href="/static/api/css/style.css">

	<link rel="shortcut icon" href="/static/api/img/favicon.png">

</head>
<body class="login-register-wrap">

	<!-- login register -->
	<div class="login-register-wrap-home">
		<div class="container">
			<div class="content">
				<form action="">
					<input type="text" placeholder="账号" name="username">
					<input type="text" placeholder="密码" name="password">
					<input style="width: 40%; float: left" type="text" id="code" placeholder="输入验证码" name="vcode">
<!--					<input style="background-color: #0b0b0b; width: 38%" type="button" id="mes" value="获取验证码" onclick="time(this)">-->
					<img style="margin: 20px; height: 30px; width: 40%" src="<?php echo captcha_src(); ?>"
						 class="verifyimg" alt="captcha">
					<span><a style="text-decoration: underline;" href="<?php echo url('api/api/retrieve'); ?>">忘记密码?</a></span>
					<input style="background-color: #4faeef; width: 100px;margin: auto;margin-top: 5px;" type="button" id="login" value="登录">
					<input style="background-color: #ffffff; color: #4faeef; width: 100px;margin: auto" type="button" id="reg" value="注册">
<!--					<a class="button-default" href="">Sign in</a>-->
<!--					<h6><a href="" style="color:#b2c3e0;">Sign up</a></h6>-->
				</form>
			</div>
		</div>
	</div>
	<!-- end login register -->
	
	<!-- scripts -->
	<script src="/static/api/js/jquery.min.js"></script>
	<script src="/static/api/js/materialize.min.js"></script>
	<script src="/static/api/js/owl.carousel.min.js"></script>
	<script src="/static/api/js/contact-form.js"></script>
	<script src="/static/api/js/fakeLoader.min.js"></script>
	<script src="/static/api/js/main.js"></script>
	<script src="/static/layui/layui.js"></script>
	<script type="text/javascript">
		$(function () {
			var verifyimg=$('.verifyimg').attr("src");
			$('.verifyimg').click(function () {
				if (verifyimg.indexOf('?')>0){
					$('.verifyimg').attr('src',verifyimg+'&random'+Math.random());
				}else {
					$('.verifyimg').attr('src',verifyimg.replace(/\?.*$/,'')+'?'+Math.random());
				}
			});
		})
		//登录
			$('#login').click(function () {
				$.ajax({
					url:"<?php echo url('api/api/login'); ?>",
					type:'post',
					data:$('form').serialize(),
					dataType:"json",
					success:function (data) {
						if (data.code==1){
							layer.msg(data.msg);
							window.setTimeout(function () {
								window.location.href=data.url;
							},2000);
						}else{
							layer.msg(data.msg);
							setTimeout(function () {
								window.location.reload();
							},2000);
						}
					}
				})
			});
		//注册
		$('#reg').click(function () {
			location.href="<?php echo url('api/api/register'); ?>";
		});
	</script>
</body>
</html>