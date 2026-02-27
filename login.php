<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login web</title>
    <style>
    :root {
        --primary-color: #4f46e5;
        --primary-light: #6366f1;
        --primary-dark: #4338ca;
        --success-color: #3e0d81;
        --error-color: #ef4444;
        --text-primary: #1f2937;
        --text-secondary: #6b7280;
        --bg-color: #f9fafb;

    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Segoe UI', Tahoma, Verdana, sans-serif;
    }

    body {
        background-color: var(--bg-color);
        color: var(--text-primary);
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        background-image: url('https://i.pinimg.com/736x/68/41/dc/6841dc4e8fd11b514b96e77dcc67d170.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        position: relative;
    }

    body::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(16, 15, 15, 0.5);
        z-index: 1;
    }

    .login-container {
        width: 100%;
        max-width: 400px;
        padding: 2rem;
        margin: 1rem;
        background-color: var(--card-bg);
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(21, 19, 19, 0.1);
        z-index: 2;
        position: relative;
        overflow: hidden;
    }

    .logo-section {
        text-align: center;
        margin-bottom: 2rem;
    }

    .app-logo {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 1rem;
        border: 3px solid var(--primary-color);
        padding: 5px;
    }

    .app-name {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary-dark);
        margin-bottom: 0.5rem;
    }

    .app-desc {
        font-size: 0.875rem;
        color: var(--text-secondary);
    }

    .form-group {
        margin-bottom: 1.25rem;
        position: relative;
    }

    .form-group label {
        display: block;
        font-size: 0.875rem;
        font-weight: 500;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 0.9375rem;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
    }

    .input-icon {
        position: absolute;
        right: 1rem;
        top: 2.4rem;
        color: var(--text-secondary);
    }

    .btn {
        width: 100%;
        padding: 0.875rem;
        border: none;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background-color: var(--primary-color);
        color: rgb(243, 231, 231);
    }

    .btn-primary:hover {
        background-color: var(--primary-dark);
    }

    .btn-block {
        display: block;
    }

    .divider {
        margin: 1.5rem 0;
        text-align: center;
        position: relative;
        color: var(--text-secondary);
        font-size: 0.8125rem;
    }

    .divider::before,
    .divider::after {
        content: '';
        position: absolute;
        top: 50%;
        width: 45%;
        height: 1px;
        background-color: #a10e24;
    }

    .divider::before {
        left: 0;
    }

    .divider::after {
        right: 0;
    }

    .social-login {
        display: flex;
        justify-content: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .social-btn {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #080809;
        background-color: rgb(232, 216, 216);
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .social-btn:hover {
        background-color: #0bc04a;
    }

    .bottom-links {
        text-align: center;
        font-size: 0.875rem;
    }

    .bottom-links a {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 500;
    }

    .bottom-links a:hover {
        text-decoration: underline;
    }

    .error-message {
        color: var(--error-color);
        font-size: 0.8125rem;
        margin-top: 0.25rem;
        display: none;
    }

    .success-message {
        color: var(--success-color);
        font-size: 0.8125rem;
        margin-top: 0.25rem;
        display: none;
    }

    .show-message {
        display: block;
    }

    @media (max-width: 480px) {
        .login-container {
            padding: 1.5rem;
            margin: 1rem;
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .login-container {
        animation: fadeIn 0.5s ease-out forwards;
    }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="logo-section">
            <img src="https://placehold.co/160x160?text=App+Logo"
                alt="Logo aplikasi dengan desain modern menggunakan warna ungu dan putih" class="app-logo">
            <h1 class="app-name">Aplikasi Kami</h1>
            <p class="app-desc">Silakan Login </p>
        </div>

        <form id="loginForm">
            <div class="form-group">
                <label for="username">Username atau Email</label>
                <input type="text" id="username" class="form-control" placeholder="Masukkan username atau email"
                    required>
                <i class="input-icon">👤</i>
                <div class="error-message" id="username-error">Username harus diisi</div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" class="form-control" placeholder="Masukkan password Anda" required>
                <i class="input-icon">🔒</i>
                <div class="error-message" id="password-error">Password harus diisi</div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Masuk</button>
            </div>

            <div class="bottom-links">
                <p>Tidak punya akun? <a href="register.php" id="registerLink">Daftar sekarang</a></p>
            </div>
        </form>
    </div>

    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script>
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        e.preventDefault();

        document.querySelectorAll('.error-message').forEach(el => {
            el.classList.remove('show-message');
        });

        const username = document.getElementById('username').value.trim();
        const password = document.getElementById('password').value.trim();

        let isValid = true;

        if (username === '') {
            document.getElementById('username-error').classList.add('show-message');
            isValid = false;
        }

        if (password === '') {
            document.getElementById('password-error').classList.add('show-message');
            isValid = false;
        }

        if (isValid) {
            setTimeout(() => {
                alert('Login berhasil! Akan mengarahkan ke dashboard...');
            }, 1000);
        }
    });

    document.getElementById('registerLink').addEventListener('click', function(e) {
        e.preventDefault();
        alert('Fitur pendaftaran akan diarahkan ke halaman registrasi');
    });

    document.getElementById('forgotPassword').addEventListener('click', function(e) {
        e.preventDefault();
        alert('Fitur lupa password akan diarahkan ke halaman reset password');
    });
    </script>
</body>

</html>