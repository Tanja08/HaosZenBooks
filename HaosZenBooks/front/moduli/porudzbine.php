<?php
    /**
     * Modul porudzbine za administratora
     * @author Tanja
     */
    abstract class porudzbine extends Modul {
        /**
         * Osnovni index metod klase porudzbine koji se prvi izvrsava kada se otvori stranica ali samo ako je korisnik admin
         */
        public static function index() {
            if ( PrijavaKorisnika::daLiImaAdminPrivilegije() ) {
                if ( isset($_GET['realizovane']) ) $Realizovane = 1;
                else $Realizovane = 0;

                $sql = "SELECT
                            p.*
                        FROM
                            porudzbine p
                        WHERE
                            p.Realizovana = {$Realizovane}
                        ORDER BY
                            p.DatumVreme DESC";
                $porudzbine = MySQL::upitUNiz($sql);
                include_once 'front/templejti/porudzbine.index.php';
            } else {
                Funkcije::redirektujNaUrl("index.php");
            }
        }

        /**
         * Metod kojim administrator obelezava da je neka porudzbina uspesno realizovana. Moze da se pokrene samo ako je prijavljeni korisnik admin
         */
        public static function realizuj() {
            if ( PrijavaKorisnika::daLiImaAdminPrivilegije() ) {
                $Porudzbina_ID = intval($_GET['Porudzbina_ID']);
                MySQL::upit("UPDATE porudzbine SET Realizovana = 1 WHERE ID = {$Porudzbina_ID}");
                Funkcije::redirektujNaUrl("index.php?modul=porudzbine");
            } else {
                Funkcije::redirektujNaUrl("index.php");
            }
        }
    }
