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

<form action="controllers/loginController.php" method="post">
    <fieldset>
        <p class="formInput">
            <input type="text" name="username" id="username" required>
            <label for="username">Username</label>
        </p>
        <p class="formInput">
            <input type="password" name="password" id="password" required>
            <label for="password">Password</label>
        </p>

        <input type="hidden" name="reauthPage" value="<?= $_GET["reauthorise"] ?? null ?>">

        <div class="formButtons">
            <button type="submit" class="linkButton" id="login">Login</button>
            <button class="linkButton" id="cancel" onclick="window.location.replace('index.php')">Cancel</button>
        </div>

    </fieldset>
</form>