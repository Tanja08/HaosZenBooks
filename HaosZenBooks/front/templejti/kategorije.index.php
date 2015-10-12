<!-- Spisak svih kategorija knjiga -->
<div class="kategorije">
    <?php foreach ($kategorije as $kategorija): ?>
    <a class="kategorija" href="index.php?modul=knjige&opcija=index&Kategorija_ID=<?php echo $kategorija['ID']; ?>">
        <img src="img/kategorije/<?php echo $kategorija['ID']; ?>.png" alt="<?php echo htmlspecialchars($kategorija['Naziv']); ?>" />
        <h1><?php echo htmlspecialchars($kategorija['Naziv']); ?></h1>
    </a>
    <?php endforeach; ?>
</div>