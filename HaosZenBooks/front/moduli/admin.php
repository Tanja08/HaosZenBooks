<?php
    /**
     * Modul admin panela
     * @author Tanja
     */
    abstract class admin extends Modul {
		/**
		 * Privatni metod koji priprema spisak dostupnih kategorija knjiga
		 */
		private static function kategorije() {
            return MySQL::upitUNiz("SELECT * FROM kategorija ORDER BY Naziv");
		}

        /**
         * Osnovni index metod klase admin koji se prvi izvrsava kada se otvori admin panel, ali samo ako je korisnik admin
         */
        public static function index() {
            if ( PrijavaKorisnika::daLiImaAdminPrivilegije() ) {
                $sql = "SELECT
                            k.*
                        FROM
                            knjiga k
                        ORDER BY
                            k.id ASC";
                $knjige = MySQL::upitUNiz($sql);
                include_once 'front/templejti/admin.index.php';
            } else {
                Funkcije::redirektujNaUrl("index.php");
            }
        }

		/**
		 * Funkcija za brisanje knjige iz baze
		 */
		public static function obrisi() {
			if ( PrijavaKorisnika::daLiImaAdminPrivilegije() ) {
				$Knjiga_ID = intval($_GET['Knjiga_ID']);
                MySQL::upit("DELETE FROM knjiga WHERE ID = {$Knjiga_ID};");
				MySQL::upit("DELETE FROM kategorija_knjiga WHERE Knjiga_ID = '{$Knjiga_ID}';");
                Funkcije::redirektujNaUrl("index.php?modul=admin&signal=obrisano");
            } else {
                Funkcije::redirektujNaUrl("index.php");
            }
		}

		/**
		 * Funkcija za izmenu podataka o knjizi
		 */
		public static function izmeni() {
			if ( PrijavaKorisnika::daLiImaAdminPrivilegije() ) {
				$Knjiga_ID = intval($_GET['Knjiga_ID']);
				if ( $_POST ) {
					$OriginalniNaslov = MySQL::escape($_POST['OriginalniNaslov']);
					$PrevodNaslova    = MySQL::escape($_POST['PrevodNaslova']);
					$BrojStrana       = intval($_POST['BrojStrana']);
					$ISBN             = MySQL::escape($_POST['ISBN']);
					$Godina           = intval($_POST['Godina']);
					$Cena             = floatval($_POST['Cena']);

					$Kategorije		  = array_values($_POST['Kategorije']);

					$sql = "UPDATE
								knjiga
							SET
								OriginalniNaslov = '{$OriginalniNaslov}',
								PrevodNaslova = '{$PrevodNaslova}',
								BrojStrana = '{$BrojStrana}',
								ISBN = '{$ISBN}',
								Godina = '{$Godina}',
								Cena = '{$Cena}'
							WHERE
								ID = {$Knjiga_ID};";
					MySQL::upit($sql);

					MySQL::upit("DELETE FROM kategorija_knjiga WHERE Knjiga_ID = '{$Knjiga_ID}';");

					$sql = "INSERT INTO kategorija_knjiga VALUES ";
					$pairs = array();
					foreach ($Kategorije as $Kategorija_ID) {
						$Kategorija_ID = intval($Kategorija_ID);
						$pairs[] = "('{$Kategorija_ID}', '{$Knjiga_ID}')";
					}
					$sql .= implode(',', $pairs);
					MySQL::upit($sql);

					Funkcije::redirektujNaUrl("index.php?modul=admin");
				} else {
					$sql = "SELECT
								k.*
							FROM
								knjiga k
							WHERE
								k.ID = {$Knjiga_ID};";
					$knjige = MySQL::upitUNiz($sql);
					if ( count($knjige) ) {
						$knjiga = $knjige[0];

						$knjiga_kategorije = array();
						$items = MySQL::upitUNiz("SELECT Kategorija_ID FROM kategorija_knjiga WHERE Knjiga_ID = '{$Knjiga_ID}';");
						foreach ( $items as $item ) {
							$knjiga_kategorije[] = intval($item['Kategorija_ID']);
						}

						$kategorije = admin::kategorije();
						include_once 'front/templejti/admin.izmeni.php';
					} else {
						Funkcije::redirektujNaUrl("index.php?modul=admin&signal=nepostojeca");
					}
				}
            } else {
                Funkcije::redirektujNaUrl("index.php");
            }
		}

		/**
		 * Funkcija za dodavanje nove njige
		 */
		public static function dodaj() {
			if ( PrijavaKorisnika::daLiImaAdminPrivilegije() ) {
				if ( $_POST ) {
					$OriginalniNaslov = MySQL::escape($_POST['OriginalniNaslov']);
					$PrevodNaslova    = MySQL::escape($_POST['PrevodNaslova']);
					$BrojStrana       = intval($_POST['BrojStrana']);
					$ISBN             = MySQL::escape($_POST['ISBN']);
					$Godina           = intval($_POST['Godina']);
					$Cena             = floatval($_POST['Cena']);

					$Kategorije		  = array_values($_POST['Kategorije']);

					$sql = "INSERT INTO knjiga (OriginalniNaslov, PrevodNaslova, BrojStrana, ISBN, Godina, Cena) VALUES
							('{$OriginalniNaslov}', '{$PrevodNaslova}', '{$BrojStrana}', '{$ISBN}', '{$Godina}', '{$Cena}');";
					MySQL::upit($sql);
					$Knjiga_ID = MySQL::poslednjiId();

					$sql = "INSERT INTO kategorija_knjiga VALUES ";
					$pairs = array();
					foreach ($Kategorije as $Kategorija_ID) {
						$Kategorija_ID = intval($Kategorija_ID);
						$pairs[] = "('{$Kategorija_ID}', '{$Knjiga_ID}')";
					}
					$sql .= implode(',', $pairs);
					MySQL::upit($sql);

					Funkcije::redirektujNaUrl("index.php?modul=admin");
				} else {
					$kategorije = admin::kategorije();
					include_once 'front/templejti/admin.dodaj.php';
				}
            } else {
                Funkcije::redirektujNaUrl("index.php");
            }
		}

		/**
		 * Funkcija za rad sa komentarima
		 */
		public static function komentari() {
			if ( PrijavaKorisnika::daLiImaAdminPrivilegije() ) {
				$sql = "SELECT
							k.ID,
							k.DatumVreme,
							k.Tekst,
							knjiga.OriginalniNaslov Knjiga,
							korisnik.KorisnickoIme Korisnik
						FROM
							komentar k
							INNER JOIN knjiga ON k.Knjiga_ID = knjiga.ID
							INNER JOIN korisnik ON k.Korisnik_ID = korisnik.ID
						WHERE
							k.Odobren = 0;";
				$komentari = MySQL::upitUNiz($sql);
				include_once 'front/templejti/admin.komentari.php';
            } else {
                Funkcije::redirektujNaUrl("index.php");
            }
		}

		/**
		 * Funkcija za brisanje komentara iz baze podataka
		 */
		public static function obrisikomentar() {
			if ( PrijavaKorisnika::daLiImaAdminPrivilegije() ) {
				$Komentar_ID = intval($_GET['Komentar_ID']);
				MySQL::upit("DELETE FROM komentar WHERE ID = '{$Komentar_ID}';");
				Funkcije::redirektujNaUrl("index.php?modul=admin&opcija=komentari&signal=obrisan");
            } else {
                Funkcije::redirektujNaUrl("index.php");
            }
		}

		/**
		 * Funkcija za odobravanje komentara iz baze podataka
		 */
		public static function odobrikomentar() {
			if ( PrijavaKorisnika::daLiImaAdminPrivilegije() ) {
				$Komentar_ID = intval($_GET['Komentar_ID']);
				MySQL::upit("UPDATE komentar SET odobren = 1 WHERE ID = '{$Komentar_ID}';");
				Funkcije::redirektujNaUrl("index.php?modul=admin&opcija=komentari&signal=odobren");
            } else {
                Funkcije::redirektujNaUrl("index.php");
            }
		}
    }
