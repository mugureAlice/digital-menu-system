<?php

echo "Start<br>";


require_once __DIR__ . '/../config/db.php';

echo "Database OK<br>";



require_once __DIR__ . '/../includes/functions.php';

echo "Functions OK<br>";



require_once __DIR__ . '/../includes/auth.php';

echo "Auth OK<br>";



echo "Everything loaded successfully!";

?>