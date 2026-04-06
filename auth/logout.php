<?php
/**
 * Logout Page
 */

session_destroy();
header("Location: ?route=home");
exit();
