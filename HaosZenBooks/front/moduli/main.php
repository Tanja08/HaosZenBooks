<?php
    /**
     * Glavni modul sajta
     * @author Tanja
     */
    abstract class main extends Modul {
        /**
         * Osnovni index emtod klase main koji se prvi izvrsava kada se otvori sajt
         */
        public static function index() {
            include_once 'front/templejti/main.index.php';
        }

        /**
         * Metod koji upravlja prijavom na sajtu
         */
        public static function prijava() {
            if ( !$_POST ) {
                @include_once 'front/templejti/main.prijava.php';
            } else {
                $KorisnickoIme = $_POST['KorisnickoIme'];
                $Lozinka       = $_POST['Lozinka'];

                sleep(2); // Namerno cekam 2 sekunde, da onemogucim brute force napad

                // Proveri da li su podaci za prijavu ispravni
                $status = PrijavaKorisnika::proveriPodatkeZaPrijavu($KorisnickoIme, $Lozinka);

                if (!$status) {
                    Funkcije::redirektujNaUrl("index.php?modul=main&opcija=prijava");
                } else {
                    Funkcije::redirektujNaUrl("index.php");
                }
            }
        }

        /**
         * Metod koji omogucava registraciju novog korisnickog naloga
         */
        public static function registracija() {
            if ( $_POST ) {
                $KorisnickoIme = $_POST['KorisnickoIme'];
                $Lozinka       = $_POST['Lozinka'];

                sleep(3); // Namerno cekam 3 sekunde, da onemogucim da neko napravi mnogo registrovanih naloga

                // Proveri da li je lozinka 6 i vise karaktera
                if ( strlen($Lozinka) < 6 ) {
                    $PORUKA = "Lozinka koju ste upisali nije ispravna. Lozina mora da ima najmanje 6 karaktera. Molimo Vas da pokušate ponovo.";
                } else {
                    // Proveri da li postoji korisnik sa definisanim korisnickim imenom
                    $postoji = Korisnici::daLiPostojiKorisnikSaKorisnicimImenom($KorisnickoIme);

                    if (!$postoji) {
                        // Ako metod dodajKorisnika iz klase Korisnici uspe da doda korisnika, preusmeri na prijavu uz signal registration_done
                        if ( Korisnici::dodajKorisnika($KorisnickoIme, $Lozinka) ) {
                            Funkcije::redirektujNaUrl("index.php?modul=main&opcija=prijava&signal=registration_done");
                        } else {
                            $PORUKA = "Došlo je do greške prilikom registracije. Molimo Vas da pokušate ponovo.";
                        }
                    } else {
                        $PORUKA = "Korisničko ime je već zauzeto. Molimo Vas da izaberete neko drugo.";
                    }
                }
            }

            @include_once 'front/templejti/main.registracija.php';
        }

        /**
         * Metod koji obezbedjuje funkciju odjave sa sajta
         */
        public static function odjava() {
            PrijavaKorisnika::ponistiSesiju();
            Funkcije::redirektujNaUrl("index.php?modul=main&opcija=prijava");
        }
    }
