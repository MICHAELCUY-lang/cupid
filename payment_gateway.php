<?php
// payment_gateway.php
// Simple payment gateway integration for profile reveal

class PaymentGateway {
    // This is a simplified version. In production, use a real payment gateway API
    private $apiKey;
    private $apiUrl;
    
    public function __construct($apiKey, $apiUrl) {
        $this->apiKey = $apiKey;
        $this->apiUrl = $apiUrl;
    }
    
    /**
     * Create a payment request for profile reveal
     * 
     * @param int $userId User requesting the reveal
     * @param int $targetUserId Target user whose profile is being revealed
     * @param int $amount Payment amount (in IDR)
     * @return array Payment details including redirect URL
     */
    public function createProfileRevealPayment($userId, $targetUserId, $amount = 5000) {
        global $conn;
        
        // Generate unique order ID
        $orderId = 'REVEAL-' . time() . '-' . $userId . '-' . $targetUserId;
        
        // Store payment request in database
        $sql = "INSERT INTO profile_reveal_payments 
                (order_id, user_id, target_user_id, amount, status, created_at) 
                VALUES (?, ?, ?, ?, 'pending', NOW())";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("siid", $orderId, $userId, $targetUserId, $amount);
        $stmt->execute();
        
        // In a real implementation, you would make an API call to your payment gateway
        // For this example, we'll create a mock payment URL
        
        $paymentUrl = "payment_process.php?order_id=" . urlencode($orderId);
        
        return [
            'order_id' => $orderId,
            'amount' => $amount,
            'payment_url' => $paymentUrl,
            'status' => 'pending'
        ];
    }
    
    /**
     * Check payment status
     * 
     * @param string $orderId The order ID to check
     * @return array Payment status details
     */
    public function checkPaymentStatus($orderId) {
        global $conn;
        
        // Get payment status from database
        $sql = "SELECT * FROM profile_reveal_payments WHERE order_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $orderId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            return ['status' => 'not_found'];
        }
        
        return $result->fetch_assoc();
    }
    
    /**
     * Complete a payment (for demo purposes)
     * 
     * @param string $orderId Order ID to complete
     * @return bool Success status
     */
    public function completePayment($orderId) {
        global $conn;
        
        // Update payment status
        $sql = "UPDATE profile_reveal_payments SET status = 'completed', paid_at = NOW() WHERE order_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $orderId);
        $result = $stmt->execute();
        
        // If payment is successful, update user permissions for profile viewing
        if ($result) {
            $sql = "SELECT user_id, target_user_id FROM profile_reveal_payments WHERE order_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $orderId);
            $stmt->execute();
            $payment = $stmt->get_result()->fetch_assoc();
            
            if ($payment) {
                // Grant permission to view the profile
                $sql = "INSERT INTO profile_view_permissions (user_id, target_user_id, created_at) 
                        VALUES (?, ?, NOW()) 
                        ON DUPLICATE KEY UPDATE created_at = NOW()";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ii", $payment['user_id'], $payment['target_user_id']);
                $stmt->execute();
            }
        }
        
        return $result;
    }
}