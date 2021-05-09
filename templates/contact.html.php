<?php
   if(session_status() === PHP_SESSION_NONE){
    session_start();
    }

    if(isset($_SESSION["ErrorFields"])){
        include "models/FormValidator.php";

        $validator = unserialize($_SESSION["ErrorFields"]);
        $oldData = $_SESSION["OldData"];

        unset($_SESSION["OldData"]);
        unset($_SESSION["ErrorFields"]);
    }
?>

<section class="contactUs">
    <h2>Contact Us</h2>

    <p>Have a problem or query, or just want to chat? No problem! Here at Sports Warehouse, we are open to any query or question you might have. Send us a line below and we'll get back to you as soon as possible.</p>
    <form action="controllers/contactController.php" method="post" name="contact">
        <fieldset>
            <p class="formInput">
                <input type="text" id="firstName" name="firstName" required placeholder="John" value="<?= isset($oldData) ? $oldData["firstName"] : null ?>">
                <label for="firstName" <?= isset($validator) ? $validator->SetErrorClass("firstName") : null ?>>First Name</label>
                <span class="inputErrors"><?= isset($validator) && in_array("firstName", $validator->errorFields) ? "- Field must contain a value" : null ?></span>
            </p>
            <p class="formInput">
                <input type="text" id="lastName" name="lastName" required placeholder="Smith" value="<?= isset($oldData) ? $oldData["lastName"] : null ?>">
                <label for="lastName"  <?= isset($validator) ? $validator->SetErrorClass("lastName") : null ?>>Last Name</label>
                <span class="inputErrors"><?= isset($validator) && in_array("lastName", $validator->errorFields) ? "- Field must contain a value" : null ?></span>
            </p>
            <p class="formInput">
                <input type="tel" name="contactNumber" id="contactNumber" placeholder="0404 040 404" value="<?= isset($oldData) ? $oldData["contactNumber"] : null ?>">
                <label for="contactNumber"  <?= isset($validator) ? $validator->SetErrorClass("contactNumber") : null ?>>Contact Number</label>
                <span class="inputErrors"></span>
            </p>
            <p class="formInput">
                <input type="email" name="email" id="email" required placeholder="john.smith@email.com" value="<?= isset($oldData) ? $oldData["email"] : null ?>">
                <label for="email"  <?= isset($validator) ? $validator->SetErrorClass("email") : null ?>>Email</label>
                <span class="inputErrors">
                    <?= isset($validator) && in_array("email", $validator->errorFields) ? "- Field must contain a value\n" : null ?>
                    <?= isset($oldData) && !filter_var($oldData["email"] ? "- Email is invalid" : null) ?>
                </span>
            </p>
            <p class="formInput">
                <textarea name="question" id="question" cols="30" rows="5" required placeholder="When will this product be back in stock?"><?= isset($oldData) ? $oldData["question"] : null ?></textarea>
                <label for="question"  <?= isset($validator) ? $validator->SetErrorClass("question") : null ?>>Question</label>
                <span class="inputErrors"><?= isset($validator) && in_array("question", $validator->errorFields) ? "- Field must contain a value" : null ?></span>
            </p>

            <div class="formButtons">
                <button type="submit" class="linkButton">Submit</button>
                <button type="reset" class="linkButton">Reset</button>
            </div>

        </fieldset>
    </form>
</section>