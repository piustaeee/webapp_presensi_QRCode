<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_Akun');
    }

    public function index()
    {
        // Set rules
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        // Check if cookies exist and pre-fill form
        if ($this->form_validation->run() == false) {
            $data['username'] = get_cookie('loginUsername') ? get_cookie('loginUsername') : '';
            $data['password'] = get_cookie('loginPassword') ? get_cookie('loginPassword') : '';
            $this->load->view('form_login', $data);
        } else {
            $this->_login();
        }
    }

    private function _login()
    {
        $username = htmlspecialchars($this->input->post('username'));
        $password = htmlspecialchars($this->input->post('password'));

        $akun = $this->M_Akun->validation_akun($username, $password);

        if ($akun) {
            if ($akun['status_akun'] == 1) {
                $nip = $akun['nip'];
                $akses = $this->M_Akun->cek_akses($nip);

                $data = [
                    'username' => $akun['username'],
                    'type' => $akses['kd_jabatan'],
                    'nama' => $akses['nama'],
                    'nip' => $akses['nip'],
                    'login' => TRUE,
                ];

                $this->session->set_userdata($data);

                if (!empty($this->input->post('remember-me'))) {
                    set_cookie("loginUsername", $username, 86400 * 30);
                    set_cookie("loginPassword", $password, 86400 * 30);
                } else {
                    delete_cookie('loginUsername');
                    delete_cookie('loginPassword');
                }

                if ($data['type'] == 2) {
                    redirect('berandaAdmin');
                } else {
                    redirect('berandaUser');
                }
            } else {
                $this->session->set_flashdata('error', 'Akun anda Belum Aktif');
                $this->load->view('form_login');
            }
        } else {
            $this->session->set_flashdata('error', 'Username atau Password salah');
            $this->load->view('form_login');
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        delete_cookie("loginUsername");
        delete_cookie("loginPassword");
        redirect('login');
    }
}
