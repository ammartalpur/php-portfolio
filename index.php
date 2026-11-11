<?php
// index.php
require_once 'includes/db.php';
include 'includes/header.php';
?>

<!-- Hero Section -->
<section class="hero-section text-center py-5">
    <div class="container py-5">
        <p class="text-primary fw-bold text-uppercase tracking-wider mb-2">About Me</p>
        <h1 class="display-4 fw-bold hero-title mb-4">
            Ammar Talpur<br>
            <span>Software Engineer.</span>
        </h1>
        <div class="row justify-content-center">
            <div class="col-md-8 fs-5">
                <p>I'm a passionate software engineer with over 5 years of experience crafting digital products that make a difference. My journey started with a curiosity for how things work on the web, and it has evolved into a deep expertise in modern frontend technologies.</p>

                <p>I specialize in React, Next.js, and TypeScript, building everything from sleek landing pages to complex enterprise applications. My approach combines technical excellence with a keen eye for design and user experience.</p>
            </div>
        </div>
    </div>
</section>

<!-- Highlights Section -->
<section class="py-5 bg-body-tertiary">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="glass-card h-100 p-4 text-center">
                    <div class="fs-1 text-primary mb-3"><i class="bi bi-code-slash"></i></div>
                    <h4 class="fw-bold">Clean Code</h4>
                    <p class="small">Writing maintainable, scalable code that stands the test of time.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="glass-card h-100 p-4 text-center">
                    <div class="fs-1 text-primary mb-3"><i class="bi bi-rocket-takeoff"></i></div>
                    <h4 class="fw-bold">Performance</h4>
                    <p class="small">Optimizing for speed and delivering lightning-fast user experiences.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="glass-card h-100 p-4 text-center">
                    <div class="fs-1 text-primary mb-3"><i class="bi bi-people"></i></div>
                    <h4 class="fw-bold">Collaboration</h4>
                    <p class="small">Working closely with teams and stakeholders to bring ideas to life.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="glass-card h-100 p-4 text-center">
                    <div class="fs-1 text-primary mb-3"><i class="bi bi-lightbulb"></i></div>
                    <h4 class="fw-bold">Innovation</h4>
                    <p class="small">Staying ahead with the latest technologies and engineering best practices.</p>
                </div>
            </div>
        </div>
        
        <div class="mt-5 p-4 rounded text-center fst-italic glass-card">
            "My mission is to create digital experiences that are not just functional, but truly delightful — products that users love to use and developers love to maintain."
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>