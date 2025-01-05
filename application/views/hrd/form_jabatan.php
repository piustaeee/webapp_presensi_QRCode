<div class="container mt-5">
    <button class="btn btn-primary" data-toggle="modal" data-target="#jabatanModal" id="addJabatanBtn">Tambah Jabatan</button>

    <table class="table table-striped mt-3" id="jabatanTable">
        <thead class="thead-dark">
            <tr>
                <th>Nama Jabatan</th>
                <th>Uraian Tugas</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($jabatan as $row): ?>
                <tr>
                    <td><?= $row['nama_jabatan'] ?></td>
                    <td><?= $row['uraian_tugas'] ?></td>
                    <td>
                        <button class="btn btn-sm btn-warning mr-2 editJabatanBtn" data-kd="<?= $row['kd_jabatan'] ?>" data-nama="<?= $row['nama_jabatan'] ?>" data-uraian="<?= $row['uraian_tugas'] ?>" data-toggle="modal" data-target="#jabatanModal">Edit</button>

                        <button class="btn btn-sm btn-danger"
                            onclick="confirmDelete('<?= base_url("Admin/Jabatan/deleteJabatan/" . urlencode($row['kd_jabatan'])) ?>')">Delete</button>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<div class="container">
    <!-- Tabel Riwayat Jabatan -->
    <h3 class="mt-5">Riwayat Jabatan</h3>
    <div class="row mt-4">
        <div class="col-md-3">
            <input type="text" id="filterNip" class="form-control" placeholder="Masukkan NIP...">
        </div>
    </div>
    <table class="table table-striped mt-3" id="riwayatJabatanTable">
        <thead class="thead-dark">
            <tr>
                <th>NIP</th>
                <th>Nama Pegawai</th>
                <th>Nama Jabatan</th>
                <th>TMT Bekerja</th>
                <th>TMT Berakhir</th>
                <th>Status Pegawai</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($riwayat_jabatan as $row): ?>
                <tr>
                    <td><?= $row['nip'] ?></td>
                    <td><?= $row['nama_pegawai'] ?></td>
                    <td><?= $row['nama_jabatan'] ?></td>
                    <td><?= $row['tmt_bekerja'] ?></td>
                    <td><?= $row['tmt_berakhir'] ?></td>
                    <td><?= $row['status_pegawai'] ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<!-- Modal Tambah/Edit Jabatan -->
<div class="modal fade" id="jabatanModal" tabindex="-1" aria-labelledby="jabatanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="" method="POST" id="jabatanForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="jabatanModalLabel">Tambah Jabatan</h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="kd_jabatan" id="kd_jabatan">

                    <div class="form-group">
                        <label for="namaJabatan">Nama Jabatan</label>
                        <input type="text" class="form-control" name="namaJabatan" id="namaJabatan" value="<?= set_value('namaJabatan') ?>" placeholder="Nama Jabatan" required>
                        <?= form_error('namaJabatan', '<div class="text-danger">', '</div>'); ?>
                    </div>

                    <div class="form-group">
                        <label for="uraianTugas">Uraian Tugas</label>
                        <textarea class="form-control" name="uraianTugas" id="uraianTugas" placeholder="Uraian Tugas" required><?= set_value('uraianTugas') ?></textarea>
                        <?= form_error('uraianTugas', '<div class="text-danger">', '</div>'); ?>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cancelBtn">Batal</button>
                    <button type="submit" class="btn btn-primary" id="submitBtn">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    document.getElementById('filterNip').addEventListener('keyup', function() {
        let filterValue = this.value.toLowerCase();
        let rows = document.querySelectorAll('#riwayatJabatanTable tbody tr');

        rows.forEach(row => {
            let nip = row.cells[0].textContent.toLowerCase();
            if (nip.includes(filterValue)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        // Saat tombol tambah jabatan diklik
        $('#addJabatanBtn').click(function() {
            $('#jabatanModalLabel').text('Tambah Jabatan');
            $('#jabatanForm').attr('action', '<?= base_url('Admin/Jabatan/insertJabatan') ?>');
            $('#namaJabatan').val('');
            $('#uraianTugas').val('');
        });

        // Saat tombol edit jabatan diklik
        $('.editJabatanBtn').click(function() {
            const namaJabatan = $(this).data('nama');
            const uraianTugas = $(this).data('uraian');
            const kd_jabatan = $(this).data('kd');

            $('#jabatanModalLabel').text('Edit Jabatan');
            $('#jabatanForm').attr('action', '<?= base_url('Admin/Jabatan/updateJabatan') ?>');
            $('#namaJabatan').val(namaJabatan);
            $('#uraianTugas').val(uraianTugas);
            $('#kd_jabatan').val(kd_jabatan);
        });
    });


    function confirmDelete(deleteUrl) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = deleteUrl;

            }
        });
    }

    // SweetAlert untuk pesan tambah 
    <?php if ($this->session->flashdata('errortambahjabatan')): ?>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            html: '<?= $this->session->flashdata('errortambahjabatan') ?>',
        });
    <?php endif; ?>

    <?php if ($this->session->flashdata('successtambahjabatan')): ?>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '<?= $this->session->flashdata('successtambahjabatan') ?>',
            showConfirmButton: false,
            timer: 2000
        });
    <?php endif; ?>



    // SweetAlert untuk pesan edit 
    <?php if ($this->session->flashdata('erroreditjabatan')): ?>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '<?= $this->session->flashdata('erroreditjabatan') ?>',
        });
    <?php endif; ?>

    <?php if ($this->session->flashdata('successeditjabatan')): ?>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '<?= $this->session->flashdata('successeditjabatan') ?>',
            showConfirmButton: false,
            timer: 2000
        });
    <?php endif; ?>

    // SweetAlert untuk pesan hapus
    <?php if ($this->session->flashdata('successhapusjabatan')): ?>
        Swal.fire({
            icon: 'success',
            title: 'Sukses!',
            text: '<?= $this->session->flashdata('successhapusjabatan') ?>'
        });
    <?php endif; ?>

    <?php if ($this->session->flashdata('errorhapusjabatan')): ?>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '<?= $this->session->flashdata('errorhapusjabatan') ?>'
        });
    <?php endif; ?>
</script>