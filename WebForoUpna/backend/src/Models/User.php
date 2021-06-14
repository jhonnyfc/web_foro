<?php

namespace Foroupna\Models;

use Exception;
use mysqli_sql_exception;

// Para quitar los reportes de error  o wringis
// error_reporting(0);

class User
{
    public string $foto_url;
    public string $username;
    public string $email;

    public function __construct()
    {
    }

    /**
     * @throws Exception
     */
    public static function signIn(string $username, string $password): string
    {

        try {
            $query = "SELECT * FROM usuario WHERE username=? LIMIT 1";

            $stmt = Database::getInstance()->getConnection()->prepare($query);

            $stmt->bind_param("s", $username);

            $stmt->execute();

            $res = $stmt->get_result();

            $stmt->close();

            if ($res->num_rows > 0) {
                $row = $res->fetch_assoc();

                if (password_verify($password, $row['password'])) {
                    Session::put('user', $row['username']);
                    return json_encode($row, JSON_THROW_ON_ERROR);
                }

                throw new Exception("Incorrect password");
            }

            throw new Exception("Incorrect username");
        } catch (mysqli_sql_exception $e) {
            throw $e;
        }
    }

    /**
     * @throws Exception
     */
    public static function signUp(
        string $username,
        string $email,
        string $password
    ): string {
        try {
            $query = "INSERT INTO usuario(username, password, email) VALUES ( ?, ?, ?)";

            $conn = Database::getInstance()->getConnection();

            if (self::checkUsernameIsTaken($username)) {
                throw new Exception("Username already taken.");
            }

            if (self::checkEmailIsTaken($email)) {
                throw new Exception("Email already taken.");
            }

            $stmt = $conn->prepare($query);

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            if (!$hashedPassword) {
                throw new Exception("Error hashing password");
            }

            $stmt->bind_param("sss", $username, $hashedPassword, $email);

            $stmt->execute();

            $stmt->close();

            return $username;
        } catch (mysqli_sql_exception $ex) {
            throw $ex;
        }
    }

    private static function checkUsernameIsTaken(string $username): string
    {
        $query = "SELECT username FROM usuario WHERE username=? LIMIT 1";

        try {
            $stmt = Database::getInstance()->getConnection()->prepare($query);

            $stmt->bind_param("s", $username);

            $stmt->execute();

            $res = $stmt->get_result();

            $stmt->close();

            if ($res->num_rows > 0) {
                return true;
            }
        } catch (mysqli_sql_exception $e) {
            throw $e;
        }

        return false;
    }

    private static function checkEmailIsTaken(string $email): string
    {
        $query = "SELECT email FROM usuario WHERE email=? LIMIT 1";

        try {
            $stmt = Database::getInstance()->getConnection()->prepare($query);

            $stmt->bind_param("s", $email);

            $stmt->execute();

            $res = $stmt->get_result();

            $stmt->close();

            if ($res->num_rows > 0) {
                return true;
            }
        } catch (mysqli_sql_exception $ex) {
            throw $ex;
        }

        return false;
    }

    public static function isLoggedIn(): bool
    {
        return (bool) Session::get('user');
    }

    /**
     * @throws Exception
     */
    public static function find($username)
    {

        $query = "SELECT * FROM usuario WHERE username=? LIMIT 1";

        try {
            $stmt = Database::getInstance()->getConnection()->prepare($query);

            $stmt->bind_param("s", $username);

            $stmt->execute();

            $res = $stmt->get_result();

            $stmt->close();

            if ($res->num_rows === 0) {
                throw new Exception("User with id " . $username . " does not exist.");
            }

            $row = $res->fetch_assoc();

            $user = new self();

            $user->foto_url = $row['foto_url'];
            $user->username = $row['username'];
            $user->email = $row['email'];

            return $user;
            // return json_encode($user, true);
        } catch (mysqli_sql_exception $ex) {
            throw $ex;
        }
    }

    public static function redirect(string $url): void
    {
        header("Location: $url");
    }

    public function sayHello(): void
    {
        echo "Hello";
    }
}
