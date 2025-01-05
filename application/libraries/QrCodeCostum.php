<?php
require_once APPPATH . 'libraries/qrcode/qrlib.php';

class QrCodeCostum
{
    public function generate($data, $path = null, $size = 300)
    {
        $filePath = $path ?: tempnam(sys_get_temp_dir(), 'qr_') . '.png';
        QRcode::png($data, $filePath, QR_ECLEVEL_L, 10);
        return $filePath;
    }
}
