<?php

function str_starts_with($haystack, $needle, $strict = false)
{

    return ($strict ? strpos($haystack, $needle) : stripos($haystack, $needle)) === 0;
}

function str_ends_with($haystack, $needle, $strict = false)
{

    return ($strict ? strrpos($haystack, $needle) : strripos($haystack, $needle)) === (strlen($haystack) - strlen($needle));
}
