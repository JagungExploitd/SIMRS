<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Receptionist') {
    header('Location: index.php');
    exit();
}

require 'config.php';


$allowed_tables = ['admission', 'patients', 'transactions'];
$table = $_GET['table'] ?? 'admission';
if (!in_array($table, $allowed_tables)) {
    $table = 'admission';
}

// Get search term from GET parameters
$search = $_GET['search'] ?? '';
$searchParam = '%' . $search . '%';

// Fetch data for the selected table with joins for better clarity
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
                    WHERE CONCAT(p.first_name, ' ', p.last_name) LIKE ?
                    LIMIT 100";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$searchParam]);
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
    } else {
        $stmt = $pdo->query("SELECT * FROM $table LIMIT 100");
    }
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $rows = [];
    $error = "Error fetching data: " . $e->getMessage();
}

// Get columns for the selected table
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
    <title>Receptionist Panel - Manage <?php echo htmlspecialchars($table); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            padding-top: 4.5rem;
        }
        .nav-tabs .nav-link.active {
            font-weight: bold;
        }
        .container {
            max-width: 100%;
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
                Logged in as: <?php echo htmlspecialchars($_SESSION['username']); ?> (Receptionist)
            </span>
            <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
        </div>
    </div>
</nav>

<div class="container">
    <h2>Receptionist Panel - Manage <?php echo ucfirst(htmlspecialchars($table)); ?></h2>
    <form method="GET" class="mb-3">
        <input type="hidden" name="table" value="<?php echo htmlspecialchars($table); ?>" />
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by name" value="<?php echo htmlspecialchars($search); ?>" />
            <button class="btn btn-primary" type="submit">Search</button>
        </div>
    </form>
    <ul class="nav nav-tabs mb-3">
        <?php foreach ($allowed_tables as $t): ?>
            <li class="nav-item">
                <a class="nav-link <?php echo $t === $table ? 'active' : ''; ?>" href="?table=<?php echo $t; ?>"><?php echo ucfirst($t); ?></a>
            </li>
        <?php endforeach; ?>
    </ul>

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
