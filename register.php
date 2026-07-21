<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/config/db.php';

if (isLoggedIn()) redirect('/menu.php');

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($_POST['name'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $role = ($_POST['role'] ?? 'customer') === 'admin' ? 'admin' : 'customer';

    if ($name === '' || $email === '' || $password === '') {
        $error = 'All fields are required.';
    } else {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $error = 'Email already registered.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
            $stmt->execute([$name, $email, $hash, $role]);
            redirect('/login.php');
        }
    }
}

require __DIR__ . '/header.php';
?>
<h2>Create an Account</h2>
<?php if ($error): ?><p class="alert"><?= $error ?></p><?php endif; ?>
<form method="POST" class="form-card">
    <label>Name</label>
    <input type="text" name="name" required>

    <label>Email</label>
    <input type="email" name="email" required>

    <label>Password</label>
    <input type="password" name="password" required>

    <label>Role</label>
    <select name="role">
        <option value="customer">Customer</option>
        <option value="admin">Admin</option>
    </select>

    <button type="submit">Register</button>
</form>
<p>Already have an account? <a href="/login.php">Login here</a></p>
<?php require __DIR__ . '/footer.php'; ?>
