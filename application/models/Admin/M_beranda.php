<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_beranda extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }


    public function getDataPresensi()
    {
        $this->db->select('riwayatpresensi.*, pegawai.nama');
        $this->db->from('riwayatpresensi');
        $this->db->join('pegawai', 'pegawai.nip = riwayatpresensi.nip');
        $query = $this->db->get();
        return $query->result_array();
    }


    public function getSumPegawai()
    {
        return $this->db->count_all_results('pegawai');
    }

    public function getDataByStatus($tanggal, $status)
    {
        $this->db->where('tanggal_presensi', $tanggal);
        $this->db->where('status_hadir', $status);
        $this->db->from('riwayatpresensi');
        return $this->db->count_all_results();
    }

    public function getDataHadir($tanggal)
    {
        return $this->getDataByStatus($tanggal, 'H');
    }

    public function getDataIzin($tanggal)
    {
        return $this->getDataByStatus($tanggal, 'I');
    }

    public function getDataAlpa($tanggal)
    {
        return $this->getDataByStatus($tanggal, 'A');
    }


    public function getDataTepatWaktu()
    {
        $this->db->where('status_telat', '0');
        $this->db->from('riwayatpresensi');
        return $this->db->count_all_results();
    }


    public function getgrafik()
    {
        $this->db->select("MONTH(tanggal_presensi) as bulan, COUNT(tanggal_presensi) as jumlah_presensi");
        $this->db->from("riwayatpresensi");
        $this->db->where('YEAR(tanggal_presensi)', date('Y'));
        $this->db->group_by('MONTH(tanggal_presensi)');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getPresensiCurrentMonth()
    {
        $this->db->select('riwayatpresensi.nip, pegawai.nama, COUNT(*) as total_presensi');
        $this->db->from('riwayatpresensi');
        $this->db->join('pegawai', 'pegawai.nip = riwayatpresensi.nip', 'inner');
        $this->db->where('YEAR(tanggal_presensi)', date('Y'));
        $this->db->where('MONTH(tanggal_presensi)', date('m'));
        $this->db->where('riwayatpresensi.status_hadir', 'H');
        $this->db->where('riwayatpresensi.status_telat', '0');
        $this->db->group_by('nip');
        $this->db->order_by('total_presensi', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
}
