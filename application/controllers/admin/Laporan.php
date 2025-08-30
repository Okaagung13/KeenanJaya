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
        $data['laporan'] = $this->Laporan_model->get_all_orders();
        $this->load->view('admin/laporan/export_pdf', $data);
    }

     public function export_pdf()
    {
        $data['laporan'] = $this->Laporan_model->get_all_orders();
        $html = $this->load->view('admin/laporan/export1_pdf', $data, true);

        $this->pdf->loadHtml($html);
        $this->pdf->setPaper('A4', 'landscape');
        $this->pdf->render();
        $this->pdf->stream("laporan_penjualan.pdf", array("Attachment" => 0));
    }
}
