<?php
$book_img_src = ($img == NULL) ? "/public/images/No-Image-Available.png" : "data:image/jpeg;base64, ".$img;
?>

<section id="main" class="main-wrapper">
    <div class="container">
        <div id="content" class="book_block col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <script id="pattern" type="text/template">
                <div data-book-id="<?=$id ?>" class="book_item col-xs-6 col-sm-3 col-md-2 col-lg-2">
                    <div class="book">
                     <a href="#"><img src="data:image/jpeg;base64, <?=$img ?>" alt="<?=$name ?>">
                            <div data-title="<?=$name ?>" class="blockI">
                                <div data-book-title="<?=$name ?>" class="title size_text"><?=$name ?></div>
                                <div data-book-author="<?=$authors ?>" class="author"><?=$authors ?></div>
                            </div>
                        </a>
                        <a href="#">
                            <button type="button" class="details btn btn-success">Читать</button>
                        </a>
                    </div>
                </div>
            </script>
            <div id="id">
                <div id="bookImg" class="col-xs-12 col-sm-3 col-md-3 item" style="
    margin:;
"><img src="<?=$book_img_src ?>" alt="Responsive image" class="img-responsive">
                    <hr>
                </div>
                <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 info">
                    <div class="bookInfo col-md-12">
                        <div id="title" class="titleBook"><?=$name ?></div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="bookLastInfo">
                            <div class="bookRow"><span class="properties">автор:</span><span id="author"><?=$authors ?></span></div>
                            <div class="bookRow"><span class="properties">год:</span><span id="year"><?=$year ?></span></div>
                            <div class="bookRow"><span class="properties">страниц:</span><span id="pages"></span></div>
                            <div class="bookRow"><span class="properties">isbn:</span><span id="isbn"></span></div>
                        </div>
                    </div>
                    <div class="btnBlock col-xs-12 col-sm-12 col-md-12">
                        <input id="adminUrl" value = "/<?=ADMIN_URL?>" hidden>
                        <input id="bookPage" value = "true" hidden>
                        <button type="submit" class="btnBookID btn-lg btn btn-success" onclick="bookPageClick(<?=$id ?>)" id="btnBook">Хочу читать!</button>
                    </div>
                    <div class="bookDescription col-xs-12 col-sm-12 col-md-12 hidden-xs hidden-sm">
                        <h4>О книге</h4>
                        <hr>
                        <p id="description"><?=$description ?></p>
                    </div>
                </div>
                <div class="bookDescription col-xs-12 col-sm-12 col-md-12 hidden-md hidden-lg">
                    <h4>О книге</h4>
                    <hr>
                    <p class="description"><?=$description ?></p>
                </div>
            </div>
        </div>
    </div>
</section>