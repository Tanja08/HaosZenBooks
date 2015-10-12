<?php

    /**
     * Klasa za rad sa knjigama u bazi
     *
     * @author Tanja
     */
    abstract class Knjiga extends HelperBaze {
        /**
         * Metod koij vraca podatke o knjizi u vidu niza koji sadrzi dva polja Knjiga i Komentari.
         * Polje Knjiga je asocijativni niz sa elementima koji opisuju knjigu.
         * Polje Komentari je niz komentara koji su svaki za sebe asocijativni niz.
         * @param int $Knjiga_ID
         * @return array
         */
        public static function podaci($Knjiga_ID) {
            $podaci = null;
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
                        k.ID = {$Knjiga_ID}
                    group by
                        k.ID
                    order by
                        k.Godina desc,
                        k.OriginalniNaslov";
            $niz = MySQL::upitUNiz($sql);
            if ( count($niz) ) {
                $podaci = array();
                $podaci['Knjiga'] = $niz[0];
                $sql = "select
                            k.*,
                            ko.KorisnickoIme KorisnikKorisnickoIme
                        from
                            Komentar k
                        left join Korisnik ko on ko.ID = k.Korisnik_ID
                        where
                            k.Knjiga_ID = {$Knjiga_ID}
                            and k.Odobren = 1
                        order by
                            k.DatumVreme desc";
                $podaci['Komentari'] = MySQL::upitUNiz($sql);
            }
            return $podaci;
        }
    }
