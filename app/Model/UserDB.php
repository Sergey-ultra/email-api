<?php
declare(strict_types=1);


namespace App\Model;


class UserDB implements IUserDB
{
    const FILENAME =  __DIR__ . './../../users.json';

    public static function readOne(int $id): User|bool
    {

        $f = @fopen(self::FILENAME, 'r+');
        $data = @fread($f, filesize(self::FILENAME));
        $data = json_decode($data, true);
        @fclose($f);
        if (false === isset($data['list'][$id])) {
            return false;
        } else {
            $existed = $data['list'][$id];
            $displayName = $existed['display_name'];
            $email = $existed['email'];
            $createdAt = $existed['created_at'];
            return new User($displayName, $email, $createdAt, $id);
        }

    }

    public static function readAll(): array
    {
        $f = @fopen(self::FILENAME, 'r+');
        $data = @fread($f, filesize(self::FILENAME));
        $data = json_decode($data, true);
        @fclose($f);
        $res = [];
        foreach ($data['list'] as $key => $v) {
            $existed = $data['list'][$key];
            $displayName = $existed['display_name'];
            $email = $existed['email'];
            $createdAt = $existed['created_at'];
            $res[] = new User($displayName, $email, $createdAt, $key);
        }
        return $res;
    }

    public static function create(User $user): User
    {

        $f = @fopen(self::FILENAME, 'a+');
        $data = @fread($f, filesize(self::FILENAME));
        $data = json_decode($data, true);

        $data['increment']++;
        $data['list'][$data['increment']] = [
            'display_name' => $user->display_name,
            'email' => $user->email,
            'created_at' => $user->createdAt
        ];
        $user->id =  $data['increment'];
        @ftruncate($f, 0);
        @fwrite($f, json_encode($data));
        @fclose($f);
        return $user;
    }

    public static function update(User $user): bool
    {

        $f = @fopen(self::FILENAME, 'a+');
        $data = @fread($f, filesize(self::FILENAME));
        $data = json_decode($data, true);

        if (isset($data['list'][$user->id])) {
            $data['list'][$user->id] = [
                'display_name' => $user->display_name,
                'email' => $user->email,
                'created_at' => $user->createdAt
            ];
            @ftruncate($f, 0);
            @fwrite($f, json_encode($data));
            @fclose($f);
            return true;
        }  else {
            @fclose($f);
            return false;
        }
    }

    public static function remove($id): bool
    {
        $f = @fopen(self::FILENAME, 'a+');
        $data = @fread($f, filesize(self::FILENAME));
        $data = json_decode($data, true);
        if (isset($data['list'][$id])) {
            unset($data['list'][$id]);
            @ftruncate($f, 0);
            @fwrite($f, json_encode($data));
            @fclose($f);
            return true;
        } else {
            @fclose($f);
            return false;
        }
    }
}