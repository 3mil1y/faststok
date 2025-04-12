<?php
require_once "../app/core/autoloader.php";

use App\Components\Layout\Header;
use App\Components\Form\EditUser;
use App\Components\Layout\Head;

echo Head::render($title);
echo Header::render();
echo EditUser::render($action, $user);
?>