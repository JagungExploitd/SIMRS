<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Doctor') {
    header('Location: index.php');
    exit();
}

require 'config.php';

// Get logged-in doctor's username
$username = $_SESSION['username'];

// Get search term from GET parameters
$search = $_GET['search'] ?? '';
$searchParam = '%' . $search . '%';

// Get doctorID for logged-in doctor
$stmt = $pdo->prepare("SELECT doctorID FROM doctor WHERE username = ?");
$stmt->execute([$username]);
$doctorID = $stmt->fetchColumn();

if (!$doctorID) {
    die('Doctor record not found.');
}

if ($search) {
    $stmt = $pdo->prepare("
        SELECT a.*, p.first_name AS patient_first_name, p.last_name AS patient_last_name
        FROM admission a
        JOIN patients p ON a.patientsID = p.patientsID
        WHERE a.doctorID = ? AND CONCAT(p.first_name, ' ', p.last_name) LIKE ?
        ORDER BY a.admission_date DESC
    ");
    $stmt->execute([$doctorID, $searchParam]);
} else {
    $stmt = $pdo->prepare("
        SELECT a.*, p.first_name AS patient_first_name, p.last_name AS patient_last_name
        FROM admission a
        JOIN patients p ON a.patientsID = p.patientsID
        WHERE a.doctorID = ?
        ORDER BY a.admission_date DESC
    ");
    $stmt->execute([$doctorID]);
}
$admissions = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Check if a patient detail view is requested
$patientID = $_GET['patientID'] ?? null;
$patientDetails = null;
if ($patientID) {
    $stmt = $pdo->prepare("
        SELECT p.*, pr.province_name
        FROM patients p
        LEFT JOIN province pr ON p.provinceID = pr.provinceID
        WHERE p.patientsID = ?
        LIMIT 1
    ");
    $stmt->execute([$patientID]);
    $patientDetails = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Doctor Admissions - SIM RS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            padding: 2rem;
            background: #f8f9fa;
        }
        .container {
            max-width: 900px;
            background: white;
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        table {
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Admissions Assigned to You</h2>
    <form method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by patient name" value="<?php echo htmlspecialchars($search); ?>" />
            <button class="btn btn-primary" type="submit">Search</button>
        </div>
    </form>

    <?php if ($patientDetails): ?>
        <div class="card mb-4">
            <div class="card-header">
                <h5>Patient Details: <?php echo htmlspecialchars($patientDetails['first_name'] . ' ' . $patientDetails['last_name']); ?></h5>
            </div>
            <div class="card-body">
                <p><strong>Gender:</strong> <?php echo htmlspecialchars($patientDetails['gender']); ?></p>
                <p><strong>Birth Date:</strong> <?php echo htmlspecialchars($patientDetails['birth_date']); ?></p>
                <p><strong>Weight:</strong> <?php echo htmlspecialchars($patientDetails['weight']); ?> kg</p>
                <p><strong>Height:</strong> <?php echo htmlspecialchars($patientDetails['height']); ?> cm</p>
                <p><strong>Disease:</strong> <?php echo htmlspecialchars($patientDetails['disease']); ?></p>
                <p><strong>Province:</strong> <?php echo htmlspecialchars($patientDetails['province_name']); ?></p>
                <!-- Add more patient details as needed -->
                <a href="doctor.php" class="btn btn-secondary mt-3">Back to Admissions</a>
            </div>
        </div>
    <?php endif; ?>

    <?php if (empty($admissions) && !$patientDetails): ?>
        <p>No admissions found.</p>
    <?php elseif (!$patientDetails): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-sm align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Admission ID</th>
                        <th>Patient Name</th>
                        <th>Admission Date</th>
                        <th>Discharge Date</th>
                        <th>Initial Diagnosis</th>
                        <th>Room ID</th>
                        <th>Staff ID</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($admissions as $admission): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($admission['admissionID']); ?></td>
                            <td><?php echo htmlspecialchars($admission['patient_first_name'] . ' ' . $admission['patient_last_name']); ?></td>
                            <td><?php echo htmlspecialchars($admission['admission_date']); ?></td>
                            <td><?php echo htmlspecialchars($admission['discharge_date'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($admission['initial_diagnosis']); ?></td>
                            <td><?php echo htmlspecialchars($admission['roomID']); ?></td>
                            <td><?php echo htmlspecialchars($admission['staffID']); ?></td>
                            <td><a href="doctor.php?patientID=<?php echo urlencode($admission['patientsID']); ?>" class="btn btn-sm btn-info">View Patient</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
    <a href="dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
</div>
</body>
</html>
