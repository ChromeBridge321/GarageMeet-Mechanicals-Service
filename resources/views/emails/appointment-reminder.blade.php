<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Recordatorio de Cita</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #ffc107; color: #212529; padding: 20px; text-align: center; border-radius: 5px 5px 0 0; }
        .content { padding: 20px; background-color: #f8f9fa; border: 1px solid #dee2e6; }
        .appointment-details { background-color: white; padding: 15px; border-radius: 5px; margin: 15px 0; border-left: 4px solid #ffc107; }
        .status { padding: 5px 10px; border-radius: 3px; color: white; background-color: #28a745; display: inline-block; }
        .footer { text-align: center; padding: 20px; color: #666; background-color: #f8f9fa; border-radius: 0 0 5px 5px; }
        .btn { display: inline-block; padding: 10px 20px; background-color: #dc3545; color: white; text-decoration: none; border-radius: 5px; margin: 10px 5px; }
        .btn:hover { background-color: #c82333; }
        .reminder-box { background-color: #fff3cd; padding: 20px; border-radius: 5px; border: 2px solid #ffc107; margin: 15px 0; text-align: center; }
        .date-highlight { background-color: #d4edda; padding: 15px; border-radius: 5px; text-align: center; margin: 15px 0; border: 2px solid #28a745; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ $appointment->workshop->name }}</h1>
            <h2>⏰ Recordatorio de Cita</h2>
        </div>

        <div class="content">
            <p><strong>Hola {{ $appointment->client_name }},</strong></p>

            <div class="reminder-box">
                <h2>🔔 ¡No olvides tu cita!</h2>
                <p><strong>Tu cita es MAÑANA</strong></p>
            </div>

            <div class="date-highlight">
                <h3>📅 Detalles de tu Cita</h3>
                <h2 style="color: #28a745; margin: 10px 0;">
                    {{ $appointment->appointment_date->format('l, d \d\e F \d\e Y') }}
                </h2>
                <h2 style="color: #28a745; margin: 10px 0;">
                    {{ $appointment->appointment_date->format('H:i') }} hrs
                </h2>
            </div>

            <div class="appointment-details">
                <h3>📋 Información de tu Cita</h3>
                <p><strong>Taller:</strong> {{ $appointment->workshop->name }}</p>
                <p><strong>Dirección:</strong> {{ $appointment->workshop->address ?? 'Por confirmar' }}</p>
                <p><strong>Teléfono del taller:</strong> {{ $appointment->workshop->cellphone_number ?? 'No disponible' }}</p>
                <p><strong>Tu problema reportado:</strong></p>
                <div style="background-color: #f8f9fa; padding: 10px; border-radius: 3px; margin: 10px 0;">
                    {{ $appointment->description }}
                </div>
                <p><strong>Estado:</strong>
                    <span class="status">✅ Confirmada</span>
                </p>
                @if($appointment->notes)
                <p><strong>Notas del taller:</strong></p>
                <div style="background-color: #e7f3ff; padding: 10px; border-radius: 3px; margin: 10px 0;">
                    {{ $appointment->notes }}
                </div>
                @endif
            </div>

            <div style="background-color: #e7f3ff; padding: 15px; border-radius: 5px; margin: 15px 0;">
                <strong>📝 Recordatorios importantes:</strong><br>
                • Llega 10 minutos antes de tu cita<br>
                • Trae tu identificación y documentos del vehículo<br>
                • Ten lista una descripción detallada del problema<br>
                • El taller registrará tus datos en el momento
            </div>

            <div style="text-align: center; margin: 20px 0;">
                <p><strong>¿Necesitas cancelar o reprogramar?</strong></p>
                <a href="{{ $cancellationUrl }}" class="btn">
                    ❌ Cancelar Cita
                </a>
                <p style="font-size: 12px; color: #666;">
                    También puedes contactar directamente al taller:<br>
                    {{ $appointment->workshop->cellphone_number ?? 'Ver datos de contacto abajo' }}
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
            <p><em>¡Te esperamos mañana! Gracias por confiar en nosotros.</em></p>
        </div>
    </div>
</body>
</html>
