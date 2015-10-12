<?php
    /**
     * Klasa koja obavelj funkcije urpavaljanja korpom za aktivnu sesiju korisnika
     * @author Tanja
     */
    abstract class KorpaZaKupovinu extends Helper {
        /**
         * Metod koji dodaje knjigu u korpu
         * @param int $Knjiga_ID
         */
        public static function dodajKnjigu($Knjiga_ID) {
            if ( !isset($_SESSION['KORPA']) ) $_SESSION['KORPA'] = array(); // Ako korpa ne postoji, napravi je
            if ( !isset($_SESSION['KORPA'][$Knjiga_ID]) ) $_SESSION['KORPA'][$Knjiga_ID] = 1; // Ako nema knjige u korpi, neka bude 1
            else $_SESSION['KORPA'][$Knjiga_ID]++; // A ako vec ima barem jedna, povecaj broj knjiga za jednu vise
        }

        /**
         * Metod koji uklanja knjigu iz korpe
         * @param int $Knjiga_ID
         */
        public static function ukloniJednuKnjigu($Knjiga_ID) {
            if ( !isset($_SESSION['KORPA']) ) return; // Ako je korpa prazna, zavrsi metod, jer nema sta da se radi
            if ( !isset($_SESSION['KORPA'][$Knjiga_ID]) ) return; // Ako knjiga nije ni dodata, zavrsi metod, jer nema sta da se ukloni
            else $_SESSION['KORPA'][$Knjiga_ID]--; // A ako vec ima barem jedna, smanji broj knjiga za jednu

            if ( $_SESSION['KORPA'][$Knjiga_ID] <= 0 ) { // Ako se ispostavi da smo uklonili i poslednju knjigu iz grupe
                unset($_SESSION['KORPA'][$Knjiga_ID]); // Ukloni grupu iz korpe
            }
        }

        /**
         * Metod koji vraca broj stavki u korpi
         * @return int
         */
        public static function brojStavkiUKorpi() {
            if ( isset($_SESSION['KORPA']) ) {
                return count($_SESSION['KORPA']);
            } else {
                return 0;
            }
        }

        /**
         * Metod koji vraca niz ciji su elementi asocijativni nizovi sa elementima Knjiga, Broj i Ukupno.
         * Knjiga je asocijativni niz koji predstavlja podatke o knjizi.
         * Broj je ukupan broj u korpi za datu knjigu.
         * Ukupno je ukupna cena za datu knjigu (cena * broj tih knjiga).
         * @return array
         */
        public static function podaciIzKorpe() {
            if ( !isset($_SESSION['KORPA']) ) return array(); // Ako je korpa prazna, vrati prazan niz

            $podaci = array();
            foreach ( $_SESSION['KORPA'] as $Knjiga_ID => $Broj_Knjiga ) {
                $Knjiga = Knjiga::podaci($Knjiga_ID);
                $podaci[] = array(
                    "Knjiga" => $Knjiga,
                    "Broj"   => $Broj_Knjiga,
                    "Ukupno" => $Knjiga['Knjiga']['Cena'] * $Broj_Knjiga
                );
            }

            return $podaci;
        }

        /**
         * Metod koji prazni korpu
         */
        public static function isprazni() {
            unset($_SESSION['KORPA']);
        }
    }
