<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use TinaBlog\Libraries\Posts\PostService;


class UsersController extends CI_Controller {

    private $postService;

    public function __construct() {

        parent::__construct();

        $this->postService = new PostService();

        //load user model
        // $this->load->model('user');

    }

    public function index() {

        echo json_encode(["user" => "Tina"]);

    }

    public function add_post() {

      $this->load->helper('form');

      $this->load->library('form_validation');

      $this->form_validation->set_rules("name", "Name", 'required');

      $this->form_validation->set_rules("email", "Name", 'required');

      if ($this->$this->form_validation->run() === FALSE) {

          $response["status"] = false;

          $response["error"]["message"] = "Error" . $this->form_validation->error_string();

          $response["error"]["code"] = 400;

          return $response;

      } else {

        $this->User_model->store();

        $this->response([

          'status' => true,

          'message' => 'added'

        ], REST_Controller::HTTP_OK);

              return $response;

      }

    }

    public function show($id) {

      $user = $this->User_model->show($id);

        //check if the user data exists
        if(empty($users)){

            //set the response and exit
            $this->response([

              'status' => FALSE,

              'message' => 'user not found'

            ], REST_Controller::HTTP_NOT_FOUND);

        } else {
            //set reposne
            $this->response([

                'status' => FALSE,

                'message' => 'SUCCESS'

            ], REST_Controller::HTTP_OK);

        }

    }

    public function destroy($id){
        //check whether post id is not empty
        if($id){
            //delete post
            $user = $this->User_model->delete_user($id);

            if($user){
                //set the response and exit
                $this->response([

                    'status' => TRUE,

                    'message' => 'UserController deleted'

                ], REST_Controller::HTTP_OK);

            } else {
                //set the response and exit
                $this->response("unable to delete", REST_Controller::HTTP_BAD_REQUEST);

            }

        } else {

            //set the response and exit
            $this->response([

                'status' => FALSE,

                'message' => 'user not found.'

            ], REST_Controller::HTTP_NOT_FOUND);

        }

    }

    public function edit() {

      // $this->User_model->update_user($this->put('id'), $user);
      return $this->User_model->update_user();

    }


}

?>
