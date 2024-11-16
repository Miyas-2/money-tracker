<?php
// Sertakan file kontrol
require_once '../backend/controll.php';

// Konfigurasi error reporting untuk pengembangan
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Pastikan sesi dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Pemeriksaan login komprehensif
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['user_id'])) {
    // Logging akses tidak sah
    error_log("Unauthorized access attempt to dashboard");

    // Redirect ke halaman login
    header("Location: login.php");
    exit();
}

// Ambil informasi pengguna
$user_id = $_SESSION['user']['user_id'];
$username = $_SESSION['user']['username'];

// Inisialisasi variabel pesan
$success_message = '';
$error_message = '';

// Periksa dan tangkap pesan sukses
if (isset($_SESSION['success'])) {
    $success_message = $_SESSION['success'];
    unset($_SESSION['success']);
}

// Periksa dan tangkap pesan error
if (isset($_SESSION['error'])) {
    $error_message = $_SESSION['error'];
    unset($_SESSION['error']);
}

// Fungsi untuk menampilkan pesan dengan SweetAlert

function showAlert($type, $message)
{
    if (!empty($message)) {
        echo "<script>
            Swal.fire({
                title: '" . ($type == 'success' ? 'Success!' : 'Oops...') . "',
                text: '$message',
                showConfirmButton: true,
                confirmButtonColor: '#5885af', // Warna biru
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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Income and Expense Tracker</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style3.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Include these in your head section -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const printBtn = document.getElementById('printExpenseReportBtn');

            printBtn.addEventListener('click', function () {
                const { jsPDF } = window.jspdf;
                const doc = new jsPDF();

                html2canvas(document.getElementById('v-pills-expense_reports')).then(canvas => {
                    const imgData = canvas.toDataURL('image/png');
                    const imgProps = doc.getImageProperties(imgData);
                    const pdfWidth = doc.internal.pageSize.getWidth();
                    const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

                    doc.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
                    doc.save('expense_report.pdf');
                });
            });
        });
    </script>
</head>

<body class="">

    <?php
    // Tampilkan alert
    showAlert('success', $success_message);
    showAlert('error', $error_message);
    ?>

    <!-- Sidebar with Tabs -->
    <?php
    include_once 'sidebar.php';
    ?>
    <!-- Main Content with Tab Content -->
    <main class="main-content">
        <div class="tab-content mt-5" id="v-pills-tabContent">
            <?php
            //  <!-- expense Tab -->
            include_once 'dashboard_tab.php';
            // <!-- Other tab expense... -->
            include_once 'expense_tab.php';
            // <!-- Other tab incomes... -->
            include_once 'income_tab.php';
            // <!-- Other tab categories... -->
            include_once 'categories_tab.php';
            // <!-- Other tab report... -->
            include_once 'income_reports_tab.php';
            // <!-- Other tab report... -->
            include_once 'expense_reports_tab.php';
            // <!-- Other tab seting... -->
            include_once 'settings_tab.php';
            ?>
        </div>
    </main>


    <?php
    include_once 'scripts.php';
    ?>
    <footer class="text-center py-3 bg-light">
        <small class="text-muted">&copy; 2024 Money Management App. By Moh Ilyas 15-2023-193.</small>
    </footer>
</body>

</html>