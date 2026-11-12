<?php
session_start();
require_once __DIR__ . '/../includes/db.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $skill_name = trim($_POST['skill_name'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $proficiency = intval($_POST['proficiency'] ?? 0);
    $id = intval($_POST['id'] ?? 0);

    if ($skill_name && $category && $proficiency >= 0 && $proficiency <= 100) {
        if ($id > 0) {
            $stmt = $conn->prepare("UPDATE skills SET skill_name=?, category=?, proficiency=? WHERE id=?");
            $stmt->execute([$skill_name, $category, $proficiency, $id]);
        } else {
            $stmt = $conn->prepare("INSERT INTO skills (skill_name, category, proficiency) VALUES (?, ?, ?)");
            $stmt->execute([$skill_name, $category, $proficiency]);
        }
        if ($stmt->rowCount() > 0) {
            $success = 'Skill saved successfully!';
        } else {
            $error = 'Error saving skill';
        }
    } else {
        $error = 'Please fill all fields correctly';
    }
}

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM skills WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: skills.php');
    exit;
}

$edit_skill = null;
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $stmt = $conn->prepare("SELECT * FROM skills WHERE id = ?");
    $stmt->execute([$id]);
    $edit_skill = $stmt->fetch();
}

$skills = $conn->query("SELECT * FROM skills ORDER BY category, proficiency DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Skills - Admin</title>
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
    <h2 class="fw-bold mb-4">Manage Skills</h2>

    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-5">
            <div class="glass-card p-4">
                <h5 class="fw-bold mb-3"><?php echo $edit_skill ? 'Edit Skill' : 'Add New Skill'; ?></h5>
                <form method="POST">
                    <input type="hidden" name="id" value="<?php echo $edit_skill['id'] ?? ''; ?>">
                    <div class="mb-3">
                        <label class="form-label">Skill Name *</label>
                        <input type="text" name="skill_name" class="form-control" required value="<?php echo htmlspecialchars($edit_skill['skill_name'] ?? ''); ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Category *</label>
                        <input type="text" name="category" class="form-control" required value="<?php echo htmlspecialchars($edit_skill['category'] ?? ''); ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Proficiency (%) *</label>
                        <input type="number" name="proficiency" class="form-control" min="0" max="100" required value="<?php echo htmlspecialchars($edit_skill['proficiency'] ?? ''); ?>">
                    </div>
                    <button type="submit" class="btn btn-success w-100"><?php echo $edit_skill ? 'Update' : 'Add'; ?> Skill</button>
                    <?php if ($edit_skill): ?>
                        <a href="skills.php" class="btn btn-secondary w-100 mt-2">Cancel</a>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <div class="col-md-7">
            <div class="glass-card p-4">
                <h5 class="fw-bold mb-3">Existing Skills</h5>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Skill</th>
                                <th>Category</th>
                                <th>Proficiency</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($skill = $skills->fetch()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($skill['skill_name']); ?></td>
                                <td><?php echo htmlspecialchars($skill['category']); ?></td>
                                <td><?php echo $skill['proficiency']; ?>%</td>
                                <td>
                                    <a href="?edit=<?php echo $skill['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="?delete=<?php echo $skill['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</a>
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
