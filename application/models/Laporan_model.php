<?php
class Laporan_model extends CI_Model
{
    public function get_all_orders($from_date = null, $to_date = null, $order_ids = [])
    {
        $this->db->from('transaction');

        if ($from_date && $to_date) {
            $this->db->where('transaction_time >=', $from_date);
            $this->db->where('transaction_time <=', $to_date);
        }

        if (!empty($order_ids)) {
            $this->db->where_in('order_id', $order_ids);
        }

        return $this->db->get()->result();
    }
}
