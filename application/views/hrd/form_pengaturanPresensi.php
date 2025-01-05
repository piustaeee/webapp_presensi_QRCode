<style>
    .container-presensi {
        font-family: Arial, sans-serif;
        background-color: #e9ecef;
        margin: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .container-presensi {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        padding: 20px;
        box-sizing: border-box;
    }

    .card {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        width: 100%;
        max-width: 400px;
        padding: 25px;
        box-sizing: border-box;
    }

    .card-title {
        font-size: 22px;
        font-weight: bold;
        margin: 0 0 12px;
        color: #333;
    }

    .card-description {
        color: #666;
        margin: 0 0 20px;
        font-size: 16px;
    }

    .button {
        display: flex;
        align-items: center;
        width: 100%;
        padding: 12px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 4px;
        background-color: #fff;
        color: #333;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s, color 0.3s;
    }

    .button:hover {
        background-color: #f8f9fa;
    }

    .button.primary {
        background-color: #007bff;
        color: #fff;
        border: none;
    }

    .button.primary:hover {
        background-color: #0069d9;
    }

    .icon {
        width: 24px;
        height: 24px;
        margin-right: 12px;
    }

    .button.primary {
        text-decoration: none;
    }
</style>

<body>
    <div class="container-presensi">
        <div class="card">
            <h2 class="card-title">Pengaturan Presensi</h2>
            <p class="card-description">Kelola pengaturan presensi Anda</p>

            <button class="button" data-toggle="modal" data-target="#modalDraftPresensi">
                <svg class="icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Draft Presensi
            </button>
            <button class="button" data-toggle="modal" data-target="#modalPresensiBerjalan">
                <svg class="icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Presensi Berjalan
            </button>
            <button class="button" id="generateQRCodeBtn" data-toggle="modal" data-target="#modalGenerate">
                <svg class="icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2zm3 4v2h2V7H8zm0 4v2h2v-2H8zm4-4v2h2V7h-2zm0 4v2h2v-2h-2zm4-4v2h2V7h-2zm0 4v2h2v-2h-2z" />
                </svg>
                Generate QrCode
            </button>
            <a href="<?= base_url('presensiBaru') ?>" class="button primary">
                <svg class="icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Buat Pengaturan Presensi Baru
            </a>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalDraftPresensi" tabindex="-1" aria-labelledby="nolLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title col-8" id="nolLabel">Draft Presensi</h5>
                    <button type="button" class="close col-2" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="w-100">
                        <?php foreach ($presensiData as $row) : ?>
                            <tr>
                                <td>
                                    <a style="text-decoration: none;" href="<?= base_url('Admin/PengaturanPresensi/presensiById/' . urlencode($row['id_presensi'])) ?>">
                                        <div>
                                            <?= $row['bulan_presensi'] ?>
                                        </div>
                                    </a>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-danger" onclick="confirmDelete('<?= base_url('Admin/PengaturanPresensi/deletePresensi/' . urlencode($row['id_presensi'])) ?>')">Delete</button>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </table>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- modal presensi berjalan -->
    <div class="modal fade" id="modalPresensiBerjalan" tabindex="-1" aria-labelledby="satuLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title col-8" id="satuModalLabel">Presensi Berjalan</h5>
                    <button type="button" class="close col-2" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="w-100">

                        <tr>
                            <td>
                                <a style="text-decoration: none;" href="<?= base_url('Admin/PengaturanPresensi/presensiById/' . urlencode($activeData['id_presensi'])) ?>">
                                    <div><?= $activeData['bulan_presensi'] ?></div>
                                </a>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-danger" onclick="confirmDelete('<?= base_url('Admin/PengaturanPresensi/deletePresensi/' . urlencode($activeData['id_presensi'])) ?>')">Delete</button>
                            </td>
                        </tr>
                    </table>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal to show QR code -->
    <div class="modal fade" id="modalGenerate" tabindex="-1" aria-labelledby="satuLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title col-8" id="satuModalLabel">QR Code</h5>
                    <button type="button" class="close col-2" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="qrcode d-flex flex-column align-items-center">
                        <!-- QR code will be dynamically loaded here -->
                        <img id="qrCodeImg" src="" class="img-fluid" alt="QR Code for Redirect" />
                        <a id="downloadLink" href="#" download="kelola_data_qrcode.png">
                            <button>Save as Image</button>
                        </a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Event listener for the "Generate QR Code" button
        document.getElementById('generateQRCodeBtn').addEventListener('click', function() {
            // Make an AJAX request to generate the QR code
            fetch('<?= site_url("Admin/PengaturanPresensi/generateQRCode") ?>')
                .then(response => response.json())
                .then(data => {
                    // Dynamically load the QR code into the modal
                    document.getElementById('qrCodeImg').src = data.qr_code_path;
                    document.getElementById('downloadLink').href = data.qr_code_path;

                    // Display the modal
                    $('#modalGenerate').modal('show');
                })
                .catch(error => console.error('Error generating QR code:', error));
        });
    </script>






    <script>
        <?php if ($this->session->flashdata('successadd')): ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '<?= $this->session->flashdata('successadd') ?>',
                showConfirmButton: false,
                timer: 2000
            });
        <?php endif; ?>
    </script>

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
        <?php if ($this->session->flashdata('successhapus')): ?>
            Swal.fire({
                icon: 'success',
                title: 'Sukses!',
                text: '<?= $this->session->flashdata('successhapus') ?>'
            });
        <?php endif; ?>

        <?php if ($this->session->flashdata('errorhapus')): ?>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '<?= $this->session->flashdata('errorhapus') ?>'
            });
        <?php endif; ?>
    </script>


</body>