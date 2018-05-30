<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct() {

        parent::__construct();

        //load database library
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

        //get where??

        $user = $this->db->get_where('id', $id);

        return $user->row_array();

    }

    public function update_user()
    {

      // $this->db->where('id', $id);

      $data = array(

        'name' => $this->post->input('name'),

        'email' => $this->post->input('email')

      );

      $this->db->where('id', $this->input->post('id'));

      return $this->db->update('users', $data);

    }

    public function delete_user($id)
    {

      $this->db->where('id', $id);

      return $this->db->delete('users');

    }









}
?>
