<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_Akun extends CI_Model {

    public function validation_akun($username, $password) {
        $akun = $this->db->get_where('akun', ['username' => $username])->row_array();

        if ($akun && password_verify($password, $akun['password'])) {
            return $akun;
        } else {
            return null;
        }
    }

    public function cek_akses($nip) {
        return $this->db->get_where('pegawai', ['nip' => $nip])->row_array();
    }
}
