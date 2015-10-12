<?php
    /**
     * Klasa Funkcije sadrzi u sebi najcesce koriscene funkcije
     * @author Tanja
     */
    abstract class Funkcije extends Helper {
        /**
         * Funkcija uklanja sve karaktere iz stringa koji nisu u grupi A-Z, a-z ili 0-9
         * @param string $string - String koji treba filtrirati
         * @return string
         */
        public static function procistiIme($string) {
            return preg_replace("/[^a-zA-Z0-9]/i", '', $string);
        }

        /**
         * Funkcija pretvara datum i vreme iz ISO standardnog zapisa (kakav vraca MySQL) u format definisan u podesavanja.php
         * @param string $isoDatumVreme - Zapis datuma i vremena u ISO standardnom zapisu
         * @return string
         */
        public static function formatirajDatumVreme($isoDatumVreme) {
            $unixDatumVreme = strtotime($isoDatumVreme);
            return date(SAJT_FORMAT_DATUMA, $unixDatumVreme);
        }
        
        /**
         * Funkcija za redirekciju korisnika na drugu adresu
         * @param string $url
         */
        public static function redirektujNaUrl($url) {
            ob_clean();                  // Ocisti sve sto je do sada ispisano u PHP-u
            header('Location: ' . $url); // Posalji u zaglavlju uputstvo za preusmerenje
            die();
        }

        /**
         * Funkcija koja prikazuje HTML zaglavlje sajta
         */
        public static function zaglavljeSajta() {
            include_once 'front/sajt/zaglavlje.php';
        }

        /**
         * Funkcija koja prikazuje glavni menu sajta
         */
        public static function glavniMenu() {
            include_once 'front/sajt/menu.php';
        }

        /**
         * Funkcija koja prikazuje HTML podnozje sajta
         */
        public static function podnozjeSajta() {
            include_once 'front/sajt/podnozje.php';
        }

        /**
         * Funkcija koja prikazuje print_r vrednost proslednjenog podatka, uokvirenog u <pre> tagove.
         * @param mixed $podaci
         */
        public static function ppr($podaci) {
            echo '<pre>';
            print_r($podaci);
            echo '</pre>';
        }

        /**
         * Funkcija koja proverava da li je sajtu upucen zajtev za login opciju glavnog modula sajta
         * @return boolean - Ako je upucen zahtev za login, vrace true, a u svim ostalim slucajevima vraca false
         */
        public static function daLiJeUpucenZahtevZaLoginFormular() {
            if ( !isset($_GET['modul']) or !isset($_GET['opcija']) ) return false;
            if ( Funkcije::procistiIme($_GET['modul']) != 'main' ) return false;
            if ( Funkcije::procistiIme($_GET['opcija']) != 'prijava' ) return false;
            return true;
        }
        
        /**
         * Funkcija koja proverava da li je sajtu upucen zajtev za opciju registracije glavnog modula sajta
         * @return boolean - Ako je upucen zahtev za registraciju, vrace true, a u svim ostalim slucajevima vraca false
         */
        public static function daLiJeUpucenZahtevZaFormularRegistracije() {
            if ( !isset($_GET['modul']) or !isset($_GET['opcija']) ) return false;
            if ( Funkcije::procistiIme($_GET['modul']) != 'main' ) return false;
            if ( Funkcije::procistiIme($_GET['opcija']) != 'registracija' ) return false;
            return true;
        }
    }
