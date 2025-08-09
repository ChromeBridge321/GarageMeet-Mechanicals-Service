<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cita Cancelada</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #dc3545; color: white; padding: 20px; text-align: center; border-radius: 5px 5px 0 0; }
        .content { padding: 20px; background-color: #f8f9fa; border: 1px solid #dee2e6; }
        .appointment-details { background-color: white; padding: 15px; border-radius: 5px; margin: 15px 0; border-left: 4px solid #dc3545; }
        .status { padding: 5px 10px; border-radius: 3px; color: white; background-color: #dc3545; display: inline-block; }
        .footer { text-align: center; padding: 20px; color: #666; background-color: #f8f9fa; border-radius: 0 0 5px 5px; }
        .btn { display: inline-block; padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px; margin: 10px 5px; }
        .btn:hover { background-color: #0056b3; }
        .info-box { background-color: #d1ecf1; padding: 15px; border-radius: 5px; border: 1px solid #bee5eb; margin: 15px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ $appointment->workshop->name }}</h1>
            <h2>❌ Cita Cancelada</h2>
        </div>

        <div class="content">
            <p><strong>Hola {{ $appointment->client_name }},</strong></p>

            <p>Te confirmamos que tu cita ha sido <strong>cancelada exitosamente</strong>.</p>

            <div class="appointment-details">
                <h3>📋 Detalles de la Cita Cancelada</h3>
                <p><strong>Fecha que tenías programada:</strong>
                @if($appointment->appointment_date)
                    {{ $appointment->appointment_date->format('d/m/Y H:i') }}
                @else
                    Por asignar
                @endif
                </p>
                <p><strong>Taller:</strong> {{ $appointment->workshop->name }}</p>
                <p><strong>Problema reportado:</strong></p>
                <div style="background-color: #f8f9fa; padding: 10px; border-radius: 3px; margin: 10px 0;">
                    {{ $appointment->description }}
                </div>
                <p><strong>Estado:</strong>
                    <span class="status">❌ Cancelada</span>
                </p>
                <p><strong>Cancelada el:</strong> {{ now()->format('d/m/Y H:i') }}</p>
            </div>

            <div class="info-box">
                <strong>💡 ¿Cambio de planes?</strong><br>
                No te preocupes, puedes agendar una nueva cita cuando lo necesites a través de nuestra aplicación móvil.
            </div>

            <div style="text-align: center; margin: 20px 0;">
                <p><strong>¿Quieres agendar una nueva cita?</strong></p>
                <a href="#" class="btn">
                    📱 Abrir App
                </a>
                <p style="font-size: 12px; color: #666;">
                    O contacta directamente al taller
                </p>
            </div>
        </div>

        <div class="footer">
            <p><strong>{{ $appointment->workshop->name }}</strong></p>
            @if($appointment->workshop->cellphone_number)
            <p>📞 {{ $appointment->workshop->cellphone_number }}</p>
            @endif
            @if($appointment->workshop->email)
            <p>📧 {{ $appointment->workshop->email }}</p>
            @endif
            <p><em>Esperamos poder atenderte en una próxima ocasión.</em></p>
        </div>
    </div>
</body>
</html>
