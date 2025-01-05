<head>
    <style>
        .container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        h1 {
            color: #2c3e50;
            text-align: center;
        }

        .category {
            margin-bottom: 20px;
            border: 1px solid #e0e0e0;
            border-radius: 5px;
            overflow: hidden;
        }

        .category-header {
            background-color: var(--primary);
            color: #fff;
            padding: 10px;
            font-weight: bold;
        }

        .category-content {
            padding: 15px;
            /* background-color: #ecf0f1; */
        }

        .data-row {
            display: flex;
            margin-bottom: 5px;
        }

        .data-label {
            flex: 1;
            font-weight: bold;
        }

        .data-value {
            flex: 2;
        }
    </style>
</head>

<div class="container">
    <h1>Data Detail Pegawai</h1>

    <div class="category">
        <div class="category-header">Informasi Pribadi</div>
        <div class="category-content">
            <div class="data-row">
                <div class="data-label">Nama:</div>
                <div class="data-value"><?= $nama ?></div>
            </div>
            <div class="data-row">
                <div class="data-label">Jenis Kelamin:</div>
                <div class="data-value"><?= $jk ?></div>
            </div>
            <div class="data-row">
                <div class="data-label">Tempat Lahir:</div>
                <div class="data-value"><?= $tempat_lahir ?></div>
            </div>
            <div class="data-row">
                <div class="data-label">Tanggal Lahir:</div>
                <div class="data-value"><?= $tanggal_lahir ?></div>
            </div>
            <div class="data-row">
                <div class="data-label">Agama:</div>
                <div class="data-value"><?= $agama ?></div>
            </div>
        </div>
    </div>

    <div class="category">
        <div class="category-header">Informasi Kontak</div>
        <div class="category-content">
            <div class="data-row">
                <div class="data-label">Alamat:</div>
                <div class="data-value"><?= $alamat ?></div>
            </div>
            <div class="data-row">
                <div class="data-label">Telepon:</div>
                <div class="data-value"><?= $telp ?></div>
            </div>
            <div class="data-row">
                <div class="data-label">Email:</div>
                <div class="data-value"><?= $email ?></div>
            </div>
        </div>
    </div>

    <div class="category">
        <div class="category-header">Informasi Kepegawaian</div>
        <div class="category-content">
            <div class="data-row">
                <div class="data-label">NIP:</div>
                <div class="data-value"><?= $nip ?></div>
            </div>
            <div class="data-row">
                <div class="data-label">NIK:</div>
                <div class="data-value"><?= $nik ?></div>
            </div>
            <div class="data-row">
                <div class="data-label">Status Pegawai:</div>
                <div class="data-value"><?php
                                        switch ($status_pegawai) {
                                            case (0):
                                                echo ('Tidak Aktif');
                                                break;
                                            case (1):
                                                echo ('Aktif');
                                                break;
                                        } ?></div>
            </div>
            <div class="data-row">
                <div class="data-label">Jabatan:</div>
                <div class="data-value"><?= $nama_jabatan ?></div>
            </div>
        </div>
    </div>

    <div class="category">
        <div class="category-header">Pendidikan dan Keluarga</div>
        <div class="category-content">
            <div class="data-row">
                <div class="data-label">Pendidikan Terakhir:</div>
                <div class="data-value"><?= $pendidikan_terakhir ?></div>
            </div>
            <div class="data-row">
                <div class="data-label">Jumlah Anak:</div>
                <div class="data-value"><?= $jumlah_anak ?></div>
            </div>
        </div>
    </div>

    <div class="category">
        <div class="category-header">Masa Kerja</div>
        <div class="category-content">
            <div class="data-row">
                <div class="data-label">TMT Bekerja:</div>
                <div class="data-value"><?= $tmt_bekerja ?></div>
            </div>
            <div class="data-row">
                <div class="data-label">TMT Berakhir:</div>
                <div class="data-value"><?= $tmt_berakhir ?></div>
            </div>
        </div>
    </div>
</div>