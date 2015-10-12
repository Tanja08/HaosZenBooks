<?php if ( isset($_SESSION['knjige_poruka']) and $_SESSION['knjige_poruka'] != '' ): // Ako je u sesiji definisana poruka za prikaz, prikazi je ?>
    <!-- Poruka is sesije -->
    <div class="poruka">
        <?php
            echo htmlspecialchars($_SESSION['knjige_poruka']); // Nakon prikaza poruke is zesije
            unset($_SESSION['knjige_poruka']);                 // Obrisati poruku iz sesije
        ?>
    </div>
<?php endif; ?>

<!-- Informacije o knjizi -->
<article class="knjiga-prikaz">
    <img class="knjiga-slika" src="img/knjige/<?php echo $knjiga['ID']; ?>.png" alt="<?php echo htmlentities($knjiga['OriginalniNaslov']); ?>" />
    <div class="knjiga-detalji">
        <div class="knjiga-naslov">
            <?php echo htmlspecialchars($knjiga['OriginalniNaslov']); ?>
        </div>

        <div class="knjiga-prevod"><?php echo htmlspecialchars($knjiga['PrevodNaslova']); ?></div>

        <div class="knjiga-isbn"><b>ISBN:</b> <?php echo $knjiga['ISBN']; ?></div>

        <?php if ( $knjiga['BrojStrana'] != '' ): ?>
            <div class="knjiga-broj-strana"><b>Broj strana:</b> <?php echo $knjiga['BrojStrana']; ?></div>
        <?php endif; ?>

        <?php if ( $knjiga['Godina'] != '' ): ?>
            <div class="knjiga-godina"><b>Godina:</b> <?php echo $knjiga['Godina']; ?></div>
        <?php endif; ?>

        <div class="knjiga-autor">
            <b>Autor:</b>
            <a href="index.php?modul=knjige&opcija=pretraga&Autor_ID=<?php echo $knjiga['Autor_ID']; ?>">
                <?php echo htmlspecialchars($knjiga['AutorImePrezime']); ?>
            </a>
        </div>
        <div class="knjiga-kategorije">
            <b>Kategorije:</b>
            <?php
                $kategorije_knjige = explode(',', $knjiga['kategorije']);
                foreach ( $kategorije_knjige as $kategorija_knjige ):
                    $ID = $kategorija_knjige;
                    $Naziv = knjige::_naziv_kategorije_za_id($kategorije, $ID);
                    ?>
                        <a class="kategorija-knjige" href="index.php?modul=knjige&opcija=pretraga&Kategorija_ID=<?php echo $ID; ?>">
                            <?php echo htmlspecialchars($Naziv); ?>
                        </a>
                    <?php
                endforeach;
            ?>
        </div>
        <div class="knjiga-kupovina">
            <br>
            <b>Cena:</b> <?php echo $knjiga['Cena']; ?> Din.</a>
            <br>
            <b>Opcije:</b> <a href="index.php?modul=knjige&opcija=kupi&Knjiga_ID=<?php echo $knjiga['ID']; ?>">+ Dodaj u korpu</a>
        </div>
    </div>
</article>

<!-- Spisak komentara -->
<?php if ( isset($komentari) and count($komentari) ) foreach ( $komentari as $komentar ): // Ako ima komentara za prikaz, prikazi ih ?>
<section class="komentari">
    <article class="komentar">
        <div class="komentar-korisnik"><?php echo htmlspecialchars($komentar['KorisnikKorisnickoIme']); ?></div>
        <div class="komentar-datum-vreme"><?php echo Funkcije::formatirajDatumVreme($komentar['DatumVreme']); ?></div>
        <div class="komentar-tekst"><?php echo htmlspecialchars($komentar['Tekst']); ?></div>
    </article>
</section>
<?php endforeach; ?>

<!-- Forma za objavu komentara -->
<form action="index.php?modul=knjige&opcija=komentarisi" method="post">
    <input type="hidden" name="Knjiga_ID" value="<?php echo $knjiga['ID']; ?>" />
    <table>
        <tr>
            <th>Unesite Vas komentar:</th>
        </tr>
        <tr>
            <td>
                <textarea required name="Tekst" class="polje-za-komentar"></textarea>
            </td>
        </tr>
        <tr>
            <td>
                <input type="submit" value="Posalji komentar" />
            </td>
        </tr>
    </table>
</form>
