<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Ensure session is started at the very beginning
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Debug: Print out session and login status
require_once __DIR__ . '/user.php';
require_once __DIR__ . '/database.php';
require_once __DIR__ . '/income.php';
require_once __DIR__ . '/categories.php'; // Include the Categories class
require_once __DIR__ . '/expense.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);
$income = new Income($db);
$categories = new Categories($db); // Create an instance of the Categories class
$expense = new Expense($db);
// Debugging
$message = '';
$showLogin = true;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        // Debugging
        if ($_POST['action'] == 'login') {
            $loginResult = $user->loginUser($_POST['email'], $_POST['password']);
            if ($loginResult) {
                $_SESSION['user'] = $loginResult;
                header("Location: ../frontend/index.php?tab=dashboard");
                exit();
            } else {
                $message = "Login failed. Invalid email or password.";
            }
        } elseif ($_POST['action'] == 'register') {
            if ($user->registerUser($_POST['username'], $_POST['email'], $_POST['password'])) {
                $message = "Registration successful. Please log in.";
                $showLogin = true;
                // Call showAlert directly
            } else {
                $message = "Registration failed. Username or Email Already Exist, Please try again.";
                $showLogin = false;
                // Call showAlert directly
            }
        } elseif ($_POST['action'] == 'addIncome') {
            // Check user login status
            if (!isset($_SESSION['user']) || !isset($_SESSION['user']['user_id'])) {
                error_log("Attempted to add income without valid user session");
                die("You must be logged in to add income. Session is invalid.");
            }

            // Proceed with income addition
            $user_id = $_SESSION['user']['user_id'];
            $income_amount = $_POST['income'];
            $category_id = $_POST['category_id']; // Changed from source to category_id
            $date = $_POST['date'];
            $description = $_POST['description'] ?? '';

            try {
                if ($income->addIncome($user_id, $income_amount, $category_id, $date, $description)) {
                    $_SESSION['success'] = "Income added successfully.";
                    header("Location: ../frontend/index.php");
                    exit();
                } else {
                    $_SESSION['error'] = "Failed to add income. Please try again.";
                    header("Location: ../frontend/index.php");
                    exit();
                }
            } catch (Exception $e) {
                $_SESSION['error'] = "Error: " . $e->getMessage();
                header("Location: ../frontend/index.php");
                exit();
            }
        } elseif ($_POST['action'] == 'editIncome') {
            // Check user login status
            if (!isset($_SESSION['user']) || !isset($_SESSION['user']['user_id'])) {
                error_log("Attempted to edit income without valid user session");
                die("You must be logged in to edit income. Session is invalid.");
            }

            // Proceed with income editing
            $income_id = $_POST['income_id'];
            $income_amount = $_POST['income'];
            $category_id = $_POST['category_id']; // Changed from source to category_id
            $date = $_POST['date'];
            $description = $_POST['description'] ?? '';

            try {
                if ($income->editIncome($income_id, $income_amount, $category_id, $date, $description)) {
                    $_SESSION['success'] = "Income updated successfully.";
                    header("Location: ../frontend/index.php");
                    exit();
                } else {
                    $_SESSION['error'] = "Failed to update income. Please try again.";
                    header("Location: ../frontend/index.php");
                    exit();
                }
            } catch (Exception $e) {
                $_SESSION['error'] = "Error: " . $e->getMessage();
                header("Location: ../frontend/index.php");
                exit();
            }
        } elseif ($_POST['action'] == 'deleteIncome') {
            // Check user login status
            if (!isset($_SESSION['user']) || !isset($_SESSION['user']['user_id'])) {
                error_log("Attempted to delete income without valid user session");
                die("You must be logged in to delete income. Session is invalid .");
            }

            // Proceed with income deletion
            $income_id = $_POST['income_id'];

            try {
                if ($income->deleteIncome($income_id)) {
                    $_SESSION['success'] = "Income deleted successfully.";
                    header("Location: ../frontend/index.php");
                    exit();
                } else {
                    $_SESSION['error'] = "Failed to delete income. Please try again.";
                    header("Location: ../frontend/index.php");
                    exit();
                }
            } catch (Exception $e) {
                $_SESSION['error'] = "Error: " . $e->getMessage();
                header("Location: ../frontend/index.php");
                exit();
            }
        } elseif ($_POST['action'] == 'addCategory') {
            // Check user login status
            if (!isset($_SESSION['user']) || !isset($_SESSION['user']['user_id'])) {
                error_log("Attempted to add category without valid user session");
                die("You must be logged in to add a category. Session is invalid.");
            }

            // Proceed with category addition
            $user_id = $_SESSION['user']['user_id'];
            $category_name = $_POST['name'];
            $category_type = $_POST['type'];

            try {
                if ($categories->addCategory($user_id, $category_name, $category_type)) {
                    $_SESSION['success'] = "Category added successfully.";

                    header("Location: ../frontend/index.php");
                    exit();
                } else {
                    $_SESSION['error'] = "Failed to add category. Please try again.";
                    header("Location: ../frontend/index.php");
                    exit();
                }
            } catch (Exception $e) {
                $_SESSION['error'] = "Error: " . $e->getMessage();
                header("Location: ../frontend/index.php");
                exit();
            }
        } elseif ($_POST['action'] == 'editCategory') {
            // Check user login status
            if (!isset($_SESSION['user']) || !isset($_SESSION['user']['user_id'])) {
                error_log("Attempted to edit category without valid user session");
                die("You must be logged in to edit a category. Session is invalid.");
            }

            // Proceed with category editing
            $category_id = $_POST['category_id'];
            $category_name = $_POST['name'];
            $category_type = $_POST['type'];

            try {
                if ($categories->editCategory($category_id, $category_name, $category_type)) {
                    $_SESSION['success'] = "Category updated successfully.";
                    header("Location: ../frontend/index.php");
                    exit();
                } else {
                    $_SESSION['error'] = "Failed to update category. Please try again.";
                    header("Location: ../frontend/index.php");
                    exit();
                }
            } catch (Exception $e) {
                $_SESSION['error'] = "Error: " . $e->getMessage();
                header("Location: ../frontend/index.php");
                exit();
            }
        } elseif ($_POST['action'] == 'deleteCategory') {
            // Check user login status
            if (!isset($_SESSION['user']) || !isset($_SESSION['user']['user_id'])) {
                error_log("Attempted to delete category without valid user session");
                die("You must be logged in to delete a category. Session is invalid.");
            }

            // Proceed with category deletion
            $category_id = $_POST['category_id'];

            try {
                if ($categories->deleteCategory($category_id)) {
                    $_SESSION['success'] = "Category deleted successfully.";
                    header("Location: ../frontend/index.php");
                    exit();
                } else {
                    $_SESSION['error'] = "Failed to delete category. Please try again.";
                    header("Location: ../frontend/index.php");
                    exit();
                }
            } catch (Exception $e) {
                $_SESSION['error'] = "Error: " . $e->getMessage();
                header("Location: ../frontend/index.php");
                exit();
            }
        } elseif ($_POST['action'] == 'addExpense') {
            // Check user login status
            if (!isset($_SESSION['user']) || !isset($_SESSION['user']['user_id'])) {
                error_log("Attempted to add expense without valid user session");
                die("You must be logged in to add an expense. Session is invalid.");
            }

            // Proceed with expense addition
            $user_id = $_SESSION['user']['user_id'];
            $expense_amount = $_POST['expense'];
            $category_id = $_POST['category_id'];
            $date = $_POST['date'];
            $description = $_POST['description'] ?? '';

            try {
                if ($expense->addExpense($user_id, $expense_amount, $category_id, $date, $description)) {
                    $_SESSION['success'] = "Expense added successfully.";
                    header("Location: ../frontend/index.php");
                    exit();
                } else {
                    $_SESSION['error'] = "Failed to add expense. Please try again.";
                    header("Location: ../frontend/index.php");
                    exit();
                }
            } catch (Exception $e) {
                $_SESSION['error'] = "Error: " . $e->getMessage();
                header("Location: ../frontend/index.php");
                exit();
            }
        } elseif ($_POST['action'] == 'editExpense') {
            // Check user login status
            if (!isset($_SESSION['user']) || !isset($_SESSION['user']['user_id'])) {
                error_log("Attempted to edit expense without valid user session");
                die("You must be logged in to edit an expense. Session is invalid.");
            }

            // Proceed with expense editing
            $expense_id = $_POST['expense_id'];
            $expense_amount = $_POST['expense'];
            $category_id = $_POST['category_id'];
            $date = $_POST['date'];
            $description = $_POST['description'] ?? '';

            try {
                if ($expense->editExpense($expense_id, $expense_amount, $category_id, $date, $description)) {
                    $_SESSION['success'] = "Expense updated successfully.";
                    header("Location: ../frontend/index.php");
                    exit();
                } else {
                    $_SESSION['error'] = "Failed to update expense. Please try again.";
                    header("Location: ../frontend/index.php");
                    exit();
                }
            } catch (Exception $e) {
                $_SESSION['error'] = "Error: " . $e->getMessage();
                header("Location: ../frontend/index.php");
                exit();
            }
        } elseif ($_POST['action'] == 'deleteExpense') {
            // Check user login status
            if (!isset($_SESSION['user']) || !isset($_SESSION['user']['user_id'])) {
                error_log("Attempted to delete expense without valid user session");
                die("You must be logged in to delete an expense. Session is invalid.");
            }

            // Proceed with expense deletion
            $expense_id = $_POST['expense_id'];

            try {
                if ($expense->deleteExpense($expense_id)) {
                    $_SESSION['success'] = "Expense deleted successfully.";
                    header("Location: ../frontend/index.php");
                    exit();
                } else {
                    $_SESSION['error'] = "Failed to delete expense. Please try again.";
                    header("Location: ../frontend/index.php");
                    exit();
                }
            } catch (Exception $e) {
                $_SESSION['error'] = "Error: " . $e->getMessage();
                header("Location: ../frontend/index.php");
                exit();
            }
        } elseif ($_POST['action'] == 'updateProfile') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $user_id = $_SESSION['user']['user_id'];

            // Handle file upload
            $profile_photo = null;
            if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] == UPLOAD_ERR_OK) {
                $target_dir = "../image/";

                // Generate a unique filename
                $file_extension = strtolower(pathinfo($_FILES["profile_photo"]["name"], PATHINFO_EXTENSION));
                $unique_filename = $user_id . '_' . uniqid() . '.' . $file_extension;
                $target_file = $target_dir . $unique_filename;

                // Check if image file is a actual image or fake image
                $check = getimagesize($_FILES["profile_photo"]["tmp_name"]);
                if ($check !== false) {
                    // Allowed file types
                    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
                    if (!in_array($_FILES["profile_photo"]["type"], $allowed_types)) {
                        $_SESSION['error'] = "Only JPG, PNG, and GIF files are allowed.";
                        header("Location: ../frontend/index.php");
                        exit();
                    }

                    // File size limit (5MB)
                    if ($_FILES["profile_photo"]["size"] > 5 * 1024 * 1024) {
                        $_SESSION['error'] = "File is too large. Maximum size is 5MB.";
                        header("Location: ../frontend/index.php");
                        exit();
                    }

                    // Move the uploaded file to the target directory
                    if (move_uploaded_file($_FILES["profile_photo"]["tmp_name"], $target_file)) {
                        $profile_photo = $unique_filename;

                        // Delete old profile photo if it exists
                        $old_photo = $_SESSION['user']['profile_photo'];
                        if (!empty($old_photo) && file_exists($target_dir . $old_photo)) {
                            unlink($target_dir . $old_photo);
                        }
                    } else {
                        $_SESSION['error'] = "Sorry, there was an error uploading your file.";
                        header("Location: ../frontend/index.php");
                        exit();
                    }
                } else {
                    $_SESSION['error'] = "File is not an image.";
                    header("Location: ../frontend/index.php");
                    exit();
                }
            }

            // Attempt to update user profile
            if ($user->updateUserProfile($user_id, $username, $email, $profile_photo)) {
                // Update session with new details
                $_SESSION['user']['username'] = $username;
                $_SESSION['user']['email'] = $email;

                // Update profile photo in session if a new photo was uploaded
                if ($profile_photo) {
                    $_SESSION['user']['profile_photo'] = $profile_photo;
                }

                $_SESSION['success'] = "Profile updated successfully!";
            } else {
                $_SESSION['error'] = "Username or email already exists. Please choose a different one.";
            }

            header("Location: ../frontend/index.php");
            exit();
        } elseif ($_POST['action'] == 'changePassword') {
            $current_password = $_POST['current_password'];
            $new_password = $_POST['new_password'];
            $confirm_password = $_POST['confirm_password'];
            $user_id = $_SESSION['user']['user_id'];

            // Validate new password
            if ($new_password !== $confirm_password) {
                $_SESSION['error'] = "New passwords do not match.";
                header("Location: ../frontend/index.php");
                exit();
            }

            if ($user->updateUserPassword($user_id, $current_password, $new_password)) {
                $_SESSION['success'] = "Password changed successfully!";
            } else {
                $_SESSION['error'] = "Current password is incorrect or update failed.";
            }
            header("Location: ../frontend/index.php");
            exit();
        }
    }
}

