<?php
if (php_sapi_name() === 'cli') {
    if ($argc !== 2) {
        echo "Usage: php generate_password_hash.php <password>\n";
        exit(1);
    }
    $password = $argv[1];
    $hash = password_hash($password, PASSWORD_DEFAULT);
    echo "Password: $password\nHash: $hash\n";
} else {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $password = $_POST['password'] ?? '';
        if ($password) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            echo "<p>Password: " . htmlspecialchars($password) . "</p>";
            echo "<p>Hash: " . htmlspecialchars($hash) . "</p>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Generate Password Hash</title>
</head>
<body>
    <h1>Generate Password Hash</h1>
    <form method="post" action="">
        <label for="password">Enter Password:</label>
        <input type="text" id="password" name="password" required />
        <button type="submit">Generate Hash</button>
    </form>
</body>
</html>
<?php
}
?>
