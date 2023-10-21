<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class DeleteMotivasi extends REST_Controller
{

    function __construct($config = 'rest')
    {
        parent::__construct($config);
        $this->load->database();
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "OPTIONS") {
            die();
        }
        // Load the motivasi model
        $this->load->model('motivasi');
    }

    function index_delete()
    {
        $id = $this->delete('id');
        if ($id) {
            // Panggil model untuk menghapus data
            $delete = $this->motivasi->delete($id);

            if ($delete) {
                $this->response([
                    'message' => 'The motivation successfully deleted.',
                    'data' => $id
                ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'message' => 'Failed to delete motivation.',
                    'data' => $id
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
            $this->response([
                'message' => 'Provide a valid ID to delete motivation.',
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}
