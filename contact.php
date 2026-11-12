<?php
require_once 'includes/db.php';
include 'includes/header.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Server-side validation
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $error = 'All fields are required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email format';
    } elseif (strlen($name) < 2) {
        $error = 'Name must be at least 2 characters';
    } elseif (strlen($message) < 10) {
        $error = 'Message must be at least 10 characters';
    } else {
        // Use prepared statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$name, $email, $subject, $message])) {
            $success = 'Thank you for your message! I will get back to you soon.';
            // Clear form
            $name = $email = $subject = $message = '';
        } else {
            $error = 'Sorry, there was an error sending your message. Please try again.';
        }
    }
}
?>
<section class="py-5 min-vh-100">
    <div class="container py-4">
        <div class="text-center mb-5">
            <p class="text-primary fw-bold text-uppercase tracking-wider mb-2">Get In Touch</p>
            <h2 class="display-5 fw-bold mb-3">Let's <span class="fst-italic text-primary">connect.</span></h2>
            <p class="text-muted mx-auto" style="max-width: 600px;">
                Have a project in mind or want to discuss opportunities? Send me a message and I'll respond as soon as possible.
            </p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="glass-card p-5">
                    <?php if ($success): ?>
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle me-2"></i><?php echo htmlspecialchars($success); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($error): ?>
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-triangle me-2"></i><?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" class="needs-validation" novalidate>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label fw-semibold">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($name ?? ''); ?>" required minlength="2">
                                <div class="invalid-feedback">Please provide your name (min 2 characters).</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label fw-semibold">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
                                <div class="invalid-feedback">Please provide a valid email.</div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="subject" class="form-label fw-semibold">Subject</label>
                            <input type="text" class="form-control" id="subject" name="subject" value="<?php echo htmlspecialchars($subject ?? ''); ?>" required>
                            <div class="invalid-feedback">Please provide a subject.</div>
                        </div>

                        <div class="mb-4">
                            <label for="message" class="form-label fw-semibold">Message</label>
                            <textarea class="form-control" id="message" name="message" rows="6" required minlength="10"><?php echo htmlspecialchars($message ?? ''); ?></textarea>
                            <div class="invalid-feedback">Message must be at least 10 characters.</div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            <i class="bi bi-send me-2"></i>Send Message
                        </button>
                    </form>
                </div>

                <div class="row mt-4">
                    <div class="col-md-4 text-center mb-3">
                        <div class="glass-card p-3 h-100">
                            <i class="bi bi-envelope fs-2 text-primary"></i>
                            <p class="mt-2 mb-0 small fw-semibold">Email</p>
                            <p class="small text-muted mb-0"><a href="mailto:knowtalpur@gmail.com" class="text-decoration-none">knowtalpur@gmail.com</a></p>
                        </div>
                    </div>
                    <div class="col-md-4 text-center mb-3">
                        <div class="glass-card p-3 h-100">
                            <i class="bi bi-telephone fs-2 text-primary"></i>
                            <p class="mt-2 mb-0 small fw-semibold">Phone</p>
                            <p class="small text-muted mb-0">+92 (322) 047-2570</p>
                        </div>
                    </div>
                    <div class="col-md-4 text-center mb-3">
                        <div class="glass-card p-3 h-100">
                            <i class="bi bi-geo-alt fs-2 text-primary"></i>
                            <p class="mt-2 mb-0 small fw-semibold">Location</p>
                            <p class="small text-muted mb-0">Hyderabad, Pakistan</p>
                        </div>
                    </div>
                    <div class="col-md-4 text-center mb-3">
                        <div class="glass-card p-3 h-100">
                            <i class="bi bi-github fs-2 text-primary"></i>
                            <p class="mt-2 mb-0 small fw-semibold">GitHub</p>
                            <p class="small text-muted mb-0"><a href="https://github.com/ammartalpur" class="text-decoration-none" target="_blank">github.com/ammartalpur</a></p>
                        </div>
                    </div>
                    <div class="col-md-4 text-center mb-3">
                        <div class="glass-card p-3 h-100">
                            <i class="bi bi-linkedin fs-2 text-primary"></i>
                            <p class="mt-2 mb-0 small fw-semibold">LinkedIn</p>
                            <p class="small text-muted mb-0"><a href="https://www.linkedin.com/in/ammar-talpur-6b77a327a/" class="text-decoration-none" target="_blank">linkedin.com/in/ammar-talpur</a></p>
                        </div>
                    </div>
                    <div class="col-md-4 text-center mb-3">
                        <div class="glass-card p-3 h-100">
                            <i class="bi bi-twitter fs-2 text-primary"></i>
                            <p class="mt-2 mb-0 small fw-semibold">Twitter</p>
                            <p class="small text-muted mb-0"><a href="#" class="text-decoration-none">Coming Soon</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
$conn = null;
include 'includes/footer.php';
?>
