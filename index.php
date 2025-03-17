<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cupid - Temukan Pasanganmu</title>
    <style>
        :root {
            --primary: #ff4b6e;
            --secondary: #ffd9e0;
            --dark: #333333;
            --light: #ffffff;
            --accent: #ff8fa3;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f9f9f9;
            color: var(--dark);
        }
        
        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        header {
            background-color: var(--light);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 100;
        }
        
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
        }
        
        .logo {
            font-size: 28px;
            font-weight: bold;
            color: var(--primary);
            text-decoration: none;
            display: flex;
            align-items: center;
        }
        
        .logo i {
            margin-right: 10px;
            font-size: 24px;
        }
        
        nav ul {
            display: flex;
            list-style: none;
        }
        
        nav ul li {
            margin-left: 20px;
        }
        
        nav ul li a {
            text-decoration: none;
            color: var(--dark);
            font-weight: 500;
            transition: color 0.3s;
        }
        
        nav ul li a:hover {
            color: var(--primary);
        }
        
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: var(--primary);
            color: var(--light);
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-weight: 500;
            transition: background-color 0.3s;
        }
        
        .btn:hover {
            background-color: #e63e5c;
        }
        
        .btn-outline {
            background-color: transparent;
            border: 2px solid var(--primary);
            color: var(--primary);
        }
        
        .btn-outline:hover {
            background-color: var(--primary);
            color: var(--light);
        }
        
        .hero {
            height: 100vh;
            display: flex;
            align-items: center;
            padding-top: 80px;
            background: linear-gradient(135deg, var(--secondary) 0%, #fff1f3 100%);
        }
        
        .hero-content {
            width: 50%;
            padding-right: 30px;
        }
        
        .hero-image {
            width: 50%;
            display: flex;
            justify-content: center;
        }
        
        .hero-image img {
            max-width: 100%;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        
        h1 {
            font-size: 48px;
            margin-bottom: 20px;
            color: var(--dark);
        }
        
        h1 span {
            color: var(--primary);
        }
        
        p {
            font-size: 18px;
            line-height: 1.6;
            margin-bottom: 30px;
            color: #666;
        }
        
        .features {
            padding: 100px 0;
        }
        
        .section-header {
            text-align: center;
            margin-bottom: 60px;
        }
        
        .section-header h2 {
            font-size: 36px;
            margin-bottom: 15px;
            color: var(--dark);
        }
        
        .section-header p {
            font-size: 18px;
            color: #666;
            max-width: 700px;
            margin: 0 auto;
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
        }
        
        .feature-card {
            background-color: var(--light);
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s, box-shadow 0.3s;
            text-align: center;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
        
        .feature-icon {
            font-size: 50px;
            color: var(--primary);
            margin-bottom: 20px;
        }
        
        .feature-card h3 {
            font-size: 22px;
            margin-bottom: 15px;
            color: var(--dark);
        }
        
        .feature-card p {
            font-size: 16px;
            color: #666;
            margin-bottom: 20px;
        }
        
        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }
        
        .modal-content {
            background-color: var(--light);
            padding: 30px;
            border-radius: 10px;
            max-width: 500px;
            width: 100%;
        }
        
        .close-btn {
            position: absolute;
            right: 20px;
            top: 15px;
            font-size: 24px;
            cursor: pointer;
            color: #666;
        }
        
        .modal h2 {
            margin-bottom: 20px;
            font-size: 24px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }
        
        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        
        .form-group textarea {
            height: 120px;
            resize: vertical;
        }
        
        footer {
            background-color: var(--dark);
            color: var(--light);
            padding: 60px 0 30px;
        }
        
        .footer-content {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 30px;
            margin-bottom: 40px;
        }
        
        .footer-logo {
            font-size: 24px;
            font-weight: bold;
            color: var(--light);
            margin-bottom: 15px;
            display: block;
        }
        
        .footer-about p {
            color: #aaa;
            margin-bottom: 20px;
        }
        
        .footer-heading {
            font-size: 18px;
            margin-bottom: 20px;
            color: var(--light);
        }
        
        .footer-links {
            list-style: none;
        }
        
        .footer-links li {
            margin-bottom: 10px;
        }
        
        .footer-links a {
            color: #aaa;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .footer-links a:hover {
            color: var(--primary);
        }
        
        .footer-bottom {
            border-top: 1px solid #444;
            padding-top: 30px;
            text-align: center;
            font-size: 14px;
            color: #aaa;
        }
        
        /* Dashboard styles */
        .dashboard {
            padding-top: 100px;
            min-height: 100vh;
            background-color: #f9f9f9;
        }
        
        .dashboard-container {
            display: grid;
            grid-template-columns: 250px 1fr;
            gap: 30px;
        }
        
        .sidebar {
            background-color: var(--light);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            height: fit-content;
            position: sticky;
            top: 100px;
        }
        
        .sidebar-menu {
            list-style: none;
        }
        
        .sidebar-menu li {
            margin-bottom: 5px;
        }
        
        .sidebar-menu a {
            display: block;
            padding: 12px 15px;
            color: var(--dark);
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        
        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background-color: var(--secondary);
            color: var(--primary);
        }
        
        .sidebar-menu i {
            margin-right: 10px;
        }
        
        .main-content {
            padding-bottom: 50px;
        }
        
        .dashboard-header {
            margin-bottom: 30px;
        }
        
        .dashboard-header h2 {
            font-size: 28px;
            margin-bottom: 10px;
        }
        
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .page-header h3 {
            font-size: 22px;
        }
        
        .card {
            background-color: var(--light);
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }
        
        .card-header {
            margin-bottom: 20px;
        }
        
        .card-header h3 {
            font-size: 20px;
        }
        
        /* Media Queries */
        @media (max-width: 991px) {
            .hero-content, .hero-image {
                width: 100%;
                padding-right: 0;
            }
            
            .hero {
                flex-direction: column;
                height: auto;
                padding: 150px 0 50px;
            }
            
            .hero-image {
                margin-top: 50px;
            }
            
            .footer-content {
                grid-template-columns: 1fr 1fr;
            }
            
            .dashboard-container {
                grid-template-columns: 1fr;
            }
            
            .sidebar {
                position: static;
            }
        }
        
        @media (max-width: 767px) {
            .header-content {
                flex-direction: column;
            }
            
            nav ul {
                margin-top: 20px;
            }
            
            nav ul li {
                margin: 0 10px;
            }
            
            h1 {
                font-size: 36px;
            }
            
            .footer-content {
                grid-template-columns: 1fr;
            }
        }
        
        /* Additional pages specific styles */
        .messages-container {
            display: flex;
            flex-direction: column;
            gap: 15px;
            max-height: 500px;
            overflow-y: auto;
            padding-right: 10px;
        }
        
        .message {
            background-color: #f0f0f0;
            padding: 15px;
            border-radius: 10px;
            position: relative;
        }
        
        .message-received {
            align-self: flex-start;
            background-color: #e4e6eb;
            max-width: 70%;
        }
        
        .message-sent {
            align-self: flex-end;
            background-color: var(--primary);
            color: white;
            max-width: 70%;
        }
        
        .message p {
            margin-bottom: 5px;
        }
        
        .message .time {
            font-size: 12px;
            color: #777;
            text-align: right;
        }
        
        .message-sent .time {
            color: rgba(255, 255, 255, 0.8);
        }
        
        .message-form {
            display: flex;
            margin-top: 20px;
        }
        
        .message-form input {
            flex: 1;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 5px 0 0 5px;
            font-size: 16px;
        }
        
        .message-form button {
            padding: 12px 20px;
            background-color: var(--primary);
            color: var(--light);
            border: none;
            border-radius: 0 5px 5px 0;
            cursor: pointer;
        }
        
        .profile-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
        }
        
        .profile-card {
            background-color: var(--light);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        
        .profile-image {
            height: 200px;
            overflow: hidden;
        }
        
        .profile-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .profile-info {
            padding: 20px;
        }
        
        .profile-info h3 {
            font-size: 18px;
            margin-bottom: 5px;
        }
        
        .profile-meta {
            font-size: 14px;
            color: #777;
            margin-bottom: 15px;
        }
        
        .profile-bio {
            font-size: 14px;
            margin-bottom: 15px;
            color: #555;
        }
        
        .profile-interests {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            margin-bottom: 15px;
        }
        
        .interest-tag {
            font-size: 12px;
            background-color: var(--secondary);
            color: var(--primary);
            padding: 5px 10px;
            border-radius: 15px;
        }
        
        .compatibility-questions {
            max-width: 700px;
            margin: 0 auto;
        }
        
        .question {
            margin-bottom: 30px;
        }
        
        .question h3 {
            font-size: 18px;
            margin-bottom: 15px;
        }
        
        .options {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        
        .option {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .option:hover, .option.selected {
            background-color: var(--secondary);
            border-color: var(--primary);
        }
        
        .option input {
            margin-right: 10px;
        }
    </style>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container">
            <div class="header-content">
                <a href="#" class="logo">
                    <i class="fas fa-heart"></i> Cupid
                </a>
                <nav>
                    <ul>
                        <li><a href="#features">Fitur</a></li>
                        <li><a href="#" id="login-btn">Masuk</a></li>
                        <li><a href="#" id="register-btn" class="btn">Daftar</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <h1>Temukan <span>Pasanganmu</span> di Cupid</h1>
                <p>Platform dimana kamu dapat menemukan pasangan yang cocok berdasarkan ketertarikan, hobi, dan tujuan yang sama. Apakah kamu mencari teman, partner belajar, atau romansa, Cupid membantu kamu terhubung dengan orang yang tepat.</p>
                <a href="#" class="btn" id="get-started-btn">Mulai Sekarang</a>
            </div>
            <div class="hero-image">
                <img src="/api/placeholder/500/400" alt="Cupid Platform Preview">
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="container">
            <div class="section-header">
                <h2>Fitur Utama</h2>
                <p>Cupid menawarkan berbagai fitur menarik untuk membantu kamu menemukan pasangan yang cocok.</p>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-user-edit"></i>
                    </div>
                    <h3>Profile Creation</h3>
                    <p>Buat profil dengan minat, hobi, dan apa yang kamu cari (teman, partner belajar, atau romansa).</p>
                    <a href="#" class="btn btn-outline">Buat Profil</a>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-mask"></i>
                    </div>
                    <h3>Anonymous Crush Menfess</h3>
                    <p>Kirim pesan anonim ke crush kamu. Jika keduanya saling suka, nama akan terungkap!</p>
                    <a href="#" class="btn btn-outline">Kirim Menfess</a>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-comments"></i>
                    </div>
                    <h3>Blind Chat</h3>
                    <p>Chat dengan mahasiswa acak tanpa melihat profil mereka terlebih dahulu.</p>
                    <a href="#" class="btn btn-outline">Mulai Chat</a>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                    <h3>Compatibility Test</h3>
                    <p>Kuis untuk mencocokkan mahasiswa berdasarkan kepribadian, jurusan, dan minat.</p>
                    <a href="#" class="btn btn-outline">Ikuti Tes</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Login Modal -->
    <div class="modal" id="login-modal">
        <div class="modal-content">
            <span class="close-btn" id="close-login">&times;</span>
            <h2>Masuk ke Cupid</h2>
            <form id="login-form">
                <div class="form-group">
                    <label for="login-email">Email</label>
                    <input type="email" id="login-email" required>
                </div>
                <div class="form-group">
                    <label for="login-password">Password</label>
                    <input type="password" id="login-password" required>
                </div>
                <button type="submit" class="btn">Masuk</button>
                <p style="text-align: center; margin-top: 20px;">
                    Belum punya akun? <a href="#" id="switch-to-register">Daftar</a>
                </p>
            </form>
        </div>
    </div>

    <!-- Register Modal -->
    <div class="modal" id="register-modal">
        <div class="modal-content">
            <span class="close-btn" id="close-register">&times;</span>
            <h2>Daftar di Cupid</h2>
            <form id="register-form">
                <div class="form-group">
                    <label for="register-name">Nama Lengkap</label>
                    <input type="text" id="register-name" required>
                </div>
                <div class="form-group">
                    <label for="register-email">Email</label>
                    <input type="email" id="register-email" required>
                </div>
                <div class="form-group">
                    <label for="register-password">Password</label>
                    <input type="password" id="register-password" required>
                </div>
                <div class="form-group">
                    <label for="register-confirm">Konfirmasi Password</label>
                    <input type="password" id="register-confirm" required>
                </div>
                <button type="submit" class="btn">Daftar</button>
                <p style="text-align: center; margin-top: 20px;">
                    Sudah punya akun? <a href="#" id="switch-to-login">Masuk</a>
                </p>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-about">
                    <a href="#" class="footer-logo">Cupid</a>
                    <p>Platform untuk menemukan pasangan yang cocok berdasarkan minat, hobi, dan tujuan yang sama.</p>
                </div>
                <div class="footer-links-section">
                    <h3 class="footer-heading">Fitur</h3>
                    <ul class="footer-links">
                        <li><a href="#">Profile Creation</a></li>
                        <li><a href="#">Anonymous Crush Menfess</a></li>
                        <li><a href="#">Blind Chat</a></li>
                        <li><a href="#">Compatibility Test</a></li>
                    </ul>
                </div>
                <div class="footer-links-section">
                    <h3 class="footer-heading">Perusahaan</h3>
                    <ul class="footer-links">
                        <li><a href="#">Tentang Kami</a></li>
                        <li><a href="#">Kontak</a></li>
                        <li><a href="#">Karir</a></li>
                        <li><a href="#">Blog</a></li>
                    </ul>
                </div>
                <div class="footer-links-section">
                    <h3 class="footer-heading">Bantuan</h3>
                    <ul class="footer-links">
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Kebijakan Privasi</a></li>
                        <li><a href="#">Syarat & Ketentuan</a></li>
                        <li><a href="#">Dukungan</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 Cupid. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Modal functionality
        const loginBtn = document.getElementById('login-btn');
        const registerBtn = document.getElementById('register-btn');
        const getStartedBtn = document.getElementById('get-started-btn');
        const loginModal = document.getElementById('login-modal');
        const registerModal = document.getElementById('register-modal');
        const closeLogin = document.getElementById('close-login');
        const closeRegister = document.getElementById('close-register');
        const switchToRegister = document.getElementById('switch-to-register');
        const switchToLogin = document.getElementById('switch-to-login');

        // Open login modal
        loginBtn.addEventListener('click', function(e) {
            e.preventDefault();
            loginModal.style.display = 'flex';
        });

        // Open register modal
        registerBtn.addEventListener('click', function(e) {
            e.preventDefault();
            registerModal.style.display = 'flex';
        });

        // Get started button
        getStartedBtn.addEventListener('click', function(e) {
            e.preventDefault();
            registerModal.style.display = 'flex';
        });

        // Close login modal
        closeLogin.addEventListener('click', function() {
            loginModal.style.display = 'none';
        });

        // Close register modal
        closeRegister.addEventListener('click', function() {
            registerModal.style.display = 'none';
        });

        // Switch to register form
        switchToRegister.addEventListener('click', function(e) {
            e.preventDefault();
            loginModal.style.display = 'none';
            registerModal.style.display = 'flex';
        });

        // Switch to login form
        switchToLogin.addEventListener('click', function(e) {
            e.preventDefault();
            registerModal.style.display = 'none';
            loginModal.style.display = 'flex';
        });

        // Close modals when clicking outside
        window.addEventListener('click', function(e) {
            if (e.target == loginModal) {
                loginModal.style.display = 'none';
            }
            if (e.target == registerModal) {
                registerModal.style.display = 'none';
            }
        });

        // Form submissions
        const loginForm = document.getElementById('login-form');
        const registerForm = document.getElementById('register-form');

        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const email = document.getElementById('login-email').value;
            const password = document.getElementById('login-password').value;
            
            // Here you would normally send an AJAX request to your PHP backend
            console.log('Login attempt:', email, password);
            
            // Simulate successful login
            alert('Login successful! Redirecting to dashboard...');
            window.location.href = 'dashboard.php';
        });

        registerForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const name = document.getElementById('register-name').value;
            const email = document.getElementById('register-email').value;
            const password = document.getElementById('register-password').value;
            const confirm = document.getElementById('register-confirm').value;
            
            if (password !== confirm) {
                alert('Passwords do not match!');
                return;
            }
            
            // Here you would normally send an AJAX request to your PHP backend
            console.log('Register attempt:', name, email, password);
            
            // Simulate successful registration
            alert('Registration successful! Please check your email to verify your account.');
            registerModal.style.display = 'none';
        });
    </script>
</body>
</html>
