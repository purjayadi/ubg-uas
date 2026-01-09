<?php
// Router for built-in PHP server
// Put this file in project root as server.php

if (preg_match('/\.(?:css|js|jpg|jpeg|png|gif|ico|svg|woff|woff2|ttf|eot)$/', $_SERVER["REQUEST_URI"])) {
    return false;    // serve the requested resource as-is.
} else {
    require_once('public/index.php');
}
