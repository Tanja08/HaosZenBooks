<?php
    /**
     * MySQL klasa se koristi za povezivanje sa bazom podataka
     * @author Tanja
     */
    abstract class MySQL {
        /**
         * Staticka promenljiva u kojoj se cuva konekcija ka MySQL serveru.
         */
        private static $mysql_konekcija = NULL;

        /**
         * Funkcija koja uspostavlja MySQL konekciju ukoliko nije ostvarena, a ako vec postoji konekcija, ne radi nista.
         */
        private static function konekcija() {
            if ( MySQL::$mysql_konekcija == NULL ) {
                MySQL::$mysql_konekcija = @mysql_connect(BAZA_SERVER, BAZA_KORISNIK, BAZA_LOZINKA) or die('Neuspela veza sa MySQL serverom.');
                @mysql_query('SET NAMES UTF8');
                @mysql_query('SET COLLATION_CONNECTION=utf8_unicode_ci');
                @mysql_select_db(BAZA_IME_BAZE) or die('Neuspela konekcija sa bazom podataka aplikacije.');
            }
        }

        /**
         * Funkcija izvrsava MySQL upit i vraca rezultat upita.
         * @param string $mysql_upit - MySQL upit koji treba da bude izvrsen
         * @return #resource - Rezultat izvrsavanja upita
         */
        public static function upit($mysql_upit) {
            MySQL::konekcija();
            return @mysql_query($mysql_upit);
        }

        /**
         * Funkcija koja izvrsava MySQL upit i vraca niz asocijativnih nizova sa rezultatima upita
         * @param string $mysql_upit - MySQL upit koji treba da bude izvrsen
         * @return array - Niz asocijativnih nizova sa rezultatima upita
         */
        public static function upitUNiz($mysql_upit) {
            MySQL::konekcija();
            $rezultat = @mysql_query($mysql_upit);
            $niz = array();
            if ( !$rezultat or mysql_num_rows($rezultat) == 0 ) return $niz;
            while ( $red = mysql_fetch_assoc($rezultat) ) {
                $niz[] = $red;
            }
            mysql_free_result($rezultat);
            return $niz;
        }

        /**
         * Funkcija koja vrsi MySQL escape stringa - osnovna zastita od SQL injection napada
         * @param string $string - String koji treba escape-ovati
         * @return string - MySQL escape-ovan string
         */
        public static function escape($string) {
            MySQL::konekcija();
            return mysql_real_escape_string($string, MySQL::$mysql_konekcija);
        }
        
        /**
         * Funkcija koja vraca ID poslednjeg dodatog zapisa u bazu.
         */
        public static function poslednjiID() {
            return @mysql_insert_id(MySQL::$mysql_konekcija);
        }
        
        /**
         * Funkcija obustavlja vezu ka MySQL serveru.
         */
        public static function prekidKonekcije() {
            @mysql_close(MySQL::$mysql_konekcija);
        }
    }
