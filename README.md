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

1. app/Http/Controllers/  <br>
-------- FinansaiController.php     # CRUD finansų įrašams<br>
-------- KategorijaController.php   # CRUD kategorijoms<br>
-------- SuvestineController.php    # Ataskaitos, PDF, el. paštas<br>
2.  Models/ <br>
-------- Finansai.php               # Finansų įrašo modelis<br>
-------- Kategorija.php             # Kategorijos modelis<br>
3. database/  <br>
-------- migrations/                   # Duomenų bazės lentelių struktūra<br>
4. resources/views/     <br>                 # Blade šablonai<br>
5. routes/ <br>
-------- web.php                     # Visi maršrutai<br>

    