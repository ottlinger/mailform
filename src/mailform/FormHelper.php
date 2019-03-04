<?php

namespace mailform;


class FormHelper
{
    /**
     * Returns true if the given key is found in $_SERVER, false otherwise.
     *
     * @param $key
     *
     * @return bool
     */
    public static function isSetAndNotEmpty($key)
    {
        return self::isSetAndNotEmptyInArray($_SERVER, $key);
    }

    public static function isSetAndNotEmptyInArray($array, $key)
    {
        // array_key_exists($key, $array) is similar but ot null-safe
        if (isset($array) && isset($key)) {
            if (isset($array[$key])) {
                return !empty($array[$key]);
            }
        }
        return false;
    }

    /**
     * Strips the given user input and replaces any XSS-attacks.
     *
     * @param $data
     *
     * @return string
     */
    public static function filterUserInput($data)
    {
        if (isset($data)) {
            $data = trim('' . $data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            // manual hack to replace quotes here in order to make stuff more DB/MySQL compliant
            $data = strtr($data, ["'" => "\'"]);
        }
        return $data;
    }
}
