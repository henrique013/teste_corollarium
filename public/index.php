<?php

use Corollarium\HtmlBuilder;


require_once '../vendor/autoload.php';


$builder = HtmlBuilder::builder();

echo $builder
    ->addJS(['index.js'])
    ->addCSS(['index.css'])
    ->setTitle("Algo")
    ->setHeader(function () {
        return '<h1>HEADER</h1>';
    })
    ->setContent(function () {
        return '<p>CONTENT</p>';
    })
    ->setFooter(function () {
        return '<footer>FOOTER</footer>';
    })
    ->render();