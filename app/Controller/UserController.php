<?php
declare(strict_types=1);


namespace App\Controller;


use App\Model\User;
use App\Model\UserDB;
use App\Request\UserRequest;

class UserController implements RestController
{
    public function index()
    {
        try {
            $users = UserDB::readAll();
            print_r(json_encode(['data' => $users]));

        } catch (\Exception $exception) {
            http_response_code(500);
            print_r(['error' => $exception->getMessage()]);
        }
    }

    public function show(int $id)
    {
        try {
            $user = UserDb::readOne($id);

            if (!$user) {
                http_response_code(404);
                print_r(json_encode(['error' => 'user not found']));
                exit();
            }

            print_r(json_encode(['data' => $user]));

        } catch (\Exception $exception) {
            http_response_code(500);
            print_r(['error' => $exception->getMessage()]);
        }
    }

    public function store()
    {
        try {
            $request = json_decode(file_get_contents("php://input"), true);
            $email = trim($request['email']);
            $displayName = trim($request['display_name']);


            if (!UserRequest::validate($displayName, $email)) {
                http_response_code(400);
                print_r(json_encode(['error' => 'invalid data']));
                exit();
            }

            $user = new User($displayName, $email, time());
            $createdUser = UserDB::create($user);

            print_r(json_encode(['data' => $createdUser]));

        } catch (\Exception $exception) {
            http_response_code(500);
            print_r(['error' => $exception->getMessage()]);
        }
    }

    public function update()
    {
        try {
            $request = json_decode(file_get_contents("php://input"), true);
            $id = (int) $request['id'];
            $email = trim($request['email']);
            $displayName = trim($request['display_name']);

            if (!UserRequest::validate($displayName, $email)) {
                http_response_code(400);
                print_r(json_encode(['error' => 'invalid data']));
                exit();
            }

            $user = new User($displayName, $email, time(), $id);
            $status = UserDB::update($user);

            if (!$status) {
                http_response_code(404);
                print_r(json_encode(['error' => 'user not found']));
                exit();
            }

            print_r(json_encode(['data' => $user]));
        } catch (\Exception $exception) {
            http_response_code(500);
            print_r(['error' => $exception->getMessage()]);
        }
    }

    public function delete(int $id)
    {
        try {
            $status = UserDB::remove($id);
            if (!$status) {
                http_response_code(404);
                print_r(json_encode(['error' => 'user not found']));
                exit();
            }

        } catch (\Exception $exception) {
            http_response_code(500);
            print_r(['error' => $exception->getMessage()]);
        }
    }
}