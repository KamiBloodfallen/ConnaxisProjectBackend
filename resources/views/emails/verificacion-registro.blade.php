<!DOCTYPE html>
<html>
<head>
    <title>Registro de Cuenta</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            -webkit-text-size-adjust: none;
            -ms-text-size-adjust: none;
        }
        table {
            border-collapse: collapse;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #007bff;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 20px;
        }
        .content h2 {
            font-size: 20px;
            color: #333333;
        }
        .content p {
            font-size: 16px;
            color: #666666;
            line-height: 1.5;
        }
        .footer {
            background-color: #f4f4f4;
            color: #666666;
            text-align: center;
            padding: 20px;
            font-size: 14px;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
        }
        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <table class="container">
        <tr>
            <td class="header">
                <h1>¡Registro de Cuenta Exitoso!</h1>
            </td>
        </tr>
        <tr>
            <td class="content">
                <h2>Hola,</h2>
                <p>Tu cuenta ha sido registrada exitosamente.</p>
                <p>Gracias por registrarte en nuestro sitio. Estamos emocionados de tenerte a bordo. Por favor, haz clic en el siguiente botón para verificar tu correo electrónico y completar el proceso de registro.</p>
                <p style="text-align: center;">
                    <a href="#" class="button">Verificar Correo Electrónico</a>
                </p>
                <p>Si no puedes hacer clic en el botón, copia y pega el siguiente enlace en tu navegador:</p>
                <p style="word-break: break-all;">https://tu-dominio.com/verificar?token=your_verification_token</p>
                <p>Saludos,<br>El Equipo de Connaxis</p>
            </td>
        </tr>
        <tr>
            <td class="footer">
                <p>&copy; 2024 Connaxis. Todos los derechos reservados.</p>
            </td>
        </tr>
    </table>
</body>
</html>