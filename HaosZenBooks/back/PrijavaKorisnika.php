<?php
    /**
     * Klasa PrijavaKorisnika obavlja poslove prijave korisnika, provere korisnickog imena i lozinke i odrzavanje sesije
     * @author Tanja
     */
    abstract class PrijavaKorisnika extends Helper {
        /**
         * Promenljiva u kojoj ce se cuvati informacije o prijavljenom korisniku
         */
        private static $prijavljeniKorisnik = NULL;

        /**
         * Funkcija vraca ID trenutno prijavljeno korisnika
         * @return int
         */
        public static function korisnikId() {
            return PrijavaKorisnika::$prijavljeniKorisnik['ID'];
        }

        /**
         * Funkcija ponistava stanje sesije
         */
        public static function ponistiSesiju() {
            unset($_SESSION);
            if (session_status() == PHP_SESSION_ACTIVE) session_destroy();
        }

        /**
         * Funkcija obnavlja kolacic sesije
         */
        public static function obnoviKolacicSesije() {
            if ( session_status() != PHP_SESSION_ACTIVE ) session_start();
            $_SESSION['korisnik']['poslednja_aktivnost'] = time();
            setcookie(session_name(), session_id(), time()+24*60*60);
            PrijavaKorisnika::$prijavljeniKorisnik = $_SESSION['korisnik'];
        }

        /**
         * Funkcija proverava podatke u sesiji. Ako postoji korisnik koji je prijavljen i ako je sesija validna.
         * @return boolean - Ako je sesija validna i korisnik prijavljen, funkcija vraca true, a u suprotnom vraca false;
         */
        public static function proveriSesiju() {
            if ( session_status() != PHP_SESSION_ACTIVE ) session_start();
            if ( isset($_SESSION['korisnik']) and is_array($_SESSION['korisnik']) ) {
                // Ako je vreme koje je proslo od poslednje aktivnosti korisnika manje od 24 sata, smatraj korisnika prijavljenim
                if ( time() - $_SESSION['korisnik']['poslednja_aktivnost'] < 24*60*60 ) {
                    PrijavaKorisnika::$prijavljeniKorisnik = $_SESSION['korisnik'];
                    PrijavaKorisnika::obnoviKolacicSesije();
                    // Vrati true
                    return true;
                }
            }

            // Ako provera podataka iz sesije nije uspela da pronadje adekvatnog korisnika, unistiti sesiju
            if ( PrijavaKorisnika::$prijavljeniKorisnik == NULL ) {
                PrijavaKorisnika::ponistiSesiju();
                return false;
            }
        }

        /**
         * Funkcija koja pokusava da izvrsi prijavu korisnika sa prilozenim korisnickim imenom i lozinkom (ako su ispravni i ako korisnik nema zabranu)
         * @param string $KorisnickoIme
         * @param string $Lozinka
         * @return boolean - Vraca true ako je korisnik uspesno prijavljen ili false ako nije uspesno prijavljen
         */
        public static function proveriPodatkeZaPrijavu($KorisnickoIme, $Lozinka) {
            $KorisnickoIme = MySQL::escape($KorisnickoIme);
            $Lozinka       = MySQL::escape($Lozinka);
            $sql = "select
                       ID, KorisnickoIme, AdminPrivilegije
                    from
                        Korisnik
                    where
                        KorisnickoIme = '{$KorisnickoIme}' and
                        Lozinka = '{$Lozinka}' and
                        ZabranaPrijave = 0
                    ";
            $niz = MySQL::upitUNiz($sql);
            if ( count($niz) ) {  
                session_start();
                $_SESSION['korisnik'] = $niz[0];
                PrijavaKorisnika::obnoviKolacicSesije();
                return true;
            } else {
                PrijavaKorisnika::ponistiSesiju();
                return false;
            }
        }

        /**
         * Vraca true ako je prijavljeni korisnik sa admin privilegijama ili false ako nije
         * @return boolean
         */
        public static function daLiImaAdminPrivilegije() {
            if ( isset($_SESSION['korisnik']) and isset($_SESSION['korisnik']['AdminPrivilegije']) ) {
                return ($_SESSION['korisnik']['AdminPrivilegije']!=0);
            } else {
                return 0;
            }
        }
    }
