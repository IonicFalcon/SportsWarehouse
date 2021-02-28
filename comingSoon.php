<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coming Soon - SportsWarehouse</title>
</head>
<body>
    <div class="root">
        <div class="logo">
            <img src="images/LogoLarge.gif" alt="SportsWarehouse">
        </div>

        <main>
            <p>SportsWarehouse is coming soon. If you have any questions, we would love to hear from you, please complete the following information.</p>

            <form action="controllers/comingSoonControl.php" name="feedback" method="post" onsubmit="return ValidateForm()">
                <p>
                    <label for="firstName">First Name *</label>
                    <input type="text" id="firstName" name="firstName" required>
                </p>
                <p>
                    <label for="lastName">Last Name *</label>
                    <input type="text" id="lastName" name="lastName" required>
                </p>
                <p>
                    <label for="contactNumber">Contact Number</label>
                    <input type="tel" name="contactNumber" id="contactNumber">
                </p>
                <p>
                    <label for="email">Email *</label>
                    <input type="email" name="email" id="email" required>
                </p>
                <p>
                    <label for="question">Question *</label>
                    <textarea name="question" id="question" cols="30" rows="10" required></textarea>
                </p>

                <p id="errorMessage"></p>

                <div class="formButtons">
                    <input type="submit" value="Submit">
                    <input type="button" value="Reset" onclick="ResetForm()">
                </div>
                
            </form>
        </main>
    </div>

    <script src="js/comingSoon.js"></script>
</body>
</html>