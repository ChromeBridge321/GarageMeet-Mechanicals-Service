<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cita Cancelada - GarageMeet</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 20px; background-color: #f8f9fa; }
        .container { max-width: 600px; margin: 0 auto; background-color: white; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .header { background-color: #28a745; color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { padding: 30px; text-align: center; }
        .success-icon { font-size: 60px; color: #28a745; margin-bottom: 20px; }
        .appointment-details { background-color: #f8f9fa; padding: 20px; border-radius: 5px; margin: 20px 0; text-align: left; }
        .btn { display: inline-block; padding: 12px 25px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px; margin: 10px; }
        .btn:hover { background-color: #0056b3; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>GarageMeet</h1>
            <h2>Cita Cancelada Exitosamente</h2>
        </div>

        <div class="content">
            <div class="success-icon">✅</div>

            <h2>¡Tu cita ha sido cancelada!</h2>

            <p>Hemos recibido tu solicitud de cancelación y hemos procesado exitosamente la cancelación de tu cita.</p>

            <div class="appointment-details">
                <h3>Detalles de la cita cancelada:</h3>
                <p><strong>Cliente:</strong> {{ $appointment['client_name'] }}</p>
                <p><strong>Taller:</strong> {{ $appointment['workshop']['name'] }}</p>
                @if($appointment['appointment_date'])
                <p><strong>Fecha que tenías programada:</strong> {{ \Carbon\Carbon::parse($appointment['appointment_date'])->format('d/m/Y H:i') }}</p>
                @endif
                <p><strong>Descripción:</strong> {{ $appointment['description'] }}</p>
                <p><strong>Estado:</strong> <span style="color: #dc3545;">Cancelada</span></p>
            </div>

            <p>Se ha enviado una confirmación de cancelación a tu correo electrónico.</p>

            <div style="margin: 30px 0;">
                <h3>¿Necesitas agendar una nueva cita?</h3>
                <p>Puedes solicitar una nueva cita a través de nuestra pagina web cuando lo necesites.</p>

                <a href="#" class="btn">GarageMeet</a>

                <p style="margin-top: 20px;">
                    <strong>O contacta directamente al taller:</strong><br>
                    @if($appointment['workshop']['cellphone_number'])
                        📞 {{ $appointment['workshop']['cellphone_number'] }}<br>
                    @endif
                    @if($appointment['workshop']['email'])
                        📧 {{ $appointment['workshop']['email'] }}
                    @endif
                </p>
            </div>
        </div>
    </div>
</body>
</html>
