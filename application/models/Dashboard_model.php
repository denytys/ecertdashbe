<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_model extends CI_Model
{
    //grafik bulanan
    public function get_monthly_data($type, $year)
    {
        switch ($type) {
            case 'ecertin':
                $table = 'ecert_in';
                $dateField = 'tgl_cert';
                break;
            case 'ephytoin':
                $table = 'ephyto_in';
                $dateField = 'tgl_cert';
                break;
            case 'ecertout':
                $table = 'ecert_out';
                $dateField = 'tgl_cert';
                break;
            case 'ephytoout':
                $table = 'ephyto_out';
                $dateField = 'tgl_cert';
                break;
            default:
                return [];
        }

        return $this->db
            ->select("MONTH($dateField) AS bulan, COUNT(*) AS total")
            ->from($table)
            ->where("YEAR($dateField)", $year)
            ->group_by("MONTH($dateField)")
            ->order_by("MONTH($dateField)", "ASC")
            ->get()
            ->result_array();
    }

    public function getEcertIn()
    {
        $query = $this->db
            ->select('tgl_cert, no_cert, doc_type, komo_eng, port_asal, neg_asal, port_tuju, tujuan')
            ->from('ecert_in')
            ->order_by('tgl_cert', 'DESC')
            ->get();

        return [
            'total_data' => $this->db->count_all('ecert_in'),
            'data' => $query->result_array()
        ];
    }

    public function getEphytoIn()
    {
        $query = $this->db
            ->select('tgl_cert, no_cert, doc_type, komo_eng, port_asal, neg_asal, port_tuju, kota_tuju, data_from')
            ->from('ephyto_in')
            ->order_by('tgl_cert', 'DESC')
            ->get();

        return [
            'total_data' => $this->db->count_all('ephyto_in'),
            'data' => $query->result_array()
        ];
    }

    public function getEcertOut()
    {
        $query = $this->db
            ->select('tgl_cert, no_cert, doc_type, komoditi, neg_tuju, upt, send_to')
            ->from('ecert_out')
            ->order_by('tgl_cert', 'DESC')
            ->get();

        return [
            'total_data' => $this->db->count_all('ecert_out'),
            'data' => $query->result_array()
        ];
    }

    public function getEphytoOut()
    {
        $query = $this->db
            ->select('tgl_cert, no_cert, doc_type, komoditi, neg_tuju, upt, send_to')
            ->from('ephyto_out')
            ->order_by('tgl_cert', 'DESC')
            ->get();

        return [
            'total_data' => $this->db->count_all('ephyto_out'),
            'data' => $query->result_array()
        ];
    }

    // hitung total dokumen via (ASW, IPPC, H2H)
    public function count_via($year)
    {
        // ecert_in → semua dianggap H2H
        $h2h_in = $this->db->where("YEAR(tgl_cert)", $year)->count_all_results('ecert_in');

        // ecert_out → cek kolom send_to
        $asw_out = $this->db->where("YEAR(tgl_cert)", $year)->where('send_to', 'ASW')->count_all_results('ecert_out');
        $ippc_out = $this->db->where("YEAR(tgl_cert)", $year)->where('send_to', 'IPPC')->count_all_results('ecert_out');
        $h2h_out = $this->db->where("YEAR(tgl_cert)", $year)->where('send_to', 'H2H')->count_all_results('ecert_out');

        // ephyto_in → cek kolom data_from
        $asw_in = $this->db->where("YEAR(tgl_cert)", $year)->where('data_from', 'ASW')->count_all_results('ephyto_in');
        $ippc_in = $this->db->where("YEAR(tgl_cert)", $year)->where('data_from', 'IPPC')->count_all_results('ephyto_in');
        $h2h_in2 = $this->db->where("YEAR(tgl_cert)", $year)->where('data_from', 'H2H')->count_all_results('ephyto_in');

        // ephyto_out → cek kolom send_to
        $asw_out2 = $this->db->where("YEAR(tgl_cert)", $year)->where('send_to', 'ASW')->count_all_results('ephyto_out');
        $ippc_out2 = $this->db->where("YEAR(tgl_cert)", $year)->where('send_to', 'IPPC')->count_all_results('ephyto_out');
        $h2h_out2 = $this->db->where("YEAR(tgl_cert)", $year)->where('send_to', 'H2H')->count_all_results('ephyto_out');

        return [
            'asw' => $asw_in + $asw_out + $asw_out2,
            'ippc' => $ippc_in + $ippc_out + $ippc_out2,
            'h2h' => $h2h_in + $h2h_out + $h2h_in2 + $h2h_out2,
        ];
    }
}
