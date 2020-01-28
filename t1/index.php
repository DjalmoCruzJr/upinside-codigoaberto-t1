<?php

ob_start();
session_start();

require __DIR__ . "/vendor/autoload.php";

echo '<h1>Olá Mundo!</h1>';


ob_end_flush();