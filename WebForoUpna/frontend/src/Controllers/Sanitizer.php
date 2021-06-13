<?php


namespace Foroupna\Controllers;


use Foroupna\Models\Database;

class Sanitizer
{
    public static function sanitize(string $data): string
    {
        $data = trim($data);
        $data = htmlspecialchars($data);
        return Database::getInstance()->getConnection()->real_escape_string($data);
    }
}