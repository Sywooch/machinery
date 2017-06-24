<?php
use yii\helpers\Html;
?>

<header class="site-header">
    <nav class="navbar navbar-inverse">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><a href="#">For sellers </a></li>
                    <li><a href="#">about us</a></li>
                    <li><a href="#">How it works?</a></li>
                    <li><a href="#">FAQ</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">EUR <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">USD</a></li>
                            <li><a href="#">UAH</a></li>
                            <li><a href="#">RUB</a></li>
                        </ul>
                    </li>
                    <li><a href="#" class="link-login"><i class="fa fa-key" aria-hidden="true"></i> LOGIN</a></li>
                    <li><a href="#" class="link-register"><i class="fa fa-user-plus" aria-hidden="true"></i> REGISTER</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img
                                src="/images/langs/lang-de.png" alt="">CHANGE language <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">DE</a></li>
                            <li><a href="#">RU</a></li>
                            <li><a href="#">EN</a></li>
                            <li><a href="#">UA</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-search" aria-hidden="true"></i></a>
                    <span class="dropdown-menu">
                        <form class="navbar-form navbar-left">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Search">
                            </div>
                            <button type="submit" class="btn btn-default"><i class="fa fa-search" aria-hidden="true"></i></button>
                        </form>
                    </span>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
<div class="container">
	<div class="row header-section">
		<div class="col-md-4 header-logo-col"><a href="/" class="logo"><img src="/images/logo.png" alt=""></a></div>
		<div class="col-md-4 header-button-col"></div>
		<div class="col-md-4 header-banner-col"></div>
	</div>
</div>
</header>
