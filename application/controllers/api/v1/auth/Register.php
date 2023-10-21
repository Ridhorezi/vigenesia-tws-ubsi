<?php

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class PostMotivasi extends REST_Controller
{
    public function __construct($config = 'rest')
    {
        parent::__construct();
        $this->load->database();
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "OPTIONS") {
            die();
        }
        // Load the motivasi model (adjust the model name as needed)
        $this->load->model('motivasi');
    }

    public function index_post()
    {
        // Get the post data
        $isi_motivasi = strip_tags($this->post('isi_motivasi'));
        $iduser = $this->post('iduser');

        // Validate the post data
        if (!empty($isi_motivasi) && !empty($iduser)) {
            // Insert motivasi data
            $materiData = array(
                'isi_motivasi' => $isi_motivasi,
                'iduser' => $iduser,
            );
            $insert = $this->motivasi->insert($materiData);

            // Check if the motivasi data is inserted
            if ($insert) {
                // Set the response and exit
                $this->response([
                    'message' => 'The motivation successfully created.',
                    'data' => $insert
                ], REST_Controller::HTTP_OK);
            } else {
                // Set the response and exit
                $this->response("Some problems occurred, please try again.", REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
            // Set the response and exit
            $this->response("Provide complete motivation info to add.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}
