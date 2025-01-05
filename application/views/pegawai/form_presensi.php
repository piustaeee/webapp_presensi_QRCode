    <style>
        .scanner-area {
            padding: 1rem;
            border-radius: 0.25rem;
            text-align: center;
        }

        #my-qr-reader {
            padding: 20px !important;
            border: 1.5px solid #b2b2b2 !important;
            border-radius: 8px;
        }

        #my-qr-reader img[alt="Info icon"] {
            display: none;
        }

        #my-qr-reader img[alt="Camera based scan"] {
            width: 100px !important;
            height: 100px !important;
        }

        button {
            padding: 10px 20px;
            border: 1px solid #b2b2b2;
            outline: none;
            border-radius: 0.25em;
            color: white;
            font-size: 15px;
            cursor: pointer;
            margin-top: 15px;
            margin-bottom: 10px;
            background-color: #008000ad;
            transition: 0.3s background-color;
        }

        button:hover {
            background-color: #008000;
        }

        /* For change scan or upload qrcode. */
        #html5-qrcode-anchor-scan-type-change {
            display: none !important;
            text-decoration: none !important;
            color: #1d9bf0;
        }

        video {
            width: 100% !important;
            border: 1px solid #b2b2b2 !important;
            border-radius: 0.25em;
        }
    </style>

    <body class="bg-light">
        <div class="container py-4">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-8">
                    <div class="card mb-4">
                        <div class="card-header bg-white">
                            <h5 class="card-title mb-0">Sistem Presensi QR Code</h5>
                            <small class="text-muted">Silakan pindai QR Code untuk melakukan presensi</small>
                        </div>
                        <div class="card-body">
                            <div class="scanner-area mb-4">
                                <div id="my-qr-reader"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://unpkg.com/html5-qrcode"></script>
        <script>
            function domReady(fn) {
                if (
                    document.readyState === "complete" ||
                    document.readyState === "interactive"
                ) {
                    setTimeout(fn, 1000);
                } else {
                    document.addEventListener("DOMContentLoaded", fn);
                }
            }

            domReady(function() {
                let isProcessing = false; // Flag untuk mencegah pemrosesan berulang
                const processingDelay = 5000; // Waktu delay (dalam milidetik)
                let htmlScanner; // Scanner akan diinisialisasi di luar

                function onScanSuccess(decodeText, decodeResult) {
                    if (isProcessing) return; // Abaikan jika sudah dalam proses

                    isProcessing = true;

                    setTimeout(() => {
                        window.location.href = decodeText;
                        htmlScanner.clear().then(() => {
                            console.log("Camera stopped successfully.");
                        }).catch(error => {
                            console.error("Error stopping camera:", error);
                        });
                    }, 1000);
                }

                // Inisialisasi QR scanner
                htmlScanner = new Html5QrcodeScanner("my-qr-reader", {
                    fps: 10,
                    qrbox: 250
                });

                htmlScanner.render(onScanSuccess);

                // Pastikan kamera berhenti saat halaman di-refresh atau sebelum keluar
                window.addEventListener("beforeunload", () => {
                    if (htmlScanner) {
                        htmlScanner.clear().catch(error => {
                            console.error("Error stopping scanner before unload:", error);
                        });
                    }
                });
            });

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

            <?php if ($this->session->flashdata('info')): ?>
                Swal.fire({
                    icon: 'info',
                    // title: 'Sukses!',
                    text: '<?= $this->session->flashdata('info') ?>'
                });
            <?php endif; ?>
        </script>
    </body>