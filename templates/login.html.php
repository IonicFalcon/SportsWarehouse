<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
    <title>Login - Sports Warehouse</title>
</head>
<body>
    <div class="root">
        <h1>
            <a href="index.php" class="siteLogo" aria-label="Sports Warehouse">
                <img src="images/LogoLarge.gif" alt="">
            </a>
        </h1>

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

                <div class="formButtons">
                    <button type="submit" class="linkButton" id="login">Login</button>
                    <button class="linkButton" id="cancel">Cancel</button>
                </div>

            </fieldset>
        </form>
    </div>
</body>
</html>