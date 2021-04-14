<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:76:"/usr/local/apache/htdocs/tp5/public/../application/api/view/index/index.html";i:1617603294;s:71:"/usr/local/apache/htdocs/tp5/public/../application/api/view/layout.html";i:1617439274;s:71:"/usr/local/apache/htdocs/tp5/public/../application/api/view/header.html";i:1617595845;s:71:"/usr/local/apache/htdocs/tp5/public/../application/api/view/footer.html";i:1617593124;}*/ ?>
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
                    <h2>Welcome to Voxes</h2>
                    <h4>Lorem ipsum dolor sit amet.</h4>
                    <a href="" class="button-default">Learn More</a>
                </div>
            </div>
        </li>
        <li>
            <img src="/static/api/img/slide2.jpg" alt="">
            <div class="caption slider-content center-align">
                <div class="container">
                    <h2>A Modern Template</h2>
                    <h4>Lorem ipsum dolor sit amet.</h4>
                    <a href="" class="button-default">Learn More</a>
                </div>
            </div>
        </li>
        <li>
            <img src="/static/api/img/slide3.jpg" alt="">
            <div class="caption slider-content center-align">
                <div class="container">
                    <h2>A Fresh Template</h2>
                    <h4>Lorem ipsum dolor sit amet.</h4>
                    <a href="" class="button-default">Learn More</a>
                </div>
            </div>
        </li>
    </ul>

</div>
<!-- end slider -->

<!-- we are -->
<div class="section we-are">
    <div class="container">
        <div class="section-head">
            <h4><?php echo $name; ?></h4>
            <h4><?php echo $rand; ?></h4>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Modi ipsa eveniet ipsum autem non? Magnam nostrum minima inventore amet id doloribus? Aliquid, facere nesciunt quis rerum assumenda ut provident fugiat.</p>
        </div>
    </div>
</div>
<!-- and we are -->

<!-- features -->
<div class="section features bg-second">
    <div class="container">
        <div class="row">
            <div class="col s6">
                <div class="content">
                    <i class="fa fa-laptop"></i>
                    <h5>Responsive</h5>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit</p>
                </div>
            </div>
            <div class="col s6">
                <div class="content">
                    <i class="fa fa-code"></i>
                    <h5>Clean Code</h5>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s6">
                <div class="content">
                    <i class="fa fa-edit"></i>
                    <h5>Easy Edit</h5>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit</p>
                </div>
            </div>
            <div class="col s6">
                <div class="content">
                    <i class="fa fa-support"></i>
                    <h5>Free Support</h5>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end features -->

<!-- home portfolio -->
<div class="section">
    <div class="container">
        <div class="section-head">
            <h4>Portfolio</h4>
            <div class="underline"></div>
        </div>
        <div class="gallery">
            <ul class="simplefilter">
                <li class="active" data-filter="all"><h5>All</h5></li>
                <li data-filter="1"><h5>Logo</h5></li>
                <li data-filter="2"><h5>Object</h5></li>
                <li data-filter="3"><h5>Art</h5></li>
            </ul>
            <div class="row">
                <div class="filtr-container">
                    <div class="col s6 filtr-item col-pd" data-category="1, 3">
                        <a href="/static/api/img/gallery1.jpg" class="image-popup"><img class="responsive-img" src="/static/api/img/gallery1.jpg" alt="sample image"></a>
                    </div>
                    <div class="col s6 filtr-item col-pd" data-category="2, 3">
                        <a href="/static/api/img/gallery2.jpg" class="image-popup"><img class="responsive-img" src="/static/api/img/gallery2.jpg" alt="sample image"></a>
                    </div>
                    <div class="col s6 filtr-item col-pd" data-category="3, 3">
                        <a href="/static/api/img/gallery3.jpg" class="image-popup"><img class="responsive-img" src="/static/api/img/gallery3.jpg" alt="sample image"></a>
                    </div>
                    <div class="col s6 filtr-item col-pd" data-category="1, 2">
                        <a href="/static/api/img/gallery4.jpg" class="image-popup"><img class="responsive-img" src="/static/api/img/gallery4.jpg" alt="sample image"></a>
                    </div>
                    <div class="col s6 filtr-item col-pd" data-category="2, 1">
                        <a href="/static/api/img/gallery5.jpg" class="image-popup"><img class="responsive-img" src="/static/api/img/gallery5.jpg" alt="sample image"></a>
                    </div>
                    <div class="col s6 filtr-item col-pd" data-category="1, 1">
                        <a href="/static/api/img/gallery6.jpg" class="image-popup"><img class="responsive-img" src="/static/api/img/gallery6.jpg" alt="sample image"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end home portfolio -->

<!-- review -->
<div class="section review-users bg-second">
    <div class="container">
        <div id="owl-review-users">
            <div class="item">
                <img src="/static/api/img/testimonial1.jpg" alt="">
                <h6>John Doe</h6>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorem esse nostrum ex, aspernatur est earum Ad vero eum nam saepe quidem perferendis</p>
                <ul>
                    <li><i class="fa fa-star"></i></li>
                    <li><i class="fa fa-star"></i></li>
                    <li><i class="fa fa-star"></i></li>
                    <li><i class="fa fa-star"></i></li>
                    <li><i class="fa fa-star"></i></li>
                </ul>
            </div>
            <div class="item">
                <img src="/static/api/img/testimonial2.jpg" alt="">
                <h6>John Doe</h6>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorem esse nostrum ex, aspernatur est earum Ad vero eum nam saepe quidem perferendis</p>
                <ul>
                    <li><i class="fa fa-star"></i></li>
                    <li><i class="fa fa-star"></i></li>
                    <li><i class="fa fa-star"></i></li>
                    <li><i class="fa fa-star"></i></li>
                    <li><i class="fa fa-star"></i></li>
                </ul>
            </div>
            <div class="item">
                <img src="/static/api/img/testimonial3.jpg" alt="">
                <h6>John Doe</h6>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorem esse nostrum ex, aspernatur est earum Ad vero eum nam saepe quidem perferendis</p>
                <ul>
                    <li><i class="fa fa-star"></i></li>
                    <li><i class="fa fa-star"></i></li>
                    <li><i class="fa fa-star"></i></li>
                    <li><i class="fa fa-star"></i></li>
                    <li><i class="fa fa-star"></i></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- end review -->

<!-- loader -->
<div id="fakeLoader"></div>
<!-- end loader -->



<!-- scripts -->
<script src="/static/api/js/jquery.min.js"></script>
<script src="/static/api/js/materialize.min.js"></script>
<script src="/static/api/js/owl.carousel.min.js"></script>
<script src="/static/api/js/jquery.filterizr.js"></script>
<script src="/static/api/js/jquery.magnific-popup.min.js"></script>
<script src="/static/api/js/portfolio.js"></script>
<script src="/static/api/js/contact-form.js"></script>
<script src="/static/api/js/fakeLoader.min.js"></script>
<script src="/static/api/js/main.js"></script>
<script src="/static/layui/layui.js"></script>
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

