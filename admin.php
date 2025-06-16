<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Admin') {
    header('Location: index.php');
    exit();
}
require 'config.php';

// Determine which table to manage
$tables = ['admission', 'doctor', 'patients', 'medicine', 'transactions', 'staff', 'room', 'roles', 'users'];
$table = $_GET['table'] ?? 'admission';
if (!in_array($table, $tables)) {
    $table = 'admission';
}

$search = $_GET['search'] ?? '';
$searchParam = '%' . $search . '%';

try {
    if ($table === 'admission') {
        if ($search) {
            $sql = "SELECT a.admissionID, CONCAT(p.first_name, ' ', p.last_name) AS patient_name, 
                    CONCAT(d.first_name, ' ', d.last_name) AS doctor_name, 
                    CONCAT(s.staff_first_name, ' ', s.staff_last_name) AS staff_name, 
                    r.room_name, a.admission_date, a.discharge_date, a.initial_diagnosis
                    FROM admission a
                    JOIN patients p ON a.patientsID = p.patientsID
                    JOIN doctor d ON a.doctorID = d.doctorID
                    JOIN staff s ON a.staffID = s.staffID
                    JOIN room r ON a.roomID = r.roomID
                    ORDER BY a.admission_date DESC
                    WHERE CONCAT(p.first_name, ' ', p.last_name) LIKE ? OR CONCAT(d.first_name, ' ', d.last_name) LIKE ? OR CONCAT(s.staff_first_name, ' ', s.staff_last_name) LIKE ?
                    LIMIT 100";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$searchParam, $searchParam, $searchParam]);
        } else {
            $sql = "SELECT a.admissionID, CONCAT(p.first_name, ' ', p.last_name) AS patient_name, 
                    CONCAT(d.first_name, ' ', d.last_name) AS doctor_name, 
                    CONCAT(s.staff_first_name, ' ', s.staff_last_name) AS staff_name, 
                    r.room_name, a.admission_date, a.discharge_date, a.initial_diagnosis
                    FROM admission a
                    JOIN patients p ON a.patientsID = p.patientsID
                    JOIN doctor d ON a.doctorID = d.doctorID
                    JOIN staff s ON a.staffID = s.staffID
                    JOIN room r ON a.roomID = r.roomID
                    ORDER BY a.admission_date DESC
                    LIMIT 100";
            $stmt = $pdo->query($sql);
        }
    } elseif ($table === 'patients') {
        if ($search) {
            $sql = "SELECT p.patientsID, CONCAT(p.first_name, ' ', p.last_name) AS full_name, p.weight, p.height, p.disease, p.gender, p.birth_date, pr.province_name
                    FROM patients p
                    JOIN province pr ON p.provinceID = pr.provinceID
                    WHERE CONCAT(p.first_name, ' ', p.last_name) LIKE ?
                    LIMIT 100";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$searchParam]);
        } else {
            $sql = "SELECT p.patientsID, CONCAT(p.first_name, ' ', p.last_name) AS full_name, p.weight, p.height, p.disease, p.gender, p.birth_date, pr.province_name
                    FROM patients p
                    JOIN province pr ON p.provinceID = pr.provinceID
                    LIMIT 100";
            $stmt = $pdo->query($sql);
        }
    } elseif ($table === 'transactions') {
        if ($search) {
            $sql = "SELECT t.transactionID, t.transaction_date, t.total_amount, t.payment_method,
                    a.admissionID, CONCAT(p.first_name, ' ', p.last_name) AS patient_name,
                    m.medicine_name
                    FROM transactions t
                    JOIN admission a ON t.admissionID = a.admissionID
                    JOIN patients p ON a.patientsID = p.patientsID
                    JOIN medicine m ON t.medicineID = m.medicineID
                    WHERE CONCAT(p.first_name, ' ', p.last_name) LIKE ?
                    LIMIT 100";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$searchParam]);
        } else {
            $sql = "SELECT t.transactionID, t.transaction_date, t.total_amount, t.payment_method,
                    a.admissionID, CONCAT(p.first_name, ' ', p.last_name) AS patient_name,
                    m.medicine_name
                    FROM transactions t
                    JOIN admission a ON t.admissionID = a.admissionID
                    JOIN patients p ON a.patientsID = p.patientsID
                    JOIN medicine m ON t.medicineID = m.medicineID
                    LIMIT 100";
            $stmt = $pdo->query($sql);
        }
    } elseif ($table === 'doctor') {
        if ($search) {
            $sql = "SELECT d.doctorID, u.username, CONCAT(d.first_name, ' ', d.last_name) AS full_name, d.specialist
                    FROM doctor d
                    LEFT JOIN users u ON d.username = u.username
                    WHERE CONCAT(d.first_name, ' ', d.last_name) LIKE ?
                    LIMIT 100";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$searchParam]);
        } else {
            $sql = "SELECT d.doctorID, u.username, CONCAT(d.first_name, ' ', d.last_name) AS full_name, d.specialist
                    FROM doctor d
                    LEFT JOIN users u ON d.username = u.username
                    LIMIT 100";
            $stmt = $pdo->query($sql);
        }
    } elseif ($table === 'staff') {
        if ($search) {
            $sql = "SELECT s.staffID, u.username, CONCAT(s.staff_first_name, ' ', s.staff_last_name) AS full_name
                    FROM staff s
                    LEFT JOIN users u ON s.username = u.username
                    WHERE CONCAT(s.staff_first_name, ' ', s.staff_last_name) LIKE ?
                    LIMIT 100";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$searchParam]);
        } else {
            $sql = "SELECT s.staffID, u.username, CONCAT(s.staff_first_name, ' ', s.staff_last_name) AS full_name
                    FROM staff s
                    LEFT JOIN users u ON s.username = u.username
                    LIMIT 100";
            $stmt = $pdo->query($sql);
        }
    } elseif ($table === 'users') {
        if ($search) {
            $sql = "SELECT u.username, u.password, r.role_name AS role
                    FROM users u
                    JOIN roles r ON u.roleID = r.roleID
                    WHERE u.username LIKE ?
                    LIMIT 100";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$searchParam]);
        } else {
            $sql = "SELECT u.username, u.password, r.role_name AS role
                    FROM users u
                    JOIN roles r ON u.roleID = r.roleID
                    LIMIT 100";
            $stmt = $pdo->query($sql);
        }
    } else {
        $stmt = $pdo->query("SELECT * FROM $table LIMIT 100");
    }
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $rows = [];
    $error = "Error fetching data: " . $e->getMessage();
}

