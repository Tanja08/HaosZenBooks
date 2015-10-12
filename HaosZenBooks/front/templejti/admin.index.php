<?php
    $PORUKA = '';
    if (isset($_GET['signal'])) {
        $signal = strval($_GET['signal']);

		switch ( $signal ) {
			case 'obrisano' :
				$PORUKA = 'Knjiga je obrisana iz baze podataka.';
				break;
			case 'nepostojeca' :
				$PORUKA = 'Knjiga ne postoji u bazi podataka.';
				break;
		}
    }
?>

<?php if ( $PORUKA != '' ): ?>
    <h4><?php echo htmlspecialchars($PORUKA); ?></h4><br>
<?php endif; ?>

<table class="table" style="width:100%;">
	<tr>
		<th colspan="7">&nbsp;</th>
		<th>
			<a class="malo-dugme" href="index.php?modul=admin&opcija=dodaj">Dodaj knjigu</a>
		</th>
	</tr>
    <tr>
        <th>ID</th>
        <th>Originalni naslov</th>
        <th>Prevod naslova</th>
        <th>Broj strana</th>
        <th>ISBN</th>
        <th>Godina</th>
        <th>Cena</th>
        <th>Opcije</th>
    </tr>
    <?php foreach ( $knjige as $knjiga ): ?>
        <tr>
            <td valign="top"><?php echo htmlspecialchars($knjiga['ID']); ?></td>
            <td valign="top"><?php echo htmlspecialchars($knjiga['OriginalniNaslov']); ?></td>
            <td valign="top"><?php echo htmlspecialchars($knjiga['PrevodNaslova']); ?></td>
            <td valign="top"><?php echo htmlspecialchars($knjiga['BrojStrana']); ?></td>
            <td valign="top"><?php echo htmlspecialchars($knjiga['ISBN']); ?></td>
            <td valign="top"><?php echo htmlspecialchars($knjiga['Godina']); ?>.</td>
            <td valign="top"><?php echo htmlspecialchars($knjiga['Cena']); ?> Din.</td>

			<td valign="top">
				<a class="malo-dugme" href="index.php?modul=admin&opcija=obrisi&Knjiga_ID=<?php echo $knjiga['ID']; ?>" onclick="return confirm('Da li ste sigurni?');">Obriši</a>
				<a class="malo-dugme" href="index.php?modul=admin&opcija=izmeni&Knjiga_ID=<?php echo $knjiga['ID']; ?>">Izmeni</a>
			</td>
        </tr>
    <?php endforeach; ?>
</table>