<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <?php include '../shared/header.php'; ?>
    <title>Caricamento immagini</title>
</head>
<body>
    <div style="margin-bottom: 20" align="center" >
    <form action="upload.php" method="post" enctype="multipart/form-data">
        Seleziona la foto da Caricare
        <input type="file" name="fileToUpload"><br>
        <textarea name ="descrizione" placeholder ="Scrivi una breve descrizione della foto..."></textarea><br>
        <textarea name ="tags" placeholder ="Inserisci qualche tag separati da spazi..."></textarea><br>
        <input type="submit" value="Upload Image" name="submit"><br>
    </form>
    </div>
</body>
</html>
