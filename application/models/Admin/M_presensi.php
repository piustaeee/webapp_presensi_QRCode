<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_presensi extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insertPresensi($data)
    {
        return $this->db->insert('riwayatpresensi', $data);
    }

    public function getPresensiByDate($tanggalPresensi,$nip){
        return $this->db->get_where('riwayatpresensi', ['tanggal_presensi' => $tanggalPresensi, 'nip' => $nip])->row_array();
    }

    public function updatePresensi($id_presensi, $data){
        return $this->db->update('riwayatpresensi', $data,  array('id_presensi' => $id_presensi));
    }

    public function isActive()
    {
        return $this->db->get_where('pengaturanpresensi', ['status_presensi' => '1'])->row_array();
    }
}