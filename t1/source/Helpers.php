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
    return site() . "/" . PATH_VIEWS . "/assets/{$path}";
}

/**
 * @param string $imageName
 * @return string|null
 */
function image(string $imageName): ?string
{
    return "https://via.placeholder.com/1200x628.png?text={$imageName}";
}

/**
 * @param string $key
 * @param string|null $value
 * @param bool $clean
 * @return string|null
 */
function session(string $key, string $value = null, bool $clean = false): ?string
{
    if (!empty($value)) {
        $_SESSION[$key] = $value;
        return $value;
    }

    if (!empty($_SESSION[$key]) && empty($value) && $clean) {
        unset($_SESSION[$key]);
        return null;
    }

    return $_SESSION[$key] ?? null;
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
            "message" => $message
        ];
        return null;
    }

    if (!empty($_SESSION["flash"]) && $flash = $_SESSION["flash"]) {
        unset($_SESSION["flash"]);
        return "<div class=\"message {$type}\">{$flash["message"]}</div>";
    }

    return null;
}

/**
 * @param string|null $param
 * @return string|null
 */
function social(string $param = null): ?string
{
    return ($param && !empty(SOCIAL[$param])) ? SOCIAL[$param] : null;
}






