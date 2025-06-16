<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

require 'config.php';

$table = $_GET['table'] ?? '';
$id = $_GET['id'] ?? '';
if (!$table || !$id) {
    die('Table or ID not specified.');
}

// Check user role and permissions for edit operation
$role = $_SESSION['role'];
$allowed_tables = [];
switch ($role) {
    case 'Admin':
        $allowed_tables = ['admission', 'doctor', 'patients', 'medicine', 'transactions', 'staff', 'room', 'roles', 'users'];
        break;
    case 'Receptionist':
        $allowed_tables = ['admission', 'patients', 'transactions'];
        break;
    case 'Pharmacist':
        $allowed_tables = ['medicine'];
        break;
    default:
        // Doctor cannot edit records
        die('You do not have permission to edit records.');
}

if (!in_array($table, $allowed_tables)) {
    die('You do not have permission to edit records in this table.');
}

/**
 * Allow users to edit their own username and password regardless of role.
 * Admin can edit any user.
 * Other roles cannot edit other users.
 */
if ($table === 'users') {
    if ($id !== $_SESSION['username'] && $role !== 'Admin') {
        die('You do not have permission to edit other users.');
    }
}

// Get primary key column
$stmt = $pdo->prepare("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ? AND COLUMN_KEY = 'PRI'");
$stmt->execute([$pdo->query('select database()')->fetchColumn(), $table]);
$primaryKey = $stmt->fetchColumn();
if (!$primaryKey) {
    die('Primary key not found for table.');
}

// Fetch existing record
$stmt = $pdo->prepare("SELECT * FROM $table WHERE $primaryKey = ?");
$stmt->execute([$id]);
$record = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$record) {
    die('Record not found.');
}

// Get columns info
$stmt = $pdo->prepare("SELECT COLUMN_NAME, DATA_TYPE, COLUMN_KEY, EXTRA FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ? ORDER BY ORDINAL_POSITION");
$stmt->execute([$pdo->query('select database()')->fetchColumn(), $table]);
$columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Remove auto_increment columns from editable form fields
$form_columns = array_filter($columns, function($col) {
    return strpos($col['EXTRA'], 'auto_increment') === false;
});

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fields = [];
    $values = [];
    foreach ($form_columns as $col) {
        $colName = $col['COLUMN_NAME'];
        $fields[] = "$colName = ?";
        if ($table === 'users' && $colName === 'password') {
            // Hash password before saving
            $values[] = password_hash($_POST[$colName] ?? '', PASSWORD_DEFAULT);
        } else {
            $values[] = $_POST[$colName] ?? null;
        }
    }
    $values[] = $id;
    $sql = "UPDATE $table SET " . implode(',', $fields) . " WHERE $primaryKey = ?";
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($values);
        $success = "Record updated successfully.";
        // Refresh record data
        $stmt = $pdo->prepare("SELECT * FROM $table WHERE $primaryKey = ?");
        $stmt->execute([$id]);
        $record = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        $error = "Error updating record: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Edit Record - <?php echo htmlspecialchars($table); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            padding: 2rem;
            background: #f8f9fa;
        }
        .container {
            max-width: 700px;
            background: white;
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Edit Record in <?php echo htmlspecialchars($table); ?></h2>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>
    <form method="POST" action="">
        <?php foreach ($form_columns as $col): 
            $colName = $col['COLUMN_NAME'];
            $value = $record[$colName] ?? '';
            $inputType = in_array($col['DATA_TYPE'], ['int','decimal','float','double']) ? 'number' : 'text';
            if ($table === 'users' && $colName === 'password') {
                $inputType = 'password';
                $value = ''; // Do not prefill password field
            }
        ?>
            <div class="mb-3">
                <label for="<?php echo htmlspecialchars($colName); ?>" class="form-label"><?php echo htmlspecialchars($colName); ?></label>
            <input
                type="<?php 
                    if ($table === 'users' && $colName === 'password') {
                        echo 'password';
                    } elseif (in_array($col['DATA_TYPE'], ['date', 'datetime', 'timestamp'])) {
                        echo 'date';
                    } elseif (in_array($col['DATA_TYPE'], ['int','decimal','float','double'])) {
                        echo 'number';
                    } else {
                        echo 'text';
                    }
                ?>"
                class="form-control"
                id="<?php echo htmlspecialchars($colName); ?>"
                name="<?php echo htmlspecialchars($colName); ?>"
                value="<?php echo htmlspecialchars($value); ?>"
                <?php echo ($col['COLUMN_KEY'] === 'PRI') ? 'readonly' : ''; ?>
                required
            >
            </div>
        <?php endforeach; ?>
        <button type="submit" class="btn btn-primary">Update Record</button>
        <a href="admin.php?table=<?php echo urlencode($table); ?>" class="btn btn-secondary ms-2">Back</a>
    </form>
</div>
</body>
</html>
