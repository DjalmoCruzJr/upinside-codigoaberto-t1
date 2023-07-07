<?php

/**
 * CSS
 */
$minCSS = new \MatthiasMullie\Minify\CSS();
$minCSS->add(dirname(__DIR__, 1) . PATH_VIEWS . PATH_ASSETS . "/css/style.css");
$minCSS->add(dirname(__DIR__, 1) . PATH_VIEWS . PATH_ASSETS . "/css/form.css");
$minCSS->add(dirname(__DIR__, 1) . PATH_VIEWS . PATH_ASSETS . "/css/button.css");
$minCSS->add(dirname(__DIR__, 1) . PATH_VIEWS . PATH_ASSETS . "/css/message.css");
$minCSS->add(dirname(__DIR__, 1) . PATH_VIEWS . PATH_ASSETS . "/css/load.css");
$minCSS->minify(dirname(__DIR__, 1) . PATH_VIEWS . PATH_ASSETS . "/styles.min.css");

/**
 * JS
 */
$minJS = new \MatthiasMullie\Minify\JS();
$minJS->add(dirname(__DIR__, 1) . PATH_VIEWS . PATH_ASSETS . "/js/jquery.js");
$minJS->add(dirname(__DIR__, 1) . PATH_VIEWS . PATH_ASSETS . "/js/jquery-ui.js");
$minJS->minify(dirname(__DIR__, 1) . PATH_VIEWS . PATH_ASSETS . "/scripts.min.js");