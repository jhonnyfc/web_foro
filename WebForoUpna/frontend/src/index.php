<?php

use Foroupna\Models\User;

require_once __DIR__ . "/../vendor/autoload.php";

$user = new User();

$user->sayHello();