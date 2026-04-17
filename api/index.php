<?php
session_start();
include 'config.php';

use MongoDB\BSON\ObjectId;
use MongoDB\BSON\UTCDateTime;

$is_logged_in = isset($_SESSION['admin_logged_in']) || isset($_SESSION['user_logged_in']);
$is_admin = isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;

// Handle CRUD
if ($_POST && isset($_POST['add_student']) && $is_admin) {
    $data = [
        'name' => $_POST['name'],
        'role' => $_POST['role'] ?? 'Siswa',
        'photo' => $_POST['photo'] ?? '../asset/asset_foto/asset_foto_siswa/sementara.png',
        'address' => $_POST['address'] ?? '',
        'skills' => !empty($_POST['skills']) ? explode(',', $_POST['skills']) : [],
        'hobby' => $_POST['hobby'] ?? '',
        'created_at' => new UTCDateTime()
    ];
    $result = $db->students->insertOne($data);
    exit(json_encode(['success' => true]));
}

if (isset($_GET['delete']) && $is_admin) {
    $db->students->deleteOne(['_id' => new ObjectId($_GET['delete'])]);
    exit(json_encode(['success' => true]));
}

if ($_POST && isset($_POST['update_student']) && $is_admin) {
    if (!$is_admin) {
        exit(json_encode(['success' => false, 'error' => 'Admin access required']));
    }
    try {
        $id = new ObjectId($_POST['id']);
        $update = ['$set' => []];
        if (!empty($_POST['name'])) $update['$set']['name'] = trim($_POST['name']);
        if (!empty($_POST['role'])) $update['$set']['role'] = trim($_POST['role']);
        if (!empty($_POST['photo'])) $update['$set']['photo'] = trim($_POST['photo']);
        if (!empty($_POST['address'])) $update['$set']['address'] = trim($_POST['address']);
        if (!empty($_POST['skills'])) $update['$set']['skills'] = array_map('trim', explode(',', $_POST['skills']));
        if (!empty($_POST['hobby'])) $update['$set']['hobby'] = trim($_POST['hobby']);
        
        if (empty($update['$set'])) {
            exit(json_encode(['success' => false, 'error' => 'No fields to update']));
        }
        
        $result = $db->students->updateOne(['_id' => $id], $update);
        if ($result->getMatchedCount() > 0) {
            exit(json_encode(['success' => true]));
        } else {
            exit(json_encode(['success' => false, 'error' => 'Student not found']));
        }
    } catch (Exception $e) {
        exit(json_encode(['success' => false, 'error' => $e->getMessage()]));
    }
}


