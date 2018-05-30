<?php

class Post_model extends CI_Model{

  public function __construct()
  {

    parent::__construct();

    $this->load->database();

  }

  public function index()
  {

  $users = $this->db->get('users')

          ->result_array();

  return $users;

  }

  public function store()
  {

    $user = array(

      'name' => $this->post->input('name'),

      'email' => $this->post->input('email')

    );

    $this->db->insert('users', $user);

  }

  public function show($id)
  {

    $post = $this->db->get_where('id', $id);

    return $user->row_array();

    // $sql = 'SELECT * FROM posts WHERE code = '$id'';
    //
    // $query = $this->db->query($sql);
    //
    // $data = $query->row();
    //
    // $this->response($data, 200);

  }

  public function update_post()
  {

    // $this->db->where('id', $id);

    $data = array(

      'body' => $this->post->input('body')

    );

    $this->db->where('id', $this->input->post('id'));

    return $this->db->update('posts', $data);

  }

  public function delete_post($id)
  {

    $this->db->where('id', $id);

    return $this->db->delete('posts');

  }























}
  ?>
