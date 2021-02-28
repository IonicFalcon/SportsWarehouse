<?php

// Currently, the homepage doesn't exist. This is to redirect a user to the comming soon page instead
// The actual homepage will replace this
// This saves having to rename the comming soon page away from index.php in the future
header("Location: commingSoon.php");
die();