// Cek jika aksi yang diminta adalah 'register'
if (isset($_GET['action']) && $_GET['action'] == 'register') {
    $showLogin = false;
}

// Inisialisasi variabel
$incomes = [];
$expenses = [];
$categoriesList = [];
$categoriesIncomeList = [];
$categoriesExpenseList = [];

// Fetch income and expense records for the logged-in user
if (isset($_SESSION['user']) && isset($_SESSION['user']['user_id'])) {
    $user_id = $_SESSION['user']['user_id'];

    // Ambil data pemasukan dan pengeluaran
    $incomes = $income->getIncomesByUser($user_id);
    $expenses = $expense->getExpensesByUser($user_id);
    $categoriesList = $categories->getCategoriesByUser($user_id);
    $categoriesIncomeList = $categories->getIncomeCategoriesByUser($user_id);
    $categoriesExpenseList = $categories->getExpenseCategoriesByUser($user_id);

    // Hitung total pemasukan dan pengeluaran
    $totalIncomeToday = $income->getTotalIncomeToday($user_id);
    $totalExpenseToday = $expense->getTotalExpenseToday($user_id);
    $totalIncomeWeek = $income->getTotalIncomeThisWeek($user_id);
    $totalExpenseWeek = $expense->getTotalExpenseThisWeek($user_id);
    $totalIncomeMonth = $income->getTotalIncomeThisMonth($user_id);
    $totalExpenseMonth = $expense->getTotalExpenseThisMonth($user_id);
    $totalIncomeYear = $income->getTotalIncomeThisYear($user_id);
    $totalExpenseYear = $expense->getTotalExpenseThisYear($user_id);
    $totalIncomeLast6Months = $income->getTotalIncomeLast6Months($user_id);
    $totalExpenseLast6Months = $expense->getTotalExpenseLast6Months($user_id);

    // Hitung total pemasukan untuk periode tambahan
    $totalIncomeYesterday = $income->getTotalIncomeYesterday($user_id);
    $totalIncomeLastWeek = $income->getTotalIncomeLastWeek($user_id);
    $totalIncomeLastMonth = $income->getTotalIncomeLastMonth($user_id);
    // Mengambil total pengeluaran untuk periode yang diperlukan
    $totalExpenseYesterday = $expense->getTotalExpenseYesterday($user_id);
    $totalExpenseLastWeek = $expense->getTotalExpenseLastWeek($user_id);
    $totalExpenseLastMonth = $expense->getTotalExpenseLastMonth($user_id);
    $percentageIncomeToday = 0;
    if ($totalIncomeYesterday > 0) {
        $percentageIncomeToday = (($totalIncomeToday - $totalIncomeYesterday) / $totalIncomeYesterday) * 100;
    }

    // Menghitung persentase untuk minggu ini dibandingkan dengan minggu lalu
    $percentageIncomeWeek = 0;
    if ($totalIncomeLastWeek > 0) {
        $percentageIncomeWeek = (($totalIncomeWeek - $totalIncomeLastWeek) / $totalIncomeLastWeek) * 100;
    }

    // Menghitung persentase untuk bulan ini dibandingkan dengan bulan lalu
    $percentageIncomeMonth = 0;
    if ($totalIncomeLastMonth > 0) {
        $percentageIncomeMonth = (($totalIncomeMonth - $totalIncomeLastMonth) / $totalIncomeLastMonth) * 100;
    }

    // Menghitung persentase untuk hari ini dibandingkan dengan kemarin
    $percentageExpenseToday = 0;
    if ($totalExpenseYesterday > 0) {
        $percentageExpenseToday = (($totalExpenseToday - $totalExpenseYesterday) / $totalExpenseYesterday) * 100;
    }

    // Menghitung persentase untuk minggu ini dibandingkan dengan minggu lalu
    $percentageExpenseWeek = 0;
    if ($totalExpenseLastWeek > 0) {
        $percentageExpenseWeek = (($totalExpenseWeek - $totalExpenseLastWeek) / $totalExpenseLastWeek) * 100;
    }

    // Menghitung persentase untuk bulan ini dibandingkan dengan bulan lalu
    $percentageExpenseMonth = 0;
    if ($totalExpenseLastMonth > 0) {
        $percentageExpenseMonth = (($totalExpenseMonth - $totalExpenseLastMonth) / $totalExpenseLastMonth) * 100;
    }

}

