<?php
    require 'class-inspirator.php';
    $i = new Inspirator();
    header("Content-Type: text/html; charset=utf-8");
    echo $i->getSentence();
    