<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <title>FileUpload</title>
</head>

<body>
    <form action='' class="p-3" enctype="multipart/form-data" method="POST">
        Select image to upload:
        <input type="file" name="uploadName">
        <input type="submit" value="Nahrát" name="sumbit">
    </form>

    <?php

    if ($_FILES) {
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($_FILES['uploadName']['name']);
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $uploadSuccess = true;

        $arr = explode('/', $_FILES['uploadName']['type']);

        if ($arr[0] !== 'image' && $arr[0] !== 'video' && $arr[0] !== 'audio') {
            echo "<p class='p-3 mb-2 bg-danger text-white mt-3'>Soubor má špatný typ: " . $_FILES['uploadName']['type'] . "</p>";
            $uploadSuccess = false;
        } else {
            if ($_FILES['uploadName']['error'] != 0) {
                echo "<p class='p-3 mb-2 bg-danger text-white mt-3'>Chyba serveru</p>";
                $uploadSuccess = false;
            } elseif (file_exists($targetFile)) {
                echo "<p class='p-3 mb-2 bg-warning text-white mt-3'>Soubor již existuje</p>";
                $uploadSuccess = false;
            } elseif ($_FILES['uploadName']['size'] > 8000000) {
                echo "<p class='p-3 mb-2 bg-danger text-white mt-3'>Soubor je moc velký</p>";
                $uploadSuccess = false;
            }

            if (!$uploadSuccess) {
                echo "<p class='p-3 mb-2 bg-danger text-white mt-3'>Došlo k chybě uploadu</p>";
            } else {
                if (move_uploaded_file($_FILES['uploadName']['tmp_name'], $targetFile)) {
                    echo "<p class='p-3 mb-2 mt-3 bg-success text-white'>Soubor " . basename($_FILES['uploadName']['name']) . " byl uložen</p>";
                } else {
                    echo "<p class='p-3 mb-2 bg-danger text-white mt-3'>Došlo k chybě uploadu</p";
                }
            }
        }
        if ($arr[0] === 'image') {
            echo "<img src='${targetFile}' style='width: 100%'>";
        } else if ($arr[0] === 'audio') {
            echo "<audio controls loop autoplay style='width: 100%'> <source src='${targetFile}' type='audio/{$fileType}'>   Your browser does not support the audio tag. </audio>";
        } else if ($arr[0] === 'video') {
            echo "<video controls autoplay loop style='width: 100%'> <source src='${targetFile}' type='audio/{$fileType}'>   Your browser does not support the video tag. </video>";
        }
    }
    ?>
</body>

</html>