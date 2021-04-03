<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:75:"/usr/local/apache/htdocs/tp5/public/../application/api/view/index/shop.html";i:1617439274;s:71:"/usr/local/apache/htdocs/tp5/public/../application/api/view/layout.html";i:1617439274;s:71:"/usr/local/apache/htdocs/tp5/public/../application/api/view/header.html";i:1617439274;s:71:"/usr/local/apache/htdocs/tp5/public/../application/api/view/footer.html";i:1617439273;}*/ ?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>云上长安</title>
    <meta name="viewport" content="width=device-width, initial-scale=1  maximum-scale=1">
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
    <link rel="stylesheet" href="/static/api/css/magnific-popup.css">
    <link rel="stylesheet" href="/static/api/css/style.css">
    <link rel="shortcut icon" href="/static/api/img/favicon.png">

</head>
<body>
<!-- navbar top -->
<div class="navbar-top">
    <div class="side-nav-panel-left" style="margin-top: 10px">
        <a href="" data-activates="slide-out-left" class="side-nav-left"><i class="fa fa-bars"></i></a>
    </div>
    <!-- site brand	 -->
    <div class="site-brand">
        <a href="<?php echo url('api/index/index'); ?>"><h1></h1></a>
    </div>
    <!-- end site brand	 -->
    <div class="side-nav-panel-right" style="margin-top: 10px">
        <a href="<?php echo url('api/index/contact'); ?>" class="side-nav-right"><i class="fa fa-envelope"></i></a>
    </div>
</div>
<!-- end navbar top -->

<!-- side nav left-->
<div class="side-nav-panel-left">
    <ul id="slide-out-left" class="side-nav side-nav-panel collapsible">
        <li class="li-top"><a href="<?php echo url('api/index/index'); ?>"><i class="fa fa-home"></i>首页</a></li>
        <li><a href="<?php echo url('api/index/shop'); ?>"><i class="fa fa-shopping-cart"></i>商店</a></li>
        <li><a href="<?php echo url('api/index/getweather'); ?>"><i class="fa fa-bold"></i>天气预报</a></li>
        <li><a href="<?php echo url('api/index/getip'); ?>"><i class="fa fa-th-large"></i>ip地址</a></li>
        <li><a href="<?php echo url('api/index/today'); ?>"><i class="fa fa-dollar"></i>历史上的今天</a></li>
        <li><a href=""><i class="fa fa-hourglass-half"></i>404</a></li>
        <li><a href=""><i class="fa fa-support"></i>Testimonial</a></li>
        <li><a href=""><i class="fa fa-user"></i>About Us</a></li>
        <li><a href=""><i class="fa fa-envelope-o"></i>Contact Us</a></li>
        <li><a href=""><i class="fa fa-sign-in"></i>Login</a></li>
        <li><a href="" id="logout"><i class="fa fa-user-plus"></i>退出登录</a></li>
    </ul>
</div>
<!-- end side nav left-->
<!-- scripts -->
<script src="/static/api/js/jquery.min.js"></script>
<script src="/static/api/js/materialize.min.js"></script>
<script src="/static/api/js/owl.carousel.min.js"></script>
<script src="/static/api/js/fakeLoader.min.js"></script>
<script src="/static/api/js/contact-form.js"></script>
<script src="/static/api/js/main.js"></script>
<script src="/static/layui/layui.js"></script>
<script>
    $(function () {
        $('#logout').click(function () {
            $.ajax({
                url:"<?php echo url('api/api/logout'); ?>",
                success:function (data) {
                    location.href=data.url;
                }
            })
        });
    })
</script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1  maximum-scale=1">
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
    <link rel="stylesheet" href="/static/api/css/magnific-popup.css">
    <link rel="stylesheet" href="/static/api/css/style.css">
    <link rel="shortcut icon" href="/static/api/img/favicon.png">

