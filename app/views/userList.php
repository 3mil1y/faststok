<?php
require_once "../app/core/autoloader.php";

use App\Components\Layout\Header;
use App\Components\Lists\UserList;
use App\Components\Layout\Head;

echo Head::render($title);
echo Header::render();
echo UserList::render($users);
?>