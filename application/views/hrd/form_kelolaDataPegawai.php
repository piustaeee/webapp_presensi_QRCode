<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        body {
            line-height: 1.6;
            color: var(--text-color);
            background-color: var(--background-color);
        }

        .container {
            max-width: 1200px;
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
            font-size: 2.5rem;
        }

        .search-container {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .search-container input {
            flex: 1;
            padding: 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            font-size: 1rem;
        }

        .search-container button {
            padding: 0.75rem 1.5rem;
            background-color: var(--primary-color);
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .search-container button:hover {
            background-color: #3a7bc8;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2rem;
        }

        th,
        td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }

        th {
            background-color: var(--secondary-color);
            color: #fff;
            font-weight: 600;
        }

        tr:nth-child(even) {
            background-color: var(--background-color);
        }

        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
        }

        .action-buttons button {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            font-size: 0.9rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .detail-btn a,
        .edit-btn a,
        .delete-btn a,
        .buatAkun-btn a {
            color: #fff;
            text-decoration: none !important;
        }

        .detail-btn {
            background-color: var(--blue);
            color: #fff;
        }

        .detail-btn:hover {
            background-color: #8faabc;
        }

        .edit-btn {
            background-color: var(--yellow);
            color: #fff;
        }

        .edit-btn:hover {
            background-color: #f4e04d;
        }

        .delete-btn {
            background-color: var(--red);
            color: #fff;
        }

        .delete-btn:hover {
            background-color: #f08080;
        }

        .buatAkun-btn {
            background-color: var(--green);
            color: #fff;
        }

        .buatAkun-btn:hover {
            background-color: #a0d6a0;
        }

        .add-employee-btn {
            display: block;
            width: 100%;
            padding: 1rem;
            background-color: var(--green-color);
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-align: center;
        }

        .add-employee-btn:hover {
            background-color: #219653;
        }

        @media (max-width: 768px) {

            .container {
                padding: 1rem;
            }

            .search-container {
                flex-direction: column;
            }

            table,
            thead,
            tbody,
            th,
            td,
            tr {
                display: block;
            }

            thead tr {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }

            tr {
                margin-bottom: 1rem;
                border: 1px solid var(--border-color);
            }

            td {
                border: none;
                position: relative;
                padding-left: 50%;
            }

            td:before {
                content: attr(data-label);
                position: absolute;
                left: 6px;
                width: 45%;
                padding-right: 10px;
                white-space: nowrap;
                font-weight: bold;
            }

            .action-buttons {
                flex-direction: column;
            }

            .action-buttons button {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Daftar Pegawai</h1>
        <div class="search-container">
            <input type="text" id="search-nip" placeholder="Cari berdasarkan NIP">
            <input type="text" id="search-name" placeholder="Cari berdasarkan nama">
            <button id="reset-btn">Reset</button>
        </div>
        <table id="pegawai-table" class="text-center">
            <thead>
                <tr>
                    <th>NIP</th>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pegawai as $row): ?>
                    <tr>
                        <td data-label="NIP"><?= $row['nip'] ?></td>
                        <td data-label="Nama"><?= $row['nama'] ?></td>
                        <td><?= $row['nama_jabatan'] ?></td>
                        <td data-label="Status"><?php
                                                switch ($row['status_pegawai']) {
                                                    case (0):
                                                        echo ('Tidak Aktif');
                                                        break;
                                                    case (1):
                                                        echo ('Aktif');
                                                        break;
                                                }
                                                ?></td>
                        <td data-label="Aksi">
                            <div class="action-buttons">
                                <?php $nip = $row['nip'] ?>
                                <a href="<?= site_url("detailDataIndividu/$nip") ?>"> <button class="detail-btn">Detail</button></a>
                                <a href="<?= base_url("updateData/$nip") ?>"><button class="edit-btn">Edit</button></a>
                                <!-- <a href="<?= base_url("hapusData/$nip") ?>"><button class="delete-btn">Hapus</button></a> -->
                                <button class="delete-btn" onclick="confirmDelete('<?= base_url("hapusData/$nip") ?>')">Hapus</button>

                                <!-- <a href="<?= base_url("Admin/KelolaData/cekAkun/$nip") ?>"> <button class="buatAkun-btn"><?= $tombolText ?></button></a> -->
                                <a href="<?= base_url("Admin/KelolaData/cekAkun/$nip") ?>" class="akun-link" data-nip="<?= $row['nip'] ?>">
                                    <button id="akunBtn-<?= $row['nip'] ?>" class="buatAkun-btn">Loading...</button>
                                </a>

                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a style="text-decoration: none;" href="<?php echo base_url('tambahData') ?>">
            <button class="add-employee-btn">Tambah Pegawai Baru</button>
        </a>
    </div>


    <script>
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

        // SweetAlert untuk pesan hapus
        <?php if ($this->session->flashdata('success')): ?>
            Swal.fire({
                icon: 'success',
                title: 'Sukses!',
                text: '<?= $this->session->flashdata('success') ?>'
            });
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')): ?>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '<?= $this->session->flashdata('error') ?>'
            });
        <?php endif; ?>


        // SweetAlert untuk pesan tambah 
        <?php if ($this->session->flashdata('errortambah')): ?>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                html: '<?= $this->session->flashdata('errortambah') ?>',
            });
        <?php endif; ?>

        <?php if ($this->session->flashdata('successtambah')): ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '<?= $this->session->flashdata('successtambah') ?>',
                showConfirmButton: false,
                timer: 2000
            });
        <?php endif; ?>



        // SweetAlert untuk pesan edit 
        <?php if ($this->session->flashdata('erroredit')): ?>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                html: '<?= $this->session->flashdata('erroredit') ?>',
            });
        <?php endif; ?>

        <?php if ($this->session->flashdata('successedit')): ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '<?= $this->session->flashdata('successedit') ?>',
                showConfirmButton: false,
                timer: 2000
            });
        <?php endif; ?>

        // SweetAlert untuk pesan tambahakun
        <?php if ($this->session->flashdata('errortambahAkun')): ?>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                html: '<?= $this->session->flashdata('errortambahAkun') ?>',
            });
        <?php endif; ?>

        <?php if ($this->session->flashdata('successtambahAkun')): ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '<?= $this->session->flashdata('successtambahAkun') ?>',
                showConfirmButton: false,
                timer: 2000
            });
        <?php endif; ?>


        // SweetAlert untuk pesan editakun
        <?php if ($this->session->flashdata('erroreditAkun')): ?>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                html: '<?= $this->session->flashdata('erroreditAkun') ?>',
            });
        <?php endif; ?>

        <?php if ($this->session->flashdata('successeditAkun')): ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '<?= $this->session->flashdata('successeditAkun') ?>',
                showConfirmButton: false,
                timer: 2000
            });
        <?php endif; ?>
    </script>
    <script>
        $(document).ready(function() {
            $('.akun-link').each(function() {
                var nip = $(this).data('nip');
                var button = $('#akunBtn-' + nip);

                $.ajax({
                    url: '<?= base_url("Admin/KelolaData/cekStatusAkunAjax/") ?>' + nip,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        button.text(response.tombolText);
                    },
                    error: function() {
                        button.text('Error');
                    }
                });
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const searchNameInput = document.getElementById("search-name");
            const searchNipInput = document.getElementById("search-nip");
            const resetButton = document.getElementById("reset-btn");
            const table = document.getElementById("pegawai-table");
            const rows = table.getElementsByTagName("tbody")[0].getElementsByTagName("tr");

            function filterTable() {
                const nameFilter = searchNameInput.value.toLowerCase();
                const nipFilter = searchNipInput.value.toLowerCase();

                for (let row of rows) {
                    const nameCell = row.cells[1].innerText.toLowerCase(); // Nama
                    const nipCell = row.cells[0].innerText.toLowerCase(); // NIP

                    const nameMatch = nameCell.includes(nameFilter);
                    const nipMatch = nipCell.includes(nipFilter);

                    if (nameMatch && nipMatch) {
                        row.style.display = ""; // Tampilkan baris
                    } else {
                        row.style.display = "none"; // Sembunyikan baris
                    }
                }
            }

            // Event listener untuk input pencarian
            searchNameInput.addEventListener("input", filterTable);
            searchNipInput.addEventListener("input", filterTable);

            // Reset button
            resetButton.addEventListener("click", function() {
                searchNameInput.value = "";
                searchNipInput.value = "";
                filterTable();
            });
        });
    </script>

</body>

</html>