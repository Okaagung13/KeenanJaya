<?php
class Laporan_model extends CI_Model
{
    public function get_all_orders()
    {
        return $this->db->get('transaction')->result(); 
    }
}
