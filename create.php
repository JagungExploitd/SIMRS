<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

require 'config.php';

$table = $_GET['table'] ?? '';
if (!$table) {
    die('Table not specified.');
}

// Check user role and permissions for create operation
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
        // Doctor cannot create records
        die('You do not have permission to create records.');
}

if (!in_array($table, $allowed_tables)) {
    die('You do not have permission to create records in this table.');
}

// Get columns info
$stmt = $pdo->prepare("SELECT COLUMN_NAME, DATA_TYPE, COLUMN_KEY, EXTRA FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ? ORDER BY ORDINAL_POSITION");
$stmt->execute([$pdo->query('select database()')->fetchColumn(), $table]);
$columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Remove auto_increment columns from form
$form_columns = array_filter($columns, function($col) {
    return strpos($col['EXTRA'], 'auto_increment') === false;
});

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fields = [];
    $placeholders = [];
    $values = [];
    foreach ($form_columns as $col) {
        $colName = $col['COLUMN_NAME'];
        $fields[] = $colName;
        $placeholders[] = '?';
        if ($table === 'users' && $colName === 'password') {
            // Hash the password before saving
            $values[] = password_hash($_POST[$colName] ?? '', PASSWORD_DEFAULT);
        } else {
            $values[] = $_POST[$colName] ?? null;
        }
    }
    $sql = "INSERT INTO $table (" . implode(',', $fields) . ") VALUES (" . implode(',', $placeholders) . ")";
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($values);
        $success = "Record added successfully.";
    } catch (Exception $e) {
        $error = "Error adding record: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Add New Record - <?php echo htmlspecialchars($table); ?></title>
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
    <h2>Add New Record to <?php echo htmlspecialchars($table); ?></h2>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>
<?php
// Fetch provinces for dropdown if table is patients
$provinces = [];
if ($table === 'patients') {
    $stmt = $pdo->query("SELECT provinceID, province_name FROM province ORDER BY province_name");
    $provinces = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<form method="POST" action="">
    <?php foreach ($form_columns as $col): ?>
        <div class="mb-3">
            <label for="<?php echo htmlspecialchars($col['COLUMN_NAME']); ?>" class="form-label"><?php echo htmlspecialchars($col['COLUMN_NAME']); ?></label>
            <?php if ($table === 'patients' && $col['COLUMN_NAME'] === 'provinceID'): ?>
                <select class="form-select" id="provinceID" name="provinceID" required>
                    <option value="">Select Province</option>
                    <?php foreach ($provinces as $province): ?>
                        <option value="<?php echo htmlspecialchars($province['provinceID']); ?>"><?php echo htmlspecialchars($province['province_name']); ?></option>
                    <?php endforeach; ?>
                </select>
            <?php elseif ($table === 'patients' && $col['COLUMN_NAME'] === 'gender'): ?>
                <select class="form-select" id="gender" name="gender" required>
                    <option value="">Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            <?php elseif ($table === 'patients' && $col['COLUMN_NAME'] === 'birth_date'): ?>
                <input
                    type="date"
                    class="form-control"
                    id="birth_date"
                    name="birth_date"
                    required
                >
            <?php else: ?>
                <input
                    type="<?php echo in_array($col['DATA_TYPE'], ['int','decimal','float','double']) ? 'number' : 'text'; ?>"
                    class="form-control"
                    id="<?php echo htmlspecialchars($col['COLUMN_NAME']); ?>"
                    name="<?php echo htmlspecialchars($col['COLUMN_NAME']); ?>"
                    <?php echo (strpos($col['EXTRA'], 'auto_increment') !== false) ? 'readonly value="Auto"' : ''; ?>
                    required
                >
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
    <button type="submit" class="btn btn-primary">Add Record</button>
    <a href="admin.php?table=<?php echo urlencode($table); ?>" class="btn btn-secondary ms-2">Back</a>
</form>
</div>
</body>
</html>