// Fungsi untuk menghitung total pengeluaran
function sum($expenses)
{
    return array_sum(array_column($expenses, 'amount')); // Mengasumsikan setiap pengeluaran memiliki kunci 'amount'
}

// Filter pengeluaran berdasarkan kategori dan rentang tanggal
$filteredExpenses = $expenses;

// Filter Kategori
if (isset($_GET['category_filter']) && !empty($_GET['category_filter'])) {
    $filteredExpenses = array_filter($filteredExpenses, function ($expense) {
        return $expense['category_id'] == $_GET['category_filter'];
    });
}

// Filter Rentang Tanggal
if (isset($_GET['start_date']) && !empty($_GET['start_date'])) {
    $filteredExpenses = array_filter($filteredExpenses, function ($expense) {
        return strtotime($expense['date']) >= strtotime($_GET['start_date']);
    });
}

if (isset($_GET['end_date']) && !empty($_GET['end_date'])) {
    $filteredExpenses = array_filter($filteredExpenses, function ($expense) {
        return strtotime($expense['date']) <= strtotime($_GET['end_date']);
    });
}

// Pagination untuk Pengeluaran yang Difilter
$expensesPerPage = isset($_GET['expensesPerPage']) ? (int) $_GET['expensesPerPage'] : 10;
$totalExpenses = count($filteredExpenses);
$totalExpensePages = ceil($totalExpenses / $expensesPerPage);
$totalExpensesMoney = sum($filteredExpenses); // Hitung total uang yang dikeluarkan

