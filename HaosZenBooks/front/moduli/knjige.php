<?php
    /**
     * Modul za rad sa kategorijama i prelistavanje knjiga po kategorijama
     * @author Tanja
     */
    abstract class knjige extends Modul {
        /**
         * Naziv klase koji treba da bude dodat pored klase modul u <div> bloku koji okruzuje sadrzaj ovog modula
         * @var string
         */
        public static $css_klasa = "knjige";

        /**
         * Funkcija koja vraca spisak svih kategorija kao asocijativni niz
         * @return array
         */
        protected static function _kategorije() {
            $sql = "select * from Kategorija order by Naziv asc";
            return MySQL::upitUNiz($sql);
        }
        
        /**
         * Funkcija koja vraca spisak svih autora kao asocijativni niz
         * @return array
         */
        protected static function _autori() {
            $sql = "select * from Autor order by ImePrezime asc";
            return MySQL::upitUNiz($sql);
        }

        /**
         * Funkcija koja vraca naziv kategorije za odredjeni ID ako se nalazi u asocijativnom nizu kategorija
         * @param array $kategorije - Asocijativni niz kategorija kakav vraca funkcija _kategorije()
         * @param int $id - ID kategorije ciji naziv treba vratiti
         * @return string
         */
        protected static function _naziv_kategorije_za_id(&$kategorije, &$id) {
            foreach ( $kategorije as $kategorija ) {
                if ( $kategorija['ID'] == $id ) {
                    return $kategorija['Naziv'];
                }
            }
            return '';
        }

        /**
         * Privatna funkcija koja vrsi pretragu knjiga sa zadatim parametrima i salje rezultat pretrage templejtu za prikaz
         */
        private static function _pretraga() {
            $kategorije = knjige::_kategorije();
            $autori     = knjige::_autori();

            if ( isset($_GET['Kategorija_ID']) and intval($_GET['Kategorija_ID']) != 0 ) {
                $Kategorija_ID = intval($_GET['Kategorija_ID']);
                $sql_Kategorija_ID_klauzula = "and kk.Kategorija_ID = {$Kategorija_ID}";
            } else {
                $sql_Kategorija_ID_klauzula = '';
            }
            
            if ( isset($_GET['Autor_ID']) and intval($_GET['Autor_ID']) != 0 ) {
                $Autor_ID = intval($_GET['Autor_ID']);
                $sql_Autor_ID_klauzula = "and ak.Autor_ID = {$Autor_ID}";
            } else {
                $sql_Autor_ID_klauzula = '';
            }

            if ( isset($_GET['KljucnaRec']) and strlen($_GET['KljucnaRec']) > 1 ) {
                $KljucnaRec = MySQL::escape(strip_tags(trim($_GET['KljucnaRec'])));
                $ISBN = preg_replace("/[^0-9]/i", '', $KljucnaRec);
                $sql_KljucnaRec_klauzula = "and ( k.OriginalniNaslov LIKE '%{$KljucnaRec}%' or k.PrevodNaslova LIKE '%{$KljucnaRec}%' or k.ISBN LIKE '%{$ISBN}%' )";
            } else {
                $sql_KljucnaRec_klauzula = '';
            }

            $sql = "select
                        k.*,
                        a.ID Autor_ID,
                        a.ImePrezime AutorImePrezime,
                        (
                            select
                                group_concat(distinct kat.ID ORDER BY kat.Naziv asc separator ',')
                            from
                                Kategorija kat 
                            where
                                kat.ID in (
                                    select
                                        katk.Kategorija_ID
                                    from
                                        Kategorija_Knjiga katk
                                    where
                                        katk.Knjiga_ID = k.ID
                                )
                        ) kategorije
                    from
                        Knjiga k
                    left join Autor_Knjiga ak on ak.Knjiga_ID = k.ID
                    left join Autor a on a.ID = ak.Autor_ID
                    left join Kategorija_Knjiga kk on kk.Knjiga_ID = k.ID
                    left join Kategorija ka ON ka.ID = kk.Kategorija_ID
                    where
                        1
                        {$sql_Autor_ID_klauzula}
                        {$sql_KljucnaRec_klauzula}
                        {$sql_Kategorija_ID_klauzula}
                    group by
                        k.ID
                    order by
                        k.Godina desc,
                        k.OriginalniNaslov";
            $knjige = MySQL::upitUNiz($sql);

            include_once 'front/templejti/knjige.pretraga.php';
        }

        /**
         * Funkcija koja upravlja prikazom podataka o izabranoj knjizi
         */
        public static function prikaz() {
            if ( !isset($_GET['ID']) ) {
                Funkcije::redirektujNaUrl("index.php?modul=knjige&opcija=pretraga");
            }

            $kategorije = knjige::_kategorije();
            $autori     = knjige::_autori();

            $ID = intval($_GET['ID']);
            $podaci = Knjiga::podaci($ID);

            if ( $podaci != null ) {
                $knjiga   = $podaci['Knjiga'];
                $komentar = $podaci['Komentari'];
                include_once 'front/templejti/knjige.prikaz.php';
            } else {
                include_once 'front/templejti/knjige.404.php';
            }
        }

        /**
         * Funkcija koja upravlja opcijom postavljanja komentara
         */
        public static function komentarisi() {
            if ( !$_POST or !isset($_POST['Knjiga_ID']) or !isset($_POST['Tekst']) ) {
                Funkcije::redirektujNaUrl("index.php?modul=knjige&opcija=pretraga");
            }

            $Korisnik_ID = PrijavaKorisnika::korisnikId();
            $Knjiga_ID = intval($_POST['Knjiga_ID']);
            $Tekst = strip_tags($_POST['Tekst']);
            $Tekst = htmlspecialchars($Tekst);
            $Tekst = MySQL::escape($Tekst);

            $sql = "insert into Komentar (Korisnik_ID, Knjiga_ID, Tekst)
                    values ({$Korisnik_ID}, {$Knjiga_ID}, '{$Tekst}')";
            $rezultat = MySQL::upit($sql);

            session_start();
            if ( $rezultat ) {
                $_SESSION['knjige_poruka'] = "Vas komentar je uspesno upisan u bazu podataka i bice prikazan kada ga odobri administrator.";
            } else {
                $_SESSION['knjige_poruka'] = "Doslo je do greske prilikom upisa Vaseg komentara u bazu podataka.";
            }

            Funkcije::redirektujNaUrl("index.php?modul=knjige&opcija=prikaz&ID=" . $Knjiga_ID);
        }

        /**
         * Metod za dodavanje knjige u korpu
         */
        public static function kupi() {
            if ( isset($_GET['Knjiga_ID']) ) {
                $Knjiga_ID = intval($_GET['Knjiga_ID']);
                KorpaZaKupovinu::dodajKnjigu($Knjiga_ID);
                Funkcije::redirektujNaUrl("index.php?modul=knjige&opcija=prikaz&ID=" . $Knjiga_ID);
            } else {
                Funkcije::redirektujNaUrl("index.php");
            }
        }
        
        /**
         * Funkcija index opcije modula knjige
         */
        public static function index() {
            if ( isset($_GET['Kategorija_ID']) or isset($_GET['KljucnaRec']) or isset($_GET['Autor_ID']) ) {
                knjige::_pretraga();
            } else {
                $kategorije = knjige::_kategorije();
                $autori     = knjige::_autori();
                include_once 'front/templejti/knjige.index.php';
            }
        }
    }
