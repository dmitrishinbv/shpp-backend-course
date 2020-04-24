<!DOCTYPE html>
<html lang="ru">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>shpp-library</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="library Sh++">

    <link rel="stylesheet" href="/public/css/libs.min.css">
    <link rel="stylesheet" href="/public/css/style.css">
    <link rel="shortcut icon" href="/public/images/favicon.png" type="image/png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="/public/js/functions.js"></script>
    <script src="/public/js/book.js" defer=""></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" crossorigin="anonymous"/>
</head>

<body data-gr-c-s-loaded="true" class="">
<section id="header" class="header-wrapper">

    <nav class="navbar navbar-default">

        <div class="container">
            <form action="" method="post">
            <div class="col-xs-5 col-sm-2 col-md-2 col-lg-2">
                <div class="logo"><a href="/library" class="navbar-brand"><span class="sh">Ш</span>
                        <span class="plus">++</span></a></div>
            </div>
            </form>
            <div class="col-xs-12 col-sm-7 col-md-8 col-lg-8">
                <div class="main-menu">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <form class="navbar-form" method="post" action="">
                            <div class="form-group">
                                <input id="search" name = "search" type="text" placeholder="Найти книгу" class="form-control">
                                <input type="submit"  hidden>
                                <div class="loader"><img src="/public/images/loading.gif"></div>
                                <div id="list" size="" class="bAutoComplete mSearchAutoComplete"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xs-2 col-sm-3 col-md-2 col-lg-2 hidden-xs">
                <div class="social">
                    <a href="https://www.facebook.com/shpp.kr/" target="_blank"><span class="fa-stack fa-sm">
                            <i class="fa fa-facebook fa-stack-1x"></i></span></a>
                    <a href="http://programming.kr.ua/ru/courses#faq" target="_blank">
                        <span class="fa-stack fa-sm"><i class="fa fa-book fa-stack-1x"></i></span></a>
                </div>
            </div>
                    <div class="col-xs-2">
                        <br>
                    <a mimetype="text/html" href="/library/admin">Админпанель</a>
                </div>
            </div>
        </div>

    </nav>
</section>