<?php
// projects.php
require_once 'includes/db.php';
include 'includes/header.php';

// Fetch all projects from the database
$sql = "SELECT * FROM projects ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<section class="py-5 bg-body-tertiary min-vh-100">
    <div class="container py-4">
        
        <div class="text-center mb-5">
            <p class="text-primary fw-bold text-uppercase tracking-wider mb-2">Featured Work</p>
            <h2 class="display-5 fw-bold mb-3">Projects that <span class="fst-italic text-primary">make an impact.</span></h2>
            <p class="text-muted mx-auto" style="max-width: 600px;">
                A selection of my recent work, from complex web applications to innovative tools that solve real-world problems.
            </p>
        </div>

        <!-- JS Feature: Client-side Project Filtering -->
        <div class="row justify-content-center mb-5">
            <div class="col-md-6">
                <div class="input-group glass-card p-1">
                    <span class="input-group-text bg-transparent border-0"><i class="bi bi-search"></i></span>
                    <input type="text" id="projectFilter" class="form-control border-0 bg-transparent shadow-none" placeholder="Filter projects by technology or title...">
                </div>
            </div>
        </div>

        <div class="row g-4" id="projectsContainer">
            <?php
            if ($result->rowCount() > 0) {
                while($row = $result->fetch()) {
                    // Explode tags string into an array for styling
                    $tags = explode(',', $row['tags']);
            ?>
                    <div class="col-md-6 col-lg-4 project-item">
                        <div class="glass-card h-100 p-0 project-card d-flex flex-column">
                            <div class="position-relative overflow-hidden">
                                <img src="<?php echo htmlspecialchars($row['image_url']); ?>" class="w-100" alt="<?php echo htmlspecialchars($row['title']); ?>" onerror="this.src='https://placehold.co/600x400?text=Project+Image'">
                                <div class="position-absolute top-0 end-0 p-3 opacity-0 hover-show transition-opacity d-flex gap-2 bg-dark bg-opacity-50 w-100 h-100 justify-content-center align-items-center">
                                    <?php if($row['demo_url'] !== '#'): ?>
                                        <a href="<?php echo htmlspecialchars($row['demo_url']); ?>" target="_blank" class="btn btn-primary btn-sm rounded-circle"><i class="bi bi-box-arrow-up-right"></i></a>
                                    <?php endif; ?>
                                    <?php if($row['github_url'] !== '#'): ?>
                                        <a href="<?php echo htmlspecialchars($row['github_url']); ?>" target="_blank" class="btn btn-dark btn-sm rounded-circle border-light"><i class="bi bi-github"></i></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="p-4 flex-grow-1 d-flex flex-column">
                                <h4 class="card-title fw-bold mb-3"><?php echo htmlspecialchars($row['title']); ?></h4>
                                <p class="card-text text-muted small flex-grow-1"><?php echo htmlspecialchars($row['description']); ?></p>
                                <div class="project-tags mt-3">
                                    <?php foreach($tags as $tag): ?>
                                        <span><?php echo htmlspecialchars(trim($tag)); ?></span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "<div class='col-12 text-center'><p class='lead'>No projects found. Add some from the admin panel!</p></div>";
            }
            ?>
        </div>
    </div>
</section>

<!-- Add this CSS snippet just for the hover buttons on images -->
<style>
.project-card .hover-show { opacity: 0; transition: opacity 0.3s ease; }
.project-card:hover .hover-show { opacity: 1; }
</style>

<?php 
$conn->close();
include 'includes/footer.php'; 
?>