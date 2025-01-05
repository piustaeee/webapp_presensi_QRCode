<div class="container mt-5">
    <form id="jabatanForm" action="<?= base_url('Admin/Jabatan/updateJabatan') ?>" method="POST" class="mb-4">
        <div class="form-group">
            <label for="namaJabatan"> Nama Jabatan</label>
            <input type="text" class="form-control" name="namaJabatan" id="namaJabatan" value="<?= $data['nama_jabatan'] ?>" placeholder="Nama Jabatan">
            <?= form_error('namaJabatan', '<div class="text-danger">', '</div>'); ?>
        </div>
        <div class="form-group">
            <label for="uraianTugas">Uraian TUgas</label>
            <textarea class="form-control" id="uraianTugas" name="uraianTugas" value="<?= set_value('uraianTugas') ?>" placeholder="Uraian Tugas"></textarea>
            <?= form_error('uraianTugas', '<div class="text-danger">', '</div>'); ?>
        </div>
        <button type="submit" class="btn btn-primary" id="submitBtn">Tambah Jabatan</button>
    </form>
</div>