<?php
    $PORUKA = '';
    if (isset($_GET['signal'])) {
        $signal = strval($_GET['signal']);

        switch ( $signal ) {
            case 'prazna_korpa' :
                $PORUKA = "Korpa je prazna tako da nema šta da se poruči. Molimo Vas da dodate u korpu barem jednu knjigu.";
                break;
            case 'uspesno_poruceno' :
                $PORUKA = "Porudžbina je uspešno prosleđena. Hvala!";
                break;
            case 'greska' :
                $PORUKA = "Došlo je do greške prilikom slanja Vaše porudžbine!";
                break;
        }
    }
?>

<?php if ( $PORUKA != '' ): ?>
    <h4><?php echo htmlspecialchars($PORUKA); ?></h4><br>
<?php endif; ?>

<!-- Stranica sa prikazom stavki u korpi -->
<?php if ( KorpaZaKupovinu::brojStavkiUKorpi() == 0 ): ?>
    <p>Trenutno nemate ništa u korpi za kupovinu.</p>
<?php else: ?>
    <?php $SUMA = 0; ?>
    <form action="index.php?modul=korpa&opcija=poruci" method="POST">
        <table class="table">
            <tr>
                <th colspan="4">Vaša korpa za kupovinu</th>
            </tr>
            <tr>
                <th>Knjiga</th>
                <th>Količina</th>
                <th>Cena</th>
                <th>Opcije</th>
            </tr>
            <?php foreach ( KorpaZaKupovinu::podaciIzKorpe() as $item ): ?>
                <tr>
                    <td valign="top">
                        <a href="index.php?modul=knjige&opcija=prikaz&ID=<?php echo $item['Knjiga']['Knjiga']['ID']; ?>">
                            <img class="knjiga-slika" height="80" src="img/knjige/<?php echo $item['Knjiga']['Knjiga']['ID']; ?>.png" alt="<?php echo htmlentities($item['Knjiga']['Knjiga']['OriginalniNaslov']); ?>" /><br>
                            <?php echo htmlspecialchars($item['Knjiga']['Knjiga']['OriginalniNaslov']); ?>
                        </a>
                    </td>
                    <td valign="top"><?php echo $item['Broj']; ?></td>
                    <td valign="top"><?php echo $item['Ukupno']; ?> Din.</td>
                    <td valign="top">
                        <a href="index.php?modul=korpa&opcija=ukloni&Knjiga_ID=<?php echo $item['Knjiga']['Knjiga']['ID']; ?>">Ukloni jednu [ -1 ]</a>
                    </td>
                </tr>
                <?php $SUMA += $item['Ukupno']; ?>
            <?php endforeach; ?>
              <tr>
                <th colspan="3">&nbsp;</th>
                <th>Ukupno: <?php echo $SUMA; ?> Din.</th>
            </tr>
            <tr>
                <th colspan="4">Podaci za porudžbinu</th>
            </tr>
            <tr>
                <th>Ime i prezime</th>
                <td colspan="3">
                    <input type="text" name="Ime_i_prezime" required>
                </td>
            </tr>
            <tr>
                <th>Ulica i broj</th>
                <td colspan="3">
                    <textarea name="Adresa" required rows="5"></textarea>
                </td>
            </tr>
            <tr>
                <th>Grad</th>
                <td colspan="3">
                    <input type="text" name="Grad" required>
                </td>
            </tr>
            <tr>
                <th>Telefon</th>
                <td colspan="3">
                    <input type="text" name="Telefon" required>
                </td>
            </tr>
            <tr>
                <th>&nbsp;</th>
                <td colspan="3">
                    <input type="submit" value="Izvrši porudžbinu">
                </td>
            </tr>
            
        </table>
    </form>
<?php endif; ?>
