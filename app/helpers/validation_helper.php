<?php
function validate_between($check, $min, $max)
{
    $n = mb_strlen($check);
    return $min <= $n && $n <= $max;
}

function password_match($pass1, $pass2)
{
    return $pass1 === $pass2;
}
