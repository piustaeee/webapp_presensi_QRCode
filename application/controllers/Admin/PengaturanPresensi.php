<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PengaturanPresensi extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Admin/M_pengaturanPresensi');
		$this->check_role('2');
	}

	public function presensiAdmin()
	{
		$this->load->view('include/header.php');
		$this->load->view('include/navbar.php');
		$this->load->view('pegawai/form_presensi.php');
		$this->load->view('include/footer.php');
	}

	public function aturPresensi()
	{
		$presensiData = $this->M_pengaturanPresensi->isDraft();
		foreach ($presensiData as &$record) {
			$record['bulan_presensi'] = $this->getNamaBulan($record['bulan_presensi']);
		}

		// Fetch active data
		$activeData = $this->M_pengaturanPresensi->isActive();
		$activeData['bulan_presensi'] = $this->getNamaBulan($activeData['bulan_presensi']);

		// Combine both data arrays into a single array
		$data = [
			'presensiData' => $presensiData,
			'activeData' => $activeData
		];

		$this->loadPage('hrd/form_pengaturanPresensi.php', $data);

	}

	public function generateQRCode()
	{
		// Load the CI QR code library
		$this->load->library('ciqrcode');

		// Generate a random token
		$token = bin2hex(random_bytes(16));
		$url = site_url("Presensi/validateToken?token=" . urlencode($token));

		// Insert token into the database
		$this->db->insert('qr_tokens', [
			'token' => $token,
			'created_at' => date('Y-m-d H:i:s'),
			'is_used' => '0'
		]);

		// Set the parameters for the QR Code generation
		$params['data'] = $url;
		$params['level'] = 'H';   // Error correction level (H = high)
		$params['size'] = 6;
		$params['savename'] = FCPATH . 'qrcodes/kelola_data_qrcode.png';

		// Generate and save the QR Code
		$this->ciqrcode->generate($params);

		// Prepare the response with the QR code path
		$data['qr_code_path'] = base_url('qrcodes/kelola_data_qrcode.png');

		// Send the response as JSON to the front-end
		echo json_encode($data);
	}


	public function presensiBaru()
	{
		$data['jabatan'] = $this->M_pengaturanPresensi->tampilJabatan();
		$this->loadPage('hrd/form_tambahPengaturanPresensi.php', $data);
	}


	public function presensiById($id_presensi)
	{
		$data = $this->M_pengaturanPresensi->tampilPresensiById($id_presensi);
		$old_data = $data['hari_kerja'];
		$data['hari_kerja'] = isset($old_data) ? explode(',', $old_data) : [];

		$data['jabatan'] = $this->M_pengaturanPresensi->tampilJabatan();
		$this->loadPage('hrd/form_updatePengaturanPresensi.php', $data);

	}

	public function isActive()
	{
		$activePresensi = $this->M_pengaturanPresensi->isActive();

		if ($activePresensi) {
			$updateData = [
				'id_presensi' => $activePresensi['id_presensi'],
				'status_presensi' => '0'
			];

			$this->M_pengaturanPresensi->editPresensi($updateData);
		}
	}


	public function addPresensi()
	{
		$config = [
			[
				'field' => 'bulan_presensi',
				'label' => 'Bulan',
				'rules' => 'required'
			],
			[
				'field' => 'tahun_presensi',
				'label' => 'Tahun',
				'rules' => 'required'
			],
			[
				'field' => 'hari_kerja[]',
				'label' => 'Hari Kerja',
				'rules' => 'required'
			],
			[
				'field' => 'jam_masuk',
				'label' => 'Absensi Jam Masuk',
				'rules' => 'required'
			],
			[
				'field' => 'jam_pulang',
				'label' => 'Absensi Jam Pulang',
				'rules' => 'required'
			],
			[
				'field' => 'durasi_telat',
				'label' => 'Durasi Keterlambatan',
				'rules' => 'required'
			],

			[
				'field' => 'jam_mulai_istirahat',
				'label' => 'Waktu Istirahat',
				'rules' => 'required'
			],
			[
				'field' => 'jam_akhir_istirahat',
				'label' => 'Waktu Istirahat Berakhir',
				'rules' => 'required'
			],
			[
				'field' => 'tanggal_libur',
				'label' => 'Tanggal Libur',
				'rules' => ''
			],

			[
				'field' => 'kd_jabatan',
				'label' => 'Jabatan',
				'rules' => 'required'
			],

		];


		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() ==  FALSE) {
			$this->session->set_flashdata('erroradd', validation_errors());
			$this->presensiBaru();
		} else {
			$data = $this->input->post();
			$hari = $this->input->post('hari_kerja[]');
			$newhari = implode(",", $hari);
			$data['hari_kerja'] = $newhari;

			if ($data['status_presensi'] == '1') {
				$this->isActive();
			}

			$this->M_pengaturanPresensi->insertPresensi($data);
			$this->session->set_flashdata('successadd', 'Presensi berhasil Disimpan!');
			redirect('aturPresensi');
		}
	}

	public function editPresensi()
	{
		$config = [
			[
				'field' => 'bulan_presensi',
				'label' => 'Bulan',
				'rules' => 'required'
			],
			[
				'field' => 'tahun_presensi',
				'label' => 'Tahun',
				'rules' => 'required'
			],
			[
				'field' => 'hari_kerja[]',
				'label' => 'Hari Kerja',
				'rules' => 'required'
			],
			[
				'field' => 'jam_masuk',
				'label' => 'Absensi Jam Masuk',
				'rules' => 'required'
			],
			[
				'field' => 'jam_pulang',
				'label' => 'Absensi Jam Pulang',
				'rules' => 'required'
			],
			[
				'field' => 'durasi_telat',
				'label' => 'Durasi Keterlambatan',
				'rules' => 'required'
			],

			[
				'field' => 'jam_mulai_istirahat',
				'label' => 'Waktu Istirahat',
				'rules' => 'required'
			],
			[
				'field' => 'jam_akhir_istirahat',
				'label' => 'Waktu Istirahat Berakhir',
				'rules' => 'required'
			],
			[
				'field' => 'tanggal_libur',
				'label' => 'Tanggal Libur',
				'rules' => ''
			],

			[
				'field' => 'kd_jabatan',
				'label' => 'Jabatan',
				'rules' => 'required'
			],

		];


		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() ==  FALSE) {
			$this->session->set_flashdata('erroradd', validation_errors());
			$this->presensiBaru();
		} else {
			$data = $this->input->post();
			$hari = $this->input->post('hari_kerja[]');
			$newhari = implode(",", $hari);
			$data['hari_kerja'] = $newhari;
			// var_dump($data['hari_kerja']);die;


			if ($data['status_presensi'] == '1') {
				$this->isActive();
			}


			$this->M_pengaturanPresensi->editPresensi($data);
			$this->session->set_flashdata('successadd', 'Presensi berhasil Disimpan!');
			redirect('aturPresensi');
		}
	}

	public function deletePresensi($id_presensi)
	{
		$delete = $this->M_pengaturanPresensi->deletePresensi($id_presensi);

		if ($delete) {
			$this->session->set_flashdata('successhapus', 'Presensi berhasil dihapus!');
		} else {
			$this->session->set_flashdata('errorhapus', 'Gagal menghapus Presensi!');
		}

		redirect('aturPresensi');
	}

	function getNamaBulan($bulan)
	{
		switch ($bulan) {
			case 1:
				return "Januari";
			case 2:
				return "Februari";
			case 3:
				return "Maret";
			case 4:
				return "April";
			case 5:
				return "Mei";
			case 6:
				return "Juni";
			case 7:
				return "Juli";
			case 8:
				return "Agustus";
			case 9:
				return "September";
			case 10:
				return "Oktober";
			case 11:
				return "November";
			case 12:
				return "Desember";
			default:
				return "Nomor bulan tidak valid.";
		}
	}
}
