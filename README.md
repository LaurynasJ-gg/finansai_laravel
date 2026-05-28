# Finansų programa

Naudojamos integracines programos:
 - PHP - programavimo kalba
 - Laravel - karkasas
 - Jetstream - autentifikacijai
 - Livewire - Ui
 - barryvdh/laravel-dompdf - PDF generavimas
 - mysql - phpmyadmin duomenų bazei
 - Vite - frontend 
 - Tailwind CSS - stiliai
 - chart.js - statisitinėms grafikams piešti

 ## PALEIDIMAS

 1. Klonuoti projektą 
 2. Įdiegti PHP priklausomybęs - `composer install`
 3. Sukonfigūruoti .env failą - `cp .env.example .env` ir jame pakeisti/nutrinti komentarus
 4. Paleisti migracijas
 5. Naudojant XAMPP paleisti `Apache, MySQL` serverius.
 6. Įdiegti node.js `npm install`
 7. Konfigūruoti email parametrus. (smtp)
 7. Paleisti serverį `php artisan serve`

 ## Projekto struktūra

 app/Http/Controllers/
        FinansaiController.php     # CRUD finansų įrašams
        KategorijaController.php   # CRUD kategorijoms
        SuvestineController.php    # Ataskaitos, PDF, el. paštas
    Models/
        Finansai.php               # Finansų įrašo modelis
        Kategorija.php             # Kategorijos modelis
database/
    migrations/                    # Duomenų bazės lentelių struktūra
resources/views/                   # Blade šablonai
routes/
    web.php                        # Visi maršrutai