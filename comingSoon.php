<?php
    session_start();

    //Get returned errors if there are any
    $errorList = $_SESSION["ErrorFields"] ?? [];
    //Get any fields that have already been filled in
    $filledFields = $_SESSION["FilledFields"] ?? [];
    session_unset();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coming Soon - SportsWarehouse</title>
    <link rel="stylesheet" href="css/comingSoon.css">
</head>
<body>
    <div class="root">
        <div class="logo">
            <img src="images/LogoLarge.gif" alt="SportsWarehouse">
        </div>

        <main>
            <p>SportsWarehouse is coming soon. If you have any questions, we would love to hear from you, please complete the following information.</p>

            <form action="controllers/comingSoonControl.php" name="feedback" method="post" onsubmit="return ValidateForm()">
                <fieldset>
                    <p class="formInput">
                        <input type="text" id="firstName" name="firstName" required value="<?= $filledFields["firstName"] ?? "" ?>">
                        <label for="firstName" <?= in_array("firstName", $errorList) ? 'class="error"' : '' ?> >First Name</label>
                    </p>
                    <p class="formInput">
                        <input type="text" id="lastName" name="lastName" required value="<?= $filledFields["lastName"] ?? "" ?>">
                        <label for="lastName" <?= in_array("lastName", $errorList) ? 'class="error"' : '' ?>>Last Name</label>
                    </p>
                    <p class="formInput">
                        <input type="tel" name="contactNumber" id="contactNumber" value="<?= $filledFields["contactNumber"] ?? "" ?>">
                        <label for="contactNumber">Contact Number</label>
                    </p>
                    <p class="formInput">
                        <input type="email" name="email" id="email" required value="<?= $filledFields["email"] ?? "" ?>">
                        <label for="email" <?= in_array("email", $errorList) ? 'class="error"' : '' ?>>Email</label>
                    </p>
                    <p class="formInput">
                        <textarea name="question" id="question" cols="30" rows="5" required><?= $filledFields["question"] ?? "" ?></textarea>
                        <label for="question" <?= in_array("question", $errorList) ? 'class="error"' : '' ?>>Question</label>
                    </p>
                </fieldset>
                

                <p id="errorMessage">
                    <?php
                        if(sizeof($errorList) > 0){
                            echo "Please check the marked fields.";
                        }
                    ?>
                </p>

                <div class="formButtons">
                    <input type="submit" value="Submit">
                    <input type="reset" value="Reset" onclick="ResetForm()">
                </div>
                
            </form>
        </main>
    </div>

    <script src="js/comingSoon.js"></script>
</body>
</html>