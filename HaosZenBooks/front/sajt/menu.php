<?php
    $stavke = array();

    $stavke[] = array("index.php", "Pocetna");
    
    // Stavke menija koje treba prikazati samo ako u sesiji postoji zapis prijavljenog korisnika
    if ( PrijavaKorisnika::proveriSesiju() ) {
        $stavke[] = array("index.php?modul=kategorije", "Kategorije");
        $stavke[] = array("index.php?modul=knjige", "Pretraga knjiga");
        $stavke[] = array("index.php?modul=korpa", "Korpa (" . KorpaZaKupovinu::brojStavkiUKorpi() . ")"); // Prikazi korpu sa brojem razlicitih knjiga u njoj

        if ( PrijavaKorisnika::daLiImaAdminPrivilegije() ) {
            $stavke[] = array("index.php?modul=porudzbine", "Pregled porudžbina");   
            $stavke[] = array("index.php?modul=admin", "Panel knjiga");   
            $stavke[] = array("index.php?modul=admin&opcija=komentari", "Komentari");   
        }

        $stavke[] = array("index.php?modul=main&opcija=odjava", "Odjava");
    }

    echo '<nav class="glavni-menu">';
    foreach ( $stavke as $stavka ) {
        echo '<a href="' . $stavka[0] . '">' . htmlspecialchars($stavka[1]) . '</a>' . PHP_EOL;
    }
    echo '</nav>';
