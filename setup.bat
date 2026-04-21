@echo off
echo.
echo ===========================================
echo   INSTALLATION AUTOMATIQUE - L'FASSIA (PFA)   
echo ===========================================
echo.

:: 1. Copier le fichier .env si il n'existe pas
if not exist .env (
    echo [1/5] Creation du fichier de configuration .env...
    copy .env.example .env
    echo.
)

:: 2. Installer les dependances PHP (Composer)
echo [2/5] Installation des librairies (Composer install)...
echo (Cela peut prendre quelques minutes selon votre connexion...)
call composer install
echo.

:: 3. Generer la cle de securite
echo [3/5] Generation de la cle de securite unique...
php artisan key:generate
echo.

:: 4. Créer le lien pour les photos (CRITIQUE)
echo [4/5] Liaison du dossier des photos (Storage Link)...
php artisan storage:link
echo.

:: 5. Base de donnees (SQLite)
echo [5/5] Preparation de la base de donnees...
:: On s'assure que le fichier sqlite existe
if not exist database\database.sqlite (
    echo Creation du fichier database.sqlite...
    type nul > database\database.sqlite
)
echo Migration et ajout des accessoires (Seeding)...
php artisan migrate --seed
echo.

echo ===========================================
echo   INSTALLATION TERMINEE AVEC SUCCES !
echo.
echo   1. Lancez le serveur : php artisan serve
echo   2. Admirez le site sur : http://127.0.0.1:8000
echo ===========================================
pause
