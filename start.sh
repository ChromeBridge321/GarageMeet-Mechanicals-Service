#!/bin/bash

# Script de inicio para Coolify
echo "🚀 Iniciando GarageMeet Backend..."

# Generar APP_KEY si no existe
if [ -z "$APP_KEY" ]; then
    echo "🔑 Generando APP_KEY..."
    php artisan key:generate --force
fi

# Intentar conectar a la base de datos con timeout
echo "⏳ Esperando conexión a la base de datos..."
max_attempts=30
attempt=1

while [ $attempt -le $max_attempts ]; do
    if php artisan migrate:status >/dev/null 2>&1; then
        echo "✅ Base de datos conectada exitosamente"
        break
    else
        echo "Intento $attempt/$max_attempts - Esperando base de datos..."
        sleep 5
        attempt=$((attempt + 1))
    fi
done

if [ $attempt -gt $max_attempts ]; then
    echo "❌ No se pudo conectar a la base de datos después de $max_attempts intentos"
    echo "⚠️ Iniciando Apache sin migraciones - revisar configuración de BD"
else
    # Ejecutar migraciones solo si hay conexión
    echo "📊 Ejecutando migraciones..."
    php artisan migrate --force
fi

# Limpiar y optimizar cache
echo "🧹 Optimizando aplicación..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Iniciar Apache
echo "✅ Iniciando servidor web en puerto 80..."
apache2-foreground
