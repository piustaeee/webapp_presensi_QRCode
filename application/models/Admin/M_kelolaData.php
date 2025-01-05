<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_kelolaData extends CI_Model
{
    public function insertPegawai($data)
    {
        $this->db->insert('pegawai', $data);
    }

    public function readPegawai($nip)
    {
        $this->db->select('pegawai.*, jabatan.nama_jabatan');
        $this->db->from('pegawai');
        $this->db->join('jabatan', 'pegawai.kd_jabatan = jabatan.kd_jabatan', 'left');
        $this->db->where('pegawai.nip', $nip);
        return $this->db->get()->row_array();
    }

    public function updatePegawai($nip, $data)
    {
        $this->db->where('nip', $nip);
        $this->db->update('pegawai', $data);
    }

    public function deletePegawai($nip)
    {
        $tables = array('akun', 'pegawai');
        $this->db->where('nip', $nip);
        $this->db->delete($tables);
        return TRUE;
    }

    public function tampilPegawai()
    {
        $this->db->order_by('created_at', 'DESC');
        $this->db->select('pegawai.*, jabatan.nama_jabatan');
        $this->db->from('pegawai');
        $this->db->join('jabatan', 'pegawai.kd_jabatan = jabatan.kd_jabatan', 'left');
        return $this->db->get()->result_array();
    }

    public function isNipUnique($nip)
    {
        $existingNip = $this->db->where('nip', $nip)->get('pegawai')->row();
        return !$existingNip;
    }

    public function isEmailUnique($email)
    {
        $existingEmail = $this->db->where('email', $email)->get('pegawai')->row();
        return !$existingEmail;
    }

    public function getJabatan()
    {
        return $this->db->get('jabatan')->result_array();
    }

    public function insertRiwayat($data)
    {
        $this->db->insert('riwayatjabatan', $data);
    }
}
