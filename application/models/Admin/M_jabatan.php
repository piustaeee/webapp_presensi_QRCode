<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_jabatan extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function tampilJabatan()
    {
        return $this->db->get('jabatan')->result_array();
    }

    public function insertJabatan($data)
    {
        return $this->db->insert('jabatan', $data);
    }

    public function updateJabatan($data)
    {
        $allowedFields = ['nama_jabatan', 'uraian_tugas'];
        $filteredData = array_intersect_key($data, array_flip($allowedFields));
        return $this->db->update('jabatan', $filteredData, array('kd_jabatan' => $data['kd_jabatan']));
    }

    public function deleteJabatan($kdJabatan)
    {
        $this->db->where('kd_jabatan', $kdJabatan);
        return $this->db->delete('jabatan');
    }

    public function getRiwayatJabatan()
    {
        $this->db->select('pegawai.nama AS nama_pegawai,riwayatjabatan.*');
        $this->db->from('riwayatjabatan');
        $this->db->join('pegawai', 'riwayatjabatan.nip = pegawai.nip', 'left');
        return $this->db->get()->result_array();
    }
}
