<?php
echo "Start<br>";

require_once '../config/db.php';
echo "Database OK<br>";

require_once '../includes/functions.php';
echo "Functions OK<br>";

require_once '../includes/auth.php';
echo "Auth OK<br>";

echo "Everything loaded successfully!";