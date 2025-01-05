<?php
defined('BASEPATH') or exit('No direct script access allowed');

class EvaluasiDiri extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Admin/M_pengaturanPresensi');
        $this->load->model('Admin/M_evaluasiDiri');
        $this->load->helper('myhelp');
    }

    private function renderEvaluasiDiri($isAdmin = true)
    {
        $nip = $this->session->userdata('nip');

        $data = [
            'grafikPresensi' => $this->M_evaluasiDiri->grafikPresensi($nip),
            'dataHadir' => $isAdmin
                ? $this->M_evaluasiDiri->getDataHadir($nip)
                : $this->M_evaluasiDiri->getAll($nip),
            'dataTepatWaktu' => $this->M_evaluasiDiri->getDataTepatWaktu($nip),
            'dataTerlambat' => $this->M_evaluasiDiri->getDataTerlambat($nip),
            'dataIzin' => $this->M_evaluasiDiri->getDataIzin($nip),
            'dataAlpa' => $this->M_evaluasiDiri->getDataAlpa($nip),
            'hariKerja' => $this->cekHariKerja(),
        ];

        // Load the correct navbar based on user type
        $navbar = $isAdmin ? 'include/navbar.php' : 'include/navbarPegawai.php';

        $this->load->view('include/header.php');
        $this->load->view($navbar);
        $this->load->view('pegawai/form_evaluasiDiri.php', $data);
        $this->load->view('include/footer.php');
    }

    public function evaluasiDiriAdmin()
    {
        $this->renderEvaluasiDiri(true);
    }

    public function evaluasiDiriUser()
    {
        $this->renderEvaluasiDiri(false);
    }

    public function isAjax()
    {
        $nip = $this->session->userdata('nip');
        $tahun = $this->input->get('year');
        $bulan = $this->input->get('month');

        $dataPresensi = $this->M_evaluasiDiri->getDataByTahunAndBulan($nip, $tahun, $bulan);
        echo json_encode($dataPresensi);
        return;
    }

    public function cekHariKerja()
    {
        $data = $this->M_pengaturanPresensi->isActive();
        $bulan = $data['bulan_presensi'];
        $tahun = $data['tahun_presensi'];
        $hariKerja = $data['hari_kerja'];
        $tanggalLibur = $data['tanggal_libur'];

        $hariKerjaArray = array_map('trim', explode(',', $hariKerja));
        $hariKerjaEnglish = array_map('convertHariToEnglish', $hariKerjaArray);
        $hariKerjaEnglish = array_filter($hariKerjaEnglish);

        return hitungHariKerja($bulan, $tahun, $hariKerjaEnglish, $tanggalLibur);
    }
}
