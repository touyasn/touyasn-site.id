<?php
// 1. Data Bot & Grup (Update Token Terbaru)
$token = "8480422689:AAH9bvALERYJUPn1rEQLR2FwNjWaubnQT2I"; 
$groupId = "-1003572326791"; // ID Grup sesuai screenshot

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    
    // Bersihkan input dari simbol @ dan spasi
    $clean_user = str_replace(['@', ' '], '', $username);

    // Hit ke API Telegram menggunakan getChatMember
    $url = "https://api.telegram.org/bot$token/getChatMember?chat_id=$groupId&user_id=$clean_user";
    
    $response = @file_get_contents($url);
    $data = json_decode($response, true);

    if ($data && $data['ok']) {
        $status = $data['result']['status'];
        
        // Cek apakah statusnya adalah owner, admin, atau member biasa
        if (in_array($status, ['creator', 'administrator', 'member'])) {
            echo json_encode(['success' => true, 'message' => 'Anggota Terverifikasi!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Anda bukan member grup ini.']);
        }
    } else {
        // Pesan jika ID tidak ditemukan atau Bot belum di-start oleh user
        echo json_encode(['success' => false, 'message' => 'User ID tidak ditemukan atau Bot belum di-start.']);
    }
}
?>
