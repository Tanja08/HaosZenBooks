<?php if ( isset($PORUKA) and $PORUKA != '' ): ?>
    <h4><?php echo htmlspecialchars($PORUKA); ?></h4><br>
<?php endif; ?>

<!-- Forma za registraciju korisnika -->
<form method="post">
    <table>
        <tr>
            <td colspan="2">
                Molimo Vas da popunite polja kako biste se registrovali na portal.
            </td>
        </tr>
        <tr>
            <th>Željeno korisnicko ime: </th>
            <td><input required type="text" name="KorisnickoIme" /></td>
        </tr>
        <tr>
            <th>Željena lozinka: </th>
            <td><input required type="password" name="Lozinka" /></td>
        </tr>
        <tr>
            <th>Ponovite lozinku: </th>
            <td><input required type="password" name="Lozinka_Opet" /></td>
        </tr>
        <tr>
            <th>&nbsp;</th>
            <td><input type="submit" value="Registruj se" /></td>
        </tr>
    </table>
</form>