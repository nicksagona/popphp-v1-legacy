<?php
if ($_POST) {
    echo "Via a POST request, you entered <strong>" .
        $_POST['name'] . "</strong> as your name and <a href=\"mailto:" .
        $_POST['email'] . "\">" .  $_POST['email'] . "</a> as your email.";
} else if (isset($_GET['name'])) {
    echo "Via a GET request, you entered <strong>" .
        $_GET['name'] . "</strong> as your name and <a href=\"mailto:" .
        $_GET['email'] . "\">" .  $_GET['email'] . "</a> as your email.";
}

