<?php
include_once 'header.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$parts = explode('/', $path);
$category = $parts[0] ?? null;
$page = $parts[1] ?? null;

if ($category && $page) {
  include_once($_SERVER['DOCUMENT_ROOT'] . '/sidebars/' . $parts[0] . '.php');
  include_once($_SERVER['DOCUMENT_ROOT'] . '/pages/' . $parts[0] . '/' . $parts[1] . '.php');
} else {
  include_once($_SERVER['DOCUMENT_ROOT'] . '/pages/main.php');
}

include_once 'footer.php';
?>
