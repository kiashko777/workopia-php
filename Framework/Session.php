<?php

// This is the session class.

namespace Framework;

class Session
{
    /**
     *Start the session
     * @return void
     */

    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Get a session key/value pair
     * @param string $key
     * @return mixed $value
     * @return void
     */
    public static function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Get a session value by key
     * @param string $key
     * @param mixed|null $default
     * @return mixed $default
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        return $_SESSION[$key] ?? $default;
    }

    /**
     * Check if a session key exists
     * @param string $key
     * @return bool
     */

    public static function has(string $key): bool
    {
        return isset($_SESSION[$key]);

    }

    /**
     * Clear a session key
     * @param string $key
     * @return void
     */

    public static function clear(string $key): void
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    /**
     * Destroy the session
     * @return void
     */
    public static function clearAll(): void
    {
        session_unset();
        session_destroy();
    }

    /**
     *Set a flash message
     * @param string $key
     * @param string $message
     * @return void
     */

    public static function setFlashMessage(string $key, string $message): void
    {
        self::set('flash_' . $key, $message);
    }

    /**
     *Get a flash message
     * @param string $key
     * @param mixed $default
     * @return string
     */

    public static function getFlashMessage(string $key, mixed $default = null): mixed
    {
        $message = self::get('flash_' . $key, $default);
        self::clear('flash_' . $key);
        return $message;
    }

}
