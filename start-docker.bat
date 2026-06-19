@echo off

title VernonEdu Docker Starter

echo ====================================
echo Starting VernonEdu Docker Services
echo ====================================

echo.
echo [1/4] Starting Docker Compose...
start cmd /k "docker compose up"

timeout /t 10 > nul

echo.
echo [2/4] Starting Vite...
start cmd /k "docker exec -it vernonedu-app sh -c \"npm install && npm run dev -- --host\""

timeout /t 5 > nul

echo.
echo [3/4] Starting Reverb...
start cmd /k "docker exec -it vernonedu-app php artisan reverb:start --host=0.0.0.0 --port=8080"

timeout /t 3 > nul

echo.
echo [4/4] Starting Queue Worker...
start cmd /k "docker exec -it vernonedu-app php artisan queue:work"

echo.
echo ====================================
echo VernonEdu Docker Environment Ready
echo ====================================

timeout /t 3 >nul
exit
