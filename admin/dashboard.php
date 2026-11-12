<?php
session_start();
require_once __DIR__ . '/../includes/db.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

// Handle delete operations
if (isset($_GET['delete'])) {
    $table = $_GET['table'] ?? '';
    $id = intval($_GET['id'] ?? 0);

    if ($table === 'projects' && $id > 0) {
        $stmt = $conn->prepare("DELETE FROM projects WHERE id = ?");
        $stmt->execute([$id]);
    } elseif ($table === 'skills' && $id > 0) {
        $stmt = $conn->prepare("DELETE FROM skills WHERE id = ?");
        $stmt->execute([$id]);
    } elseif ($table === 'messages' && $id > 0) {
        $stmt = $conn->prepare("DELETE FROM contact_messages WHERE id = ?");
        $stmt->execute([$id]);
    }
    header('Location: dashboard.php');
    exit;
}

// Get counts
$projects_count = $conn->query("SELECT COUNT(*) as c FROM projects")->fetch()['c'];
$skills_count = $conn->query("SELECT COUNT(*) as c FROM skills")->fetch()['c'];
$messages_count = $conn->query("SELECT COUNT(*) as c FROM contact_messages")->fetch()['c'];

// Recent messages
$messages = $conn->query("SELECT * FROM contact_messages ORDER BY submitted_at DESC LIMIT 5");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Portfolio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="../css/style.css" rel="stylesheet">
</head>
<body data-bs-theme="light">
<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="dashboard.php">Admin Panel</a>
        <div class="d-flex">
            <a href="../index.php" class="btn btn-outline-light btn-sm me-2">View Site</a>
            <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
        </div>
    </div>
</nav>

<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="glass-card p-4 text-center">
                <i class="bi bi-folder fs-1 text-primary"></i>
                <h3 class="mt-2"><?php echo $projects_count; ?></h3>
                <p class="text-muted">Projects</p>
                <a href="projects.php" class="btn btn-sm btn-primary">Manage</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="glass-card p-4 text-center">
                <i class="bi bi-code-slash fs-1 text-success"></i>
                <h3 class="mt-2"><?php echo $skills_count; ?></h3>
                <p class="text-muted">Skills</p>
                <a href="skills.php" class="btn btn-sm btn-success">Manage</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="glass-card p-4 text-center">
                <i class="bi bi-envelope fs-1 text-warning"></i>
                <h3 class="mt-2"><?php echo $messages_count; ?></h3>
                <p class="text-muted">Messages</p>
                <a href="messages.php" class="btn btn-sm btn-warning">View</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="glass-card p-4">
                <h4 class="fw-bold mb-3"><i class="bi bi-clock-history me-2"></i>Recent Messages</h4>
                <?php if ($messages->rowCount() > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Subject</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($msg = $messages->fetch()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($msg['name']); ?></td>
                                    <td><?php echo htmlspecialchars($msg['email']); ?></td>
                                    <td><?php echo htmlspecialchars($msg['subject']); ?></td>
                                    <td><?php echo date('M d, Y', strtotime($msg['submitted_at'])); ?></td>
                                    <td>
                                        <a href="?delete=1&table=messages&id=<?php echo $msg['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this message?')">Delete</a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted">No messages yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
