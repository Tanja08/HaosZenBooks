<?php
    $PORUKA = '';
    if (isset($_GET['signal'])) {
        $signal = strval($_GET['signal']);

        switch ( $signal ) {
            case 'registration_done' :
                $PORUKA = "Registracija je uspešno završena. Možete da se prijavite na portal.";
                break;
        }
    }
?>

<?php if ( $PORUKA != '' ): ?>
    <h4><?php echo htmlspecialchars($PORUKA); ?></h4><br>
<?php endif; ?>

<!-- Forma za prijavu korisnika -->
<form method="post">
    <table>
        <tr>
            <td colspan="2">
                Da biste ptretrazivali nas katalog knjiga, potrebno je da se prijavite na portal.
            </td>
        </tr>
        <tr>
            <th>Korisnicko ime: </th>
            <td><input required type="text" name="KorisnickoIme" /></td>
        </tr>
        <tr>
            <th>Lozinka: </th>
            <td><input required type="password" name="Lozinka" /></td>
        </tr>
        <tr>
            <th>&nbsp;</th>
            <td><input type="submit" value="Prijavi se" /></td>
        </tr>
        <tr>
            <td colspan="2">
                Ukoliko nemate nalog za pretragu kataloga knjiga Haos &amp; Zen Books, molimo Vas da<br/>
                kliknete <a href="index.php?modul=main&opcija=registracija">ovde</a> kako biste registrovali novi.
            </td>
        </tr>
        </tr>
    </table>
</form>