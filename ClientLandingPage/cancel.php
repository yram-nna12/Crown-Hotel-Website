<?php
session_start();
require_once(__DIR__ . '/../db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['booking_id'])) {
    $booking_id = $_POST['booking_id'];

    // Fetch booking details
    $stmt = $conn->prepare("SELECT * FROM bookings WHERE id = ?");
    $stmt->bind_param("i", $booking_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $booking = $result->fetch_assoc();
        $check_in = new DateTime($booking['check_in']);
        $today = new DateTime();
        $interval = $today->diff($check_in);
        $days_before_checkin = $interval->days;

        // Paid bookings — apply penalties
        if ($booking['is_paid']) {
            if ($interval->invert || $days_before_checkin < 2) {
                $_SESSION['error'] = "❌ Cannot cancel a paid booking within 2 days of check-in.";
                header("Location: ../ClientLandingPage/index.php");
                exit();
            }

            // Determine penalty
            if ($days_before_checkin >= 7) {
                $penalty_rate = 0.10;
            } elseif ($days_before_checkin >= 5) {
                $penalty_rate = 0.15;
            } else {
                $penalty_rate = 0.20;
            }

            $penalty_amount = $booking['total_price'] * $penalty_rate;
            $refund_amount = $booking['total_price'] - $penalty_amount;

            // Delete booking
            $del = $conn->prepare("DELETE FROM bookings WHERE id = ?");
            $del->bind_param("i", $booking_id);
            $del->execute();

            $_SESSION['success'] = "✅ Paid booking cancelled. Penalty: ₱" . number_format($penalty_amount, 2) . ". Refund: ₱" . number_format($refund_amount, 2);
        } 
        
        // Unpaid bookings — cancel freely
        else {
            $del = $conn->prepare("DELETE FROM bookings WHERE id = ?");
            $del->bind_param("i", $booking_id);
            $del->execute();

            $_SESSION['success'] = "✅ Unpaid booking cancelled successfully. No penalty applied.";
        }
    } else {
        $_SESSION['error'] = "❌ Booking not found.";
    }
} else {
    $_SESSION['error'] = "❌ Invalid request.";
}

header("Location: ../ClientLandingPage/index.php");
exit();
