<?php
    $PORUKA = '';
    if (isset($_GET['signal'])) {
        $signal = strval($_GET['signal']);
    }
?>

<?php if ( $PORUKA != '' ): ?>
    <h4><?php echo htmlspecialchars($PORUKA); ?></h4><br>
<?php endif; ?>

<form method="post">
	<table class="table" style="width:100%;">
		<tr>
			<th width="130">ID</th>
			<td>
				<?php echo htmlspecialchars($knjiga['ID']); ?>
			</td>
		</tr>
		<tr>
			<th>Originalni naslov</th>
			<td>
				<input type="text" required name="OriginalniNaslov" value="<?php echo htmlspecialchars($knjiga['OriginalniNaslov']); ?>">
			</td>
		</tr>
		<tr>
			<th>Prevod naslova</th>
			<td>
				<input type="text" required name="PrevodNaslova" value="<?php echo htmlspecialchars($knjiga['PrevodNaslova']); ?>">
			</td>
		</tr>
		<tr>
			<th>Broj strana</th>
			<td>
				<input type="number" min="1" step="1" required name="BrojStrana" value="<?php echo htmlspecialchars($knjiga['BrojStrana']); ?>">
			</td>
		</tr>
		<tr>
			<th>ISBN</th>
			<td>
				<input type="text" required name="ISBN" value="<?php echo htmlspecialchars($knjiga['ISBN']); ?>">
			</td>
		</tr>
		<tr>
			<th>Godina</th>
			<td>
				<input type="number" max="<?php echo date('Y'); ?>" step="1" required name="Godina" value="<?php echo htmlspecialchars($knjiga['Godina']); ?>">
			</td>
		</tr>
		<tr>
			<th>Cena</th>
			<td>
				<input type="number" min="1" step="any" required name="Cena" value="<?php echo htmlspecialchars($knjiga['Cena']); ?>">
			</td>
		</tr>
		<tr>
			<th valign="top">Kategorije</th>
			<td>
				<select multiple required name="Kategorije[]" size="35">
					<?php foreach ($kategorije as $kategorija): ?>
						<option value="<?php echo $kategorija['ID']; ?>" <?php if ( in_array($kategorija['ID'], $knjiga_kategorije) ) echo 'selected'; ?>>
							<?php echo htmlspecialchars($kategorija['Naziv']); ?>
						</option>
					<?php endforeach; ?>
				</select>
			</td>
		</tr>
		<tr>
			<th>&nbsp;</th>
			<td>
				<input type="submit" value="Izmeni knjigu">
			</td>
		</tr>
	</table>
</form>
