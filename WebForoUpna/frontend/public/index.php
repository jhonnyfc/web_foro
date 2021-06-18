<?php

require __DIR__ . "/../src/config/config.php";

$url = ORIGIN_NAME."/router.php/";
header("Location: $url");