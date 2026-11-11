<?php
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

$success = '';
$error = '';

// Handle add/edit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $tags = trim($_POST['tags'] ?? '');
    $demo_url = trim($_POST['demo_url'] ?? '#');
    $github_url = trim($_POST['github_url'] ?? '#');
    $id = intval($_POST['id'] ?? 0);

    if ($title && $description && $tags) {
        if ($id > 0) {
            $stmt = $conn->prepare("UPDATE projects SET title=?, description=?, tags=?, demo_url=?, github_url=? WHERE id=?");
            $stmt->bind_param("sssssi", $title, $description, $tags, $demo_url, $github_url, $id);
        } else {
            $stmt = $conn->prepare("INSERT INTO projects (title, description, tags, demo_url, github_url) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $title, $description, $tags, $demo_url, $github_url);
        }
        if ($stmt->execute()) {
            $success = $id > 0 ? 'Project updated successfully!' : 'Project added successfully!';
        } else {
            $error = 'Error saving project';
        }
    } else {
        $error = 'Please fill all required fields';
    }
}

// Handle delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM projects WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header('Location: projects.php');
    exit;
}

// Get edit data
$edit_project = null;
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $stmt = $conn->prepare("SELECT * FROM projects WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $edit_project = $stmt->get_result()->fetch_assoc();
}

// Get all projects
$projects = $conn->query("SELECT * FROM projects ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Projects - Admin</title>
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
    <h2 class="fw-bold mb-4">Manage Projects</h2>

    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-5">
            <div class="glass-card p-4">
                <h5 class="fw-bold mb-3"><?php echo $edit_project ? 'Edit Project' : 'Add New Project'; ?></h5>
                <form method="POST">
                    <input type="hidden" name="id" value="<?php echo $edit_project['id'] ?? ''; ?>">
                    <div class="mb-3">
                        <label class="form-label">Title *</label>
                        <input type="text" name="title" class="form-control" required value="<?php echo htmlspecialchars($edit_project['title'] ?? ''); ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description *</label>
                        <textarea name="description" class="form-control" rows="3" required><?php echo htmlspecialchars($edit_project['description'] ?? ''); ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tags (comma separated) *</label>
                        <input type="text" name="tags" class="form-control" required value="<?php echo htmlspecialchars($edit_project['tags'] ?? ''); ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Demo URL</label>
                        <input type="url" name="demo_url" class="form-control" value="<?php echo htmlspecialchars($edit_project['demo_url'] ?? '#'); ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">GitHub URL</label>
                        <input type="url" name="github_url" class="form-control" value="<?php echo htmlspecialchars($edit_project['github_url'] ?? '#'); ?>">
                    </div>
                    <button type="submit" class="btn btn-primary w-100"><?php echo $edit_project ? 'Update' : 'Add'; ?> Project</button>
                    <?php if ($edit_project): ?>
                        <a href="projects.php" class="btn btn-secondary w-100 mt-2">Cancel</a>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <div class="col-md-7">
            <div class="glass-card p-4">
                <h5 class="fw-bold mb-3">Existing Projects</h5>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Tags</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($proj = $projects->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($proj['title']); ?></td>
                                <td><small><?php echo htmlspecialchars($proj['tags']); ?></small></td>
                                <td>
                                    <a href="?edit=<?php echo $proj['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="?delete=<?php echo $proj['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
