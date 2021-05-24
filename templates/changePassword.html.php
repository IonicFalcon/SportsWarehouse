<?php
    if(session_status() === PHP_SESSION_NONE){
        session_start();
    }

    if(isset($_SESSION["ErrorInfo"])){
        $error = $_SESSION["ErrorInfo"];
        unset($_SESSION["ErrorInfo"]);
    }
?>

<h1>
    <a href="index.php" class="siteLogo" aria-label="Sports Warehouse">
        <img src="images/LogoLarge.gif" alt="">
    </a>
</h1>

<?php
    if(isset($error)){
        ?>
            <p class="errorMessage"><?= $error ?></p>
        <?php
    }
?>

<form action="controllers/changePasswordController.php" method="post">
    <fieldset>
        <p class="formInput">
            <input type="password" name="originPass" id="originPass" required>
            <label for="originPass">Original Password</label>
            <span class="inputErrors"></span>
        </p>
        <p class="formInput">
            <input type="password" name="newPass" id="newPass" required>
            <label for="newPass">New Password</label>
            <span class="inputErrors"></span>
        </p>
        <p class="formInput">
            <input type="password" name="passConfirm" id="passConfirm" required>
            <label for="passConfirm">Retype New Password</label>
            <span class="inputErrors"></span>
        </p>

        <div class="formButtons">
            <button type="submit" class="linkButton" id="changePassword">Change Password</button>
            <button class="linkButton" id="cancel">Cancel</button>
        </div>
    </fieldset>
</form>