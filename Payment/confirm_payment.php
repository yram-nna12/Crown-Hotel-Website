<?php
session_start();
require_once(__DIR__ . '/../db.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// PHPMailer setup
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';
require '../PHPMailer/Exception.php';

// Validate session data
if (!isset($_SESSION['transaction_id'])) {
    echo "<script>alert('No transaction found.'); window.location.href = 'index.php';</script>";
    exit;
}

$transaction_id = $_SESSION['transaction_id'];
$full_name      = $_SESSION['first_name'] . ' ' . $_SESSION['last_name'];
$email          = $_SESSION['email'];
$contact        = $_SESSION['contact'];
$check_in       = $_SESSION['check_in'];
$check_out      = $_SESSION['check_out'];
$room_type      = $_SESSION['room_type'];
$total_price    = $_SESSION['total_price'];
$hotel_name     = $_SESSION['selected_hotel_name'] ?? 'Crown Hotel';
$location       = $_SESSION['selected_hotel_location'] ?? 'Metro Manila';

// 1. Mark the booking as paid
$stmt = $conn->prepare("UPDATE bookings SET is_paid = 1 WHERE transaction_id = ?");
$stmt->bind_param("s", $transaction_id);

if ($stmt->execute()) {
    // 2. Send email receipt
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'crownhotel930@gmail.com'; // ✅ your sender Gmail
        $mail->Password   = 'kzfj lyws peba ibzp';      // ✅ Gmail App Password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('crownhotel930@gmail.com', 'Crown Hotel');
        $mail->addAddress($email, $full_name);

        $mail->isHTML(true);
        $mail->Subject = 'Payment Receipt - Crown Hotel';
        $mail->Body    = "
            <h3>Payment Receipt</h3>
            <p>Dear <strong>$full_name</strong>,</p>
            <p>Thank you for your payment. Here are your receipt details:</p>
            <ul>
              <li><strong>Transaction ID:</strong> $transaction_id</li>
              <li><strong>Hotel:</strong> $hotel_name</li>
              <li><strong>Location:</strong> $location</li>
              <li><strong>Room Type:</strong> $room_type</li>
              <li><strong>Check-In:</strong> $check_in</li>
              <li><strong>Check-Out:</strong> $check_out</li>
              <li><strong>Total Paid:</strong> ₱" . number_format($total_price, 2) . "</li>
            </ul>
            <p>This email serves as your official receipt. If you have questions, contact us at Crownhotel07@gmail.com.</p>
            <p>Warm regards,<br>Crown Hotel Team</p>
        ";

        $mail->send();
    } catch (Exception $e) {
        // Log error (optional)
        error_log("Mail Error: " . $mail->ErrorInfo);
    }

    echo "<script>
        alert('Payment successful! A receipt has been sent to your email.');
        window.location.href = '../ClientLandingPage/index.php';
    </script>";
    exit;

} else {
    echo "<script>alert('Failed to update payment.'); window.history.back();</script>";
    exit;
}
?>
