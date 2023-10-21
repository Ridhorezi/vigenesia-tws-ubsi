    <?php

    defined('BASEPATH') or exit('No direct script access allowed');

    require APPPATH . '/libraries/REST_Controller.php';

    use Restserver\Libraries\REST_Controller;

    class PostMotivasi extends REST_Controller
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
            $this->load->model('motivasi');
        }



        public function index_post()
        {
            $motivasiData = array(
                'isi_motivasi' => $this->input->post("isi_motivasi"),
                'iduser' => $this->input->post("iduser")
            );
        
            $insert = $this->motivasi->insert($motivasiData);
        
            // Check if the user data is inserted
            if ($insert) {
                // Set the response and exit
                $this->response([
                    'message' => 'The motivation successfully created.',
                    'data' => $insert
                ], REST_Controller::HTTP_OK);
            }
        }
    }
