<?php
    /**
     * Tanja B.
     * Fakultet za informatiku i racunarstvo
     * Univerzitet Singidunum
     */

     // Podesavanja sajta i baze
    include_once 'podesavanja.php';

    // Osnovne klase sajta
    include_once 'back/Helpers.php';
    include_once 'back/Funkcije.php';
    include_once 'back/MySQL.php';
    include_once 'back/KorpaZaKupovinu.php';
    include_once 'back/Knjiga.php';
    include_once 'back/Korisnici.php';
    include_once 'back/PrijavaKorisnika.php';

    // Ako korisnik nije ulogovan i u ovom trenutku nije upucen zahtev za otvaranje formulara za prijavu, uputi korisnika na formular za prijavu
    if ( !PrijavaKorisnika::proveriSesiju() ) {
        if ( !Funkcije::daLiJeUpucenZahtevZaLoginFormular() and !Funkcije::daLiJeUpucenZahtevZaFormularRegistracije() ) {
            Funkcije::redirektujNaUrl("index.php?modul=main&opcija=prijava");
        }
    }

    Funkcije::zaglavljeSajta(); // Generisi HTML zaglavlje sajta
    Funkcije::glavniMenu();     // Generisi glavni menu sajta

    include_once "back/Modul.php"; // Ucitaj php sa osnovnom klasom modula

    $default_modul  = 'main';  // Default naziv modula
    $default_opcija = 'index'; // Default naziv opcije

    $modul = $default_modul;   // Podrazumevane vrednosti modula smestena u privremenu promenljivu
    $opcija = $default_opcija; // Podrazumevane vrednosti opcije smestena u privremenu promenljivu

    // Preuzimanje izabranog modula i opcije iz HTTP zahteva
    if ( isset($_GET['modul']) )  $modul  = Funkcije::procistiIme($_GET['modul']);
    if ( isset($_GET['opcija']) ) $opcija = Funkcije::procistiIme($_GET['opcija']);

    if ( !file_exists("front/moduli/" . $modul . ".php") ) { // Proveri da li postoji php fajl za izabrani modul
        $modul = $default_modul;                             // ako ne postoji, izaberi default modul
    }

    include_once "front/moduli/" . $modul . ".php"; // Ucitaj php fajl gde je definisana klasa modula

    // Proveri da li postoji metod sa izabranim imenom u klasi ucitanog modula, ako ne postoji, izaberi default opciju kao metod
    if ( !is_callable(array($modul, $opcija)) ) {
        $opcija = $default_opcija;
    }

    define('modul',  $modul);
    define('opcija', $opcija);

    $modul::before();  // Izvrsi funkciju before() pre bilo koje druge funkcije
    $modul::$opcija(); // Izvrsi izabranu opciju u izabranim modulu
    $modul::after();   // Izvrsi funkciju after() posle svih ostalih funkcija

    Funkcije::podnozjeSajta(); // Generisi podnozje sajta
