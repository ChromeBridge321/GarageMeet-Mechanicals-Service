#!/bin/bash

# Script de inicio para Coolify
echo "🚀 Iniciando GarageMeet Backend..."

# Esperar a que la base de datos esté disponible
echo "⏳ Esperando conexión a la base de datos..."
until php artisan migrate:status >/dev/null 2>&1; do
    echo "Esperando base de datos..."
    sleep 5
done

# Ejecutar migraciones
echo "📊 Ejecutando migraciones..."
php artisan migrate --force

# Limpiar y optimizar cache
echo "🧹 Optimizando aplicación..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Iniciar Apache
echo "✅ Iniciando servidor web..."
apache2-foreground
