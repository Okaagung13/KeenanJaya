<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Laporan_model');
        $this->load->library('pdf'); // pastikan library Pdf sudah ada
    }

    public function index()
    {
        if ($this->session->userdata('level') != '1') {
            redirect('welcome');
        }

        $from_date = $this->input->get('from_date');
        $to_date = $this->input->get('to_date');

        $data['title'] = 'Laporan Penjualan';
        $data['laporan'] = $this->Laporan_model->get_all_orders($from_date, $to_date);
        $data['from_date'] = $from_date;
        $data['to_date'] = $to_date;

        $this->load->view('layout/admin/header', $data);
        $this->load->view('admin/laporan/Laporan', $data);
        $this->load->view('layout/admin/footer');
    }

    public function export_pdf()
    {
        $from_date = $this->input->get('from_date');
        $to_date = $this->input->get('to_date');
        $selected_ids = $this->input->post('selected_ids');

        if (!is_array($selected_ids)) {
            $selected_ids = [];
        }

        $data['laporan'] = $this->Laporan_model->get_all_orders($from_date, $to_date, $selected_ids);
        
        $html = $this->load->view('admin/laporan/export1_pdf', $data, true);

        $this->pdf->loadHtml($html);
        $this->pdf->setPaper('A4', 'landscape');
        $this->pdf->render();
        $this->pdf->stream("laporan_penjualan.pdf", array("Attachment" => 0));
    }
}
