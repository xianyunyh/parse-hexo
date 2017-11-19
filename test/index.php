<?php
require_once __DIR__ . '/../vendor/autoload.php';

$parse = new \XianYun\ParseHexo('./crontab.md');

$header = $parse->getHeader();
$content = $parse->getContent();
$Parsedown = new \Parsedown();
$content = $Parsedown->text($content);
include 'template.html';
