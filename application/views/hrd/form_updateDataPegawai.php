<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-color);
            background-color: var(--background-color);
            line-height: 1.6;
        }

        .container {
            max-width: 800px;
            margin: 2rem auto;
            background-color: #fff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: var(--secondary-color);
            text-align: center;
            margin-bottom: 2rem;
            font-size: 2rem;
        }

        .section-title {
            font-size: 1.25rem;
            color: var(--secondary-color);
            border-bottom: 2px solid var(--border-color);
            margin-bottom: 1rem;
            margin-top: 3rem;
            font-weight: bold;
            padding-bottom: 0.5rem;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        label {
            display: block;
            font-weight: 600;
            color: var(--secondary-color);
            margin-bottom: 0.25rem;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(74, 144, 226, 0.2);
        }

        .button-group {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 2rem;
        }

        button {
            padding: 0.75rem 1.5rem;
            background-color: var(--primary-color);
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #3a7bc8;
        }

        button.secondary {
            background-color: var(--secondary-color);
        }

        button.secondary:hover {
            background-color: #34495e;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Update Data Pegawai</h1>
        <form id="inputPegawaiForm" method="post" action="<?= base_url('updateDataPegawai') ?>">

            <input type="hidden" name="old_nip" value="<?= $nip ?>">
            <input type="hidden" name="old_email" value="<?= $email ?>">

            <!-- Data Pribadi -->
            <div class="section-title">Data Pribadi</div>
            <div class="form-grid">
                <div class="form-group">
                    <label for="nip">NIP</label>
                    <input type="text" id="nip" name="nip" value="<?= $nip ?>">
                    <?= form_error('nip', '<div class="text-danger">', '</div>'); ?>
                </div>
                <div class="form-group">
                    <label for="nik">NIK</label>
                    <input type="text" id="nik" name="nik" value="<?= $nik ?>">
                    <?= form_error('nik', '<div class="text-danger">', '</div>'); ?>
                </div>
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" id="nama" name="nama" value="<?= $nama ?>">
                    <?= form_error('nama', '<div class="text-danger">', '</div>'); ?>
                </div>
                <div class="form-group">
                    <label for="jk">Jenis Kelamin</label>
                    <select id="jk" name="jk">
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="L" <?= ($jk == 'L') ? 'selected' : ''; ?>>Laki-laki</option>
                        <option value="P" <?= ($jk == 'P') ? 'selected' : ''; ?>>Perempuan</option>
                    </select>
                    <?= form_error('jk', '<div class="text-danger">', '</div>'); ?>
                </div>
                <div class="form-group">
                    <label for="tempat_lahir">Tempat Lahir</label>
                    <input type="text" id="tempat_lahir" name="tempat_lahir" value="<?= $tempat_lahir ?>">
                    <?= form_error('tempat_lahir', '<div class="text-danger">', '</div>'); ?>
                </div>
                <div class="form-group">
                    <label for="tanggal_lahir">Tanggal Lahir</label>
                    <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="<?= $tanggal_lahir ?>">
                    <?= form_error('tanggal_lahir', '<div class="text-danger">', '</div>'); ?>
                </div>
            </div>

            <!-- Kontak -->
            <div class="section-title">Kontak</div>
            <div class="form-grid">
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea id="alamat" name="alamat"><?= $alamat ?></textarea>
                    <?= form_error('alamat', '<div class="text-danger">', '</div>'); ?>
                </div>
                <div class="form-group">
                    <label for="telp">Telepon</label>
                    <input type="tel" id="telp" name="telp" value="<?= $telp ?>">
                    <?= form_error('telp', '<div class="text-danger">', '</div>'); ?>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?= $email ?>">
                    <?= form_error('email', '<div class="text-danger">', '</div>'); ?>
                </div>
            </div>





            <!-- Pendidikan & Agama -->
            <div class="section-title">Pendidikan & Agama</div>
            <div class="form-grid">
                <div class="form-group">
                    <label for="pendidikan_terakhir">Pendidikan Terakhir</label>
                    <input type="text" id="pendidikan_terakhir" name="pendidikan_terakhir" value="<?= $pendidikan_terakhir ?>">
                    <?= form_error('pendidikan_terakhir', '<div class="text-danger">', '</div>'); ?>
                </div>
                <div class="form-group">
                    <label for="agama">Agama</label>
                    <select id="agama" name="agama">
                        <option value="" disabled selected>Pilih Agama</option>
                        <option value="Islam" <?= ($agama == 'Islam') ? 'selected' : ''; ?>>Islam</option>
                        <option value="Kristen" <?= ($agama == 'Kristen') ? 'selected' : ''; ?>>Kristen</option>
                        <option value="Katolik" <?= ($agama == 'Katolik') ? 'selected' : ''; ?>>Katolik</option>
                        <option value="Hindu" <?= ($agama == 'Hindu') ? 'selected' : ''; ?>>Hindu</option>
                        <option value="Buddha" <?= ($agama == 'Buddha') ? 'selected' : ''; ?>>Buddha</option>
                        <option value="Konghucu" <?= ($agama == 'Konghucu') ? 'selected' : ''; ?>>Konghucu</option>
                    </select>
                    <?= form_error('agama', '<div class="text-danger">', '</div>'); ?>
                </div>
            </div>

            <!-- Data Keluarga -->
            <div class="section-title">Data Keluarga</div>
            <div class="form-group">
                <label for="jumlah_anak">Jumlah Anak</label>
                <input type="number" id="jumlah_anak" name="jumlah_anak" min="0" value="<?= $jumlah_anak ?>">
                <?= form_error('jumlah_anak', '<div class="text-danger">', '</div>'); ?>
            </div>

            <!-- Pekerjaan -->
            <div class="section-title">Pekerjaan</div>
            <div class="form-grid">
                <div class="form-group">
                    <label for="tmt_bekerja">TMT Bekerja</label>
                    <input type="date" id="tmt_bekerja" name="tmt_bekerja" value="<?= $tmt_bekerja ?>">
                    <?= form_error('tmt_bekerja', '<div class="text-danger">', '</div>'); ?>
                </div>
                <div class="form-group">
                    <label for="tmt_berakhir">TMT Berakhir</label>
                    <input type="date" id="tmt_berakhir" name="tmt_berakhir" value="<?= $tmt_berakhir ?>">
                    <?= form_error('tmt_berakhir', '<div class="text-danger">', '</div>'); ?>
                </div>
                <div class="form-group">
                    <label for="status_pegawai">Status Pegawai</label>
                    <select id="status_pegawai" name="status_pegawai" required>
                        <option value="1" <?= ($status_pegawai == '1') ? 'selected' : ''; ?>>Aktif</option>
                        <option value="0" <?= ($status_pegawai == '0') ? 'selected' : ''; ?>>Tidak Aktif</option>
                    </select>
                    <?= form_error('status_pegawai', '<div class="text-danger">', '</div>'); ?>
                </div>
                <div class="form-group">
                    <label for="kd_jabatan">Kode Jabatan</label>
                    <select id="kd_jabatan" name="kd_jabatan">
                        <?php foreach ($jabatan as $row) : ?>
                            <option value="<?= $row['kd_jabatan'] ?>" <?= ($kd_jabatan == $row['kd_jabatan']) ? 'selected' : ''; ?>>
                                <?= $row['nama_jabatan'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <?= form_error('kd_jabatan', '<div class="text-danger">', '</div>'); ?>
                </div>
            </div>

            <!-- Buttons -->
            <div class="button-group">
                <a href="<?= base_url('dataPegawai') ?>"><button type="button" class="secondary">Batal</button></a>
                <button type="submit">Simpan Data</button>
            </div>
        </form>
    </div>
</body>

</html>