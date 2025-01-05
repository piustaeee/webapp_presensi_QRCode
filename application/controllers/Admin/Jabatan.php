<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jabatan extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Admin/M_jabatan');
        $this->check_role('2');
    }

    public function tampilJabatan()
    {
        $data['jabatan'] = $this->M_jabatan->tampilJabatan();
        $data['riwayat_jabatan'] = $this->M_jabatan->getRiwayatJabatan();
        
        $this->loadPage('hrd/form_jabatan.php', $data);
    }

    public function insertJabatan()
    {
        $config = [
            [
                'field' => 'namaJabatan',
                'label' => 'namaJabatan',
                'rules' => 'required|is_unique[jabatan.nama_jabatan]'
            ],
            [
                'field' => 'uraianTugas',
                'label' => 'uraianTugas',
                'rules' => 'required'
            ],
        ];

        $namaJabatan = $this->input->post('namaJabatan');
        $query = $this->db->get_where('jabatan', ['nama_jabatan' => $namaJabatan]);

        if ($query->num_rows() > 0) {
            $this->session->set_flashdata('erroreditjabatan', 'Nama Jabatan sudah ada, harap masukan nama jabatan lain!');
            redirect('dataJabatan');
            return;
        }

        $this->form_validation->set_rules($config);

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('errortambahjabatan', validation_errors());
            redirect('dataJabatan');
        } else {
            $data = [
                'nama_Jabatan' => $this->input->post('namaJabatan'),
                'uraian_Tugas' => $this->input->post('uraianTugas'),
            ];
            $this->M_jabatan->insertJabatan($data);
            $this->session->set_flashdata('successtambahjabatan', 'Jabatan berhasil disimpan!');
            redirect('dataJabatan');
        }
    }

    public function updateJabatan()
    {
        $kdJabatan = $this->input->post('kd_jabatan');
        $namaJabatanBaru = $this->input->post('namaJabatan');

        $jabatanLama = $this->db->get_where('jabatan', ['kd_jabatan' => $kdJabatan])->row_array();

        $query = $this->db->get_where('jabatan', [
            'nama_jabatan' => $namaJabatanBaru,
            'kd_jabatan !=' => $kdJabatan
        ]);

        if ($query->num_rows() > 0) {
            $this->session->set_flashdata('erroreditjabatan', 'Nama Jabatan sudah ada, harap masukan nama jabatan lain!');
            redirect('dataJabatan');
            return;
        }

        $config = [
            [
                'field' => 'namaJabatan',
                'label' => 'Nama Jabatan',
                'rules' => 'required',
            ],
            [
                'field' => 'uraianTugas',
                'label' => 'Uraian Tugas',
                'rules' => 'required'
            ],
        ];

        $this->form_validation->set_rules($config);

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('erroreditjabatan', validation_errors());
            $this->tampilJabatan();
        } else {
            $data = [
                'kd_jabatan' => $kdJabatan,
                'nama_jabatan' => $namaJabatanBaru,
                'uraian_tugas' => $this->input->post('uraianTugas'),
            ];
            $this->M_jabatan->updateJabatan($data);
            $this->session->set_flashdata('successeditjabatan', 'Jabatan berhasil diperbarui!');
            $this->tampilJabatan();
        }
    }

    public function deleteJabatan($kdJabatan)
    {
        $delete = $this->M_jabatan->deleteJabatan($kdJabatan);
        if ($delete) {
            $this->session->set_flashdata('successhapusjabatan', 'Jabatan berhasil dihapus!');
        } else {
            $this->session->set_flashdata('errorhapusjabatan', 'Gagal menghapus jabatan!');
        }
        redirect('dataJabatan');
    }
}
