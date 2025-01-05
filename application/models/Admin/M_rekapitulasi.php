<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_rekapitulasi extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAllKaryawan()
    {
        $this->db->select('pegawai.nip,pegawai.nama,jabatan.nama_jabatan,COALESCE(riwayatpresensi.status_hadir, "Belum Presensi") as status_hadir
    ');
        $this->db->from('pegawai');
        $this->db->join('riwayatpresensi', 'pegawai.nip = riwayatpresensi.nip AND DATE(riwayatpresensi.tanggal_presensi) = "' . date('Y-m-d') . '"', 'left');
        $this->db->join('jabatan', 'pegawai.kd_jabatan = jabatan.kd_jabatan', 'left');
        return $this->db->get()->result_array();
    }

    public function getAllKaryawanRekap()
    {
        $this->db->select('pegawai.nama,jabatan.nama_jabatan,riwayatpresensi.*,');
        $this->db->from('riwayatpresensi');
        $this->db->join('pegawai', 'pegawai.nip = riwayatpresensi.nip', 'left');
        $this->db->join('jabatan', 'pegawai.kd_jabatan = jabatan.kd_jabatan', 'left');
        $this->db->order_by('riwayatpresensi.tanggal_presensi', 'ASC');
        return $this->db->get()->result_array();
    }

    public function getRecordByNipAndDate($nip, $tanggal)
    {
        $this->db->where('nip', $nip);
        $this->db->where('DATE(tanggal_presensi)', $tanggal);
        return $this->db->get('riwayatpresensi')->row_array();
    }

    public function updateKaryawanStatus($nip, $status_hadir, $tanggal)
    {
        $data = [
            'status_hadir' => $status_hadir
        ];
        $this->db->where('nip', $nip);
        $this->db->where('DATE(tanggal_presensi)', $tanggal);
        return $this->db->update('riwayatpresensi', $data);
    }

    public function insertKaryawanStatus($nip, $status_hadir, $tanggal)
    {
        $data = [
            'nip' => $nip,
            'status_hadir' => $status_hadir,
            'tanggal_presensi' => $tanggal
        ];
        return $this->db->insert('riwayatpresensi', $data);
    }
}
