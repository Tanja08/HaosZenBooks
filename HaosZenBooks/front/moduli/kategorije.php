<?php
    /**
     * Modul za rad sa kategorijama i prelistavanje knjiga po kategorijama
     * @author Tanja
     */
    abstract class kategorije extends Modul {
        public static function index() {
            $sql = "select * from Kategorija order by Naziv asc";
            $kategorije = MySQL::upitUNiz($sql);
            include_once 'front/templejti/kategorije.index.php';
        }
    }
