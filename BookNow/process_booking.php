<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';
require '../PHPMailer/Exception.php';

session_start();
require_once(__DIR__ . '/../db.php'); // Your DB connection
date_default_timezone_set('Asia/Manila');

// Check login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../LoginPage/index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Fetch form data
    $user_id     = $_SESSION['user_id'];
    $email       = $_POST['email'];
    $first_name  = $_POST['first_name'];
    $last_name   = $_POST['last_name'];
    $contact     = $_POST['contact'];
    $check_in    = $_POST['check_in'];
    $check_out   = $_POST['check_out'];
    $room_type   = $_POST['room_type'];

    $hotel_name  = $_SESSION['selected_hotel_name'];
    $location    = $_SESSION['selected_hotel_location'];
    $full_name   = $first_name . ' ' . $last_name;

    // Validate 2-day advance
    $today = new DateTime();
    $check_in_date = new DateTime($check_in);
    $interval = $today->diff($check_in_date);

    if ($interval->days < 2 || $check_in_date < $today) {
        echo "<script>alert('Reservation must be at least 2 days in advance.'); window.history.back();</script>";
        exit;
    }

    // Check availability
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM bookings 
        WHERE hotel_name = ? AND room_type = ? AND check_in = ?");
    $stmt->bind_param("sss", $hotel_name, $room_type, $check_in);
    $stmt->execute();
    $result = $stmt->get_result();
    $room_count = $result->fetch_assoc()['count'];

    if ($room_count >= 9) {
        echo "<script>alert('This room type is fully booked for the selected date.'); window.history.back();</script>";
        exit;
    }

    // Fetch room price
    $stmt = $conn->prepare("SELECT price FROM room_pricing WHERE hotel_name = ? AND room_type = ?");
    $stmt->bind_param("ss", $hotel_name, $room_type);
    $stmt->execute();
    $price_result = $stmt->get_result();
    $price_row = $price_result->fetch_assoc();

    if (!$price_row) {
        echo "<script>alert('Room pricing not found.'); window.history.back();</script>";
        exit;
    }

    $price_per_day = $price_row['price'];

    // Calculate nights
    $check_in_obj = new DateTime($check_in);
    $check_out_obj = new DateTime($check_out);
    $nights = $check_in_obj->diff($check_out_obj)->days;

    if ($nights <= 0) {
        echo "<script>alert('Check-out must be after check-in.'); window.history.back();</script>";
        exit;
    }

    $total_price = $price_per_day * $nights;

    // Generate transaction ID
    $stmt = $conn->query("SELECT COUNT(*) AS total FROM bookings");
    $booking_number = $stmt->fetch_assoc()['total'] + 1;

    $name_code = strtoupper(substr($first_name, 0, 2));
    $book_month = strtoupper(date('M'));
    $book_day = date('d');
    $res_month = date('m', strtotime($check_in));
    $res_year = date('y', strtotime($check_in));
    $room_code = strtoupper(substr(str_replace(' ', '', $room_type), 0, 3));
    $booking_code = str_pad($booking_number, 5, '0', STR_PAD_LEFT);

    $transaction_id = "{$name_code}{$book_month}{$book_day}{$res_month}{$res_year}-{$room_code}{$booking_code}";

    // Insert booking
    $stmt = $conn->prepare("INSERT INTO bookings 
        (user_id, email, full_name, contact, check_in, check_out, room_type, hotel_name, location, transaction_id, is_paid, total_price, created_at) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0, ?, NOW())");
    $stmt->bind_param("isssssssssd", 
        $user_id, $email, $full_name, $contact, $check_in, $check_out, 
        $room_type, $hotel_name, $location, $transaction_id, $total_price);

    if ($stmt->execute()) {
        // Send confirmation email
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'crownhotel930@gmail.com';        // ✅ your Gmail
            $mail->Password   = 'kzfj lyws peba ibzp';           // ✅ App password
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->setFrom('crownhotel930@gmail.com', 'Crown Hotel');
            $mail->addAddress($email, $full_name);

            $mail->isHTML(true);
            $mail->Subject = 'Booking Confirmation - Crown Hotel';
            $mail->Body    = "
                <h3>Booking Confirmation</h3>
                <p>Dear <strong>$full_name</strong>,</p>
                <p>Your booking has been confirmed. Here are the details:</p>
                <ul>
                  <li><strong>Transaction ID:</strong> $transaction_id</li>
                  <li><strong>Hotel:</strong> $hotel_name</li>
                  <li><strong>Room Type:</strong> $room_type</li>
                  <li><strong>Check-In:</strong> $check_in</li>
                  <li><strong>Check-Out:</strong> $check_out</li>
                  <li><strong>Total Price:</strong> ₱" . number_format($total_price, 2) . "</li>
                </ul>
                <p>Thank you for booking with Crown Hotel.</p>
            ";

            $mail->send();
        } catch (Exception $e) {
            // You may log error if needed
        }
 $_SESSION['transaction_id'] = $transaction_id;
        $_SESSION['first_name'] = $first_name;
        $_SESSION['last_name'] = $last_name;
        $_SESSION['email'] = $email;
        $_SESSION['contact'] = $contact;
        $_SESSION['check_in'] = $check_in;
        $_SESSION['check_out'] = $check_out;
        $_SESSION['room_type'] = $room_type;
        $_SESSION['total_price'] = $total_price;

        header("Location: ../Payment/index.php");
        exit;
    } else {
        echo "<script>alert('Booking failed. Please try again.'); window.history.back();</script>";
        exit;
    }
}
?>
