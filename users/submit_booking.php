<?php
// submit_booking.php
session_start();
header('Content-Type: text/html; charset=utf-8');
include_once '../db.php'; 

function mask_mobile($num)
{
    if (!$num)
        return null;
    // keep only digits, then mask all but last 4
    $digits = preg_replace('/\D/', '', $num);
    return preg_replace('/\d(?=\d{4})/', '*', $digits);
}

function get_last4($card)
{
    if (!$card)
        return null;
    $digits = preg_replace('/\D/', '', $card);
    return (strlen($digits) >= 4) ? substr($digits, -4) : null;
}

function generate_dummy_trx()
{
    // dummy trx: DUMMY- + 10 chars hex
    return 'DUMMY-' . strtoupper(substr(md5(uniqid('', true)), 0, 10));
}

// --------------------------
// Read input (support GET/POST)
// --------------------------
$input = array_merge($_GET, $_POST);

// Required fields (from your form)
$banquetID = isset($input['banquetID']) ? intval($input['banquetID']) : null;
$event_date = isset($input['event_date']) ? $input['event_date'] : null;   // expect YYYY-MM-DD
$time_slot = isset($input['time_slot']) ? $input['time_slot'] : null;
$payment_option = isset($input['payment_option']) ? $input['payment_option'] : 'full';
$amount_raw = isset($input['amount']) ? $input['amount'] : '0';
$amount = floatval(str_replace(',', '', $amount_raw));

// optional payer info (from payment fields)
$method = isset($input['method']) ? $input['method'] : ($input['paymentMethodLeft'] ?? null); // try common keys
$payer_name = isset($input['payer_name']) ? trim($input['payer_name']) : (isset($input['payerNameLeft']) ? trim($input['payerNameLeft']) : null);
$payer_number = isset($input['payer_number']) ? trim($input['payer_number']) : (isset($input['payerNumberLeft']) ? trim($input['payerNumberLeft']) : null);
$card_number = isset($input['card_number']) ? $input['card_number'] : (isset($input['cardNumberLeft']) ? $input['cardNumberLeft'] : null);



// basic validation
$errors = [];
if (!$banquetID)
    $errors[] = "Banquet ID missing.";
if (!$event_date)
    $errors[] = "Event date missing.";
if (!$time_slot)
    $errors[] = "Time slot missing.";
if ($amount <= 0)
    $errors[] = "Invalid amount.";



if (count($errors) > 0) {
    // show errors and stop
    echo "<h3>Errors:</h3><ul>";
    foreach ($errors as $e)
        echo "<li>" . htmlspecialchars($e) . "</li>";
    echo "</ul>";
    exit;
}

// --------------------------
// Determine user_id (if logged in)
$userId = $_SESSION['id'] ?? null;


// --------------------------
// Prepare payment fields
$maskedPayer = $payer_number ? mask_mobile($payer_number) : null;
$card_last4 = $card_number ? get_last4($card_number) : null;

// For now, create a dummy transaction id as requested
$transactionRef = generate_dummy_trx();

// We'll mark payment as 'paid' for this demo since trx is dummy and user asked to save it.
// In real flow, you should wait for gateway callback to mark as 'paid'.
$paymentStatus = 'paid';

// --------------------------
// Insert booking + payment in a DB transaction
// --------------------------
try {
    $pdo->beginTransaction();

    // Insert booking
    $stmtBk = $pdo->prepare("
        INSERT INTO bookings
          (user_id, banquet_id, date, time_slot, notes, address, status, created_at)
        VALUES
          (?, ?, ?, ?, ?, ?, ?, NOW())
    ");

    // We try to pull notes/address from input if present (ids from your form)
    $notes = $input['notesStep2'] ?? $input['notes'] ?? null;
    $address = $input['addressStep2'] ?? $input['address'] ?? null;

    // initial booking status: confirmed if payment made, else pending
    $bookingStatus = ($paymentStatus === 'paid') ? 'confirmed' : 'pending';

    $stmtBk->execute([
        $userId,
        $banquetID,
        $event_date,
        $time_slot,
        $notes,
        $address,
        $bookingStatus
    ]);

    $bookingId = $pdo->lastInsertId();

    // Insert payment
    $stmtPay = $pdo->prepare("
        INSERT INTO payments
          (booking_id, payment_option, amount, method, transaction_ref, payer_name, status, payer_number, created_at, card_last4)
        VALUES
          (?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)
    ");

    $stmtPay->execute([
        $bookingId,
        $payment_option,
        $amount,
        $method,
        $transactionRef,
        $payer_name,
        $paymentStatus,
        $maskedPayer,
        $card_last4
    ]);

    $paymentId = $pdo->lastInsertId();

    // commit
    $pdo->commit();

    // Success — redirect or show message
    // Redirect to a success page (example)
    header("Location: booking_success.php?booking_id=" . urlencode($bookingId) . "&payment_id=" . urlencode($paymentId));
    exit;

} catch (Exception $e) {
    $pdo->rollBack();
    // Log error in real app; show a friendly message to user
    echo "<h3>Server error while saving booking/payment</h3>";
    echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
    exit;
}
