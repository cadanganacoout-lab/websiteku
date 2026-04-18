<?php
// Updated script to populate/update students with rank for terpopuler (order 0 = most popular)
include 'config.php';
use MongoDB\BSON\UTCDateTime;

// Temporarily disabled for CLI - re-enable for web
// session_start();
// if (!isset($_SESSION['admin_logged_in'])) die('Login first!');

$hardcoded = [
    // KAKOMLI IT (rank 0 = terpopuler)
    ['name' => 'Bapak Irfan Priyono S.Kom', 'role' => 'KAKOMLI IT', 'address' => '-', 'skills' => [], 'hobby' => '-', 'photo' => '../asset/asset_foto/asset_foto_guru/sementara.png'],
    // Wali Kelas
    ['name' => 'Bapak Andies Pramudiyantoro, S.Kom', 'role' => 'Wali Kelas', 'address' => '-', 'skills' => ['Manajemen Kelas'], 'hobby' => '-', 'photo' => '../asset/asset_foto/asset_foto_siswa/sementara.png'],
    ['name' => 'Affandi Fathurrahman', 'role' => 'Siswa', 'address' => '-', 'skills' => [], 'hobby' => '-', 'photo' => '../asset/asset_foto/asset_foto_siswa/sementara.png'],
    ['name' => 'Ahmad Barrak Neil Fadli H.', 'role' => 'Siswa', 'address' => 'urip iku urup', 'skills' => ['cosplay mayit'], 'hobby' => 'turu', 'photo' => '../asset/asset_foto/asset_foto_siswa/sementara.png'],
    ['name' => 'Alecia Poppy Shakira Ayu K.', 'role' => 'Siswa', 'address' => '-', 'skills' => [], 'hobby' => '-', 'photo' => '../asset/asset_foto/asset_foto_siswa/sementara.png'],
    ['name' => 'Alexa Aditya Cindra Dewi.', 'role' => 'Sekretaris', 'address' => '-', 'skills' => [], 'hobby' => '-', 'photo' => '../asset/asset_foto/asset_foto_siswa/sementara.png'],
    ['name' => 'Amanda Cinthya Kasih', 'role' => 'Siswa', 'address' => '-', 'skills' => [], 'hobby' => '-', 'photo' => '../asset/asset_foto/asset_foto_siswa/sementara.png'],
    ['name' => 'Ardilla Wahyuning Putri', 'role' => 'Siswa', 'address' => '-', 'skills' => [], 'hobby' => '-', 'photo' => '../asset/asset_foto/asset_foto_siswa/sementara.png'],
    ['name' => 'Aretha Maulina Noviatin', 'role' => 'Siswa', 'address' => '-', 'skills' => [], 'hobby' => '-', 'photo' => '../asset/asset_foto/asset_foto_siswa/sementara.png'],
    ['name' => 'Atha Thandagra Suryansyah', 'role' => 'Siswa', 'address' => '-', 'skills' => [], 'hobby' => '-', 'photo' => '../asset/asset_foto/asset_foto_siswa/sementara.png'],
    ['name' => 'Bagas Ardiansyah', 'role' => 'Siswa', 'address' => '-', 'skills' => [], 'hobby' => '-', 'photo' => '../asset/asset_foto/asset_foto_siswa/sementara.png'],
    // Bendahara
    ['name' => 'Candy Al Azka', 'role' => 'Bendahara', 'address' => '-', 'skills' => [], 'hobby' => '-', 'photo' => '../asset/asset_foto/asset_foto_siswa/sementara.png'],
    ['name' => 'Celvin Yoga Alvino', 'role' => 'Siswa', 'address' => '-', 'skills' => [], 'hobby' => '-', 'photo' => '../asset/asset_foto/asset_foto_siswa/sementara.png'],
    // Persensi
    ['name' => 'Celsia Ramadhani', 'role' => 'Persensi', 'address' => '-', 'skills' => [], 'hobby' => '-', 'photo' => '../asset/asset_foto/asset_foto_siswa/sementara.png'],
    ['name' => 'Dimas Riang Ilham Saputra', 'role' => 'Siswa', 'address' => '-', 'skills' => [], 'hobby' => '-', 'photo' => '../asset/asset_foto/asset_foto_siswa/sementara.php'],
    ['name' => 'Diva Ayu Permata', 'role' => 'Siswa', 'address' => '-', 'skills' => [], 'hobby' => '-', 'photo' => '../asset/asset_foto/asset_foto_siswa/sementara.png'],
    ['name' => 'Ena Zivanna Idelia Gita', 'role' => 'Siswa', 'address' => '-', 'skills' => [], 'hobby' => '-', 'photo' => '../asset/asset_foto/asset_foto_siswa/gita.png'],
    ['name' => 'Ficko Adiputra Perdana', 'role' => 'Siswa', 'address' => '-', 'skills' => [], 'hobby' => 'bantai ade-adean cs', 'photo' => '../asset/asset_foto/asset_foto_siswa/eko.png'],
    ['name' => 'Gayuh Gita Yulia Natasya', 'role' => 'Siswa', 'address' => 'mabar epep,emel.roblox', 'skills' => ['turunin bintng rank'], 'hobby' => 'gaming', 'photo' => '../asset/asset_foto/asset_foto_siswa/gita.png'],
    ['name' => 'Gilang Nur Maulida Faid', 'role' => 'Siswa', 'address' => 'pengen dadi ultramen', 'skills' => ['Gaming','Coding','Reading'], 'hobby' => 'Game, baca manhwa, coding, turu', 'photo' => '../asset/asset_foto/asset_foto_siswa/apalah.png'],
    ['name' => 'Helcia Andika Putri', 'role' => 'Siswa', 'address' => '-', 'skills' => [], 'hobby' => '-', 'photo' => '../asset/asset_foto/asset_foto_siswa/sementara.png'],
    ['name' => 'Hendri Setiawana', 'role' => 'Persensi', 'address' => '', 'skills' => [], 'hobby' => '', 'photo' => '../asset/asset_foto/asset_foto_siswa/sementara.png'],
    ['name' => 'Ilham Rofiq Ananda Barocta', 'role' => 'Siswa', 'address' => 'ora ruh', 'skills' => ['main gripen'], 'hobby' => 'main gripen', 'photo' => '../asset/asset_foto/asset_foto_siswa/download.png'],
    // Ketua Kelas
    ['name' => 'Julian Tri Pratama', 'role' => 'Ketua Kelas', 'address' => '-', 'skills' => [], 'hobby' => '-', 'photo' => '../asset/asset_foto/asset_foto_siswa/sementara.png'],
    ['name' => 'Kenza Pratama', 'role' => 'Siswa', 'address' => '-', 'skills' => [], 'hobby' => '-', 'photo' => '../asset/asset_foto/asset_foto_siswa/sementara.png'],
    ['name' => 'Khaula Nendra Sukma A', 'role' => 'Siswa', 'address' => '-', 'skills' => [], 'hobby' => 'coli', 'photo' => '../asset/asset_foto/asset_foto_siswa/sementara.png'],
    ['name' => 'Meta Evrilya Giovanny', 'role' => 'Wakil Ketua Kelas', 'address' => '-', 'skills' => [], 'hobby' => '-', 'photo' => '../asset/asset_foto/asset_foto_siswa/sementara.png'],
    ['name' => 'Muhammad Akbar Fikriansyah', 'role' => 'Siswa', 'address' => '-', 'skills' => [], 'hobby' => '-', 'photo' => '../asset/asset_foto/asset_foto_siswa/sementara.png'],
    ['name' => 'Nabila Atha Nur Alfiyah', 'role' => 'Siswa', 'address' => '-', 'skills' => [], 'hobby' => '-', 'photo' => '../asset/asset_foto/asset_foto_siswa/sementara.png'],
    ['name' => 'Nurul Safika', 'role' => 'Siswa', 'address' => 'one day i am gonna grow a wings.', 'skills' => ['tau kalau gilang suka boonk'], 'hobby' => 'ngejek muji dan ibak ', 'photo' => '../asset/asset_foto/asset_foto_siswa/bakekok.png'],
    ['name' => 'Ragil Bagus Nugroho', 'role' => 'Bendahara', 'address' => '-', 'skills' => [], 'hobby' => '-', 'photo' => '../asset/asset_foto/asset_foto_siswa/sementara.png'],
    ['name' => 'Ragil Satria Risdiyanto', 'role' => 'Siswa', 'address' => '-', 'skills' => ['ngloooco'], 'hobby' => 'lihat bokep', 'photo' => '../asset/asset_foto/asset_foto_siswa/ragel_edan.png'],
    ['name' => 'Relyta Triya Ayu Lestari', 'role' => 'Siswa', 'address' => '-', 'skills' => [], 'hobby' => '-', 'photo' => '../asset/asset_foto/asset_foto_siswa/sementara.png'],
    ['name' => 'Rifky Aditya Saputra', 'role' => 'Siswa', 'address' => '-', 'skills' => [], 'hobby' => '-', 'photo' => '../asset/asset_foto/asset_foto_siswa/sementara.png'],
    ['name' => 'Satria Pradika Bayu Pratama', 'role' => 'Siswa', 'address' => '-', 'skills' => [], 'hobby' => '', 'photo' => '../asset/asset_foto/asset_foto_siswa/sementara.png'],
    ['name' => 'Sulthan Pasha Ibrahim Sukarno', 'role' => 'Sekretaris', 'address' => '-', 'skills' => [], 'hobby' => '-', 'photo' => '../asset/asset_foto/asset_foto_siswa/sementara.png'],
];

$success_count = $update_count = 0;
foreach ($hardcoded as $index => $s) {
    $data = $s + ['rank' => $index, 'updated_at' => new UTCDateTime()];
    $result = $db->students->replaceOne(['name' => $s['name']], $data, ['upsert' => true]);
    if ($result->getMatchedCount() > 0) {
        $update_count++;
    } else {
        $success_count++;
    }
}

echo "Updated $update_count, added $success_count students with rank (0 = terpopuler). Total: " . count($hardcoded) . ". Check diagnostic.php.\n";
?>
