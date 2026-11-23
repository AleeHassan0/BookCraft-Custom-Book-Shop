<?php

// BookCraft application configuration

define('BASE_URL', '/bookcraft/');

// Start session if it has not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>