// Dapatkan halaman saat ini untuk pengeluaran
$expenseCurrentPage = isset($_GET['expense_page']) ? max(1, intval($_GET['expense_page'])) : 1;

// Hitung offset
$expenseOffset = ($expenseCurrentPage - 1) * $expensesPerPage;

// Ambil potongan pengeluaran untuk halaman saat ini
$pageExpenses = array_slice($filteredExpenses, $expenseOffset, $expensesPerPage);

function calculateTotalIncome($incomes)
{
    return array_sum(array_column($incomes, 'amount')); // Assuming each income has an 'amount' key
}

// Filter incomes based on category and date range
$filteredIncomes = $incomes;

// Category Filter
if (isset($_GET['category_filter']) && !empty($_GET['category_filter'])) {
    $filteredIncomes = array_filter($filteredIncomes, function ($income) {
        return $income['category_id'] == $_GET['category_filter'];
    });
}

// Date Range Filter
if (isset($_GET['start_date']) && !empty($_GET['start_date'])) {
    $filteredIncomes = array_filter($filteredIncomes, function ($income) {
        return strtotime($income['date']) >= strtotime($_GET['start_date']);
    });
}

if (isset($_GET['end_date']) && !empty($_GET['end_date'])) {
    $filteredIncomes = array_filter($filteredIncomes, function ($income) {
        return strtotime($income['date']) <= strtotime($_GET['end_date']);
    });
}

