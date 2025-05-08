<?php
// Check if constants are already defined to prevent redefinition warnings
if (!defined('DB_HOST')) {
    define('DB_HOST', 'localhost');
}

if (!defined('DB_NAME')) {
    define('DB_NAME', 'td_construction');  // Ensure this matches the actual DB name
}

if (!defined('DB_USER')) {
    define('DB_USER', 'root');  // Update if necessary
}

if (!defined('DB_PASS')) {
    define('DB_PASS', '');      // Update if using a password
}
?>
