<?php

if (! function_exists('get_sanitized_length')) {
    /**
     * 공백 문자를 제외한 문자열 길이를 구합니다.
     *
     * @param string|null $var
     * @return int
     */
    function get_sanitized_length($var = null)
    {
        return mb_strlen(trim($var));
    }
}