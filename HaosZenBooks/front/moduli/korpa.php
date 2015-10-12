<?php
    /**
     * Modul korpe za kupovinu
     * @author Tanja
     */
    abstract class korpa extends Modul {
        /**
         * Osnovni index emtod klase korpa koji se prvi izvrsava kada se otvori stranica za prikaz sadrzaja korpe
         */
        public static function index() {
            include_once 'front/templejti/korpa.index.php';
        }

        /**
         * Metod koji uklanja jednu stavku iz korpe
         */
        public static function ukloni() {
            $Knjiga_ID = intval($_GET['Knjiga_ID']);
            KorpaZaKupovinu::ukloniJednuKnjigu($Knjiga_ID);
            Funkcije::redirektujNaUrl("index.php?modul=korpa");
        }

        /**
         * Metod kojim se izvrsava porucivanje i upis porudzbine u bazu
         */
        public static function poruci() {
            $podaci = KorpaZaKupovinu::podaciIzKorpe(); // Uzmi podatke o sadrzaju korpe
            
            if ( $podaci == 0 or !$_POST ) { // Ako je korpa prazna
                Funkcije::redirektujNaUrl("index.php?modul=korpa&signal=prazna_korpa"); // Uputi korisnika da to vidi
            } else {
                $Korisnik_ID = PrijavaKorisnika::korisnikId(); // Uzmi ID prijavljenog korisnika

                $Suma = 0; // Za izracunavanje ukupnog iznosa za uplatu za porudzbinu
                foreach ( $podaci as $item ) {
                    $SUMA += $item['Ukupno'];
                }

                $Porudzbina = MySQL::escape(json_encode($podaci)); // Pretvaranje svih podataka o porudzbini i JSON format za skladistenje

                $Ime_i_prezime = MySQL::escape($_POST['Ime_i_prezime']);
                $Adresa        = MySQL::escape($_POST['Adresa']);
                $Grad          = MySQL::escape($_POST['Grad']);
                $Telefon       = MySQL::escape($_POST['Telefon']);

                $sql = "INSERT INTO porudzbine (`Korisnik_ID`, `Porudzbina`, `Suma`, `Ime_i_prezime`, `Adresa`, `Grad`, `Telefon`)
                        VALUES ({$Korisnik_ID}, '{$Porudzbina}', $SUMA, '{$Ime_i_prezime}', '{$Adresa}', '{$Grad}', '{$Telefon}');";
                $res = MySQL::upit($sql); // Izvrsiti upis u bazu
                if ($res) {
                    KorpaZaKupovinu::isprazni();
                    Funkcije::redirektujNaUrl("index.php?modul=korpa&signal=uspesno_poruceno");
                } else {
                    Funkcije::redirektujNaUrl("index.php?modul=korpa&signal=greska");
                }
            }
        }
    }
