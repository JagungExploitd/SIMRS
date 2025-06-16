<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Pharmacist') {
    header('Location: index.php');
    exit();
}

require 'config.php';

$table = 'medicine';

// Get search term from GET parameters
$search = $_GET['search'] ?? '';
$searchParam = '%' . $search . '%';

// Fetch data for medicine table with joins if needed
try {
    if ($search) {
        $sql = "SELECT medicineID, medicine_name, medicine_stock, medicine_price FROM medicine WHERE medicine_name LIKE ? LIMIT 100";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$searchParam]);
    } else {
        $sql = "SELECT medicineID, medicine_name, medicine_stock, medicine_price FROM medicine LIMIT 100";
        $stmt = $pdo->query($sql);
    }
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $rows = [];
    $error = "Error fetching data: " . $e->getMessage();
}

// Get columns for medicine table
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
    <title>Pharmacist Panel - Manage Medicine</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            padding-top: 4.5rem;
        }
        .container {
            max-width: 900px;
            padding: 1rem;
        }
        .table-responsive {
            max-height: 70vh;
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
                Logged in as: <?php echo htmlspecialchars($_SESSION['username']); ?> (Pharmacist)
            </span>
            <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
        </div>
    </div>
</nav>

<div class="container">
    <h2>Pharmacist Panel - Manage Medicine</h2>
    <form method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by medicine name" value="<?php echo htmlspecialchars($search); ?>" />
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