</head>
<body>
<!-- slider -->
<div class="slider">

    <ul class="slides">
        <li>
            <img src="/static/api/img/slide1.jpg" alt="">
            <div class="caption slider-content center-align">
                <div class="container">
                    <h2>Welcome to my Shop</h2>
                    <h4>Lorem ipsum dolor sit amet.</h4>
                    <a href="" class="button-default">Learn More</a>
                </div>
            </div>
        </li>
        <li>
            <img src="/static/api/img/slide2.jpg" alt="">
            <div class="caption slider-content center-align">
                <div class="container">
                    <h2>Get Discount Today</h2>
                    <h4>Lorem ipsum dolor sit amet.</h4>
                    <a href="" class="button-default">Learn More</a>
                </div>
            </div>
        </li>
        <li>
            <img src="/static/api/img/slide3.jpg" alt="">
            <div class="caption slider-content center-align">
                <div class="container">
                    <h2>Save Values Money</h2>
                    <h4>Lorem ipsum dolor sit amet.</h4>
                    <a href="" class="button-default">Learn More</a>
                </div>
            </div>
        </li>
    </ul>

</div>
<!-- end slider -->

<!-- home shop -->
<!--<div class="shop-home section">-->
<!--    <div class="container">-->
<!--        <div class="row">-->
<!--            <div class="col s6">-->
<!--                <div class="shop">-->
<!--                    <img src="/static/api/img/shop1.png" alt="">-->
<!--                    <h6><a href="shop-single.html">Tshirt Elegant</a></h6>-->
<!--                    <span>$132</span>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="col s6">-->
<!--                <div class="shop">-->
<!--                    <img src="/static/api/img/shop2.png" alt="">-->
<!--                    <h6><a href="shop-single.html">Tshirt Elegant</a></h6>-->
<!--                    <span>$132</span>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div class="row">-->
<!--            <div class="col s6">-->
<!--                <div class="shop">-->
<!--                    <img src="/static/api/img/shop3.png" alt="">-->
<!--                    <h6><a href="shop-single.html">Tshirt Elegant</a></h6>-->
<!--                    <span>$132</span>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="col s6">-->
<!--                <div class="shop">-->
<!--                    <img src="/static/api/img/shop4.png" alt="">-->
<!--                    <h6><a href="shop-single.html">Tshirt Elegant</a></h6>-->
<!--                    <span>$132</span>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div class="row">-->
<!--            <div class="col s6">-->
<!--                <div class="shop">-->
<!--                    <img src="/static/api/img/shop5.png" alt="">-->
<!--                    <h6><a href="shop-single.html">Tshirt Elegant</a></h6>-->
<!--                    <span>$132</span>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="col s6">-->
<!--                <div class="shop">-->
<!--                    <img src="/static/api/img/shop6.png" alt="">-->
<!--                    <h6><a href="shop-single.html">Tshirt Elegant</a></h6>-->
<!--                    <span>$132</span>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div class="row m-bottom">-->
<!--            <div class="col s12">-->
<!--                <div class="shop-pagination">-->
<!--                    <ul>-->
<!--                        <li class="active"><a href="">1</a></li>-->
<!--                        <li><a href="">2</a></li>-->
<!--                        <li><a href="">3</a></li>-->
<!--                        <li><a href="">4</a></li>-->
<!--                        <li><a href="">5</a></li>-->
<!--                    </ul>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<!-- end home shop -->

<!-- scripts -->
<script src="/static/api/js/jquery.min.js"></script>
<script src="/static/api/js/materialize.min.js"></script>
<script src="/static/api/js/owl.carousel.min.js"></script>
<script src="/static/api/js/fakeLoader.min.js"></script>
<script src="/static/api/js/main.js"></script>

</body>
</html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1  maximum-scale=1">
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
    <link rel="stylesheet" href="/static/api/css/magnific-popup.css">
    <link rel="stylesheet" href="/static/api/css/style.css">

    <link rel="shortcut icon" href="/static/api/img/favicon.png">

</head>
<body>
<!-- footer -->
<div class="footer">
    <div class="container">
        <div class="about-us-foot">
            <h6></h6>
            <p>is a lorem ipsum dolor sit amet, consectetur adipisicing elit consectetur adipisicing elit.</p>
        </div>
        <div class="social-media">
            <a href=""><i class="fa fa-facebook"></i></a>
            <a href=""><i class="fa fa-twitter"></i></a>
            <a href=""><i class="fa fa-google"></i></a>
            <a href=""><i class="fa fa-linkedin"></i></a>
            <a href=""><i class="fa fa-instagram"></i></a>
        </div>
        <div class="copyright">
            <span>©All Right By <a href="http://www.bootstrapmb.com/">bootstrapmb</a></span>
        </div>
    </div>
</div>
<!-- end footer -->
</body>

