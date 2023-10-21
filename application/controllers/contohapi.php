<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class api extends REST_Controller
{

    function __construct($config = 'rest')
    {
        parent::__construct($config);
        $this->load->database();
    }


    function index_get()
    {
        $id = $this->get('id');

        if ($id == '') {
            $api = $this->db->get('user')->result();
        } else {
            $this->db->where('iduser', $id);
            $api = $this->db->get('user')->result();
        }
        
        $this->response($api, 200);
    }



    function index_post()
    {
        $data = array(
            'iduser'           => $this->post('id'),
            'nama'          => $this->post('nama'),
            'profesi'    => $this->post('profesi'),
            'tnggal_lahir'    => $this->post('tnggal_lahir'),
            'umur'    => $this->post('umur'),
            'jenis_kelamin'    => $this->post('jenis_kelamin'),
            'alamat'    => $this->post('alamat'),
            'email'    => $this->post('email'),
            'call_num'    => $this->post('call_num'),
            'image'    => $this->post('image'),
            'password'    => $this->post('password'),
            'role_id'    => $this->post('role_id'),
            'is_active'    => $this->post('is_active'),
            'tanggal_input'    => $this->post('tanggal_input')
        );
        $insert = $this->db->insert('user', $data);
        if ($insert) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }


    function index_put()
    {
        $id = $this->put('iduser');

        // Get the post data
        $nama = strip_tags($this->put('nama'));
        $profesi = strip_tags($this->put('profesi'));
        $email = strip_tags($this->put('email'));
        $password = $this->put('password');


        // Validate the post data
        if (!empty($nama)  && !empty($profesi) && !empty($email) && !empty($password)) {
            // Update user's account data
            $userData = array();
            if (!empty($nama)) {
                $userData['nama'] = $nama;
            }

            if (!empty($profesi)) {
                $userData['profesi'] = $profesi;
            }
            if (!empty($email)) {
                $userData['email'] = $email;
            }
            if (!empty($password)) {
                $userData['password'] = md5($password);
            }

            $update = $this->user->update($userData, $id);

            // Check if the user data is updated
            if ($update) {
                // Set the response and exit
                $this->response([
                    'status' => TRUE,
                    'message' => 'user berhasil updated profile baru.'
                ], REST_Controller::HTTP_OK);
            } else {
                // Set the response and exit
                $this->response("Some problems occurred, please try again.", REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
            // Set the response and exit
            $this->response("Provide at least one user info to update.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    function index_delete()
    {
        $id = $this->delete('id');
        $this->db->where('id', $id);
        $delete = $this->db->delete('user');
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }
}
