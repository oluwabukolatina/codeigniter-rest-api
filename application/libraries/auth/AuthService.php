<?php

namespace TinaBlog\Libraries\Auth;

defined('BASEPATH') or exit('No direct script access allowed');

class AuthService {

    private $CI;

    public function __construct() {

        $this->CI = &get_instance();

    }

    public function signUp(array $data) : array {

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

    public function loginUser(array $data) : array {

        $user = $this->CI->db->select('email, password')

                    ->from('users')

                    ->where("email", $data['email'])

                    ->get()->result();

        if(empty($user))
        {

            $response['code'] = "404";

            $response['message'] = "username/password not found";

            $response['status'] = false;

            return $response;

        }

        $result = password_verify($data['password'], $user[0]->password);

        if($result)
        {

            $response['code'] = 200;

            $response['message'] = 'logged in';

            $response['status'] = true;

            return $response;

        }

        $response['code'] = 200;

        $response['message'] = 'email/password do not match';

        return $response;



//        if(password_verify($data['password'], $user[0]->password))
//        {
//
//            $response['code'] = 200;
//
//            $response['message'] = 'logged in';
//
//        } else {
//
//            echo "invalid password";
//
//        }

//        $result = password_verify($data['password', $hash])

    }

    public function loginUsers(array $data) : array{

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
