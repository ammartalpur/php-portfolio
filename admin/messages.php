<?php
session_start();
require_once __DIR__ . '/../includes/db.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM contact_messages WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: messages.php');
    exit;
}

$messages = $conn->query("SELECT * FROM contact_messages ORDER BY submitted_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Messages - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="../css/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="dashboard.php">Admin Panel</a>
        <a href="dashboard.php" class="btn btn-outline-light btn-sm">Dashboard</a>
    </div>
</nav>

<div class="container py-4">
    <h2 class="fw-bold mb-4">Contact Messages</h2>

    <?php if ($messages->rowCount() > 0): ?>
        <div class="glass-card p-4">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($msg = $messages->fetch()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($msg['name']); ?></td>
                            <td><a href="mailto:<?php echo htmlspecialchars($msg['email']); ?>"><?php echo htmlspecialchars($msg['email']); ?></a></td>
                            <td><?php echo htmlspecialchars($msg['subject']); ?></td>
                            <td><small><?php echo htmlspecialchars(substr($msg['message'], 0, 100)) . '...'; ?></small></td>
                            <td><?php echo date('M d, Y H:i', strtotime($msg['submitted_at'])); ?></td>
                            <td>
                                <a href="?delete=<?php echo $msg['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this message?')">Delete</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php else: ?>
        <div class="glass-card p-4 text-center">
            <p class="text-muted">No messages yet.</p>
        </div>
    <?php endif; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
