<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_pengaturanPresensi extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insertPresensi($data)
    {
        return $this->db->insert('pengaturanpresensi', $data);
    }

    public function tampilPresensiById($id_presensi)
    {
        return $this->db->get_where('pengaturanpresensi', ['id_presensi' => $id_presensi])->row_array();
    }

    public function editPresensi($data)
    {
        return $this->db->update('pengaturanpresensi', $data,  array('id_presensi' => $data['id_presensi']));
    }

    public function deletePresensi($id_presensi)
    {
        $this->db->where('id_presensi', $id_presensi);
        return $this->db->delete('pengaturanpresensi');
    }



    // add-on   
    public function tampilJabatan()
    {
        return $this->db->get('jabatan')->result_array();
    }

    public function isActive()
    {
        return $this->db->get_where('pengaturanpresensi', ['status_presensi' => '1'])->row_array();
    }

    public function isDraft()
    {
        return $this->db->get_where('pengaturanpresensi', ['status_presensi' => '0'])->result_array();
    }
}
