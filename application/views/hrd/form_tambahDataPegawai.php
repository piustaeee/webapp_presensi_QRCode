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
        <h1>Kelola Data Pegawai</h1>
        <form id="inputPegawaiForm" method="post" action="<?= base_url('Admin/KelolaData/insert_pegawai') ?>">

            <!-- Data Pribadi -->
            <div class="section-title">Data Pribadi</div>
            <div class="form-grid">
                <div class="form-group">
                    <label for="nip">NIP<span style="color: red;">*</span></label>
                    <input type="text" id="nip" name="nip" value="<?= set_value('nip') ?>">
                    <?= form_error('nip', '<div class="text-danger">', '</div>'); ?>
                </div>
                <div class="form-group">
                    <label for="nik">NIK<span style="color: red;">*</span></label>
                    <input type="text" id="nik" name="nik" value="<?= set_value('nik') ?>">
                    <?= form_error('nik', '<div class="text-danger">', '</div>'); ?>
                </div>
                <div class="form-group">
                    <label for="nama">Nama<span style="color: red;">*</span></label>
                    <input type="text" id="nama" name="nama" value="<?= set_value('nama') ?>">
                    <?= form_error('nama', '<div class="text-danger">', '</div>'); ?>
                </div>
                <div class="form-group">
                    <label for="jk">Jenis Kelamin<span style="color: red;">*</span></label>
                    <select id="jk" name="jk">
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="L" <?= set_select('jk', 'L'); ?>>Laki-laki</option>
                        <option value="P" <?= set_select('jk', 'P'); ?>>Perempuan</option>
                    </select>
                    <?= form_error('jk', '<div class="text-danger">', '</div>'); ?>
                </div>
                <div class="form-group">
                    <label for="tempat_lahir">Tempat Lahir<span style="color: red;">*</span></label>
                    <input type="text" id="tempat_lahir" name="tempat_lahir" value="<?= set_value('tempat_lahir') ?>">
                    <?= form_error('tempat_lahir', '<div class="text-danger">', '</div>'); ?>
                </div>
                <div class="form-group">
                    <label for="tanggal_lahir">Tanggal Lahir<span style="color: red;">*</span></label>
                    <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="<?= set_value('tanggal_lahir') ?>">
                    <?= form_error('tanggal_lahir', '<div class="text-danger">', '</div>'); ?>
                </div>
            </div>

            <!-- Kontak -->
            <div class="section-title">Kontak</div>
            <div class="form-grid">
                <div class="form-group">
                    <label for="alamat">Alamat<span style="color: red;">*</span></label>
                    <textarea id="alamat" name="alamat"> <?= set_value('alamat') ?></textarea>
                    <?= form_error('alamat', '<div class="text-danger">', '</div>'); ?>
                </div>
                <div class="form-group">
                    <label for="telp">Telepon<span style="color: red;">*</span></label>
                    <input type="tel" id="telp" name="telp" value="<?= set_value('telp') ?>">
                    <?= form_error('telp', '<div class="text-danger">', '</div>'); ?>
                </div>
                <div class="form-group">
                    <label for="email">Email<span style="color: red;">*</span></label>
                    <input type="email" id="email" name="email" value="<?= set_value('email') ?>">
                    <?= form_error('email', '<div class="text-danger">', '</div>'); ?>
                </div>
            </div>

            <!-- Pendidikan & Agama -->
            <div class="section-title">Pendidikan & Agama</div>
            <div class="form-grid">
                <div class="form-group">
                    <label for="pendidikan_terakhir">Pendidikan Terakhir<span style="color: red;">*</span></label>
                    <select id="pendidikan_terakhir" name="pendidikan_terakhir" class="form-control">
                        <option value="">-- Pilih Pendidikan Terakhir --</option>
                        <option value="SD" <?= $pendidikan_terakhir == 'SD' ? 'selected' : '' ?>>SD</option>
                        <option value="SMP" <?= $pendidikan_terakhir == 'SMP' ? 'selected' : '' ?>>SMP</option>
                        <option value="SMA" <?= $pendidikan_terakhir == 'SMA' ? 'selected' : '' ?>>SMA</option>
                        <option value="Diploma" <?= $pendidikan_terakhir == 'Diploma' ? 'selected' : '' ?>>Diploma</option>
                        <option value="Sarjana" <?= $pendidikan_terakhir == 'Sarjana' ? 'selected' : '' ?>>Sarjana</option>
                        <option value="Magister" <?= $pendidikan_terakhir == 'Magister' ? 'selected' : '' ?>>Magister</option>
                        <option value="Doktor" <?= $pendidikan_terakhir == 'Doktor' ? 'selected' : '' ?>>Doktor</option>
                    </select>
                    <?= form_error('pendidikan_terakhir', '<div class="text-danger">', '</div>'); ?>
                </div>

                <div class="form-group">
                    <label for="agama">Agama<span style="color: red;">*</span></label>
                    <select id="agama" name="agama">
                        <option value="" disabled selected>Pilih Agama</option>
                        <option value="Islam" <?= set_select('agama', 'Islam') ?>>Islam</option>
                        <option value="Kristen" <?= set_select('agama', 'Kristen') ?>>Kristen</option>
                        <option value="Katolik" <?= set_select('agama', 'Katolik') ?>>Katolik</option>
                        <option value="Hindu" <?= set_select('agama', 'Hindu') ?>>Hindu</option>
                        <option value="Buddha" <?= set_select('agama', 'Buddha') ?>>Buddha</option>
                        <option value="Konghucu" <?= set_select('agama', 'Konghucu') ?>>Konghucu</option>
                    </select>
                    <?= form_error('agama', '<div class="text-danger">', '</div>'); ?>
                </div>
            </div>

            <!-- Data Keluarga -->
            <div class="section-title">Data Keluarga</div>
            <div class="form-group">
                <label for="jumlah_anak">Jumlah Anak<span style="color: red;">*</span></label>
                <input type="number" id="jumlah_anak" name="jumlah_anak" min="0" value="<?= set_value('jumlah_anak') ?>">
                <?= form_error('jumlah_anak', '<div class="text-danger">', '</div>'); ?>
            </div>

            <!-- Pekerjaan -->
            <div class="section-title">Pekerjaan</div>
            <div class="form-grid">
                <div class="form-group">
                    <label for="tmt_bekerja">TMT Bekerja<span style="color: red;">*</span></label>
                    <input type="date" id="tmt_bekerja" name="tmt_bekerja" value="<?= set_value('tmt_bekerja') ?>">
                    <?= form_error('tmt_bekerja', '<div class="text-danger">', '</div>'); ?>
                </div>
                <div class="form-group">
                    <label for="tmt_berakhir">TMT Berakhir<span style="color: red;">*</span></label>
                    <input type="date" id="tmt_berakhir" name="tmt_berakhir" value="<?= set_value('tmt_berakhir') ?>">
                    <?= form_error('tmt_berakhir', '<div class="text-danger">', '</div>'); ?>
                </div>
                <div class="form-group">
                    <label for="status_pegawai">Status Pegawai<span style="color: red;">*</span></label>
                    <select id="status_pegawai" name="status_pegawai">
                        <option value="1" <?= set_select('status_pegawai', '1'); ?>>Aktif</option>
                        <option value="0" <?= set_select('status_pegawai', '0'); ?>>Tidak Aktif</option>
                    </select>
                    <?= form_error('status_pegawai', '<div class="text-danger">', '</div>'); ?>
                </div>
                <div class="form-group">
                    <label for="kd_jabatan">Jabatan<span style="color: red;">*</span></label>
                    <select id="kd_jabatan" name="kd_jabatan">
                        <?php foreach ($jabatan as $row) : ?>
                            <option value="<?= $row['kd_jabatan'] ?>" <?= set_select('kd_jabatan', $row['kd_jabatan']) ?>>
                                <?= $row['nama_jabatan'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>


                    <?= form_error('kd_jabatan', '<div class="text-danger">', '</div>'); ?>
                </div>
            </div>

            <!-- Buttons -->
            <div class="button-group">
                <button type="button" class="secondary" onclick="window.history.back()">Batal</button>
                <button type="submit">Simpan Data</button>
            </div>
        </form>


    </div>
</body>

</html>