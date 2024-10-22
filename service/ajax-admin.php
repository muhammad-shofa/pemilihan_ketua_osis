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

// Kembalikan hasil dalam format JSON
echo json_encode([
    'persentase_kandidat_1' => $persentase_kandidat_1,
    'persentase_kandidat_2' => $persentase_kandidat_2,
    'jumlah_suara1' => $kandidat_votes[1],
    'jumlah_suara2' => $kandidat_votes[2]
]);