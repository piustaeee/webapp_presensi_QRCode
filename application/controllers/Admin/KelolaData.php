<?php
defined('BASEPATH') or exit('No direct script access allowed');

class kelolaData extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Admin/M_akunPegawai');
		$this->load->model('Admin/M_kelolaData');

		$this->check_role('2');
	}

	public function kelolaDataPegawai()
	{
		$data['pegawai'] = $this->M_kelolaData->tampilPegawai();
		$this->loadPage('hrd/form_kelolaDataPegawai.php', $data);
	}

	public function tambahData()
	{
		$data = [
			'jabatan' => $this->M_kelolaData->getJabatan(),
		];

		$this->loadPage('hrd/form_tambahDataPegawai.php', $data);
	}


	public function insert_pegawai()
	{
		$config = [
			[
				'field' => 'nip',
				'label' => 'NIP',
				'rules' => 'required|numeric|is_unique[pegawai.nip]'
			],
			[
				'field' => 'nik',
				'label' => 'NIK',
				'rules' => 'required|numeric|is_unique[pegawai.nik]'
			],
			[
				'field' => 'nama',
				'label' => 'Nama',
				'rules' => 'required'
			],
			[
				'field' => 'jk',
				'label' => 'Jenis Kelamin',
				'rules' => 'required'
			],
			[
				'field' => 'tempat_lahir',
				'label' => 'Tempat Lahir',
				'rules' => 'required'
			],
			[
				'field' => 'tanggal_lahir',
				'label' => 'Tanggal Lahir',
				'rules' => 'required'
			],

			// Kontak
			[
				'field' => 'alamat',
				'label' => 'Alamat',
				'rules' => 'required'
			],
			[
				'field' => 'telp',
				'label' => 'Telepon',
				'rules' => 'required|numeric'
			],
			[
				'field' => 'email',
				'label' => 'Email',
				'rules' => 'required|valid_email|is_unique[pegawai.email]'
			],

			// Pendidikan & Agama
			[
				'field' => 'pendidikan_terakhir',
				'label' => 'Pendidikan Terakhir',
				'rules' => 'required'
			],
			[
				'field' => 'agama',
				'label' => 'Agama',
				'rules' => 'required'
			],

			// Data Keluarga
			[
				'field' => 'jumlah_anak',
				'label' => 'Jumlah Anak',
				'rules' => 'required|integer|greater_than_equal_to[0]'
			],

			// Pekerjaan
			[
				'field' => 'tmt_bekerja',
				'label' => 'TMT Bekerja',
				'rules' => 'required'
			],
			[
				'field' => 'tmt_berakhir',
				'label' => 'TMT Berakhir',
				'rules' => 'required'
			],
			[
				'field' => 'status_pegawai',
				'label' => 'Status Pegawai',
				'rules' => 'required'
			],
			[
				'field' => 'kd_jabatan',
				'label' => 'Kode Jabatan',
				'rules' => 'required|integer'
			]
		];


		$this->form_validation->set_rules($config);

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('errortambah', validation_errors());
			$this->tambahData();
		} else {
			$data = $this->input->post();
			$this->M_kelolaData->insertPegawai($data);
			$this->session->set_flashdata('successtambah', 'Data berhasil Ditambah!');
			redirect('dataPegawai');
		}
	}

	public function updateData($nip)
	{
		$pegawai = $this->M_kelolaData->readPegawai($nip);
		$jabatan =	$data['jabatan'] = $this->M_kelolaData->getJabatan();


		$data = array_merge(
			['jabatan' => $jabatan],
			$pegawai
		);

		$this->loadPage('hrd/form_updateDataPegawai.php', $data);
	}

	public function updateDataPegawai()
	{
		$config = [
			[
				'field' => 'nip',
				'label' => 'NIP',
				'rules' => 'required|numeric'
			],
			[
				'field' => 'nik',
				'label' => 'NIK',
				'rules' => 'required|numeric'
			],
			[
				'field' => 'nama',
				'label' => 'Nama',
				'rules' => 'required'
			],
			[
				'field' => 'jk',
				'label' => 'Jenis Kelamin',
				'rules' => 'required'
			],
			[
				'field' => 'tempat_lahir',
				'label' => 'Tempat Lahir',
				'rules' => 'required'
			],
			[
				'field' => 'tanggal_lahir',
				'label' => 'Tanggal Lahir',
				'rules' => 'required'
			],

			// Kontak
			[
				'field' => 'alamat',
				'label' => 'Alamat',
				'rules' => 'required'
			],
			[
				'field' => 'telp',
				'label' => 'Telepon',
				'rules' => 'required|numeric'
			],
			[
				'field' => 'email',
				'label' => 'Email',
				'rules' => 'required|valid_email'
			],

			// Pendidikan & Agama
			[
				'field' => 'pendidikan_terakhir',
				'label' => 'Pendidikan Terakhir',
				'rules' => 'required'
			],
			[
				'field' => 'agama',
				'label' => 'Agama',
				'rules' => 'required'
			],

			// Data Keluarga
			[
				'field' => 'jumlah_anak',
				'label' => 'Jumlah Anak',
				'rules' => 'required|integer|greater_than_equal_to[0]'
			],

			// Pekerjaan
			[
				'field' => 'tmt_bekerja',
				'label' => 'TMT Bekerja',
				'rules' => 'required'
			],
			[
				'field' => 'tmt_berakhir',
				'label' => 'TMT Berakhir',
				'rules' => 'required'
			],
			[
				'field' => 'status_pegawai',
				'label' => 'Status Pegawai',
				'rules' => 'required'
			],
			[
				'field' => 'kd_jabatan',
				'label' => 'Kode Jabatan',
				'rules' => 'required|integer'
			]
		];

		$this->form_validation->set_rules($config);
		$nip = $this->input->post('old_nip');
		$email = $this->input->post('old_email');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('erroredit', validation_errors());
			$this->updateData($nip);
		} else {
			$data = $this->input->post();
			$newNip = $data['nip'];
			$newEmail = $data['email'];
			$newKodeJabatan = $data['kd_jabatan'];

			$currentNip = $nip;
			$currentEmail = $email;

			if ($newNip != $currentNip && !$this->M_kelolaData->isNipUnique($newNip)) {
				$this->session->set_flashdata('error', 'NIP sudah terdaftar.');
				$this->updateData($currentNip);
			}

			if ($newEmail != $currentEmail && !$this->M_kelolaData->isEmailUnique($newEmail)) {
				$this->session->set_flashdata('error', 'Email sudah terdaftar.');
				$this->updateData($currentNip);
			}

			$currentData = $this->M_kelolaData->readPegawai($currentNip);

			unset($data['old_email']);
			unset($data['old_nip']);

			$this->M_kelolaData->updatePegawai($currentNip, $data);

			if ($newKodeJabatan != $currentData['kd_jabatan']) {
				$riwayatData = [
					'nip' => $currentData['nip'],
					'kd_jabatan' => $currentData['kd_jabatan'],
					'nama_jabatan' => $currentData['nama_jabatan'],
					'tmt_bekerja' => $currentData['tmt_bekerja'],
					'tmt_berakhir' => $currentData['tmt_berakhir'],
					'status_pegawai' => $currentData['status_pegawai'],
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s')
				];

				$this->M_kelolaData->insertRiwayat($riwayatData);
			}

			$this->session->set_flashdata('successedit', 'Data berhasil diupdate!');
			redirect('dataPegawai');
		}
	}

	public function detailDataIndividu($nip)
	{
		$data = $this->M_kelolaData->readPegawai($nip);
		$this->loadPage('hrd/form_detailData.php', $data);
	}

	public function hapusData($nip)
	{
		$deleteStatus = $this->M_kelolaData->deletePegawai($nip);

		if ($deleteStatus) {
			$this->session->set_flashdata('success', 'Data berhasil dihapus!');
		} else {
			$this->session->set_flashdata('error', 'Data gagal dihapus!');
		}

		redirect('dataPegawai');
	}


	//Kelola Akun Pegawai
	public function tambahAkun($nip)
	{
		$pegawai = $this->M_kelolaData->readPegawai($nip);
		$data = [
			'nip' => $nip,
			'email' => $pegawai['email'],
		];

		$this->loadPage('hrd/form_tambahAkun.php', $data);
	}


	public function readAkunPegawai($nip)
	{
		$akun = $this->M_akunPegawai->readAkunPegawai($nip);

		$data = [
			'nip' => $akun['nip'],
			'email' => $akun['email'],
			'username' => $akun['username'],
			'password' => $akun['password'],
			'status_akun' => $akun['status_akun'],
		];

		$this->loadPage('hrd/form_updateAkun.php', $data);
	}


	public function cekAkun($nip)
	{
		$this->M_akunPegawai->cekAkun($nip);
		!empty($this->M_akunPegawai->cekAkun($nip)) ? $this->readAkunPegawai($nip) : $this->tambahAkun($nip,);
	}


	public function insertAkunPegawai()
	{

		$nip = $this->input->post('nip');
		$email = $this->input->post('email');

		$config = [
			[
				'field' => 'username',
				'label' => 'Username',
				'rules' => 'required|min_length[5]|max_length[20]|is_unique[akun.username]'
			],
			[
				'field' => 'password',
				'label' => 'Password',
				'rules' => 'required|min_length[6]|callback_password_check'
			],
			[
				'field' => 'status_akun',
				'label' => 'Status Akun',
				'rules' => 'required'
			]
		];

		$this->form_validation->set_rules($config);

		if ($this->form_validation->run() == FALSE) {
			$this->cekAkun($nip);
		} else {
			$data = array(
				'nip' => $this->input->post('nip'),
				'email' => $this->input->post('email'),
				'username' => $this->input->post('username'),
				'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
				'status_akun' => $this->input->post('status_akun')
			);
			if ($this->M_akunPegawai->insertAkunPegawai($data)) {
				$this->session->set_flashdata('successtambahAkun', 'Akun berhasil dibuat!');
				redirect('dataPegawai');
			} else {
				$this->session->set_flashdata('errortambahAkun', 'Gagal membuat akun, silakan coba lagi.');
				var_dump($data);
				die;
				$this->tambahAkun($data['nip']);
			}
		}
	}


	public function password_check($password)
	{
		// Cek huruf besar
		if (!preg_match('/[A-Z]/', $password)) {
			$this->form_validation->set_message('password_check', 'Password must contain at least one uppercase letter.');
			return FALSE;
		}

		// Cek huruf kecil
		if (!preg_match('/[a-z]/', $password)) {
			$this->form_validation->set_message('password_check', 'Password must contain at least one lowercase letter.');
			return FALSE;
		}

		// Cek angka
		if (!preg_match('/[0-9]/', $password)) {
			$this->form_validation->set_message('password_check', 'Password must contain at least one number.');
			return FALSE;
		}

		// Cek karakter khusus
		if (!preg_match('/[^A-Za-z0-9]/', $password)) {
			$this->form_validation->set_message('password_check', 'Password must contain at least one special character.');
			return FALSE;
		}

		return TRUE;
	}

	public function updateAkunPegawai()
	{
		// Mengambil data dari input form
		$nip = $this->input->post('nip');
		$email = $this->input->post('email');
		$old_username = $this->input->post('old_username');

		$username_rules = 'required|min_length[5]|max_length[20]';
		if ($old_username != $this->input->post('username')) {
			$username_rules .= '|is_unique[akun.username]';
		}


		$password_rules = '';
		if ($this->input->post('password') != '') {
			$password_rules .= 'min_length[6]|callback_password_check';
		}

		// Mengatur aturan validasi form
		$config = [
			[
				'field' => 'username',
				'label' => 'Username',
				'rules' => $username_rules,
			],
			[
				'field' => 'password',
				'label' => 'Password',
				'rules' => $password_rules,
			],
			[
				'field' => 'status_akun',
				'label' => 'Status Akun',
				'rules' => 'required'
			]
		];

		$this->form_validation->set_rules($config);

		// Jika validasi gagal
		if ($this->form_validation->run() == FALSE) {
			$this->readAkunPegawai($nip);
		} else {
			$data = array(
				'nip' => $this->input->post('nip'),
				'email' => $this->input->post('email'),
				'username' => $this->input->post('username'),
				'status_akun' => $this->input->post('status_akun')
			);

			$password = $this->input->post('password');
			if (!empty($password)) {
				$data['password'] = password_hash($password, PASSWORD_DEFAULT);
			}

			if ($this->M_akunPegawai->updateAkunPegawai($nip, $data)) {
				$this->session->set_flashdata('successeditAkun', 'Akun berhasil diperbarui!');
				redirect('dataPegawai');
			} else {
				$this->session->set_flashdata('erroreditAkun', 'Gagal memperbarui akun, silakan coba lagi.');
				$this->cekAkun($nip);
			}
		}
	}



	public function cekStatusAkunAjax($nip)
	{
		$akunExists = !empty($this->M_akunPegawai->cekAkun($nip));

		$response = [
			'statusAkun' => $akunExists ? 'update' : 'buat',
			'tombolText' => $akunExists ? 'Update Akun' : 'Buat Akun'
		];

		echo json_encode($response);
	}
}
