@echo off
title QRVault Secure Server
color 0A

echo ===================================================
echo               Starting QRVault System
echo ===================================================
echo.
echo Please wait while we detect your network settings...
echo.

cd /d "%~dp0"

:: 1. Check if global php works
php -v >nul 2>&1
if %errorlevel% equ 0 (
    php artisan qrvault:start
    goto end
)

:: 2. Check default XAMPP location on different drives
if exist "C:\xampp\php\php.exe" (
    "C:\xampp\php\php.exe" artisan qrvault:start
    goto end
)
if exist "D:\xampp\php\php.exe" (
    "D:\xampp\php\php.exe" artisan qrvault:start
    goto end
)
if exist "E:\xampp\php\php.exe" (
    "E:\xampp\php\php.exe" artisan qrvault:start
    goto end
)

:: 3. If neither works, show error
echo.
echo ===================================================
echo ERROR: PHP was not found on this system.
echo ===================================================
echo Please ensure XAMPP is installed in the default directory (C:\xampp)
echo or add the PHP folder path to your Windows Environment Variables (PATH).
echo.

:end
echo.
echo Server stopped. Press any key to exit.
pause >nul
