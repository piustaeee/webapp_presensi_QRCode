<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_akunPegawai extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insertAkunPegawai($data)
    {
        return $this->db->insert('akun', $data);
    }

    public function readAkunPegawai($nip)
    {
        return $this->db->get_where('akun', ['nip' => $nip])->row_array();
    }

    public function updateAkunPegawai($nip, $data)
    {
        $this->db->where('nip', $nip); 
        return $this->db->update('akun', $data);
    }

    public function cekAkun($nip){
        return $this->db->get_where('akun', ['nip' => $nip])->row_array();
    }



}
