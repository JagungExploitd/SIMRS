<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

$role = $_SESSION['role'];
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>SIM RS - Sistem Informasi dan Manajemen Rumah Sakit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            padding-top: 4.5rem;
        }
        .nav-link.active {
            font-weight: bold;
            color: #0d6efd !important;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark bg-primary fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">SIM RS</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav me-auto mb-2 mb-md-0">
                <?php if ($role === 'Admin'): ?>
                    <li class="nav-item"><a class="nav-link" href="admin.php">Admin Panel</a></li>
                <?php endif; ?>
                <?php if ($role === 'Doctor'): ?>
                    <li class="nav-item"><a class="nav-link" href="doctor.php">My Admissions</a></li>
                <?php endif; ?>
                <?php if ($role === 'Receptionist'): ?>
                    <li class="nav-item"><a class="nav-link" href="receptionist.php">Receptionist Panel</a></li>
                <?php endif; ?>
                <?php if ($role === 'Pharmacist'): ?>
                    <li class="nav-item"><a class="nav-link" href="pharmacist.php">Medicine Management</a></li>
                <?php endif; ?>
            </ul>
            <span class="navbar-text me-3">
                Logged in as: <?php echo htmlspecialchars($username); ?> (<?php echo htmlspecialchars($role); ?>)
            </span>
            <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
        </div>
    </div>
</nav>

<div class="container">
    <h1>Welcome, <?php echo htmlspecialchars($username); ?>!</h1>
    <p>This is your dashboard. Use the navigation menu to access your features.</p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
