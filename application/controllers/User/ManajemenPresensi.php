<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ManajemenPresensi extends MY_Controller {
	public function __construct() {
        parent::__construct();
        
        $this->check_role('1');
    }

	public function evaluasiDiriUser()
	{
		$this->load->view('include/header.php');
		$this->load->view('include/navbarPegawai.php');
		$this->load->view('pegawai/form_evaluasiDiri.php');
		$this->load->view('include/footer.php');
	}
}
