<?php
// Simple contact form endpoint.
// IMPORTANT: This requires running on a PHP-enabled server (not file://, not VS Code Live Server).

header('Content-Type: text/plain; charset=UTF-8');

if (
    empty($_POST['name']) ||
    empty($_POST['subject']) ||
    empty($_POST['message']) ||
    empty($_POST['email']) ||
    !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)
) {
    http_response_code(400);
    echo "Invalid form data";
    exit();
}

$name = strip_tags(htmlspecialchars($_POST['name']));
$email = strip_tags(htmlspecialchars($_POST['email']));
$m_subject = strip_tags(htmlspecialchars($_POST['subject']));
$message = strip_tags(htmlspecialchars($_POST['message']));

// Basic protection against header injection
$email = str_replace(["\r", "\n"], '', $email);

$to = "espaciosdfr@gmail.com"; // Change this email to your
$subject = "$m_subject: $name";
$body =
    "Tienes un nuevo mensaje de tu formulario de contacto.\n\n" .
    "Aquí tienes los detalles:\n\n" .
    "Nombre: $name\n" .
    "Email: $email\n" .
    "Asunto: $m_subject\n\n" .
    "Mensaje:\n$message\n";

$headers = "From: $email\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

if (!mail($to, $subject, $body, $headers)) {
    http_response_code(500);
    echo "Mail server error";
    exit();
}

http_response_code(200);
echo "OK";
?>