$students = iterator_to_array($db->students->find([], ['sort' => ['role' => 1, 'name' => 1]]));
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>X RPL 1 | SMK PGRI 2 Ponorogo</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif
        }

        :root {
            --primary: #6b46c1;
            --secondary: #4c1d95;
            --accent: #ed64a6;
            --bg: #0f0f23;
            --card-bg: linear-gradient(135deg, #1e1b4b, #2d1b69)
        }

        body {
            background: var(--bg);
            color: white;
            overflow-x: hidden;
        }

        header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            backdrop-filter: blur(10px);
            padding: 1rem 2rem;
            box-shadow: 0 4px 20px rgba(107, 70, 193, .3)
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto
        }

        .logo {
            font-size: 1.8rem;
            font-weight: 700;
            background: linear-gradient(45deg, white, var(--accent));
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            list-style: none
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: all .3s;
            opacity: .9
        }

        .nav-links a:hover {
            opacity: 1;
            transform: translateY(-2px)
        }

        .hamburger {
            display: none;
            flex-direction: column;
            cursor: pointer;
            gap: .3rem
        }

        .nav-links.open {
            display: flex !important;
            position: fixed;
            top: 70px;
            left: 0;
            right: 0;
            flex-direction: column;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            padding: 1rem;
            gap: 1rem;
            z-index: 99;
        }

        .hamburger span {
            width: 25px;
            height: 3px;
            background: white;
            transition: .3s
        }

        .hero {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 0 2rem;
            background: linear-gradient(135deg, rgba(107, 70, 193, .1), rgba(76, 29, 149, .1)), url('../asset/asset_foto/asset_logo_sekolah/birumerah.png');
            background-size: cover;
            background-position: center;
            background-attachment: fixed
        }

        .hero h1 {
            font-size: clamp(3rem, 8vw, 6rem);
            font-weight: 800;
            margin-bottom: 1rem;
            background: linear-gradient(45deg, #fff, var(--accent), #fff);
            background-size: 200%;
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: gradientMove 4s ease infinite
        }

        .hero p {
            font-size: clamp(1.2rem, 3vw, 2rem);
            max-width: 600px;
            margin-bottom: 3rem;
            opacity: .9
        }

        .cta {
            background: var(--accent);
            color: #000;
            padding: 1rem 3rem;
            border: none;
            border-radius: 50px;
            font-size: 1.2rem;
            font-weight: 600;
            cursor: pointer;
            transition: all .3s;
            box-shadow: 0 10px 30px rgba(237, 100, 166, .4)
        }

        .cta:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(237, 100, 166, .6)
        }

        .section {
            padding: 6rem 2rem;
            max-width: 1200px;
            margin: 0 auto
        }

        .section h2 {
            font-size: clamp(2.5rem, 6vw, 4rem);
            text-align: center;
            margin-bottom: 4rem;
            font-weight: 700;
            background: linear-gradient(45deg, white, var(--accent));
            background-size: 200%;
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: gradientMove 3s ease infinite
        }

        @keyframes gradientMove {

            0%,
            100% {
                background-position: 0 50%
            }

            50% {
                background-position: 100% 50%
            }
        }

        .students-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 2rem
        }

        .student-card {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            transition: all .4s;
            box-shadow: 0 20px 40px rgba(0, 0, 0, .3);
            border: 1px solid rgba(107, 70, 193, .2);
            overflow: hidden;
            position: relative
        }

        .student-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--accent), var(--primary))
        }

        .student-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 30px 60px rgba(107, 70, 193, .4)
        }

        .avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid white;
            margin: 0 auto 1.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .4)
        }

        .student-name {
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: .5rem
        }

        .student-role {
            background: var(--primary);
            color: white;
            padding: .5rem 1.5rem;
            border-radius: 25px;
            font-size: .95rem;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 1rem
        }

        .details {
            margin-top: 1.5rem;
            font-size: .95rem;
            line-height: 1.6;
            opacity: .9
        }

        .details i {
            margin-right: .5rem;
            color: var(--accent)
        }

        .album {
            position: relative;
            overflow: hidden;
            border-radius: 20px;
            box-shadow: 0 30px 60px rgba(0, 0, 0, .4);
            margin: 3rem 0
        }

        .album-track {
            display: flex;
            animation: scroll 40s linear infinite
        }

        .album-card {
            flex: 0 0 400px;
            height: 300px;
            margin-right: 1.5rem;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 15px 30px rgba(0, 0, 0, .3)
        }

        .album-card img {
            width: 100%;
            height: 100%;
            object-fit: cover
        }

        @keyframes scroll {
            0% {
                transform: translateX(0)
            }

            100% {
                transform: translateX(-50%)
            }
        }

        .admin-panel {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 2rem;
            margin: 2rem 0;
            border: 1px solid rgba(107, 70, 193, .3)
        }

        .admin-panel h3 {
            margin-bottom: 1.5rem;
            font-size: 1.5rem
        }

        .admin-form {
            display: grid;
            gap: 1rem;
            max-width: 500px
        }

        .admin-form input,
        .admin-form textarea,
        .admin-form select {
            padding: 1rem;
            border: 1px solid rgba(255, 255, 255, .2);
            border-radius: 12px;
            background: rgba(255, 255, 255, .05);
            color: white;
            font-size: 1rem
        }

        .admin-form input::placeholder,
        .admin-form textarea::placeholder {
            color: rgba(255, 255, 255, .5)
        }

        .btn {
            background: var(--primary);
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all .3s
        }

        .btn:hover {
            background: var(--secondary);
            transform: translateY(-2px)
        }

        .btn-danger {
            background: #e53e3e
        }

        .btn-danger:hover {
            background: #c53030
        }

        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, .8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 2000;
            opacity: 0;
            visibility: hidden;
            transition: all .3s
        }

        .modal.active {
            opacity: 1;
            visibility: visible
        }

        .modal-content {
            background: linear-gradient(135deg, #1a1a3e, #2d1b69);
            border-radius: 25px;
            padding: 3rem;
            max-width: 500px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 40px 80px rgba(0, 0, 0, .6);
            transform: scale(.8);
            transition: all .3s
        }

        .modal.active .modal-content {
            transform: scale(1)
        }

        .modal-header {
            text-align: center;
            margin-bottom: 2rem
        }

        .modal-header img {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            border: 6px solid white;
            margin-bottom: 1rem
        }

        .modal-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: .5rem
        }

        .modal-role {
            background: var(--accent);
            color: #000;
            padding: .75rem 1.5rem;
            border-radius: 30px;
            font-weight: 600;
            display: inline-block
        }

        .skill-tags {
            display: flex;
            flex-wrap: wrap;
            gap: .5rem;
            margin: 1.5rem 0
        }

        .skill-tag {
            background: var(--primary);
            padding: .5rem 1rem;
            border-radius: 20px;
            font-size: .9rem
        }

        footer {
            background: linear-gradient(135deg, #1e1b4b, #2d1b69);
            padding: 4rem 2rem 2rem;
            text-align: center
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem
        }

        .footer-link {
            color: rgba(255, 255, 255, .8);
            text-decoration: none;
            transition: .3s
        }

        .footer-link:hover {
            color: white
        }

        @media (max-width:768px) {
            .hamburger {
                display: flex
            }

            .nav-links {
                display: none
            }

            .students-grid {
                grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
                gap: 1.5rem
            }

            .album-card {
                flex: 0 0 300px;
                height: 200px;
                margin-right: 1rem
            }
        }
    </style>
</head>

<body>
    <header>
        <nav>
            <div class="logo">X RPL 1</div>
            <ul class="nav-links">
                <li><a href="#home">Beranda</a></li>
                <li><a href="#struktur">Struktur</a></li>
                <li><a href="#album">Galeri</a></li>
                <li><a href="#kontak">Kontak</a></li>
                <?php if (!$is_logged_in): ?>
                    <li><a href="login.php">Login</a></li>
                <?php else: ?>
                    <li><a href="logout.php">Logout</a></li>
                <?php endif; ?>
            </ul>
            <div class="hamburger" onclick="toggleMenu()">
                <span></span><span></span><span></span>
            </div>
        </nav>
    </header>

    <section id="home" class="hero">
        <h1>Kelas X RPL 1</h1>
        <p>Rekayasa Perangkat Lunak - SMK PGRI 2 Ponorogo. Temukan struktur lengkap kelas, wali kelas, dan kenangan foto bersama kami!</p>
        <button class="cta" onclick="scrollTo('#struktur')">Lihat Struktur Kelas</button>
    </section>

    <section id="struktur" class="section">
        <h2>Struktur Kelas</h2>
        <?php if ($is_admin): ?>
            <div class="admin-panel">
                <h3><i class="fas fa-plus"></i> Kelola Siswa</h3>
                <form class="admin-form" id="studentForm">
                    <input name="name" placeholder="Nama lengkap" required>
                    <input name="role" placeholder="Jabatan (Wali Kelas/Siswa/Ketua dll)">
                    <input name="photo" placeholder="Path foto">
                    <textarea name="address" placeholder="Catatan khusus/alamat" rows="2"></textarea>
                    <input name="skills" placeholder="Keahlian (pisahkan koma)">
                    <input name="hobby" placeholder="Hobby">
                    <button type="submit" class="btn">Tambah Siswa <i class="fas fa-save"></i></button>
                </form>
            </div>
        <?php endif; ?>
        <div class="students-grid" id="studentsGrid">
            <?php foreach ($students as $s): ?>
                <div class="student-card" onclick="openModal(<?= json_encode($s) ?>)">
                    <img class="avatar" src="<?= $s['photo'] ?? '../asset/asset_foto/asset_foto_siswa/sementara.png' ?>" alt="<?= $s['name'] ?>">
                    <h3 class="student-name"><?= $s['name'] ?></h3>
                    <div class="student-role"><?= $s['role'] ?? 'Siswa' ?></div>
                    <div class="details">
                        <i class="fas fa-quote-left"></i> <?= $s['address'] ?? 'Siswa hebat!' ?>
                        <?php if (!empty($s['hobby'])): ?><br><i class="fas fa-gamepad"></i> <?= $s['hobby'] ?><?php endif; ?>
                    </div>
                    <?php if ($is_admin): ?>
                    <div style="margin-top: 1rem;">
                        <button class="btn" style="background: #10b981; padding: .5rem 1rem; font-size: .9rem;" onclick="editStudent(<?= json_encode($s) ?>); event.stopPropagation();">✏️ Edit</button>
                    </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section id="album" class="section">
        <h2>Galeri Foto Kelas</h2>
        <div class="album">
            <div class="album-track" id="albumTrack">
                <?php
                $photos = ['agit.png', 'bintalsik.png', 'bintalsik2.png', 'bukber.png', 'dirumahpakandies.png', 'fotobersama.png', 'gaje.png', 'gajev2.png', 'jaman majapahit.png', 'last mpls.png', 'mujahadah.png', 'opo i.png', 'pondokcw.png', 'pondokcwk.png', 'sejarahv2.png', 'sejorh.png', 'terawih.png', 'withpakendi.png'];
                foreach ($photos as $p) {
                    echo "<div class='album-card'><img src='../asset/asset_foto/asset_foto_album/$p' loading='lazy'></div>";
                }
                foreach ($photos as $p) {
                    echo "<div class='album-card'><img src='../asset/asset_foto/asset_foto_album/$p' loading='lazy'></div>";
                } // Duplicate for infinite
                ?>
            </div>
        </div>
    </section>

    <footer id="kontak">
        <div class="footer-content">
            <div>
                <h4>SMK PGRI 2 Ponorogo</h4><a href="https://smkpgri2ponorogo.sch.id/" class="footer-link">Website Resmi</a>
            </div>
            <div>
                <h4>Sosial Media</h4><a href="https://instagram.com/official.smkpgri2ponorogo" class="footer-link">Instagram</a>
            </div>
        </div>
        <p>&copy; 2026 Kelas X RPL 1.</p>
    </footer>

    <div id="modal" class="modal" onclick="closeModal(event)">
        <div class="modal-content" onclick="event.stopPropagation()">
            <div class="modal-header">
                <img id="modalPhoto" class="avatar" alt="">
                <h2 id="modalName"></h2>
                <div id="modalRole" class="student-role"></div>
            </div>
            <div id="modalDetails" class="details"></div>
            <form id="editForm" style="display: none;">
                <input type="hidden" name="id" id="editId">
                <input type="text" id="editName" name="name" placeholder="Nama lengkap">
                <input type="text" id="editRole" name="role" placeholder="Role/Jabatan">
                <input type="text" id="editPhoto" name="photo" placeholder="Path foto">
                <textarea id="editAddress" name="address" rows="2" placeholder="Address/Catatan"></textarea>
                <input type="text" id="editSkills" name="skills" placeholder="Skills (koma separated)">
                <input type="text" id="editHobby" name="hobby" placeholder="Hobby">
                <button type="submit" class="btn" style="background: #f59e0b;">💾 Update Siswa</button>
            </form>
            <?php if ($is_admin): ?>
            <button class="btn" onclick="toggleEditMode(false)" id="editToggleBtn" style="background: #10b981;">✏️ Edit Mode</button>
            <?php endif; ?>
        </div>
    </div>

    <script>
        let currentStudent = null;
        let editMode = false;

        function toggleMenu() {
            document.querySelector('.nav-links').classList.toggle('open')
        }

        function toggleEditMode(showEdit) {
            editMode = showEdit;
            const details = document.getElementById('modalDetails');
            const form = document.getElementById('editForm');
            const toggleBtn = document.getElementById('editToggleBtn');
            const actions = document.getElementById('modalActions');
            
            if (showEdit) {
                details.style.display = 'none';
                form.style.display = 'block';
                toggleBtn.textContent = '👁️ View';
                toggleBtn.style.background = '#6b46c1';
                form.querySelectorAll('input, textarea').forEach(input => {
                    input.style.borderColor = 'var(--accent)';
                });
            } else {
                details.style.display = 'block';
                form.style.display = 'none';
                toggleBtn.textContent = '✏️ Edit';
                toggleBtn.style.background = '#10b981';
            }
        }

        function editStudent(student) {
            openModal(student);
            setTimeout(() => toggleEditMode(true), 100);
            document.getElementById('editId').value = student._id.$oid || student._id;
            document.getElementById('editName').value = student.name || '';
            document.getElementById('editRole').value = student.role || '';
            document.getElementById('editPhoto').value = student.photo || '';
            document.getElementById('editAddress').value = student.address || '';
            document.getElementById('editSkills').value = Array.isArray(student.skills) ? student.skills.join(', ') : '';
            document.getElementById('editHobby').value = student.hobby || '';
        }

        function scrollTo(id) {
            document.querySelector(id).scrollIntoView({
                behavior: 'smooth'
            })
        }

        document.getElementById('studentForm')?.addEventListener('submit', async e => {
            e.preventDefault()
            const fd = new FormData(e.target)
            const formData = new FormData()
            formData.append('add_student', '1')
            for (let [key, value] of fd.entries()) {
                formData.append(key, value)
            }
            try {
                const res = await fetch('', {
                    method: 'POST',
                    body: formData
                })
                const data = await res.json()
                if (data.success) {
                    alert('✅ Siswa berhasil ditambahkan!')
                    location.reload()
                } else alert('❌ Error: ' + data.error)
            } catch (err) {
                alert('❌ Gagal: ' + err)
            }
        })

        document.getElementById('editForm')?.addEventListener('submit', async e => {
            e.preventDefault()
            const fd = new FormData(e.target)
            fd.append('update_student', '1')
            try {
                const res = await fetch('', {
                    method: 'POST',
                    body: fd
                })
                const data = await res.json()
                if (data.success) {
                    alert('✅ Data siswa berhasil diupdate!')
                    toggleEditMode(false)
                    location.reload()
                } else {
                    alert('❌ Error: ' + data.error)
                }
            } catch (err) {
                alert('❌ Gagal update: ' + err)
            }
        })


        function openModal(student) {
            currentStudent = student
            editMode = false;
            document.getElementById('modalPhoto').src = student.photo || '../asset/asset_foto/asset_foto_siswa/sementara.png'
            document.getElementById('modalName').textContent = student.name
            document.getElementById('modalRole').textContent = student.role || 'Siswa'
            document.getElementById('modalDetails').innerHTML = `
<i class="fas fa-quote-left"></i> ${student.address||'Siswa luar biasa'}<br>
${student.skills?.length?`<i class="fas fa-cogs"></i> ${student.skills.join(', ')}<br>`:''}
<i class="fas fa-heart"></i> ${student.hobby||'Belum diketahui'}
`
            document.getElementById('editForm').style.display = 'none';
            document.getElementById('modalDetails').style.display = 'block';
            const toggleBtn = document.getElementById('editToggleBtn');
            if (toggleBtn) {
                toggleBtn.textContent = '✏️ Edit';
                toggleBtn.style.background = '#10b981';
                toggleBtn.style.display = 'inline-block';
            }
            document.getElementById('modal').classList.add('active')
        }

        function closeModal(e) {
            document.getElementById('modal').classList.remove('active')
        }

        async function deleteStudent(student) {
            if (!confirm('Hapus ' + student.name + '?')) return
            try {
                await fetch(`?delete=${student._id}`)
                alert('✅ Dihapus!')
                location.reload()
            } catch (err) {
                alert('❌ Gagal hapus')
            }
        }

        window.addEventListener('scroll', () => {
            document.querySelectorAll('.student-card').forEach((card, i) => {
                const rect = card.getBoundingClientRect()
                if (rect.top < window.innerHeight) {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)'
                }
            })
        })
    </script>
</body>

</html>