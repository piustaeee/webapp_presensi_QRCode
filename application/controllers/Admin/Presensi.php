<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Presensi extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Admin/M_presensi');
        $this->load->model('Admin/M_kelolaData');
        $this->load->model('Admin/M_pengaturanPresensi');

        $this->check_role('2');
    }


    public function savePresensi()
    {
        $nip = $this->session->userdata('nip');
        $tanggal_presensi = date('Y-m-d');
        $current_time = date('H:i:s');
        $current_month = (int) date('m');
        $current_year = (int) date('Y');

        $pengaturan = $this->M_presensi->isActive();



        if (!$pengaturan) {
            $this->session->set_flashdata('error', 'Presensi Belum di Atur');
            redirect('presensiAdmin');
        }

        if ($pengaturan['tahun_presensi'] != $current_year || $pengaturan['bulan_presensi'] != $current_month) {
            $this->session->set_flashdata('error', 'Presensi tidak dibuka untuk bulan ini');
            redirect('presensiAdmin');
        }

        $hari_ini = strtolower(date('l'));

        $days_in_indonesian = [
            'monday'    => 'senin',
            'tuesday'   => 'selasa',
            'wednesday' => 'rabu',
            'thursday'  => 'kamis',
            'friday'    => 'jumat',
            'saturday'  => 'sabtu',
            'sunday'    => 'minggu'
        ];

        $hari_ini = $days_in_indonesian[$hari_ini];
        $hari_kerja = explode(',', strtolower($pengaturan['hari_kerja']));
        // var_dump($hari_ini);
        // var_dump($hari_kerja);
        // die;
        if (!in_array($hari_ini, $hari_kerja)) {
            $this->session->set_flashdata('error', 'Hari Ini Bukan Hari Kerja');
            redirect('presensiAdmin');
        }

        $tanggal_libur = explode(',', $pengaturan['tanggal_libur']);
        if (in_array($tanggal_presensi, $tanggal_libur)) {
            $this->session->set_flashdata('error', 'Hari Ini Libur');
            redirect('presensiAdmin');
        }

        $existingPresensi = $this->M_presensi->getPresensiByDate($tanggal_presensi, $nip);
        // var_dump($existingPresensi);die;

        // var_dump(date('H:i:s'));die;

        if ($existingPresensi) {
            if (!$existingPresensi['jam_mulai_istirahat']) {
                $this->M_presensi->updatePresensi($existingPresensi['id_presensi'], [
                    'jam_mulai_istirahat' => $current_time,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            } elseif (!$existingPresensi['jam_akhir_istirahat']) {
                $this->M_presensi->updatePresensi($existingPresensi['id_presensi'], [
                    'jam_akhir_istirahat' => $current_time,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            } elseif (!$existingPresensi['jam_pulang']) {
                $this->M_presensi->updatePresensi($existingPresensi['id_presensi'], [
                    'jam_pulang' => $current_time,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            } else {
                $this->session->set_flashdata('info', 'Attendance already complete for today.');
                redirect('presensiAdmin');
            }
        } else {
            $jam_masuk_pengaturan = $pengaturan['jam_masuk'];
            $durasi_telat = $pengaturan['durasi_telat'] * 60;
            $batas_telat = date('H:i:s', strtotime($jam_masuk_pengaturan) + $durasi_telat);

            $status_telat = (strtotime($current_time) > strtotime($batas_telat)) ? '1' : '0';

            $data_presensi = [
                'tanggal_presensi' => $tanggal_presensi,
                'nip' => $nip,
                'jam_masuk' => $current_time,
                'jam_pulang' => NULL,
                'status_hadir' => 'H',
                'jam_mulai_istirahat' => NULL,
                'jam_akhir_istirahat' => NULL,
                'status_telat' => $status_telat,
                'status_lembur' => '0',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $this->M_presensi->insertPresensi($data_presensi);
        }

        $this->session->set_flashdata('success', 'Presensi Disimpan');
        redirect('presensiAdmin');
    }




    public function markAlpaForNoCheckout()
    {
        $yesterday = date('Y-m-d', strtotime('-1 day'));
        $pendingPresensi = $this->M_presensi->getPendingCheckoutRecords($yesterday);

        foreach ($pendingPresensi as $record) {
            $this->M_presensi->updatePresensi($record['id_presensi'], [
                'status_hadir' => 'A',
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
}
