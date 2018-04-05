<?php

 if (!empty($_GET['image'])) {
     if(file_exists('uploads/' .$_GET['image'])) {
         unlink('uploads/' .$_GET['image']);
         header('Location : index.php');

     }
 }



if (!empty($_FILES['files']['name'][0])) {
    $files = $_FILES['files'];
    $uploaded = [];
    $allowed = ["image/jpg", "image/jpeg", "image/png", "image/gif"];
    foreach ($files['name'] as $position => $file_name) {
        $file_tmp = $files['tmp_name'][$position];
        $file_size = $files['size'][$position];
        $file_error = $files['error'][$position];
        $file_ext = $files['type'][$position];
        var_dump($file_ext);

        if (in_array($file_ext, $allowed)) {
            if ($file_error === 0) {
                if ($file_size <= 1048576) {
                    $extension = pathinfo($files['name'][$position], PATHINFO_EXTENSION);
                    $file_name_new = uniqid('', true) .'.' .$extension;
                    $file_destination = 'uploads/' .$file_name_new;
                    if (move_uploaded_file($file_tmp, $file_destination)) {
                        $uploaded[$position] = $file_destination;
                    } else {
                        echo "Le fichier n'a pas pu être téléchargé.";
                    }
                } else {
                    echo "Le fichier est trop lourd.";
                }
            } else {
                echo $file_error[$position];
            }
        } else {
            echo "Ce format n'est pas autorisé.";
        }
    }
}
?>




<!DOCTYPE html>
<html lang=fr>
<head>
    <meta charset="utf-8" />
    <title>Laisse pas trainer ton file</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
</head>

<body>

    <div class="container">

        <h1>Télécharger des fichiers</h1>

        <form class="form" action="" method="post" role="form" enctype="multipart/form-data">

        <div class="form-group">
            <input type="file"  name="files[]" multiple="multiple" id="file">
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Envoyer</button>
        </form>

    </div>

    <?php
    $dir    = 'uploads/';
    $images = array_diff(scandir($dir), array('.', '..'));
    ?>

    <?php foreach ($images as $image): ?>
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-md-3">
                <a href="#" class="thumbnail">
                    <img src="<?= 'uploads/' .$image  ?>" alt="">
                </a>
            </div>
                <a href="?image=<?= $image ?>" class="btn btn-danger">Supprimer</a>


        </div>
    </div>
<?php endforeach; ?>

</body>
</html>