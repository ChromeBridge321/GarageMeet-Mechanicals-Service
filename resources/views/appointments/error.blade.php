<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Error - GarageMeet</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 20px; background-color: #f8f9fa; }
        .container { max-width: 600px; margin: 0 auto; background-color: white; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .header { background-color: #dc3545; color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { padding: 30px; text-align: center; }
        .error-icon { font-size: 60px; color: #dc3545; margin-bottom: 20px; }
        .btn { display: inline-block; padding: 12px 25px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px; margin: 10px; }
        .btn:hover { background-color: #0056b3; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>GarageMeet</h1>
            <h2>Error al Procesar Solicitud</h2>
        </div>

        <div class="content">
            <div class="error-icon">❌</div>

            <h2>Oops! Algo salió mal</h2>

            <p><strong>{{ $message }}</strong></p>

            <p>Si este error persiste, por favor contacta directamente al taller o intenta agendar una nueva cita a través de la aplicación.</p>

            <div style="margin: 30px 0;">
                <a href="#" class="btn">📱 Abrir App</a>
                <a href="mailto:support@garagemeet.com" class="btn">📧 Contactar Soporte</a>
            </div>
        </div>
    </div>
</body>
</html>
