<?php
// payment_process.php
// Process payment for profile reveal

require_once 'config.php';
require_once 'payment_gateway.php';

// Make sure user is logged in
requireLogin();

// Check if order ID is provided
if (!isset($_GET['order_id'])) {
    redirect('dashboard.php?page=chat');
    exit();
}

$orderId = $_GET['order_id'];
$userId = $_SESSION['user_id'];

// Initialize payment gateway
$paymentGateway = new PaymentGateway('your_api_key', 'https://payment.api/');

// Check payment status
$payment = $paymentGateway->checkPaymentStatus($orderId);

// Make sure the payment exists and belongs to the current user
if ($payment['status'] === 'not_found' || $payment['user_id'] != $userId) {
    redirect('dashboard.php?page=chat&error=invalid_payment');
    exit();
}

// Get payment details
$targetUserId = $payment['target_user_id'];

// Get target user information
$sql = "SELECT u.name, p.profile_pic, p.bio FROM users u 
        LEFT JOIN profiles p ON u.id = p.user_id 
        WHERE u.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $targetUserId);
$stmt->execute();
$targetUser = $stmt->get_result()->fetch_assoc();

// If payment is already completed, redirect to view profile
if ($payment['status'] === 'completed') {
    redirect('view_profile.php?id=' . $targetUserId . '&from_payment=1');
    exit();
}

// Process the payment (in a real system, this would be handled by your payment gateway)
$paymentSuccess = false;
if (isset($_POST['simulate_payment'])) {
    // This is just a simulation. In real-world, you would integrate with a payment gateway
    $paymentSuccess = $paymentGateway->completePayment($orderId);
    
    if ($paymentSuccess) {
        redirect('view_profile.php?id=' . $targetUserId . '&from_payment=1&new=1');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Lihat Profil - Cupid</title>
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
            background-color: #f9f9f9;
            color: var(--dark);
        }
        
        .container {
            width: 100%;
            max-width: 600px;
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
        
        .payment-container {
            padding-top: 100px;
            padding-bottom: 50px;
        }
        
        .card {
            background-color: var(--light);
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            padding: 30px;
            margin-bottom: 30px;
        }
        
        .card-header {
            margin-bottom: 20px;
            text-align: center;
        }
        
        .card-header h1 {
            font-size: 24px;
            color: var(--dark);
        }
        
        .payment-details {
            margin-bottom: 30px;
        }
        
        .payment-details .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }
        
        .payment-details .label {
            font-weight: 500;
            color: #666;
        }
        
        .payment-details .value {
            font-weight: 600;
        }
        
        .user-preview {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 10px;
        }
        
        .user-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            overflow: hidden;
            margin-right: 15px;
        }
        
        .user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .user-info h3 {
            font-size: 18px;
            margin-bottom: 5px;
        }
        
        .user-info p {
            font-size: 14px;
            color: #666;
            margin: 0;
        }
        
        .payment-methods {
            margin-bottom: 30px;
        }
        
        .payment-method {
            display: flex;
            align-items: center;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .payment-method:hover {
            border-color: var(--primary);
            background-color: var(--secondary);
        }
        
        .payment-method input {
            margin-right: 10px;
        }
        
        .payment-method img {
            height: 30px;
            margin-right: 10px;
        }
        
        .payment-method-name {
            font-weight: 500;
        }
        
        .disclaimer {
            font-size: 13px;
            color: #777;
            text-align: center;
            margin-top: 30px;
        }
        
        .price-highlight {
            color: var(--primary);
            font-size: 24px;
            font-weight: bold;
        }
        
        .benefits {
            margin-bottom: 30px;
        }
        
        .benefits ul {
            list-style: none;
        }
        
        .benefits li {
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        
        .benefits li i {
            color: var(--primary);
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container">
            <div class="header-content">
                <a href="index.php" class="logo">
                    <i class="fas fa-heart"></i> Cupid
                </a>
                <nav>
                    <ul>
                        <li><a href="dashboard.php">Dashboard</a></li>
                        <li>
                            <a href="dashboard.php?page=chat" class="btn btn-outline">Kembali ke Chat</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <!-- Payment Section -->
    <section class="payment-container">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <h1>Lihat Profil Lengkap</h1>
                </div>
                
                <div class="user-preview">
                    <div class="user-avatar">
                        <img src="<?php echo !empty($targetUser['profile_pic']) ? htmlspecialchars($targetUser['profile_pic']) : '/api/placeholder/60/60'; ?>" alt="User Avatar">
                    </div>
                    <div class="user-info">
                        <h3><?php echo htmlspecialchars($targetUser['name']); ?></h3>
                        <p>Lihat profil lengkap untuk mengetahui info lebih detail</p>
                    </div>
                </div>
                
                <div class="benefits">
                    <h3>Dengan melihat profil, Anda akan mendapatkan:</h3>
                    <ul>
                        <li><i class="fas fa-check-circle"></i> Info lengkap tentang minat dan hobi</li>
                        <li><i class="fas fa-check-circle"></i> Jurusan dan fakultas</li>
                        <li><i class="fas fa-check-circle"></i> Bio lengkap</li>
                        <li><i class="fas fa-check-circle"></i> Foto profil yang jelas</li>
                        <li><i class="fas fa-check-circle"></i> Informasi kecocokan</li>
                    </ul>
                </div>
                
                <div class="payment-details">
                    <div class="row">
                        <div class="label">Order ID:</div>
                        <div class="value"><?php echo htmlspecialchars($orderId); ?></div>
                    </div>
                    <div class="row">
                        <div class="label">Lihat Profil:</div>
                        <div class="value"><?php echo htmlspecialchars($targetUser['name']); ?></div>
                    </div>
                    <div class="row">
                        <div class="label">Harga:</div>
                        <div class="value price-highlight">Rp 5.000</div>
                    </div>
                </div>
                
                <div class="payment-methods">
                    <h3>Metode Pembayaran:</h3>
                    
                    <!-- In a real implementation, you would integrate with payment gateways -->
                    <!-- This is just a simulation for demonstration purposes -->
                    
                    <label class="payment-method">
                        <input type="radio" name="payment_method" value="bca" checked>
                        <span>Bank Transfer - BCA</span>
                    </label>
                    
                    <label class="payment-method">
                        <input type="radio" name="payment_method" value="mandiri">
                        <span>Bank Transfer - Mandiri</span>
                    </label>
                    
                    <label class="payment-method">
                        <input type="radio" name="payment_method" value="ovo">
                        <span>OVO</span>
                    </label>
                    
                    <label class="payment-method">
                        <input type="radio" name="payment_method" value="gopay">
                        <span>GoPay</span>
                    </label>
                </div>
                
                <form method="post">
                    <!-- In a real implementation, this would be replaced with actual payment gateway -->
                    <button type="submit" name="simulate_payment" class="btn" style="width: 100%;">Bayar Sekarang</button>
                </form>
                
                <p class="disclaimer">
                    Dengan menekan tombol "Bayar Sekarang", Anda setuju dengan syarat dan ketentuan Cupid mengenai pembayaran dan penggunaan fitur premium.
                </p>
            </div>
        </div>
    </section>

    <script>
        // You would add payment gateway related JavaScript here
    </script>
</body>
</html>