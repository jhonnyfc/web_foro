<?php

namespace Foroupna\Controllers;

use Foroupna\Models\Session;
use Exception;
use Foroupna\Models\User;

class UserController
{
    public function __construct()
    {
        // if(!isset($_COOKIE["PHPSESSID"]))
        // {
        session_start();
        // }
        try {
            $_POST = json_decode(file_get_contents('php://input'), true, 512, JSON_THROW_ON_ERROR);
        } catch (Exception $e) {
            // http_response_code(500);
        }
    }

    public function signUp(): string
    {
        if (
            empty($_POST['username'])
            || empty($_POST['password'])
            || empty($_POST['email'])
        ) {
            http_response_code(400);
            return 'Bad request error.';
        }

        $username = Sanitizer::sanitize($_POST['username']);
        $password = Sanitizer::sanitize($_POST['password']);
        $email = Sanitizer::sanitize($_POST['email']);
        

        // Check if user type is valid
        try {
            $this->validateInputData($username, $email, $password);

            $usernameok = User::signUp(
                $username,
                $email,
                $password
            );

            return json_encode(array("username"=>$usernameok),true);
        } catch (Exception $ex) {
            http_response_code(400);
            return $ex->getMessage();
        }
    }

    public function signIn(): string
    {
        // Check user data is set
        if (empty($_POST['username']) || empty($_POST['password'])) {
            http_response_code(400);
            return 'Bad request error.';
        }

        $username = Sanitizer::sanitize($_POST['username']);
        $password = Sanitizer::sanitize($_POST['password']);

        try {
            return User::signIn($username, $password);
        } catch (Exception $ex) {
            http_response_code(400);
            return $ex->getMessage();
        }
    }

    public function getUser(): string
    {
        if ( Session::get('user') === null ) {
            //User::redirect("http://localhost:1234/");
            http_response_code(400);
            return "You must login.";
        }

        try {
            return json_encode(User::find(Session::get('user')), JSON_THROW_ON_ERROR);
        } catch (Exception $e) {
            http_response_code(400);
            return $e->getMessage();
        }
    }

    public function findUser(string $username): string {
        $username = Sanitizer::sanitize($username);
        try {
            return json_encode(User::find($username), JSON_THROW_ON_ERROR);
        } catch (Exception $e) {
            http_response_code(400);
            // return $e->getMessage();
            return "el usurio no existe";
        }
    }

    public function logout(): string
    {
        if ( Session::get('user') !== null ) {
            //session_start();
            Session::forget('user');
            session_destroy();
            //User::redirect("http://localhost:1234/");
            $res = array(0=> "User logged out successfully.");
            return json_encode($res);
        }
        http_response_code(400);
        return "User not logged in.";
    }

    /**
     * @throws Exception
     */
    private function validateInputData(
        string $username,
        string $email,
        string $password
    ): void {
        if (!$this->validateUsername($username)) {
            throw new Exception('Invalid username');
        }

        if (!$this->validateEmail($email)) {
            throw new Exception('Invalid email');
        }

        if (!$this->validatePassword($password)) {
            throw new Exception('Invalid password');
        }
    }

    private function validateUsername(string $username): bool
    {
        return (bool)preg_match('/^[A-Za-z][A-Za-z0-9]{3,31}$/', $username);
    }

    private function validateEmail(string $email): bool
    {
        return (bool)filter_var($email, FILTER_VALIDATE_EMAIL);
    }


    private function validatePassword(string $password): bool
    {
        // $pattern =  "/[^a-z_\-0-9]/i";
        // $pattern = "/[^a-z_\-0-9]{6,20}$/";
        if (ctype_alnum($password)
            && strlen($password) > 3
            && strlen($password) < 20
        ) {
            return true;
        }

        return false;
    }

    // =====  End of Input Data Validation  ======
}
