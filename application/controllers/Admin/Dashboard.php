<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->check_role('2');
		$this->load->model('Admin/M_beranda');
		$this->load->model('Admin/M_kelolaData');
		$this->load->model('Admin/M_pengaturanPresensi');
		$this->load->helper('myhelp');
	}

	public function admin()
	{
		$tanggal = date("Y-m-d");

		$data = [
			'dataPresensi' => $this->M_beranda->getDataPresensi(),
			'sumPegawai' => $this->M_beranda->getSumPegawai(),
			'dataHadir' => $this->M_beranda->getDataHadir($tanggal),
			'dataIzin' => $this->M_beranda->getDataIzin($tanggal),
			'dataAlpa' => $this->M_beranda->getDataAlpa($tanggal),
			'dataTepatWaktu' => $this->M_beranda->getDataTepatWaktu(),
			'dataTepatWaktu' => $this->M_beranda->getGrafik(),
			'hariKerja' => $this->cekHariKerja(),
			'dataPresensiCurrentMonth' => $this->M_beranda->getPresensiCurrentMonth(),
		];

		$this->loadPage('hrd/form_beranda.php', $data);
	}

	public function isAjax()
	{
		$dataPresensi = $this->M_beranda->getDataPresensi();

		$tanggalPresensi = array_map(function ($item) {
			return $item['tanggal_presensi'];
		}, $dataPresensi);

		$attendance = array_fill(0, 12, 0);

		$currentYear = date('Y');

		foreach ($tanggalPresensi as $date) {
			if ($date !== '0000-00-00') {
				// Periksa apakah tahun sesuai dengan tahun saat ini
				$year = date('Y', strtotime($date));
				if ($year == $currentYear) {
					$month = (int) date('m', strtotime($date)) - 1; // Mendapatkan indeks bulan (0-11)
					$attendance[$month]++;
				}
			}
		}

		echo json_encode($attendance);
	}

	public function detailData()
	{
		$nip = $this->session->userdata('nip');
		$data = $this->M_kelolaData->readPegawai($nip);
		
		$this->loadPage('hrd/form_detailData.php', $data);
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
