<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

require APPPATH . 'libraries/RestController.php';
require APPPATH . 'libraries/Format.php';

class Countryset extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_country', 'country_setting');
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    }

    public function index_post()
    {
        $data =
            [
                'id_neg' => $this->post('id_neg'),
                'doc' => $this->post('doc'),
                'via' => $this->post('via')
            ];

        $insert = $this->country_setting->insert($data);

        if ($insert) {
            $this->response([
                'status' => true,
                'message' => 'Perizinan berhasil disimpan'
            ], 201);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Gagal menyimpan data'
            ], 500);
        }
    }

    public function index_options()
    {
        // kiye sing bolak balik perkara preflight CORS
        return $this->response(null, 200);
    }

    public function index_get()
    {
        $limit = $this->get('limit') ? (int)$this->get('limit') : 5;
        $page = $this->get('page') ? (int)$this->get('page') : 1;
        $offset = ($page - 1) * $limit;

        // njukut total data
        $total = $this->db->count_all('country_setting');

        // njukut data limit & offset
        $query = $this->db->get('country_setting', $limit, $offset)->result();

        if ($query) {
            $this->response([
                'status' => true,
                'data' => $query,
                'pagination' => [
                    'total' => $total,
                    'limit' => $limit,
                    'page' => $page,
                    'total_pages' => ceil($total / $limit)
                ]
            ], 200);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }
    }
}
