<?php

/**
 * @param string|null $param
 * @return string
 */
function site(string $param = null): string
{
    return ($param && !empty(SITE[$param])) ? SITE[$param] : SITE['root'];
}

/**
 * @param string $path
 * @return string
 */
function asset(string $path): string
{
    return site() . "/views/assets/{$path}";
}

/**
 * @param string|null $type
 * @param string|null $message
 * @return string|null
 */
function flash(string $type = null, string $message = null): ?string
{
    if ($type && $message) {
        $_SESSION["flash"] = [
            "type" => $type,
            "messa" => $message
        ];
        return null;
    }

    if (!empty($_SESSION["flash"]) && $flash = $_SESSION["flash"]) {
        unset($_SESSION["flash"]);
        return "<div class=\"message {$type}\">{$flash["message"]}</div>";
    }

    return null;
}



