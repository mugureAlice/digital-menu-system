<?php

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/config/db.php';


if (isLoggedIn()) {
    redirect('/digital-menu-system/menu.php');
}


$error = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = sanitize($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';


    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);


    if ($user && password_verify($password, $user['password'])) {

        loginUser($user);


        if ($user['role'] === 'admin') {
            redirect('/digital-menu-system/admin/dashboard.php');
        } else {
            redirect('/digital-menu-system/menu.php');
        }


    } else {

        $error = 'Invalid email or password.';

    }

}


require __DIR__ . '/header.php';

?>

<h2>Login</h2>


<?php if ($error): ?>

    <p class="alert">
        <?= sanitize($error) ?>
    </p>

<?php endif; ?>


<form method="POST" class="form-card">

    <label>Email</label>

    <input 
        type="email" 
        name="email" 
        required
    >


    <label>Password</label>

    <input 
        type="password" 
        name="password" 
        required
    >


    <button type="submit">
        Login
    </button>

</form>


<p>
    No account? 
    <a href="/digital-menu-system/register.php">
        Register here
    </a>
</p>


<p class="hint">
    Admin demo login: admin@kiosk.com / admin123
</p>


<?php require __DIR__ . '/footer.php'; ?>