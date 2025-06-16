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

// Check user role and permissions for delete operation
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
        // Doctor cannot delete records
        die('You do not have permission to delete records.');
}

if (!in_array($table, $allowed_tables)) {
    die('You do not have permission to delete records in this table.');
}

// Get primary key column
$stmt = $pdo->prepare("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ? AND COLUMN_KEY = 'PRI'");
$stmt->execute([$pdo->query('select database()')->fetchColumn(), $table]);
$primaryKey = $stmt->fetchColumn();
if (!$primaryKey) {
    die('Primary key not found for table.');
}

// Delete record
try {
    $stmt = $pdo->prepare("DELETE FROM $table WHERE $primaryKey = ?");
    $stmt->execute([$id]);
    header("Location: admin.php?table=" . urlencode($table));
    exit();
} catch (Exception $e) {
    die("Error deleting record: " . $e->getMessage());
}
?>
