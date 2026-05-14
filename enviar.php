<?php
// Procesa el formulario de contacto.
// MVP: si hay PHPMailer + SMTP configurado, envía por SMTP. Si no, intenta mail() nativo.
// Siempre redirige a /contacto con ?status=ok o ?status=err&err=...

require_once __DIR__ . '/includes/data.php';

function redirect_back(string $status, array $errors = []): void {
    $qs = 'status=' . urlencode($status);
    if ($errors) {
        $qs .= '&err=' . urlencode(implode('|', $errors));
    }
    header('Location: /contacto?' . $qs);
    exit;
}

// Solo acepta POST
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    redirect_back('err', ['Método no permitido.']);
}

// Honeypot: si bots llenan "website", lo descartamos en silencio (200 OK simulado).
if (!empty($_POST['website'] ?? '')) {
    redirect_back('ok');
}

$name    = trim((string)($_POST['name']    ?? ''));
$email   = trim((string)($_POST['email']   ?? ''));
$phone   = trim((string)($_POST['phone']   ?? ''));
$service = trim((string)($_POST['service'] ?? ''));
$message = trim((string)($_POST['message'] ?? ''));

$errors = [];
if (mb_strlen($name)    < 2)   $errors[] = 'Tu nombre es muy corto.';
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Email inválido.';
if (mb_strlen($message) < 10)  $errors[] = 'El mensaje debe tener al menos 10 caracteres.';
if (mb_strlen($message) > 2000) $errors[] = 'El mensaje es demasiado largo.';

if ($errors) redirect_back('err', $errors);

// Construcción del email
$site = site_data();
$to       = $site['smtp_to']        ?? ($site['email'] ?? '');
$fromName = $site['smtp_from_name'] ?? ($site['name'] ?? 'Web');

$subject = '[Web] Nueva consulta de ' . $name;
$body  = "Nombre:   $name\n";
$body .= "Email:    $email\n";
$body .= "Teléfono: " . ($phone ?: '—') . "\n";
$body .= "Servicio: " . ($service ?: '—') . "\n";
$body .= "----------------------------------\n";
$body .= $message . "\n";
$body .= "----------------------------------\n";
$body .= "Enviado desde " . ($_SERVER['HTTP_HOST'] ?? '') . " · " . date('Y-m-d H:i:s') . "\n";

$sent = false;

// --- Intento 1: PHPMailer + SMTP (si está disponible y configurado) ---
$phpmailerAutoload = __DIR__ . '/vendor/PHPMailer/src/PHPMailer.php';
$smtpUser = $site['smtp_user'] ?? '';
$smtpPass = $site['smtp_pass'] ?? '';

if (is_file($phpmailerAutoload) && $smtpUser && $smtpPass) {
    require_once __DIR__ . '/vendor/PHPMailer/src/Exception.php';
    require_once __DIR__ . '/vendor/PHPMailer/src/PHPMailer.php';
    require_once __DIR__ . '/vendor/PHPMailer/src/SMTP.php';

    $mail = new PHPMailer\PHPMailer\PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = $site['smtp_host'] ?? 'localhost';
        $mail->SMTPAuth   = true;
        $mail->Username   = $smtpUser;
        $mail->Password   = $smtpPass;
        $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = (int)($site['smtp_port'] ?? 587);
        $mail->CharSet    = 'UTF-8';

        $mail->setFrom($smtpUser, $fromName);
        $mail->addAddress($to);
        $mail->addReplyTo($email, $name);

        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
        $sent = true;
    } catch (\Throwable $e) {
        error_log('SMTP error: ' . $e->getMessage());
    }
}

// --- Intento 2: mail() nativo (fallback, suele funcionar en cPanel) ---
if (!$sent && $to) {
    $headers  = "From: \"$fromName\" <no-reply@" . ($_SERVER['HTTP_HOST'] ?? 'localhost') . ">\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $sent = @mail($to, $subject, $body, $headers);
}

// --- Intento 3 (último recurso): guardar a log local para que no se pierda ---
if (!$sent) {
    $logDir = __DIR__ . '/data/_inbox';
    if (!is_dir($logDir)) @mkdir($logDir, 0755, true);
    $logFile = $logDir . '/' . date('Ymd_His') . '_' . substr(md5(uniqid('', true)), 0, 6) . '.txt';
    @file_put_contents($logFile, "Asunto: $subject\n\n$body");
}

redirect_back('ok');
