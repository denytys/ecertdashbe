<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Incoming extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Dashboard_model');
    }

    public function ecertin()
    {
        $response = $this->Dashboard_model->getEcertIn();
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function ephytoin()
    {
        $response = $this->Dashboard_model->getEphytoIn();
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }
}
