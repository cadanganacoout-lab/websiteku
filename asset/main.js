// Main JS for index.php - sidebar, modal, student grid from DB
let students = []; // Will be populated from PHP

function showSidebar() {
    document.querySelector('.sidebar').style.display = 'flex';
}

function hideSidebar() {
    document.querySelector('.sidebar').style.display = 'none';
}

function openModal(index) {
    const data = students[index];
    document.getElementById('modal-img').src = data.photo || 'asset foto/asset foto siswa/sementara.png';
    document.getElementById('modal-name').textContent = data.name;
    document.getElementById('modal-role').textContent = data.role;
    document.getElementById('modal-address').textContent = data.address || '';
    document.getElementById('modal-hobby').textContent = data.hobby || '';

    const skillsContainer = document.getElementById('modal-skills');
    skillsContainer.innerHTML = '';
    if (data.skills && Array.isArray(data.skills)) {
        data.skills.forEach(skill => {
            const badge = document.createElement('span');
            badge.className = 'skill-badge';
            badge.textContent = skill;
            skillsContainer.appendChild(badge);
        });
    }

    document.getElementById('modal').classList.add('active');
}

function closeModal() {
    document.getElementById('modal').classList.remove('active');
}

function renderStudents(studentsData) {
    students = studentsData;
    const grid = document.getElementById('student-grid');
    grid.innerHTML = '';
    studentsData.forEach((student, index) => {
        const card = document.createElement('div');
        card.className = 'student-card';
        card.onclick = () => openModal(index);
        card.innerHTML = `
            <img src="${student.photo || 'asset foto/asset foto siswa/sementara.png'}" alt="${student.name}" class="card-avatar">
            <div class="student-name">${student.name}</div>
            <div class="student-role">${student.role || 'Siswa'}</div>
            <div class="click-hint">Klik untuk detail</div>
        `;
        grid.appendChild(card);
    });
}

// Load students on page load from PHP data
document.addEventListener('DOMContentLoaded', function() {
    if (typeof studentData !== 'undefined') {
        renderStudents(studentData);
    }
});

// Modal close on overlay click
document.getElementById('modal').addEventListener('click', (e) => {
    if (e.target.id === 'modal') closeModal();
});

// CRUD functions (admin)
function addStudent() {
    const form = document.getElementById('addStudentForm');
    const formData = new FormData(form);
    const skillsStr = document.getElementById('skills_str').value;
    formData.append('add_student', '1');
    
    fetch('', {  // Same page
        method: 'POST',
        body: formData
    }).then(res => res.json()).then(data => {
        if (data.success) {
            alert('Siswa ditambahkan!');
            location.reload();
        } else {
            alert('Error: ' + (data.error || 'Unknown'));
        }
    }).catch(err => alert('Request failed: ' + err));
}

function deleteStudent(id) {
    if (confirm('Hapus siswa ini?')) {
        fetch(`?action=delete&id=${id}`).then(res => res.json()).then(data => {
            if (data.success) location.reload();
            else alert('Error: ' + (data.error || 'Unknown'));
        }).catch(err => alert('Delete failed'));
    }
}

// Update openModal to set current ID for delete
function openModal(index) {
    const data = students[index];
    document.getElementById('modal-img').src = data.photo || 'asset foto/asset foto siswa/sementara.png';
    document.getElementById('modal-name').textContent = data.name;
    document.getElementById('modal-role').textContent = data.role;
    document.getElementById('modal-address').textContent = data.address || '';
    document.getElementById('modal-hobby').textContent = data.hobby || '';

    const skillsContainer = document.getElementById('modal-skills');
    skillsContainer.innerHTML = '';
    if (data.skills && Array.isArray(data.skills)) {
        data.skills.forEach(skill => {
            const badge = document.createElement('span');
            badge.className = 'skill-badge';
            badge.textContent = skill;
            skillsContainer.appendChild(badge);
        });
    }

    // Set global for delete
    window.currentStudentId = data._id;

    document.getElementById('modal').classList.add('active');
}

