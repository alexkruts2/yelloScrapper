<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('static/images/logo-light-icon.png')}}">
    <title>海潮管理平台 - 登录</title>

    <!-- page css -->
    <link href="{{asset('static/css/pages/login-register-lock.css')}}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{asset('static/css/style.min.css')}}" rel="stylesheet">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<!-- ============================================================== -->
<!-- Preloader - style you can find in spinners.css -->
<!-- ============================================================== -->
<div class="preloader">
    <div class="loader">
        <div class="loader__figure"></div>
        <p class="loader__label">海潮</p>
    </div>
</div>
<!-- ============================================================== -->
<!-- Main wrapper - style you can find in pages.scss -->
<!-- ============================================================== -->
<section id="wrapper" class="login-register login-sidebar" style="background-image:url({{asset('static/images/background/login-register.jpg')}});">
    <div class="login-box card">
        <div class="card-body">
            <form class="form-horizontal form-material text-center" id="loginform" method="post">
                <a href="javascript:void(0)" class="db"><img width="200px" src="{{asset('static/images/hccenter.png')}}" alt="Home" /></a>
                <div class="form-group m-t-40">
                    <div class="col-xs-12">
                        <input class="form-control" id="mobile" name="mobile" type="text" required="" placeholder="手机号">
                    </div>
                    @if($errors->has('mobile'))
                    <div class="help-block animated fadeInDown">
                        {{ $errors->first('mobile') }}
                    </div>
                    @endif
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <input class="form-control" id="password" name="password" type="text" required="" placeholder="验证码">
                    </div>
                    @if($errors->has('password'))
                    <div class="help-block animated fadeInDown">
                        {{ $errors->first('password') }}
                    </div>
                    @endif
                </div>
                <div class="form-group text-center m-t-20">
                    <div class="col-xs-12">
                        <button id="btnauthcode" class="btn btn-warning btn-lg btn-block text-uppercase waves-effect waves-light" type="button" onclick="getAuthCode()"> 获取验证码</button>
                    </div>
                </div>
                <div class="form-group text-center m-t-20">
                    <div class="col-xs-12">
                        <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">登录</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-footer text-center">
            <div>
                <img src="{{ asset('static/images/hmlogohcs.png') }}" style="width: 100px;">
            </div>

            <span class="text-center">沪ICP备18028867号-2</span>
        </div>
    </div>
</section>

<!-- ============================================================== -->
<!-- End Wrapper -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->
<script src="{{asset('static/plugin/jquery/jquery-3.2.1.min.js')}}"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="{{asset('static/plugin/popper/popper.min.js')}}"></script>
<script src="{{asset('static/plugin/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<script src="{{ asset('static/admin/login.js') }}"></script>
<script src="{{ asset('static/plugin/sweetalert2/sweetalert2.js') }}"></script>

<!--Custom JavaScript -->
<script type="text/javascript">
    $(function() {
        $(".preloader").fadeOut();
    });
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    });
    // ==============================================================
    // Login and Recover Password
    // ==============================================================
</script>

</body>

</html>