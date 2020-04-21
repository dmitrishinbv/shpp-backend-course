<?php
$id = htmlentities($info[0]['book_id']);
$name = htmlentities($info[0]['name']);
$authors = htmlentities($info[0]['authors']);
$year = htmlentities($info[0]['year']);
$description = htmlentities($info[0]['description']);
$img = base64_encode($info[0]['image']);

$contentPage = 'public/tpl/main-wrapper.php';
include_once($contentPage);