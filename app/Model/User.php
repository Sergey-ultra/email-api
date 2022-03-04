<?php

namespace App\Model;

class User
{
    public function __construct(
        public string $display_name,
        public string $email,
        public int $createdAt,
        public int|null $id = null
    ) {}

}