$columns = [];
if (!empty($rows)) {
    $columns = array_keys($rows[0]);
} else {
    // Try to get columns from information_schema
    $stmt = $pdo->prepare("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?");
    $stmt->execute([$pdo->query('select database()')->fetchColumn(), $table]);
    $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Admin Panel - Manage <?php echo htmlspecialchars($table); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            padding-top: 4.5rem;
        }
        .sidebar {
            height: 100vh;
            position: fixed;
            top: 56px;
            left: 0;
            width: 220px;
            background-color: #f8f9fa;
            padding-top: 1rem;
            border-right: 1px solid #dee2e6;
        }
        .content {
            margin-left: 230px;
            padding: 1rem;
            overflow-x: auto;
        }
        .table-responsive {
            max-height: 70vh;
            overflow-x: auto;
            overflow-y: auto;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark bg-primary fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="dashboard.php">SIM RS</a>
        <div class="d-flex">
            <span class="navbar-text me-3">
                Logged in as: <?php echo htmlspecialchars($_SESSION['username']); ?> (Administrator)
            </span>
            <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
        </div>
    </div>
</nav>

<div class="sidebar">
    <h5 class="px-3">Manage Tables</h5>
    <div class="list-group list-group-flush">
        <?php foreach ($tables as $t): ?>
            <a href="?table=<?php echo $t; ?>" class="list-group-item list-group-item-action <?php echo $t === $table ? 'active' : ''; ?>">
                <?php echo ucfirst($t); ?>
            </a>
        <?php endforeach; ?>
    </div>
</div>

<div class="content">
    <h2>Manage Table: <?php echo htmlspecialchars($table); ?></h2>
    <form method="GET" class="mb-3">
        <input type="hidden" name="table" value="<?php echo htmlspecialchars($table); ?>" />
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by name" value="<?php echo htmlspecialchars($search); ?>" />
            <button class="btn btn-primary" type="submit">Search</button>
        </div>
    </form>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-bordered table-hover table-sm align-middle">
            <thead class="table-light">
                <tr>
                    <?php foreach ($columns as $col): ?>
                        <th><?php echo htmlspecialchars($col); ?></th>
                    <?php endforeach; ?>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $row): ?>
                    <tr>
                        <?php foreach ($columns as $col): ?>
                            <td><?php echo htmlspecialchars($row[$col]); ?></td>
                        <?php endforeach; ?>
                        <td>
                            <a href="edit.php?table=<?php echo urlencode($table); ?>&id=<?php echo urlencode($row[$columns[0]]); ?>" class="btn btn-sm btn-primary">Edit</a>
                            <a href="delete.php?table=<?php echo urlencode($table); ?>&id=<?php echo urlencode($row[$columns[0]]); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete this record?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <a href="create.php?table=<?php echo urlencode($table); ?>" class="btn btn-success mt-3">Add New Record</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
