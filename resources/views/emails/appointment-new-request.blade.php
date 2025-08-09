<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nueva Solicitud de Cita</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #007bff; color: white; padding: 20px; text-align: center; border-radius: 5px 5px 0 0; }
        .content { padding: 20px; background-color: #f8f9fa; border: 1px solid #dee2e6; }
        .appointment-details { background-color: white; padding: 15px; border-radius: 5px; margin: 15px 0; border-left: 4px solid #007bff; }
        .status { padding: 5px 10px; border-radius: 3px; color: white; background-color: #ffc107; display: inline-block; }
        .footer { text-align: center; padding: 20px; color: #666; background-color: #f8f9fa; border-radius: 0 0 5px 5px; }
        .btn { display: inline-block; padding: 10px 20px; background-color: #28a745; color: white; text-decoration: none; border-radius: 5px; margin: 10px 5px; }
        .btn:hover { background-color: #218838; }
        .alert { padding: 15px; margin: 15px 0; border-radius: 5px; background-color: #fff3cd; border: 1px solid #ffeaa7; color: #856404; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ $appointment->workshop->name }}</h1>
            <h2>📅 Nueva Solicitud de Cita</h2>
        </div>

        <div class="content">
            <p><strong>¡Hola!</strong></p>

            <p>Has recibido una nueva solicitud de cita a través de la aplicación móvil.</p>

            <div class="appointment-details">
                <h3>📋 Detalles de la Solicitud</h3>
                <p><strong>Cliente:</strong> {{ $appointment->client_name }}</p>
                <p><strong>Email:</strong> {{ $appointment->client_email }}</p>
                <p><strong>Teléfono:</strong> {{ $appointment->client_phone }}</p>
                <p><strong>Descripción del problema:</strong></p>
                <div style="background-color: #f8f9fa; padding: 10px; border-radius: 3px; margin: 10px 0;">
                    {{ $appointment->description }}
                </div>
                <p><strong>Estado:</strong>
                    <span class="status">⏳ Pendiente de confirmación</span>
                </p>
                <p><strong>Solicitada el:</strong> {{ $appointment->created_at->format('d/m/Y H:i') }}</p>
            </div>

            <div class="alert">
                <strong>💡 Próximos pasos:</strong><br>
                1. Revisa la solicitud<br>
                2. Asigna una fecha y hora disponible<br>
                3. Confirma la cita desde tu dashboard<br>
                4. El cliente será notificado automáticamente
            </div>

            <div style="text-align: center; margin: 20px 0;">
                <a href="{{ url('/dashboard/appointments') }}" class="btn">
                    🔧 Ir al Dashboard
                </a>
            </div>
        </div>

        <div class="footer">
            <p><strong>{{ $appointment->workshop->name }}</strong></p>
            <p>Sistema de Gestión de Citas - GarageMeet</p>
            <p><em>Este es un mensaje automático, por favor no responder directamente.</em></p>
        </div>
    </div>
</body>
</html>
