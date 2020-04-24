<?php
$id = htmlentities($data[0]['book_id']);
$name = htmlentities($data[0]['name']);
$authors = htmlentities($data[0]['authors']);
$year = htmlentities($data[0]['year']);
$description = htmlentities($data[0]['description']);
$img = base64_encode($data[0]['image']);
$contentPage = 'public/tpl/book-wrapper.php';
include_once($contentPage);