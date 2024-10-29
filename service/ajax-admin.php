<?php
include 'connection.php';

$query = "SELECT kandidat_id, COUNT(*) as jumlah FROM votes GROUP BY kandidat_id";
$result = $connected->query($query);

$kandidat_votes = [
    1 => 0,
    2 => 0
];

while ($row = $result->fetch_assoc()) {
    $kandidat_votes[$row['kandidat_id']] = $row['jumlah'];
}

// Hitung total suara
$total_votes = $kandidat_votes[1] + $kandidat_votes[2];

// Hitung persentase
$persentase_kandidat_1 = $total_votes > 0 ? ($kandidat_votes[1] / $total_votes) * 100 : 0;
$persentase_kandidat_2 = $total_votes > 0 ? ($kandidat_votes[2] / $total_votes) * 100 : 0;



$query_semua_votes = "SELECT COUNT(*) as total_votes FROM votes";
$result_semua_votes = $connected->query($query_semua_votes);
$value_semua_votes = "";
$value_persentase_votes = "";

if ($result_semua_votes) {
    $data = $result_semua_votes->fetch_assoc();
    $total_votes = $data['total_votes'];

    $target_votes = 1714;

    // Hitung persentase suara yang terkumpul
    $percentage = ($total_votes / $target_votes) * 100;

    $value_semua_votes = "Jumlah suara yang terkumpul: $total_votes";
    $value_persentase_votes = "Persentase siswa yang memilih: " . round($percentage, 2) . "%";
} else {
    echo "Gagal mengambil data suara.";
}

// Kembalikan hasil dalam format JSON
echo json_encode([
    'persentase_kandidat_1' => $persentase_kandidat_1,
    'persentase_kandidat_2' => $persentase_kandidat_2,
    'jumlah_suara1' => $kandidat_votes[1],
    'jumlah_suara2' => $kandidat_votes[2],
    'value_semua_votes' => $value_semua_votes,
    'value_persentase_votes' => $value_persentase_votes
]);