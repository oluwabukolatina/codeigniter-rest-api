<?php

//require(APPPATH . 'libraries/REST_Controller.php');

use TinaBlog\Libraries\Post\PostService;


/**
 * Created by PhpStorm.
 * User: oluwa
 * Date: 5/28/2018
 * Time: 4:14 AM
 */

 class PostController extends MY_Controller {

    private $postService;

    public function __construct()
    {

        parent::__construct();

        $this->postService = new PostService();

    }

    //sample

    public function name (){

      echo json_encode(["user" => "Tina"]);

    }

    //create
    public function index_post() {
          $postData = $this->input->post();
          if(is_null($postData) || empty($postData)) {
              $postData = json_decode($this->security->xss_clean($this->input->raw_input_stream), true);
            }
        //log_message('debug', "Raw file data: ". json_encode($_FILES));
          $postData = !is_null($postData) ? $postData : [];
          $this->load->library('form_validation');
          $this->form_validation->set_data($postData);
          $this->form_validation->set_rules("title", "Title", 'trim|required');
          $this->form_validation->set_rules("body", "Body", 'trim|required');
           if ($this->form_validation->run() === FALSE) {
               $response["status"] = false;
               $response["error"]["message"] = $this->form_validation->error_string();
               $response["error"]["code"] = 400;
               $this->response($response, self::HTTP_BAD_REQUEST);
           } else {
               //UPLOAD IMAGE
               $config['upload_path'] = './assets/images/posts';
               $config['allowed_types'] = 'gif|jpg|png';
               $config['max_size'] = '2048';
               $config['max_width'] = '2000';
               $config['max_height'] = '2000';
               $this->load->library('upload', $config);
               $upload = $this->upload->do_upload('imagePath');
//               log_message('debug', "Image upload result: ".json_encode($upload));
               if($upload)
               {
                   $data = array('upload_path' => $this->upload->data());
                   $postImage = $_FILES['imagePath']['name'];

               } else {
                   $error = array('error' => $this->upload->display_errors());
                   $postImage = 'noimage.jpg';
               }
               $response = $this->postService->store($postData, $postImage);
               $statusCode = ($response["status"]) ? self::HTTP_OK : self::HTTP_BAD_REQUEST;
               $this->response($response, $statusCode);
           }
    }

    public function edit_post($id)
    {
        $editData = $this->input->post();

        if(is_null($editData) || empty($editData)) {

            $editData = json_decode($this->security->xss_clean($this->input->raw_input_stream), true);

        }

        $editData = !is_null($editData) ? $editData : [];

        log_message("debug", "update controller called " . json_encode($editData));

        $this->load->library('form_validation');

        $this->form_validation->set_data($editData);
        $this->form_validation->set_rules("title", "Post Title", "trim");
        $this->form_validation->set_rules("body", "Post Body", "trim");

        if ($this->form_validation->run()) {

            $response = $this->postService->updatePost($id, $editData);

            $statusCode = ($response["status"]) ? self::HTTP_OK : self::HTTP_BAD_REQUEST;

            $this->response($response, $statusCode);

        } else {

            $response["status"] = false;

            $response["error"]["message"] = $this->form_validation->error_string();

            $response["error"]["code"] = 400;

            $this->response($response, self::HTTP_BAD_REQUEST);

        }
    }

    public function edit_real($id)
    {
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
    public function index_get() {

        $response = $this->postService->get();

        $statusCode = ($response["status"]) ? self::HTTP_OK : self::HTTP_BAD_REQUEST;

        $this->response($response, $statusCode);

    }

    //read one
    public function view_get($id)
    {

        $response = $this->postService->get($id);
        $statusCode = ($response["status"]) ? self::HTTP_OK : self::HTTP_BAD_REQUEST;
        $this->response($response, $statusCode);

    }

    public function destroy_post($id)
    {

     // $response = $this->postService->delete($id);

     // $this->response($response);

     $response = $this->postService->delete($id);

     $this->response($response);

    }
























}
