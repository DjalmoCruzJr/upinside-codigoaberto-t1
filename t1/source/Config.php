<?php

/**
 * SITE CONFIG
 */
define("SITE", [
    "name" => "Auth em MVC com PHP",
    "desc" => "Aprenda a constuir um aplicação de autenticação em MVC com PHP do jeito certo :)",
    "domain" => "localhost",
    "locale" => "pt_BR",
    "root" => "https://localhost/tutorial-upinside-codigoaberto/t1"
]);

/**
 * PROJECT PATHS/NAMESPACES CONFIG
 */
define("NAMESPACE_CONTROLLERS", "Source\Controllers");
define("PATH_VIEWS", "/views");
define("PATH_ASSETS", "/assets");
define("PATH_STORAGE", "/storage");

/**
 * SITE MINIFY
 */
if (in_array($_SERVER["SERVER_NAME"], ["localhost", "127.0.0.1"])) {
    require __DIR__ . "/Minify.php";
}

/**
 * DATABASE CONFIG
 */
define("DATA_LAYER_CONFIG", [
    "driver" => "mysql",
    "host" => "localhost",
    "port" => "3306",
    "dbname" => "tutorial_upinside_codigoaberto",
    "username" => "root",
    "passwd" => "",
    "options" => [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_CASE => PDO::CASE_NATURAL
    ]
]);

/**
 * SEO CONFIG
 */
define("SOCIAL", [
    "facebook_page" => "djalmocruzjr",
    "facebook_author" => "djalmocruzjr",
    "facebook_app_id" => "djalmocruzjr",
    "twitter_creator" => "@djalmocruzjr",
    "twitter_site" => "@djalmocruzjr",
]);

/**
 * EMAIL CONFIG
 */
define("MAIL", []);

/**
 * SOCIAL LOGIN CONFIG
 */
define("FACEBOOK_LOGIN", []);
define("GOOGLE_LOGIN", []);


/**
 * SESSION/MESSAGE/RESPONSE CONFIG
 */
define("SESSION_USER", "user");
define("SESSION_FORGET", "forget");
define("MESSAGE_MSG", "message");
define("MESSAGE_TYPE", "type");
define("MESSAGE_TYPE_SUCCESS", "success");
define("MESSAGE_TYPE_INFO", "info");
define("MESSAGE_TYPE_ALERT", "alert");
define("MESSAGE_TYPE_ERROR", "error");
define("RESPONSE_MESSAGE", "message");
define("RESPONSE_REDIRECT", "redirect");
define("RESPONSE_URL", "url");

/**
 * EMAIL CONFIG
 */
define("EMAIL", [
    "host" => "smtp.sendgrid.net",
    "port" => "587",
    "username" => "apikey",
    "passwd" => "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",
    "protocol" => "tls",
    "charset" => "utf-8",
    "lang" => "br",
    "from_name" => "Djalmo Cruz Jr",
    "from_address" => "djalmo.cruz@gmail.com",
]);
