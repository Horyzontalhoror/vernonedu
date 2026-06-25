@echo off
title VernonEdu Development Server

echo ================================
echo Menjalankan VernonEdu...
echo ================================

start "Vite Dev Server" cmd /c "npm run dev"
start "Laravel Server" cmd /c "php artisan serve"
start "Laravel Reverb" cmd /c "php artisan reverb:start"
start "Laravel Queue" cmd /c "php artisan queue:work"

echo ================================
echo Semua service berhasil dijalankan
echo ================================

timeout /t 3 >nul
exit
