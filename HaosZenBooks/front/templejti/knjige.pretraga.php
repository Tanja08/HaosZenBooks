<?php
    // Ucitaj formu za pretragu iz templejta
    include_once 'front/templejti/knjige.pretraga.forma.php';

    // Prikazi spisak rezultata pretrage, ako ima rezultata
    echo '<section class="spisak-knjiga">';
    foreach ( $knjige as $knjiga ) {
      ?>
        <article class="knjiga">
            <a href="index.php?modul=knjige&opcija=prikaz&ID=<?php echo $knjiga['ID']; ?>">
                <img class="knjiga-slika" src="img/knjige/<?php echo $knjiga['ID']; ?>.png" alt="<?php echo htmlentities($knjiga['OriginalniNaslov']); ?>" />
            </a>
            <div class="knjiga-detalji">
                <a class="knjiga-naslov" href="index.php?modul=knjige&opcija=prikaz&ID=<?php echo $knjiga['ID']; ?>">
                    <?php echo htmlspecialchars($knjiga['OriginalniNaslov']); ?>
                </a>

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
            </div>
        </article>
      <?php
    }
    echo '</section>';
