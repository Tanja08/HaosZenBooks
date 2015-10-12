<?php
    $PORUKA = '';
    if (isset($_GET['signal'])) {
        $signal = strval($_GET['signal']);
    }
?>

<?php if ( $PORUKA != '' ): ?>
    <h4><?php echo htmlspecialchars($PORUKA); ?></h4><br>
<?php endif; ?>

<table class="table" style="width:100%;">
    <tr>
        <th colspan="2"><?php echo ($Realizovane)?'Realizovane':'Nerealizovane'; ?> porudžbine</th>
        <td colspan="2">
            <?php if ( $Realizovane ): ?>
                <a href="index.php?modul=porudzbine">Prikaži nerealizovane porudžbine</a>
            <?php else: ?>
                <a href="index.php?modul=porudzbine&realizovane">Prikaži realizovane porudžbine</a>
            <?php endif; ?>
        </td>
    </tr>
    <tr>
        <th>Datum</th>
        <th>Knjige</th>
        <th>Adresa</th>
        <th>Suma</th>

        <?php if ( !$Realizovane ): ?>
            <th>Opcije</th>
        <?php endif; ?>
    </tr>
    <?php foreach ( $porudzbine as $porudzbina ): ?>
        <?php $items = json_decode($porudzbina['Porudzbina'], true); ?>
        <tr>
            <td valign="top"><?php echo date("d.m.Y.", strtotime($porudzbina['DatumVreme'])); ?></td>
            <td valign="top">
                <?php
                    foreach ( $items as $item ) {
                        echo '<b>' . $item['Broj'] . 'x</b> "<b>' . $item['Knjiga']['Knjiga']['OriginalniNaslov'] . '</b>" po ceni ' . $item['Knjiga']['Knjiga']['Cena'] . '<br>';
                    }
                ?>
            </td>
            <td valign="top">
                <b><?php echo $porudzbina['Ime_i_prezime']; ?></b><br>
                <?php echo $porudzbina['Adresa']; ?><br>
                <?php echo $porudzbina['Grad']; ?><br>
                <?php echo $porudzbina['Telefon']; ?>
            </td>
            <td valign="top"><?php echo $porudzbina['Suma']; ?> Din.</td>

            <?php if ( !$Realizovane ): ?>
                <td valign="top">
                    <a href="index.php?modul=porudzbine&opcija=realizuj&Porudzbina_ID=<?php echo $porudzbina['ID']; ?>">Realizovano!</a>
                </td>
            <?php endif; ?>
        </tr>
		<?php $SUMA = 0; ?>
        <?php $SUMA += $item['Ukupno']; ?>
    <?php endforeach; ?>
</table>