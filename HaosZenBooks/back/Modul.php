<?php
    /**
     * Osnovna klasa Modul
     * @author Tanja
     */
    abstract class Modul {
        public static $css_klasa = "osnovni";

        public static function index() {
            
        }

        public static function before() {
            $ja = get_class();
            echo '<div class="modul ' . $ja::$css_klasa . '">';
        }

        public static function after() {
            echo '</div>';
        }
    }
