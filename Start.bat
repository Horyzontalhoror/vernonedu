@echo off
title VernonEdu Development Server

echo ================================
echo Menjalankan VernonEdu...
echo ================================

:: Jalankan Vite / NPM Dev
start cmd /k "npm run dev"

:: Jalankan Laravel Server
start cmd /k "php artisan serve"

:: Jalankan Laravel Reverb
start cmd /k "php artisan reverb:start"

echo ================================
echo Semua service berhasil dijalankan
echo ================================

pause
