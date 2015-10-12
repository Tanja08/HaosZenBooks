<?php
    /**
     * Klasa za rad sa korisnicima u bazi podataka
     * @author Tanja
     */
    abstract class Korisnici extends HelperBaze {
        /**
         * Metod koji vraca true ako postoji korisnik sa trazenim korisnickim imenom i false ako ne postoji
         * @param string $korisnickoIme Korisnicko ime koje se proverava
         * @return boolean
         */
        public static function daLiPostojiKorisnikSaKorisnicimImenom($korisnickoIme) {
            $korisnickoIme = MySQL::escape($korisnickoIme);
            $data = MySQL::upitUNiz("SELECT COUNT(id) broj FROM korisnik WHERE KorisnickoIme = '{$korisnickoIme}'");
            if ( count($data) ) {
                $broj = $data[0]['broj'];
                if ( $broj > 0 ) return true;
                else return false;
            } else return false;
        }

        /**
         * Metod koji kreira u bazi novog korisnika sa definisanim korisnickim imenom i lozinkom
         * @param type $korisnickoIme
         * @param type $lozinka
         * @return boolean Da li je dodavanje uspesno izvrseno
         */
        public static function dodajKorisnika($korisnickoIme, $lozinka) {
            $korisnickoIme = MySQL::escape($korisnickoIme);
            $lozinka       = MySQL::escape($lozinka);
            return MySQL::upit("INSERT INTO korisnik (`KorisnickoIme`, `Lozinka`, `ZabranaPrijave`) VALUES ('{$korisnickoIme}', '{$lozinka}', 0);");
        }
    }
