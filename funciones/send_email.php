<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Datos del formulario
    $nombre = htmlspecialchars($_POST['nombre']);
    $correo = htmlspecialchars($_POST['correo']);
    $numero = htmlspecialchars($_POST['numero']);
    $asunto = htmlspecialchars($_POST['asunto']);
    $mensaje = htmlspecialchars($_POST['mensaje']);
    
    // Email destino
    $to = 'contacto@elclubdelverso.com';
    
    // Asunto del correo
    $subject = "Nuevo mensaje de: $nombre";
    
    // Cuerpo del mensaje en HTML con estilos inline
    $body = '
    <html>
    <head>
        <meta charset="UTF-8">
    </head>
    <body style="background-color: #000; color: #fff; font-family: Arial, sans-serif; position: relative; padding: 20px;">
        <div style="position: relative; z-index: 1;">
            <h1 style="color: #fff;">Nuevo mensaje de: ' . $nombre . '</h1>
            <p><strong>Correo:</strong> ' . $correo . '</p>
            <p><strong>Número:</strong> ' . $numero . '</p>
            <p><strong>Asunto:</strong> ' . $asunto . '</p>
            <p><strong>Mensaje:</strong></p>
            <p>' . nl2br($mensaje) . '</p>
        </div>
        <!-- Imagen como marca de agua -->
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: -1;">
            <img src="https://www.elclubdelverso.com/wp-content/uploads/2023/04/cropped-logo_home-95x110.png" alt="Logo" style="opacity: 0.1; width: 400px;">
        </div>
    </body>
    </html>';
    
    // Encabezados del correo
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: $correo\r\n";
    $headers .= "Reply-To: $correo\r\n";
    
    // Enviar el correo
    if (mail($to, $subject, $body, $headers)) {
        echo "El mensaje ha sido enviado correctamente.";
        header("Location: ../contacto.html?melo=El mensaje ha sido enviado correctamentes");
    } else {
        echo "Hubo un error al enviar el mensaje. Inténtalo nuevamente.";
        header("Location: ../contacto.html?error=Hubo un error al enviar el mensaje. Inténtalo nuevamente");
    }
} else {
    echo "Solicitud no válida.";
}
?>
