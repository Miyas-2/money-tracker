<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if user is already logged in
if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

// Get logout message if exists
$logout_message = '';
if (isset($_SESSION['logout_message'])) {
    $logout_message = $_SESSION['logout_message'];
    unset($_SESSION['logout_message']); // Clear the message after using it
}

function showAlert($type, $message)
{
    if (!empty($message)) {
        echo "<script>
            Swal.fire({
                text: '$message',
                showConfirmButton: true,
                confirmButtonColor: '#5885af',
                timer: 5000,
                timerProgressBar: true,
                didClose: () => {
                    // Optional: Tambahkan aksi setelah alert ditutup
                    console.log('Alert ditutup');
                },
                willClose: () => {
                    // Optional: Tambahkan aksi sebelum alert ditutup
                    console.log('Alert akan ditutup');
                }
            });
        </script>";
    }
}

// Require backend logic (ensure this doesn't affect session messages)
require_once '../backend/controll.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<div class="container-fluid custom-background">
    <div class="row">
        <div class="col-md-6 d-none d-md-flex justify-content-center align-items-center">
        </div>
        <div class="col-md-6 d-flex justify-content-center align-items-center" style="min-height: 100vh;">
            <div class="card shadow w-75">
            <h2 class="card-title text-center mb-2 mt-3"><small class="text-body-dark fst-italic">Money Tracker</small></h2>
                <div class="card-body">
                    <?php if (!empty($logout_message)): ?>
                        <?php showAlert('success', $logout_message); ?>
                    <?php endif; ?>

                    <?php if ($showLogin): ?>
                        <h2 class="card-title text-center mb-4">Login</h2>
                        <?php if (!empty($message)): ?>
                            <?php showAlert('info', htmlspecialchars($message)); ?>
                        <?php endif; ?>
                        <form method="POST" action="">
                            <input type="hidden" name="action" value="login">
                            <div class="mb-3">
                                <input type="email" name="email" class="form-control" placeholder="Email" required>
                            </div>
                            <div class="mb-3">
                                <div class="input-group">
                                    <input type="password" name="password" id="loginPassword" class="form-control"
                                        placeholder="Password" required>
                                    <button type="button" class="btn btn-outline-secondary show-password"
                                        onclick="togglePassword('loginPassword')">
                                        <i class="bi bi-eye" id="loginPasswordIcon"></i>
                                    </button>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Login</button>
                        </form>
                        <p class="mt-3 text-center">Don't have an account? <a href="?action=register">Register</a></p>
                    <?php else: ?>
                        <h2 class="card-title text-center mb-4">Register</h2>
                        <?php if (!empty($message)): ?>
                            <?php showAlert('info', htmlspecialchars($message)); ?>
                        <?php endif; ?>
                        <form method="POST" action="">
                            <input type="hidden" name="action" value="register">
                            <div class="mb-3">
                                <input type="text" name="username" class="form-control" placeholder="Username" required>
                            </div>
                            <div class="mb-3">
                                <input type="email" name="email" class="form-control" placeholder="Email" required>
                            </div>
                            <div class="mb-3">
                                <div class="input-group">
                                    <input type="password" name="password" id="registerPassword" class="form-control"
                                        placeholder="Password" required>
                                    <button type="button" class="btn btn-outline-secondary show-password"
                                        onclick="togglePassword('registerPassword')">
                                        <i class="bi bi-eye" id="registerPasswordIcon"></i>
                                    </button>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Register</button>
                        </form>
                        <p class="mt-3 text-center">Already have an account? <a href="login.php">Login</a></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Optional: Footer -->


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function togglePassword(passwordFieldId) {
        const passwordField = document.getElementById(passwordFieldId);
        const icon = document.getElementById(passwordFieldId + 'Icon');

        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            passwordField.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    }
</script>
</body>

</html>