<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('Admin/M_presensi');
		$this->load->model('Admin/M_kelolaData');
		$this->load->model('Admin/M_pengaturanPresensi');
		$this->load->model('Admin/M_evaluasiDiri');
		$this->load->helper('myhelp');

		$this->check_role('1');
	}

	public function user()
	{
		$nip = $this->session->userdata('nip');
		$date = date('Y-m-d');
		$bulan = date('m');
		$tahun = date('Y');

		$data['grafikPresensi'] = $this->M_evaluasiDiri->grafikPresensi($nip);
		$data['dataHadir'] = $this->M_evaluasiDiri->getAll($nip);
		$data['dataTepatWaktu'] = $this->M_evaluasiDiri->getDataTepatWaktu($nip);
		$data['dataTerlambat'] = $this->M_evaluasiDiri->getDataTerlambat($nip);
		$data['dataIzin'] = $this->M_evaluasiDiri->getDataIzin($nip);
		$data['dataAlpa'] = $this->M_evaluasiDiri->getDataAlpa($nip);
		$data['hariKerja'] = $this->cekHariKerja();

		$query = $this->M_pengaturanPresensi->isActive();
		$data['jadwalmasuk'] = date('H:i', strtotime($query['jam_masuk']));
		$data['jadwalpulang'] = date('H:i', strtotime($query['jam_pulang']));
		$data['jadwalistirahatawal'] = date('H:i', strtotime($query['jam_mulai_istirahat']));
		$data['jadwalistirahatakhir'] = date('H:i', strtotime($query['jam_akhir_istirahat']));

		$presensi = $this->M_presensi->getPresensiByDate($date, $nip);
		$data['cekjadwalmasuk'] = !empty($presensi['jam_masuk']) ? 'checked' : '';
		$data['cekjadwalpulang'] = !empty($presensi['jam_pulang']) ? 'checked' : '';
		$data['cekjadwalistirahatawal'] = !empty($presensi['jam_mulai_istirahat']) ? 'checked' : '';
		$data['cekjadwalistirahatakhir'] = !empty($presensi['jam_akhir_istirahat']) ? 'checked' : '';
		$data['dataPresensi'] = $this->M_evaluasiDiri->getDataByTahunAndBulan($nip, $tahun, $bulan);

		$this->load->view('include/header.php');
		$this->load->view('include/navbarPegawai.php');
		$this->load->view('pegawai/form_beranda.php', $data);
		$this->load->view('include/footer.php');
	}

	public function detailData()
	{
		$nip = $this->session->userdata('nip');
		$data = $this->M_kelolaData->readPegawai($nip);

		$this->load->view('include/header.php');
		$this->load->view('include/navbarPegawai.php');
		$this->load->view('hrd/form_detailData.php', $data);
		$this->load->view('include/footer.php');
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
