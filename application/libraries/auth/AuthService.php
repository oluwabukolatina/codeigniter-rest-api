<?php

namespace TinaBlog\Libraries\Auth;

defined('BASEPATH') or exit('No direct script access allowed');

class AuthService {

    private $CI;

    public function __construct() {

        $this->CI = &get_instance();

    }

    public function store(array $data) : array {

        //dcd above, now $this->CI
        $result = $this->CI->db->insert("users", [

            'name' => $data['name'],

            'email' => $data['email'],

            'password' => password_hash($data['password'], PASSWORD_BCRYPT)

        ]);

        if(!$result)
        {

            $response["status"] = false;

            $response["error"]["message"] = "Sorry we're unable to add new user now. Please try again or contact support";

            $response["error"]["code"] = 500;

            return $response;

        }

        $response["status"] = true;

//        $response["post"] = $result;

        $response["message"] = "user created successfully";

        $response["code"] = 201;

        return $response;

    }

    public function loginUser(array $data) : array{

        //validate
        // $this->db->where('username', $username);
        $this->CI->db->where('email', $data['email']);

        $this->CI->db->where('password', $data['password']);
        // $this->db->where('password', $password)

        $result = $this->CI->db->get('users');

        if($result->num_rows() == 1)
        {
            $response["status"] = true;

            $response["posts"] = $result;

            $response["message"] = "logged in";

            $response["error"] = 201;

            return $response;

        }

        $response["status"] = false;

        $response["error"]["message"] = "try again";

        $response["code"] = 404;

        return $response;

    }










}
