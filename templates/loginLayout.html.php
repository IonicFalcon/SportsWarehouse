<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
    <title><?= $pageTitle ?></title>
</head>
<body>
    <div class="root">
        <?= $mainOutput ?>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <?php
        //Import any other relevant files for the specific page
        if(isset($JSSources)){
            foreach($JSSources as $file){
                //Javascipt Modules have to be declared differently
                if(is_array($file)){
                    if($file[1] === true){
                        ?>
                            <script type="module" src="<?= $file[0] ?>"></script>
                        <?php
                    } else{
                        ?>
                            <script src="<?= $file[0] ?>"></script>
                        <?php
                    }
                } else{
                    ?>
                        <script src="<?=$file?>"></script>
                    <?php
                }
            }
        }
    ?>
</body>
</html>