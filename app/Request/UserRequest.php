<?php
declare(strict_types=1);


namespace App\Request;


class UserRequest
{
    public static  function validate(string $displayName, string $email)
{
    if (empty($displayName) || empty($email)  || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    } else {
        return true;
    }
}
}