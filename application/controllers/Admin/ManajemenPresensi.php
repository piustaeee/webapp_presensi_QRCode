<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ManajemenPresensi extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->check_role('2');
		$this->load->model('Admin/M_rekapitulasi');
	}

	public function rekapitulasi()
	{
		$this->loadPage('hrd/form_rekapitulasi.php');
	}

	public function isAjax()
	{
		$data = $this->M_rekapitulasi->getAllKaryawan();
		echo json_encode($data);
	}

	public function isAjaxRekap()
	{
		$dataRekap = $this->M_rekapitulasi->getAllKaryawanRekap();
		echo json_encode($dataRekap);
	}


	public function updateStatusAjax()
	{
		$data = json_decode($this->input->raw_input_stream, true);

		$nip = $data['nip'];
		$status_hadir = $data['status_hadir'];
		$tanggal = date('Y-m-d');

		// Check if nip and status_hadir are provided
		if (empty($nip) || empty($status_hadir)) {
			echo json_encode(['success' => false, 'message' => 'NIP or status is empty']);
			return;
		}

		// Check if the record exists for the given nip and date
		$existingRecord = $this->M_rekapitulasi->getRecordByNipAndDate($nip, $tanggal);

		if ($existingRecord) {
			// If record exists, update the status
			$updateSuccess = $this->M_rekapitulasi->updateKaryawanStatus($nip, $status_hadir, $tanggal);
			if ($updateSuccess) {
				echo json_encode(['success' => true, 'message' => 'Status updated successfully']);
			} else {
				echo json_encode(['success' => false, 'message' => 'Failed to update status']);
			}
		} else {
			// If record does not exist, insert a new record
			$insertSuccess = $this->M_rekapitulasi->insertKaryawanStatus($nip, $status_hadir, $tanggal);
			if ($insertSuccess) {
				echo json_encode(['success' => true, 'message' => 'Status added successfully']);
			} else {
				echo json_encode(['success' => false, 'message' => 'Failed to add status']);
			}
		}
	}
}
