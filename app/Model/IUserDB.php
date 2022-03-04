<?php


namespace App\Model;


interface IUserDB
{
    public static function readOne(int $id) : User|bool;

    public static function readAll(): array;

    public static function create(User $user): User;

    public static function update(User $user): bool;

    public static function remove($id): bool;
}