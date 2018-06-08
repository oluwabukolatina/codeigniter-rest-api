<?php

//require(APPPATH . 'libraries/REST_Controller.php');

use TinaBlog\Libraries\User\UserService;


/**
 * Created by PhpStorm.
 * User: oluwa
 * Date: 5/28/2018
 * Time: 4:14 AM
 */

 class UserController extends MY_Controller {

    private $userService;

    public function __construct()
    {

        parent::__construct();

        $this->userService = new UserService();

    }

    //create
    public function index_post() {

      $postData = $this->input->post();

      if(is_null($postData) || empty($postData)) {

          $postData = json_decode($this->security->xss_clean($this->input->raw_input_stream), true);

        }

      $this->load->library('form_validation');

      $this->form_validation->set_data($postData);

      $this->form_validation->set_rules("name", "Name", 'trim|required');

      $this->form_validation->set_rules("email", "Email", 'trim|required|valid_email');

      $this->form_validation->set_rules('password', 'Password', array('required', 'trim', 'min_length[5]'));

       if ($this->form_validation->run()) {

           $response = $this->userService->store($postData);

           $statusCode = ($response["status"]) ? self::HTTP_OK : self::HTTP_BAD_REQUEST;

           $this->response($response, $statusCode);

       } else {

           $response["status"] = false;

           $response["error"]["message"] = $this->form_validation->error_string();

           $response["error"]["code"] = 400;

           $this->response($response, self::HTTP_BAD_REQUEST);

       }

    }

    public function edit_put($id)
    {

      // $id = $this->uri->segment(3);

    //   $editData = array('name' => $this->input->get('name'),
    // 'email' => $this->input->get('email'));

      $postData = $this->input->post();

      if(is_null($postData) || empty($postData)) {

          $postData = json_decode($this->security->xss_clean($this->input->raw_input_stream), true);

        }

      $this->load->library('form_validation');

      $this->form_validation->set_data($postData);

      $this->form_validation->set_rules("name", "Name", 'trim|required');

      $this->form_validation->set_rules("email", "Email", 'trim|required|valid_email');

      $this->form_validation->set_rules('password', 'Password', array('required', 'trim', 'min_length[5]'));

       if ($this->form_validation->run()) {

           $response = $this->userService->updateUser($postData);

           $statusCode = ($response["status"]) ? self::HTTP_OK : self::HTTP_BAD_REQUEST;

           $this->response($response, $statusCode);

       } else {

           $response["status"] = false;

           $response["error"]["message"] = $this->form_validation->error_string();

           $response["error"]["code"] = 400;

           $this->response($response, self::HTTP_BAD_REQUEST);

       }
      //
      // $response = $this->userService->updateUser($id, $editData);
      //
      // $this->response($response);

    }

    public function destroy_delete($id)
    {

      $this->userService->delete($id);

    }

    public function eddit_put($id)
    {

      // $editData = $this->input->post();
      $editData = array(
        'title' => $this->input->post('title'),
        'body' => $this->input->post('body')
      );

      if(is_null($editData) || empty($editData)) {

          $editData = json_decode($this->security->xss_clean($this->input->raw_input_stream), true);

        }

      $this->load->library('form_validation');

      $this->form_validation->set_data($editData);

      $this->form_validation->set_rules("title", "Title", 'trim|required');

      $this->form_validation->set_rules("body", "Body", 'trim|required');

       if ($this->form_validation->run()) {

           $response = $this->postService->updatePost($editData, $id);

           $statusCode = ($response["status"]) ? self::HTTP_OK : self::HTTP_BAD_REQUEST;

           $this->response($response, $statusCode);

       } else {

           $response["status"] = false;

           $response["error"]["message"] = $this->form_validation->error_string();

           $response["error"]["code"] = 400;

           $this->response($response, self::HTTP_BAD_REQUEST);

       }

    }

    //read all
    public function user_get() {

        $response = $this->userService->get();

        $statusCode = ($response["status"]) ? self::HTTP_OK : self::HTTP_BAD_REQUEST;

        $this->response($response, $statusCode);

    }

    //read one
    public function view_get($id = NULL)
    {

      $response = $this->userService->get($id);

      if(empty($response)) {

        $statusCode = ($response["status"]) ? self::HTTP_OK : self::HTTP_BAD_REQUEST;

        $this->response($response, $statusCode);

      } else {

        $response['status'] = FALSE;

        $response['error']['message'] = 'not found';

        $response['error']['code'] = 400;

        $this->response($response, self::HTTP_BAD_REQUEST);

      }

    }

  //   public function login_post() {
  //
	// 	// create the data object
	// 	// $data = new stdClass();
  //   $login = $this->input->post();
  //
  //   if(is_null($login) || empty($login)) {
  //
  //   $postData = json_decode($this->security->xss_clean($this->input->raw_input_stream), true);
  //
  //   }
  //
  // // $this->load->library('form-validation');
  // // $this->load->helper(array('form', 'url'));
  //
  // $this->load->library('form_validation');
  //
  // $this->form_validation->set_rules("email", "Email", 'trim|required|valid_email');
  //
  // $this->form_validation->set_rules('password', 'Password', array('required', 'trim'));
  //
  // if ($this->form_validation->run()) {
  //
  //   // $username = $this->input->post('username');
  //
  //   //get and ecrypt password
  //   // $password = password_hash($this->input->post('password', PASSWORD_BCRYPT));
  //
  //   //log in users
  //   $user_id = $this->userService->loginUser($username, $password);
  //
  //   //check for the // ID
  //   if($user_id){
  //
  //     //
  //     $statusCode = ($response["status"]) ? self::HTTP_OK : self::HTTP_BAD_REQUEST;
  //
  //     $this->response($response, $statusCode);
  //
  //   } else {
  //
  //     return "incorrect creds";
  //
  //   }
    // $response = $this->userService->loginUser($username, $password);

      // $user_id = $this->user_model->get_id_from_username($username);
      //
      // $user    = $this->user_model->get_user($user_id);




  //  } else {
  //
  //   $response["status"] = false;
  //
  //   $response["error"]["message"] = $this->form_validation->error_string();
  //
  //   $response["error"]["code"] = 400;
  //
  //   $this->response($response, self::HTTP_BAD_REQUEST);
  //
  //
  // }

  public function userlogin_post()
  {

    $login = $this->input->post();

if(is_null($login) || empty($login))
{

  $login = json_decode($this->security->xss_clean($this->input->raw_input_stream), true);

  }

$this->load->library('form_validation');

$this->form_validation->set_data($login);

$this->form_validation->set_rules("email", "Email", 'trim|required|valid_email');
//
$this->form_validation->set_rules('password', 'Password', array('required', 'trim'));

if ($this->form_validation->run()) {

    $response = $this->userService->loginUser($login);

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
