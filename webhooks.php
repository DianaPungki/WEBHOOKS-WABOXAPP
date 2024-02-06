<?php

$waboxapp_api_key = 'YOUR APIKEY WABOXAPP';

// Baca data dari webhook
$json = file_get_contents('php://input');
$decodedData = urldecode($json);

parse_str($decodedData, $result);

// Ambil pesan dan nomor pengirim
$pesan = $result['message']['body']['text'];
$pengirim = $result['contact']['uid'];
$aksi_event = $result['event'];

// Simpan pesan ke database atau lakukan operasi lainnya
// Contoh: Simpan pesan ke database MySQL
$koneksi = new mysqli('HOST', 'USERNAME', 'PASSWORD', 'DATABASE');
if ($koneksi->connect_error) {
    die("Koneksi ke database gagal: " . $koneksi->connect_error);
}

$query = "INSERT INTO messages (pengirim, pesan, aksi_event) VALUES ('$pengirim', '$pesan','$aksi_event')";
if ($koneksi->query($query) === TRUE) {
    echo "Pesan berhasil disimpan ke database.";
} else {
    echo "Error: " . $query . "<br>" . $koneksi->error;
}

$koneksi->close();

// Beri respons 200 OK ke Waboxapp
http_response_code(200);
?>
