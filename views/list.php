<?php
require_once '../app/bookmark.php';

header('Content-Type: application/javascript');
$bookmark = new Bookmark('title unused here');
echo $bookmark->get();
