<?php
// File: register.php
// Halaman dan proses pendaftaran

// Start session
session_start();

require_once 'config.php';

// Cek jika user sudah login
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit();
}

// Inisialisasi variabel
$name = '';
$email = '';
$error = '';
$success = '';


// Proses form registrasi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validasi input
    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = 'Harap isi semua field.';
    } elseif ($password !== $confirm_password) {
        $error = 'Password konfirmasi tidak cocok.';
    } elseif (strlen($password) < 6) {
        $error = 'Password harus minimal 6 karakter.';
    } else {
        // Cek jika email sudah terdaftar
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $error = 'Email sudah terdaftar. Silakan login.';
        } else {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Insert new user
            $insert_stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $insert_stmt->bind_param("sss", $name, $email, $hashed_password);
            
            if ($insert_stmt->execute()) {
                $user_id = $conn->insert_id;
                
                // Auto login after register
                $_SESSION['user_id'] = $user_id;
                $_SESSION['user_name'] = $name;
                $_SESSION['user_email'] = $email;
                
                // Redirect ke dashboard
                header('Location: dashboard.php');
                exit();
            } else {
                $error = 'Terjadi kesalahan saat mendaftar: ' . $conn->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Cupid</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
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
            background: linear-gradient(135deg, var(--secondary) 0%, #fff1f3 100%);
            color: var(--dark);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 0;
        }
        
        .container {
            width: 100%;
            max-width: 400px;
            padding: 0 20px;
        }
        
        .logo-container {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .logo {
            font-size: 36px;
            font-weight: bold;
            color: var(--primary);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }
        
        .logo i {
            margin-right: 10px;
            font-size: 32px;
        }
        
        .card {
            background-color: var(--light);
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }
        
        .card-header {
            margin-bottom: 25px;
            text-align: center;
        }
        
        .card-header h1 {
            font-size: 24px;
            color: var(--dark);
        }
        
        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 14px;
            text-align: center;
        }
        
        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 14px;
            text-align: center;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }
        
        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(255, 75, 110, 0.2);
        }
        
        .btn {
            display: block;
            width: 100%;
            padding: 12px;
            background-color: var(--primary);
            color: var(--light);
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 500;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        
        .btn:hover {
            background-color: #e63e5c;
        }
        
        .extra-links {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
        }
        
        .extra-links a {
            color: var(--primary);
            text-decoration: none;
        }
        
        .extra-links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo-container">
            <a href="index.php" class="logo">
                <i class="fas fa-heart"></i> Cupid
            </a>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h1>Daftar</h1>
            </div>
            
            <?php if (!empty($error)): ?>
            <div class="error-message">
                <?php echo $error; ?>
            </div>
            <?php endif; ?>
            
            <?php if (!empty($success)): ?>
            <div class="success-message">
                <?php echo $success; ?>
            </div>
            <?php endif; ?>
            
            <form method="post" action="register.php">
                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <div class="form-group">
                    <label for="confirm_password">Konfirmasi Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>
                
                <button type="submit" class="btn">Daftar</button>
                
                <div class="extra-links">
                    <p>Sudah punya akun? <a href="login.php">Masuk</a></p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>