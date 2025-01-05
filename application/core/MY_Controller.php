<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('login')) {
            redirect('login');
        }
    }

    public function loadPage($view, $data = [])
    {
        $this->load->view('include/header.php');
        $this->load->view('include/navbar.php');
        $this->load->view($view, $data);
        $this->load->view('include/footer.php');
    }


    protected function check_role($required_role)
    {
        $user_role = $this->session->userdata('type'); // Get the user's role from the session

        if ($required_role === '2') {
            // Check for Admin role
            if ($user_role !== '2') {
                redirect('not_authorized');
            }
        } else {
            // Check for Pegawai roles (anything except '2')
            if ($user_role === '2') {
                redirect('not_authorized'); // Admin cannot access Pegawai areas
            }
        }
    }
}
