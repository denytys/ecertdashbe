<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Outgoing extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Dashboard_model');
    }

    public function ecertout()
    {
        $response = $this->Dashboard_model->getEcertOut();
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function ephytoout()
    {
        $response = $this->Dashboard_model->getEphytoOut();
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }
}
