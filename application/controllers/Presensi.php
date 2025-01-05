<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Presensi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Admin/M_presensi');
        $this->load->model('Admin/M_kelolaData');
    }


    public function validateToken()
    {
        $token = $this->input->get('token', TRUE);
        if (!$token) {
            show_error('Token tidak ditemukan!', 400);
            return;
        }

        $query = $this->db->get_where('qr_tokens', ['token' => $token]);
        $data = $query->row();

        if (!$data) {
            show_error('Token tidak valid!', 400);
            return;
        }

        if ($data->is_used) {
            echo 'Token ini telah digunakan sebelumnya.';
        } else {
            $this->savePresensi($token);
        }
    }



    public function savePresensi($token)
    {
        $nip = $this->session->userdata('nip');
        $current_time = date('H:i:s');
        $current_date = date('Y-m-d');
        $current_month = (int) date('m');
        $current_year = (int) date('Y');
        $user_type = $this->session->userdata('type');
        $redirect_path = $user_type == '2' ? 'berandaAdmin' : 'berandaUser';
        $redirect_patherror = $user_type == '2' ? 'presensiAdmin' : 'presensiUser';

        // Check token validity
        $token_data = $this->db->get_where('qr_tokens', ['token' => $token])->row();
        if (!$token_data) {
            $this->load->view('errors/html/error_404');
            return;
        }

        // Validate presensi configuration
        $settings = $this->M_presensi->isActive();
        if (!$settings) {
            $this->session->set_flashdata('error', 'Presensi belum diatur.');
            redirect($redirect_patherror);
            return;
        }

        if ($settings['tahun_presensi'] != $current_year || $settings['bulan_presensi'] != $current_month) {
            $this->session->set_flashdata('error', 'Presensi bukan diatur untuk bulan ini.');
            redirect($redirect_patherror);
            return;
        }

        // Check workday
        $day_map = [
            'monday' => 'senin',
            'tuesday' => ' selasa',
            'wednesday' => ' rabu',
            'thursday' => ' kamis',
            'friday' => ' jumat',
            'saturday' => ' sabtu',
            'sunday' => ' minggu'
        ];
        $today = $day_map[strtolower(date('l'))];
        $workdays = explode(',', strtolower($settings['hari_kerja']));
        if (!in_array($today, $workdays)) {
            $this->session->set_flashdata('error', 'Hari ini bukan hari kerja.');
            redirect($redirect_patherror);
            return;
        }

        // Check holidays
        if (in_array($current_date, explode(',', $settings['tanggal_libur']))) {
            $this->session->set_flashdata('error', 'Hari ini libur.');
            redirect($redirect_patherror);
            return;
        }

        // Validate presensi time
        $early_time = date('H:i:s', strtotime($settings['jam_masuk']) - 3600); // 1 hour before start
        $late_time = date('H:i:s', strtotime($settings['jam_pulang']) + 18000); // 5 hours after end
        if ($current_time < $early_time || $current_time > $late_time) {
            $this->session->set_flashdata('error', "Presensi hanya diizinkan antara $early_time dan $late_time.");
            redirect($redirect_patherror);
            return;
        }

        // Existing presensi logic
        $existing = $this->M_presensi->getPresensiByDate($current_date, $nip);
        if ($existing) {
            $update_data = [];
            $break_start_min = date('H:i:s', strtotime($settings['jam_mulai_istirahat']) - 600); // 10 minutes before break start
            $break_start_max = date('H:i:s', strtotime($settings['jam_akhir_istirahat']) + 600); // 10 minutes after break start

            if ($current_time > $break_start_max) {
                // Jika waktu sudah melewati jam istirahat, langsung proses presensi jam pulang
                if (!$existing['jam_pulang']) {
                    $update_data['jam_pulang'] = $current_time;
                    $update_data['status_lembur'] = strtotime($current_time) > strtotime($settings['jam_pulang']) + 3600 ? '1' : '0';
                    $this->session->set_flashdata('success', 'Absensi Jam pulang berhasil.');
                    $this->autoAbsen();
                } else {
                    $this->session->set_flashdata('info', 'Presensi hari ini sudah selesai.');
                    redirect($redirect_path);
                    return;
                }
            } else {
                // Proses presensi jam istirahat
                if (!$existing['jam_mulai_istirahat']) {
                    if ($current_time >= $break_start_min && $current_time <= $break_start_max) {
                        $update_data['jam_mulai_istirahat'] = $current_time;
                        $this->session->set_flashdata('success', 'Absensi Jam mulai istirahat berhasil.');
                    } else {
                        $this->session->set_flashdata('error', 'Absensi jam mulai istirahat hanya diperbolehkan 10 menit sebelum atau setelah waktu istirahat.');
                        redirect($redirect_path);
                        return;
                    }
                } elseif (!$existing['jam_akhir_istirahat']) {
                    if ($current_time >= $break_start_min && $current_time <= $break_start_max) {
                        $update_data['jam_akhir_istirahat'] = $current_time;
                        $this->session->set_flashdata('success', 'Absensi Jam akhir istirahat berhasil.');
                    } else {
                        $this->session->set_flashdata('error', 'Absensi jam akhir istirahat hanya diperbolehkan 10 menit sebelum atau setelah waktu istirahat.');
                        redirect($redirect_path);
                        return;
                    }
                } else {
                    $this->session->set_flashdata('info', 'Belum waktunya Absensi Pulang.');
                    redirect($redirect_path);
                    return;
                }
            }


            $update_data['updated_at'] = date('Y-m-d H:i:s');
            $this->M_presensi->updatePresensi($existing['id_presensi'], $update_data);
            redirect($redirect_path);
            return;
        }

        // New presensi
        $late_tolerance = strtotime($settings['jam_masuk']) + $settings['durasi_telat'] * 60;
        $data_presensi = [
            'tanggal_presensi' => $current_date,
            'nip' => $nip,
            'jam_masuk' => $current_time,
            'status_telat' => strtotime($current_time) > $late_tolerance ? '1' : '0',
            'status_hadir' => 'H',
            'status_lembur' => '0',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->M_presensi->insertPresensi($data_presensi);
        $this->session->set_flashdata('success', 'Presensi masuk berhasil disimpan.');
        redirect($redirect_path);
        return;
    }

    public function autoAbsen()
    {
        $tanggal_presensi = date('Y-m-d');
        $current_time = date('H:i:s');


        $pengaturan = $this->M_presensi->isActive();
        $jam_pulang_pengaturan = $pengaturan['jam_pulang'];

        // Hanya jalankan jika waktu saat ini lebih dari jam pulang (untuk pastikan hanya jalankan setelah jam pulang)
        if (strtotime($current_time) > strtotime($jam_pulang_pengaturan)) {
            $all_pegawai = $this->M_kelolaData->tampilPegawai();

            // Iterasi semua pegawai
            foreach ($all_pegawai as $pegawai) {
                // Cek apakah pegawai sudah presensi untuk hari ini
                $existingPresensiForToday = $this->M_presensi->getPresensiByDate($tanggal_presensi, $pegawai['nip']);


                // Jika tidak ada presensi untuk pegawai ini pada hari ini, masukkan data absen
                if (!$existingPresensiForToday) {
                    $data_absen = [
                        'tanggal_presensi' => $tanggal_presensi,
                        'nip' => $pegawai['nip'],
                        'jam_masuk' => NULL,
                        'jam_pulang' => NULL,
                        'status_hadir' => 'A', // Absen
                        'jam_mulai_istirahat' => NULL,
                        'jam_akhir_istirahat' => NULL,
                        'status_telat' => '0',
                        'status_lembur' => '0',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];

                    // Masukkan data absen ke database
                    $this->M_presensi->insertPresensi($data_absen);
                }
            }
        }
    }
}
