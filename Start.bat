@echo off
title VernonEdu Development Server

echo ================================
echo Menjalankan VernonEdu...
echo ================================

:: Jalankan Vite / NPM Dev
start "Vite Dev Server" cmd /c "npm run dev"

:: Jalankan Laravel Server
start "Laravel Server" cmd /c "php artisan serve"

:: Jalankan Laravel Reverb
start "Laravel Reverb" cmd /c "php artisan reverb:start"

echo ================================
echo Semua service berhasil dijalankan
echo ================================

timeout /t 3 >nul
exit
