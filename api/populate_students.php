<?php
// One-time script to populate sample students from hardcoded data
include 'config.php';
session_start();
if (!isset($_SESSION['admin_logged_in'])) die('Login first!');

$hardcoded = [
    // KAKOMLI IT
    ['name' => 'Bapak Irfan Priyono S.Kom', 'role' => 'KAKOMLI IT', 'address' => '-', 'skills' => [], 'hobby' => '-', 'photo' => 'asset foto/asset foto guru/sementara.png'],
    // Bendahara
    ['name' => 'Candy Al Azka', 'role' => 'Bendahara', 'address' => '-', 'skills' => [], 'hobby' => '-', 'photo' => 'asset foto/asset foto siswa/sementara.png'],
    ['name' => 'Ragil Bagus Nugroho', 'role' => 'Bendahara', 'address' => '-', 'skills' => [], 'hobby' => '-', 'photo' => 'asset foto/asset foto siswa/sementara.png'],
    // Ketua Kelas
    ['name' => 'Julian Tri Pratama', 'role' => 'Ketua Kelas', 'address' => '-', 'skills' => [], 'hobby' => '-', 'photo' => 'asset foto/asset foto siswa/sementara.png'],
    // Persensi
    ['name' => 'Celsia Ramadhani', 'role' => 'Persensi', 'address' => '-', 'skills' => [], 'hobby' => '-', 'photo' => 'asset foto/asset foto siswa/sementara.png'],
    ['name' => 'Hendri Setiawana', 'role' => 'Persensi', 'address' => '', 'skills' => [], 'hobby' => '', 'photo' => 'asset foto/asset foto siswa/sementara.png'],
    // Sekretaris
    ['name' => 'Alexa Aditya Cindra Dewi.', 'role' => 'Sekretaris', 'address' => '-', 'skills' => [], 'hobby' => '-', 'photo' => 'asset foto/asset foto siswa/sementara.png'],
    ['name' => 'Sulthan Pasha Ibrahim Sukarno', 'role' => 'Sekretaris', 'address' => '-', 'skills' => [], 'hobby' => '-', 'photo' => 'asset foto/asset foto siswa/sementara.png'],
    // Siswa (alphabetical by name)
    ['name' => 'Affandi Fathurrahman', 'role' => 'Siswa', 'address' => '-', 'skills' => [], 'hobby' => '-', 'photo' => 'asset foto/asset foto siswa/sementara.png'],
    ['name' => 'Ahmad Barrak Neil Fadli H.', 'role' => 'Siswa', 'address' => 'urip iku urup', 'skills' => ['cosplay mayit'], 'hobby' => 'turu', 'photo' => 'asset foto/asset foto siswa/sementara.png'],
    ['name' => 'Alecia Poppy Shakira Ayu K.', 'role' => 'Siswa', 'address' => '-', 'skills' => [], 'hobby' => '-', 'photo' => 'asset foto/asset foto siswa/sementara.png'],
    ['name' => 'Amanda Cinthya Kasih', 'role' => 'Siswa', 'address' => '-', 'skills' => [], 'hobby' => '-', 'photo' => 'asset foto/asset foto siswa/sementara.png'],
    ['name' => 'Ardilla Wahyuning Putri', 'role' => 'Siswa', 'address' => '-', 'skills' => [], 'hobby' => '-', 'photo' => 'asset foto/asset foto siswa/sementara.png'],
    ['name' => 'Aretha Maulina Noviatin', 'role' => 'Siswa', 'address' => '-', 'skills' => [], 'hobby' => '-', 'photo' => 'asset foto/asset foto siswa/sementara.png'],
    ['name' => 'Atha Thandagra Suryansyah', 'role' => 'Siswa', 'address' => '-', 'skills' => [], 'hobby' => '-', 'photo' => 'asset foto/asset foto siswa/sementara.png'],
    ['name' => 'Bagas Ardiansyah', 'role' => 'Siswa', 'address' => '-', 'skills' => [], 'hobby' => '-', 'photo' => 'asset foto/asset foto siswa/sementara.png'],
    ['name' => 'Celvin Yoga Alvino', 'role' => 'Siswa', 'address' => '-', 'skills' => [], 'hobby' => '-', 'photo' => 'asset foto/asset foto siswa/sementara.png'],
    ['name' => 'Dimas Riang Ilham Saputra', 'role' => 'Siswa', 'address' => '-', 'skills' => [], 'hobby' => '-', 'photo' => 'asset foto/asset foto siswa/sementara.png'],
    ['name' => 'Diva Ayu Permata', 'role' => 'Siswa', 'address' => '-', 'skills' => [], 'hobby' => '-', 'photo' => 'asset foto/asset foto siswa/sementara.png'],
    ['name' => 'Ena Zivanna Idelia Gita', 'role' => 'Siswa', 'address' => '-', 'skills' => [], 'hobby' => '-', 'photo' => 'asset foto/asset foto siswa/gita.png'],
    ['name' => 'Ficko Adiputra Perdana', 'role' => 'Siswa', 'address' => '-', 'skills' => [], 'hobby' => 'bantai ade-adean cs', 'photo' => 'asset foto/asset foto siswa/eko.png'],
    ['name' => 'Gayuh Gita Yulia Natasya', 'role' => 'Siswa', 'address' => 'mabar epep,emel.roblox', 'skills' => ['turunin bintng rank'], 'hobby' => 'gaming', 'photo' => 'asset foto/asset foto siswa/gita.png'],
    ['name' => 'Gilang Nur Maulida Faid', 'role' => 'Siswa', 'address' => 'pengen dadi ultramen', 'skills' => ['Gaming','Coding','Reading'], 'hobby' => 'Game, baca manhwa, coding, turu', 'photo' => 'asset foto/asset foto siswa/apalah.png'],
    ['name' => 'Helcia Andika Putri', 'role' => 'Siswa', 'address' => '-', 'skills' => [], 'hobby' => '-', 'photo' => 'asset foto/asset foto siswa/sementara.png'],
    ['name' => 'Ilham Rofiq Ananda Barocta', 'role' => 'Siswa', 'address' => 'ora ruh', 'skills' => ['main gripen'], 'hobby' => 'main gripen', 'photo' => 'asset foto/asset foto siswa/download.png'],
    ['name' => 'Kenza Pratama', 'role' => 'Siswa', 'address' => '-', 'skills' => [], 'hobby' => '-', 'photo' => 'asset foto/asset foto siswa/sementara.png'],
    ['name' => 'Khaula Nendra Sukma A', 'role' => 'Siswa', 'address' => '-', 'skills' => [], 'hobby' => 'coli', 'photo' => 'asset foto/asset foto siswa/sementara.png'],
    ['name' => 'Muhammad Akbar Fikriansyah', 'role' => 'Siswa', 'address' => '-', 'skills' => [], 'hobby' => '-', 'photo' => 'asset foto/asset foto siswa/sementara.png'],
    ['name' => 'Nabila Atha Nur Alfiyah', 'role' => 'Siswa', 'address' => '-', 'skills' => [], 'hobby' => '-', 'photo' => 'asset foto/asset foto siswa/sementara.png'],
    ['name' => 'Nurul Safika', 'role' => 'Siswa', 'address' => 'one day i am gonna grow a wings.', 'skills' => ['tau kalau gilang suka boonk'], 'hobby' => 'ngejek muji dan ibak ', 'photo' => 'asset foto/asset foto siswa/bakekok.png'],
    ['name' => 'Ragil Satria Risdiyanto', 'role' => 'Siswa', 'address' => '-', 'skills' => ['ngloooco'], 'hobby' => 'lihat bokep', 'photo' => 'asset foto/asset foto siswa/ragel edan.png'],
    ['name' => 'Relyta Triya Ayu Lestari', 'role' => 'Siswa', 'address' => '-', 'skills' => [], 'hobby' => '-', 'photo' => 'asset foto/asset foto siswa/sementara.png'],
    ['name' => 'Rifky Aditya Saputra', 'role' => 'Siswa', 'address' => '-', 'skills' => [], 'hobby' => '-', 'photo' => 'asset foto/asset foto siswa/sementara.png'],
    ['name' => 'Satria Pradika Bayu Pratama', 'role' => 'Siswa', 'address' => '-', 'skills' => [], 'hobby' => '', 'photo' => 'asset foto/asset foto siswa/sementara.png'],
    // Wali Kelas
    ['name' => 'Bapak Andies Pramudiyantoro, S.Kom', 'role' => 'Wali Kelas', 'address' => '-', 'skills' => ['Manajemen Kelas'], 'hobby' => '-', 'photo' => 'asset foto/asset foto siswa/sementara.png'],
    // Wakil Ketua Kelas
    ['name' => 'Meta Evrilya Giovanny', 'role' => 'Wakil Ketua Kelas', 'address' => '-', 'skills' => [], 'hobby' => '-', 'photo' => 'asset foto/asset foto siswa/sementara.png']
];

$success_count = 0;
foreach ($hardcoded as $s) {
    $existing = $db->students->findOne(['name' => $s['name']]);
    if (!$existing) {
        $db->students->insertOne($s + ['created_at' => new MongoDB\BSON\UTCDateTime()]);
        $success_count++;
    }
}

echo "Populated $success_count new students. Check diagnostic.php.\n";
?>

