<?php

defined('BASEPATH') or exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;

class Mahasiswa extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key

        // $this->load->model('ModelApi', 'getApi');
        $this->load->model([
            'ModelApi' => 'getApi'
        ]);
    }

    public function index_get()
    {
        // code here...
    }

    public function GetMahasiswaAktif()
    {
        // code
        $idMhs = $this->get('id');
        // var_dump($idMhs);
        // die;
        if ($idMhs === null) {
            $mhs = $this->getApi->get_mhs()->result_array();
        } else {
            $mhs = $this->getApi->get_mhs($idMhs)->result_array();
        }
        if ($mhs) {
            $this->response([
                'status' => true,
                'data' => $mhs
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => FALSE,
                'data'   => 'Id Not Found!'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
}
