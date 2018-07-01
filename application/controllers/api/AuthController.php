<?php

use TinaBlog\Libraries\Auth\AuthService;

class AuthController extends MY_Controller
{
    private $authService;

    public function __construct()
    {
        parent::__construct();

        $this->authService = new AuthService();

    }

    public function register_post()
    {
        $postData = $this->input->post();

        if(is_null($postData) || empty($postData))
        {

            $postData = json_decode($this->security->xss_clean($this->input->raw_input_stream), true);

        }

        $this->load->library('form_validation');

        $this->form_validation->set_data($postData);

        $this->form_validation->set_rules('name', 'Name', 'trim|required');

        $this->form_validation->set_rules('email', 'Email', 'trim|required');

        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        if($this->form_validation->run())
        {

            $response = $this->authService->signUp($postData);

            $statusCode = ($response['status']) ? self::HTTP_OK : self::HTTP_BAD_REQUEST;

            $this->response($response, $statusCode);

        } else {

            $response['status'] = false;

            $response["error"]["message"] = $this->form_validation->error_string();

            $response["error"]["code"] = 400;

            $this->response($response, self::HTTP_BAD_REQUEST);

        }

    }

    public function login_post()
    {
        $postData = $this->input->post();
        if(is_null($postData) || empty($postData)) {
            $postData = json_decode($this->security->xss_clean($this->input->raw_input_stream), true);
        }
        $this->load->library('form_validation');
        $this->form_validation->set_data($postData);
        $this->form_validation->set_rules("email", "Email", 'trim|required');
        $this->form_validation->set_rules("password", "Password", 'trim|required');
        if ($this->form_validation->run()) {
            //log in user
            $response = $this->authService->loginUser($postData);
            $this->load->library('session');
            $statusCode = ($response["status"]) ? self::HTTP_OK : self::HTTP_BAD_REQUEST;
            $this->response($response, $statusCode);
        } else {
            $response["status"] = false;
            $response["error"]["message"] = $this->form_validation->error_string();
            $response["error"]["code"] = 400;
            $this->response($response, self::HTTP_BAD_REQUEST);
        }
    }






}