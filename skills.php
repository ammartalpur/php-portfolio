<?php
// skills.php
require_once 'includes/db.php';
include 'includes/header.php';

// Group skills by category for better display
$sql = "SELECT * FROM skills ORDER BY category, proficiency DESC";
$result = $conn->query($sql);

$skillsByCategory = [];
if ($result->rowCount() > 0) {
    while($row = $result->fetch()) {
        $skillsByCategory[$row['category']][] = $row;
    }
}
?>

<section class="py-5 min-vh-100">
    <div class="container py-4">
        
        <div class="text-center mb-5">
            <p class="text-primary fw-bold text-uppercase tracking-wider mb-2">My Journey</p>
            <h2 class="display-5 fw-bold mb-3">Skills & <span class="fst-italic text-primary">Education.</span></h2>
            <p class="text-muted mx-auto" style="max-width: 600px;">
                A snapshot of my technical expertise and academic background in Computer Systems Engineering.
            </p>
        </div>

        <div class="row g-5">
            <!-- Left Column: Education & Experience Timeline -->
            <div class="col-lg-6">
                <h3 class="fw-bold mb-4 d-flex align-items-center"><i class="bi bi-mortarboard text-primary me-2"></i> Education & Experience</h3>
                
                <div class="glass-card p-4 mb-4 border-start border-primary border-4">
                    <span class="text-primary small fw-bold">Aug 2024 - Present (3rd Year)</span>
                    <h5 class="fw-bold mt-2">B.E. Computer Systems Engineering</h5>
                    <p class="text-muted mb-0">Mehran University of Engineering and Technology (MUET), Jamshoro</p>
                    <p class="small text-muted mt-2">Batch 21CS. Coursework includes Web Engineering, Computer Networks, and Microprocessors.</p>
                </div>

                <div class="glass-card p-4 mb-4">
                    <span class="text-primary small fw-bold">Jan 2025 - Present</span>
                    <h5 class="fw-bold mt-2">Director IT</h5>
                    <p class="text-muted mb-0">PakUraan Foundation · Hybrid</p>
                    <p class="small text-muted mt-2">Leading a 5-member IT team, streamlining workflows and automating processes to improve operational efficiency. Developed the organization's website and employee tracking system, reducing manual work by 40%. Introduced a paperless system for meeting minutes and IT asset tracking, cutting reporting errors by 20%.</p>
                </div>

                <div class="glass-card p-4 mb-4">
                    <span class="text-primary small fw-bold">Dec 2024 - Dec 2025</span>
                    <h5 class="fw-bold mt-2">Web Designer & Developer</h5>
                    <p class="text-muted mb-0">AurFun Online</p>
                    <p class="small text-muted mt-2">Leading end-to-end development of an artist-focused e-commerce platform for showcasing and selling merchandise with integrated payment gateways. Collaborating with artists to tailor UX/UI to niche audience needs, increasing average session duration by 50%.</p>
                </div>

                <div class="glass-card p-4 mb-4">
                    <span class="text-primary small fw-bold">Dec 2024 - Present</span>
                    <h5 class="fw-bold mt-2">Web Coordinator</h5>
                    <p class="text-muted mb-0">IEEE Computer Society, Student Branch Chapter MUET, Jamshoro · Offline</p>
                    <p class="small text-muted mt-2">Developing, updating, and maintaining web content to ensure smooth communication and user-friendly experiences for members. Responsible for managing and enhancing the chapter's digital presence.</p>
                </div>
            </div>

            <!-- Right Column: Technical Skills from DB -->
            <div class="col-lg-6">
                <h3 class="fw-bold mb-4 d-flex align-items-center"><i class="bi bi-laptop text-primary me-2"></i> Technical Expertise</h3>
                
                <?php if (empty($skillsByCategory)): ?>
                    <p>No skills data found in the database.</p>
                <?php else: ?>
                    <div class="accordion" id="skillsAccordion">
                        <?php 
                        $i = 0;
                        foreach($skillsByCategory as $category => $skills): 
                            $isFirst = ($i === 0);
                        ?>
                            <div class="accordion-item glass-card mb-3 border-0 bg-transparent">
                                <h2 class="accordion-header">
                                    <button class="accordion-button <?php echo $isFirst ? '' : 'collapsed'; ?> fw-bold bg-body-tertiary rounded" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $i; ?>">
                                        <?php echo htmlspecialchars($category); ?>
                                    </button>
                                </h2>
                                <div id="collapse<?php echo $i; ?>" class="accordion-collapse collapse <?php echo $isFirst ? 'show' : ''; ?>" data-bs-parent="#skillsAccordion">
                                    <div class="accordion-body px-0 pt-3 pb-0">
                                        <?php foreach($skills as $skill): ?>
                                            <div class="mb-3">
                                                <div class="d-flex justify-content-between mb-1">
                                                    <span class="small fw-semibold"><?php echo htmlspecialchars($skill['skill_name']); ?></span>
                                                    <span class="small text-muted"><?php echo $skill['proficiency']; ?>%</span>
                                                </div>
                                                <div class="progress" style="height: 6px;">
                                                    <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo $skill['proficiency']; ?>%;" aria-valuenow="<?php echo $skill['proficiency']; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        <?php 
                        $i++;
                        endforeach; 
                        ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php 
$conn = null;
include 'includes/footer.php'; 
?>