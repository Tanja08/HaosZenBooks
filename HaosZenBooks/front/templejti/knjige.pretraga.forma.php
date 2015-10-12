<!-- Forma za pretragu knjiga -->
<form method="get">
    <!-- Trenutni modul -->
    <input type="hidden" name="modul" value="<?php echo modul; ?>" />
    <!-- Trenutna opcija -->
    <input type="hidden" name="opcija" value="<?php echo opcija; ?>" />

    <!-- Parametri pretrage -->
    <table>
        <tr>
            <td>
                <!-- Spisak svih kategorija knjiga -->
                <select name="Kategorija_ID">
                    <option value="">Sve kategorije</option>
                    <?php if (is_array($kategorije) ) foreach ( $kategorije as $kategorija ): ?>
                        <option value="<?php echo intval($kategorija['ID']); ?>" <?php if ( isset($_GET['Kategorija_ID']) and intval($_GET['Kategorija_ID']) == $kategorija['ID'] ) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($kategorija['Naziv']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </td>
            <td>
                <!-- Spisak svih autora -->
                <select name="Autor_ID">
                    <option value="">Svi autori</option>
                    <?php if (is_array($autori) ) foreach ( $autori as $autor ): ?>
                        <option value="<?php echo intval($autor['ID']); ?>" <?php if ( isset($_GET['Autor_ID']) and intval($_GET['Autor_ID']) == $autor['ID'] ) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($autor['ImePrezime']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </td>
            <td>
                <!-- Polje za kljucne reci ili ISBN -->
                <input type="text" name="KljucnaRec" value="<?php echo htmlspecialchars(strip_tags(@$_GET['KljucnaRec'])); ?>" placeholder="Kljucna rec za pretragu" />
            </td>
            <td>
                <input type="submit" value="Trazi" />
            </td>
        </tr>
    </table>
</form>