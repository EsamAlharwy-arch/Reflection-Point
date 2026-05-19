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
php artisan qrvault:start

echo.
echo Server stopped. Press any key to exit.
pause >nul
