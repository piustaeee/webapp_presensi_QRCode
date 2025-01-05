<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_evaluasiDiri extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }


    public function grafikPresensi($nip)
    {
        $this->db->select("MONTH(tanggal_presensi) as bulan, COUNT(tanggal_presensi) as jumlah_presensi");
        $this->db->from("riwayatpresensi");
        $this->db->where('YEAR(tanggal_presensi)', date('Y'));
        $this->db->where('nip', $nip);
        $this->db->group_by('MONTH(tanggal_presensi)');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getAll($nip)
    {
        $this->db->where('nip', $nip);
        $this->db->where('MONTH(tanggal_presensi)', date('m'));
        $this->db->where('YEAR(tanggal_presensi)', date('Y'));
        $this->db->from('riwayatpresensi');
        return $this->db->count_all_results();
    }

    public function getDataByStatus($nip, $status)
    {
        $this->db->where('status_hadir', $status);
        $this->db->where('nip', $nip);
        $this->db->where('MONTH(tanggal_presensi)', date('m'));
        $this->db->where('YEAR(tanggal_presensi)', date('Y'));
        $this->db->from('riwayatpresensi');
        return $this->db->count_all_results(); 
    }

    public function getDataHadir($nip)
    {
        return $this->getDataByStatus($nip, 'H');
    }

    public function getDataIzin($nip)
    {
        return $this->getDataByStatus($nip, 'I');
    }

    public function getDataAlpa($nip)
    {
        return $this->getDataByStatus($nip, 'A');
    }


    public function getDataTepatWaktu($nip)
    {
        $this->db->where('status_telat', '0');
        $this->db->where('nip', $nip);
        $this->db->where('MONTH(tanggal_presensi)', date('m'));
        $this->db->where('YEAR(tanggal_presensi)', date('Y'));
        $this->db->from('riwayatpresensi');
        return $this->db->count_all_results();
    }

    public function getDataTerlambat($nip)
    {
        $this->db->where('status_telat', '1');
        $this->db->where('nip', $nip);
        $this->db->where('MONTH(tanggal_presensi)', date('m'));
        $this->db->where('YEAR(tanggal_presensi)', date('Y'));
        $this->db->from('riwayatpresensi');
        return $this->db->count_all_results();
    }

    public function getDataByTahunAndBulan($nip, $tahun, $bulan)
    {
        $this->db->where('nip', $nip);
        $this->db->where('YEAR(tanggal_presensi)', $tahun);
        $this->db->where('MONTH(tanggal_presensi)', $bulan);
        $this->db->from('riwayatpresensi');
        return $this->db->get()->result_array();
    }
}
