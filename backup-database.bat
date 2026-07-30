@echo off
setlocal EnableExtensions
cd /d "%~dp0"

set "MYSQL_BIN=D:\xampp\mysql\bin"
set "DB_NAME=inventory_konstruksi"
set "DB_USER=root"
set "DB_PASS="

for /f "tokens=2 delims==." %%A in ('wmic os get LocalDateTime /value ^| findstr /i "LocalDateTime"') do set "ldt=%%A"
set "DATETIME=%ldt:~0,8%_%ldt:~8,6%"
set "OUTPUT=%~dp0backup_inventory_konstruksi_%DATETIME%.sql"

if not exist "%MYSQL_BIN%\mysqldump.exe" (
  echo ERROR: mysqldump.exe tidak ditemukan di %MYSQL_BIN%
  exit /b 1
)

if defined DB_PASS (
  "%MYSQL_BIN%\mysqldump.exe" -u"%DB_USER%" -p"%DB_PASS%" "%DB_NAME%" > "%OUTPUT%"
) else (
  "%MYSQL_BIN%\mysqldump.exe" -u"%DB_USER%" "%DB_NAME%" > "%OUTPUT%"
)

if errorlevel 1 (
  echo ERROR: backup gagal.
  exit /b 1
)

echo Backup berhasil disimpan di "%OUTPUT%"
echo.
endlocal
