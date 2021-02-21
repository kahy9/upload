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
    <form action='' enctype="multipart/form-data" method="POST">
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
            echo "Soubor má špatný typ: " . $_FILES['uploadName']['type'];
            $uploadSuccess = false;
        } else {
            if ($_FILES['uploadName']['error'] != 0) {
                echo "Chyba serveru ";
                $uploadSuccess = false;
            } elseif (file_exists($targetFile)) {
                echo "Soubor již existuje ";
                $uploadSuccess = false;
            } elseif ($_FILES['uploadName']['size'] > 8000000) {
                echo "Soubor je moc velký ";
                $uploadSuccess = false;
            }

            if (!$uploadSuccess) {
                echo "Došlo k chybě uploadu";
            } else {
                if (move_uploaded_file($_FILES['uploadName']['tmp_name'], $targetFile)) {
                    echo "Soubor" . basename($_FILES['uploadName']['name']) . "byl uložen";
                } else {
                    echo "Došlo k chybě uploadu ";
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