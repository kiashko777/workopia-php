<?php

// This is the controller for the user operations (login, register, logout, authenticate)

namespace App\controllers;

use Exception;
use Framework\Database;
use Framework\Validation;
use Framework\Session;

class UserController
{
    protected Database $db;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $config = require basePath('config/db.php');
        $this->db = new Database($config);
    }

    /**
     * Show the login form
     * @return void
     */

    public function login(): void
    {
        loadView('users/login');
    }

    /**
     * Show the register form
     * @return void
     */

    public function create(): void
    {
        loadView('users/create');
    }

    /**
     * Store user in database
     * @return void
     */

    public function store(): void
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $password = $_POST['password'];
        $passwordConfirmation = $_POST['password_confirmation'];

        $errors = [];

        //Email validation
        if (!Validation::email($email)) {
            $errors['email'] = 'Pleas enter a valid email address!';
        }

        if (!Validation::string($name, 3, 50)) {
            $errors['name'] = 'Name must be between 3 and 50 characters!';
        }

        if (!Validation::string($password, 6, 50)) {
            $errors['password'] = 'Password must be between 6 and 50 characters!';
        }

        if (!Validation::match($password, $passwordConfirmation)) {
            $errors['password_confirmation'] = 'Password do not match!';
        }

        if (!empty($errors)) {
            loadView('users/create', [
              'errors' => $errors,
              'user' => [
                'name' => $name,
                'email' => $email,
                'city' => $city,
                'state' => $state,
              ]
            ]);
            exit;
        }

        //Check if user already exists
        $params = [
          'email' => $email
        ];

        $user = $this->db->query('SELECT * FROM users WHERE email = :email', $params)->fetch();
        if ($user) {
            $errors['email'] = 'Email already exists!';
            loadView('users/create', [
              'errors' => $errors,
            ]);
            exit;
        }

        //Create user account
        $params = [
          'name' => $name,
          'email' => $email,
          'city' => $city,
          'state' => $state,
          'password' => password_hash($password, PASSWORD_DEFAULT)
        ];

        $this->db->query('INSERT INTO users (name, email, city, state, password) VALUES (:name, :email, :city, :state, :password)', $params);

        //Get user id
        $userId = $this->db->conn->lastInsertId();

        Session::set('user', [
          'id' => $userId,
          'name' => $name,
          'email' => $email,
          'city' => $city,
          'state' => $state,
        ]);

        redirect('/');
    }

    /**
     *Logout user and destroy session
     * @return void
     */

    public function logout(): void
    {
        Session::clearAll();

        $params = session_get_cookie_params();
        setcookie('PHPSESSID', '', time() - 86400, $params['path'], $params['domain'], $params['secure']);
        redirect('/');
    }

    /**
     *Authenticate user
     * @return void
     */

    public function authenticate(): void
    {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $errors = [];

        //Validate email
        if (!Validation::email($email)) {
            $errors['email'] = 'Please enter a valid email address!';
        }

        //Validate password
        if (!Validation::string($password, 6, 50)) {
            $errors['password'] = 'Password must be between at least 6 characters!';
        }

        //Check for errors
        if (!empty($errors)) {
            loadView('users/login', [
              'errors' => $errors
            ]);
            exit;
        }

        //Check for email
        $params = [
          'email' => $email
        ];
        $user = $this->db->query('SELECT * FROM users WHERE email = :email', $params)->fetch();
        if (!$user) {
            $errors['email'] = 'Email does not exist!';
            loadView('users/login', [
              'errors' => $errors
            ]);
            exit;
        }

        //Check for password
        if (!password_verify($password, $user->password)) {
            $errors['password'] = 'Password is incorrect!';
            loadView('users/login', [
              'errors' => $errors
            ]);
            exit;
        }

        //Set the user session
        Session::set('user', [
          'id' => $user->id,
          'name' => $user->name,
          'email' => $user->email,
          'city' => $user->city,
          'state' => $user->state,
        ]);
        redirect('/');


    }
}