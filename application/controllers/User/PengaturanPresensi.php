<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PengaturanPresensi extends MY_Controller {
	public function __construct() {
        parent::__construct();
		$this->load->model('Admin/M_presensi');
        $this->load->model('Admin/M_kelolaData');
        $this->load->model('Admin/M_pengaturanPresensi');
        
        $this->check_role('1');
    }

	public function presensiUser()
	{
		$this->load->view('include/header.php');
		$this->load->view('include/navbarPegawai.php');
		$this->load->view('pegawai/form_presensi.php');
		$this->load->view('include/footer.php');
	}
}