// Pagination for Filtered Incomes
$incomesPerPage = isset($_GET['incomesPerPage']) ? (int) $_GET['incomesPerPage'] : 10;
$totalIncomes = count($filteredIncomes);
$totalIncomePages = ceil($totalIncomes / $incomesPerPage);
$totalIncomesMoney = calculateTotalIncome($filteredIncomes); // Calculate total income

// Get current page for income
$incomeCurrentPage = isset($_GET['income_page']) ? max(1, intval($_GET['income_page'])) : 1;

// Calculate offset
$incomeOffset = ($incomeCurrentPage - 1) * $incomesPerPage;

// Slice incomes for current page
$pageIncomes = array_slice($filteredIncomes, $incomeOffset, $incomesPerPage);

// Get entries per page and filter type from query parameters
$itemsPerPage = isset($_GET['entriesPerPage']) ? (int) $_GET['entriesPerPage'] : 5;
$filterType = isset($_GET['filterType']) ? $_GET['filterType'] : '';

// Filter categories based on selected type
if ($filterType) {
    $filteredCategoriesList = array_filter($categoriesList, function ($category) use ($filterType) {
        return $category['type'] === $filterType;
    });
} else {
    $filteredCategoriesList = $categoriesList;
}

// Pagination logic
$totalItems = count($filteredCategoriesList);
$totalPages = ceil($totalItems / $itemsPerPage);
$currentPage = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$currentPage = max(1, min($currentPage, $totalPages));
$startIndex = ($currentPage - 1) * $itemsPerPage;
$categoriesToDisplay = array_slice($filteredCategoriesList, $startIndex, $itemsPerPage);
function generateWaveSVG($color = '#28a745', $opacity = 0.1)
{
    return '
    <div class="wave-background position-absolute bottom-0 start-0 w-100 opacity-10">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
            <path fill="' . $color . '" fill-opacity="' . $opacity . '" 
                  d="M0,288L48,272C96,256,192,224,288,197.3C384,171,480,149,576,165.3C672,181,768,235,864,245.3C960,256,1056,224,1152,208C1248,192,1344,192,1392,192L1440,192L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320L192,320L96,320L0,320Z">
            </path>
        </svg>
    </div>';
}

?>