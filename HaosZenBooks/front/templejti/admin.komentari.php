<?php
    $PORUKA = '';
    if (isset($_GET['signal'])) {
        $signal = strval($_GET['signal']);

		switch ( $signal ) {
			case 'odobren' :
				$PORUKA = 'Komentar je odobren!';
				break;
			case 'obrisan' :
				$PORUKA = 'Komentar je obrisan iz baze podataka!';
				break;
		}
    }
?>

<?php if ( $PORUKA != '' ): ?>
    <h4><?php echo htmlspecialchars($PORUKA); ?></h4><br>
<?php endif; ?>

<table class="table" style="width:100%;">
    <tr>
        <th>ID</th>
        <th>Datum i vreme</th>
        <th>Korisnik</th>
        <th>Tekst</th>
        <th>Opcije</th>
    </tr>
    <?php if ( isset($komentari) and is_array($komentari) and count($komentari) ): ?>
	<?php foreach ( $komentari as $komentar ): ?>
        <tr>
            <td valign="top" width="50"><?php echo htmlspecialchars($komentar['ID']); ?></td>
            <td valign="top" width="140"><?php echo htmlspecialchars($komentar['DatumVreme']); ?></td>
            <td valign="top" width="80"><?php echo htmlspecialchars($komentar['Korisnik']); ?></td>
            <td valign="top"><?php echo htmlspecialchars($komentar['Tekst']); ?></td>

			<td valign="top" width="100">
				<a class="malo-dugme" href="index.php?modul=admin&opcija=obrisikomentar&Komentar_ID=<?php echo $komentar['ID']; ?>" onclick="return confirm('Da li ste sigurni?');">Obriši</a>
				<a class="malo-dugme" href="index.php?modul=admin&opcija=odobrikomentar&Komentar_ID=<?php echo $komentar['ID']; ?>" onclick="return confirm('Da li ste sigurni?');">Odobri</a>
			</td>
        </tr>
    <?php endforeach; ?>
	<?php else: ?>
		<tr>
			<td colspan="5">
				Nema neodobrenih komentara.
			</td>
		</tr>
	<?php endif; ?>
</table>