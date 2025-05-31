<?php
/**
 * Simple PHP QR Code generator
 * 
 * Ini adalah implementasi sederhana untuk menghasilkan QR Code
 * tanpa memerlukan library eksternal
 */

function generateQRCode($text, $size = 10) {
    // URL encode the data
    $encodedText = urlencode($text);
    
    // Gunakan API QR Code Generator
    $qrCodeUrl = "https://api.qrserver.com/v1/create-qr-code/?data=$encodedText&size={$size}x{$size}&margin=2";
    
    return $qrCodeUrl;
}
?>
