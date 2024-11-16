<script>
    function previewProfilePhoto(event) {
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = function (e) {
            const profilePhotoContainer = document.querySelector('.profile-photo-container');

            // Replace existing photo or placeholder
            const existingImg = profilePhotoContainer.querySelector('img');
            const placeholderDiv = profilePhotoContainer.querySelector('.bg-light');

            if (existingImg) {
                existingImg.src = e.target.result;
            } else if (placeholderDiv) {
                placeholderDiv.outerHTML = `
                <img src="${e.target.result}"
                     alt="Profile Photo" 
                     class="img-fluid rounded-circle profile-photo" 
                     style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #007bff;">
            `;
            }
        }

        reader.readAsDataURL(file);

        // Optional: File validation
        const maxSizeInBytes = 5 * 1024 * 1024; // 5MB
        const allowedTypes = ['image/jpeg', 'image/png'];

        if (file.size > maxSizeInBytes) {
            alert('File is too large. Maximum size is 5MB.');
            event.target.value = '';
            return;
        }

        if (!allowedTypes.includes(file.type)) {
            alert('Please upload a JPG or PNG image.');
            event.target.value = '';
            return;
        }
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const printBtn = document.getElementById('printExpenseReportBtn');

        printBtn.addEventListener('click', function () {
            // Create a printable version of the expense report
            const printContents = document.getElementById('v-pills-expense_reports').cloneNode(true);

            // Remove unnecessary elements
            const modalElements = printContents.querySelectorAll('.modal');
            modalElements.forEach(modal => modal.remove());

            // Find the table and remove the Actions column
            const table = printContents.querySelector('table');
            if (table) {
                // Remove header Actions column
                const headerRow = table.querySelector('thead tr');
                if (headerRow) {
                    headerRow.deleteCell(-1); // Remove last column
                }

                // Remove Actions column from each row
                const bodyRows = table.querySelectorAll('tbody tr');
                bodyRows.forEach(row => {
                    row.deleteCell(-1); // Remove last cell in each row
                });
            }

            // Remove filtering and pagination elements
            const filterForm = printContents.querySelector('form');
            const paginationNav = printContents.querySelector('nav');
            if (filterForm) filterForm.remove();
            if (paginationNav) paginationNav.remove();

            // Create a new window for printing
            const printWindow = window.open('', '', 'height=500, width=800');

            // Get current date and total expenses
            const currentDate = new Date().toLocaleDateString();
            const totalExpensesElement = printContents.querySelector('.total-expenses');
            const totalExpenses = totalExpensesElement ? totalExpensesElement.textContent : 'N/A';

            // Add comprehensive print styling and content
            printWindow.document.write(`
            <html>
                <head>
                    <title>Expense Report</title>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            line-height: 1.6;
                            margin: 0;
                            padding: 20mm;
                        }
                        .report-header {
                            text-align: center;
                            margin-bottom: 20px;
                            border-bottom: 2px solid #000;
                            padding-bottom: 10px;
                        }
                        .report-header h1 {
                            margin: 0;
                            color: #333;
                        }
                        .report-info {
                            display: flex;
                            justify-content: space-between;
                            margin-bottom: 20px;
                        }
                        .total-expenses-box {
                            border: 1px solid #000;
                            padding: 10px;
                            text-align: center;
                        }
                        table {
                            width: 100%;
                            border-collapse: collapse;
                            margin-bottom: 20px;
                        }
                        table, th, td {
                            border: 1px solid #000;
                        }
                        th, td {
                            padding: 8px;
                            text-align: left;
                        }
                        th {
                            background-color: #f2f2f2;
                        }
                        @media print {
                            @page {
                                size: A4;
                                margin: 10mm;
                            }
                            body {
                                padding: 0;
                            }
                        }
                    </style>
                </head>
                <body>
                    <div class="report-header">
                        <h1>Expense Report</h1>
                        <p>Generated on: ${currentDate}</p>
                    </div>
                    
                    <div class="report-info">
                        <div>
                            <strong>Report Period:</strong> 
                            ${document.getElementById('startDate').value} to 
                            ${document.getElementById('endDate').value}
                        </div>
                        <div class="total-expenses-box">
                            <strong>Total Expenses:</strong> ${totalExpenses}
                        </div>
                    </div>

                    ${printContents.querySelector('.table-responsive').innerHTML}

                    <footer>
                        <p style="text-align: center; margin-top: 20px; font-size: 0.8em;">
                            End of Expense Report
                        </p>
                    </footer>
                </body>
            </html>
        `);

            printWindow.document.close();
            printWindow.print();
            printWindow.close();
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const printIncomeBtn = document.getElementById('printIncomeReportBtn'); // Make sure to add a button with this ID

        printIncomeBtn.addEventListener('click', function () {
            // Create a printable version of the income report
            const printContents = document.getElementById('v-pills-income_reports').cloneNode(true);

            // Remove unnecessary elements
            const modalElements = printContents.querySelectorAll('.modal');
            modalElements.forEach(modal => modal.remove());

            // Find the table and remove the Actions column
            const table = printContents.querySelector('table');
            if (table) {
                // Remove header Actions column
                const headerRow = table.querySelector('thead tr');
                if (headerRow) {
                    headerRow.deleteCell(-1); // Remove last column
                }

                // Remove Actions column from each row
                const bodyRows = table.querySelectorAll('tbody tr');
                bodyRows.forEach(row => {
                    row.deleteCell(-1); // Remove last cell in each row
                });
            }

            // Remove filtering and pagination elements
            const filterForm = printContents.querySelector('form');
            const paginationNav = printContents.querySelector('nav');
            if (filterForm) filterForm.remove();
            if (paginationNav) paginationNav.remove();

            // Create a new window for printing
            const printWindow = window.open('', '', 'height=500, width=800');

            // Get current date and total income
            const currentDate = new Date().toLocaleDateString();
            const totalIncomeElement = printContents.querySelector('.lead'); // Assuming this contains the total income
            const totalIncome = totalIncomeElement ? totalIncomeElement.textContent : 'N/A';

            // Add comprehensive print styling and content
            printWindow.document.write(`
            <html>
                <head>
                    <title>Income Report</title>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            line-height: 1.6;
                            margin: 0;
                            padding: 20mm;
                        }
                        .report-header {
                            text-align: center;
                            margin-bottom: 20px;
                            border-bottom: 2px solid #000;
                            padding-bottom: 10px;
                        }
                        .report-header h1 {
                            margin: 0;
                            color: #333;
                        }
                        .report-info {
                            display: flex;
                            justify-content: space-between;
                            margin-bottom: 20px;
                        }
                        .total-income-box {
                            border: 1px solid #000;
                            padding: 10px;
                            text-align: center;
                        }
                        table {
                            width: 100%;
                            border-collapse: collapse;
                            margin-bottom: 20px;
                        }
                        table, th, td {
                            border: 1px solid #000;
                        }
                        th, td {
                            padding: 8px;
                            text-align: left;
                        }
                        th {
                            background-color: #f2f2f2;
                        }
                        @media print {
                            @page {
                                size: A4;
                                margin: 10mm;
                            }
                            body {
                                padding: 0;
                            }
                        }
                    </style>
                </head>
                <body>
                    <div class="report-header">
                        <h1>Income Report</h1>
                        <p>Generated on: ${currentDate}</p>
                    </div>
                    
                    <div class="report-info">
                        <div>
                            <strong>Total Income:</strong> ${totalIncome}
                        </div>
                    </div>

                    ${printContents.querySelector('.table-responsive').innerHTML}

                    <footer>
                        <p style="text-align: center; margin-top: 20px; font-size: 0.8em;">
                            End of Income Report
                        </p>
                    </footer>
                </body>
            </html>
        `);

            printWindow.document.close();
            printWindow.print();
            printWindow.close();
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.getElementById('sidebar');
        const toggleButton = document.getElementById('toggleSidebar');

        // Default sidebar dalam keadaan collapsed
        sidebar.classList.add('collapsed');

        // Simpan state collapsed di localStorage
        localStorage.setItem('sidebarCollapsed', 'true');

        // Fungsi untuk toggle sidebar
        function toggleSidebar() {
            sidebar.classList.toggle('collapsed');
            // Simpan status terbaru di localStorage
            localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
        }

        // Event listener untuk tombol toggle
        toggleButton.addEventListener('click', function (event) {
            event.stopPropagation(); // Mencegah event propagation
            toggleSidebar();
        });

        // Event listener untuk klik di luar sidebar
        document.addEventListener('click', function (event) {
            // Periksa apakah klik tidak berada di dalam sidebar atau tombol toggle
            if (!sidebar.contains(event.target) && event.target !== toggleButton) {
                // Tutup sidebar jika sedang terbuka
                if (!sidebar.classList.contains('collapsed')) {
                    toggleSidebar();
                }
            }
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Fungsi untuk menyimpan tab yang aktif
        function saveActiveTab(tabId) {
            localStorage.setItem('activeTab', tabId);
        }

        // Fungsi untuk memuat tab yang aktif
        function loadActiveTab() {
            const activeTab = localStorage.getItem('activeTab');

            // Nonaktifkan semua tab terlebih dahulu
            document.querySelectorAll('.nav-link').forEach(tab => {
                tab.classList.remove('active');
            });
            document.querySelectorAll('.tab-pane').forEach(pane => {
                pane.classList.remove('show', 'active');
            });

            // Default ke dashboard jika tidak ada tab tersimpan
            const defaultTabId = '#v-pills-dashboard';
            const defaultTabButton = document.querySelector(`[data-bs-target="${defaultTabId}"]`);
            const defaultTabPane = document.querySelector(defaultTabId);

            if (activeTab) {
                // Cari tombol dan panel tab
                const tabButton = document.querySelector(`[data-bs-target="${activeTab}"]`);
                const tabPane = document.querySelector(activeTab);

                // Aktifkan tab yang disimpan jika ditemukan
                if (tabButton && tabPane) {
                    tabButton.classList.add('active');
                    tabPane.classList.add('show', 'active');
                } else {
                    // Jika tab tidak ditemukan, kembalikan ke dashboard
                    defaultTabButton.classList.add('active');
                    defaultTabPane.classList.add('show', 'active');
                    saveActiveTab(defaultTabId);
                }
            } else {
                // Aktifkan dashboard sebagai default
                defaultTabButton.classList.add('active');
                defaultTabPane.classList.add('show', 'active');
                saveActiveTab(defaultTabId);
            }
        }

        // Tambahkan event listener ke semua tab
        document.querySelectorAll('.nav-link').forEach(tab => {
            tab.addEventListener('click', function () {
                saveActiveTab(this.getAttribute('data-bs-target'));
            });
        });

        // Tangani login
        const loginTrigger = document.querySelector('form[action="../backend/login.php"]');
        if (loginTrigger) {
            loginTrigger.addEventListener('submit', function () {
                // Set tab ke dashboard saat login
                localStorage.setItem('activeTab', '#v-pills-dashboard');
            });
        }

        // Tangani logout
        const logoutLink = document.querySelector('a[href="../backend/logout.php"]');
        if (logoutLink) {
            logoutLink.addEventListener('click', function () {
                // Hapus tab yang aktif saat logout
                localStorage.removeItem('activeTab');
            });
        }

        // Muat tab yang aktif saat halaman dimuat
        loadActiveTab();
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('minimalistColumnChart').getContext('2d');
        let chart; // Global chart variable

        // Store original data from PHP
        const originalData = {
            incomes: <?php echo json_encode($incomes); ?>,
            expenses: <?php echo json_encode($expenses); ?>
        };

        // Function to get default date range (last 7 days)
        function getDefaultDateRange() {
            const endDate = new Date();
            const startDate = new Date();
            startDate.setDate(endDate.getDate() - 7);
            
            return {
                startDate: startDate.toISOString().split('T')[0],
                endDate: endDate.toISOString().split('T')[0]
            };
        }

        // Function to filter transactions by date range
        function filterTransactionsByDateRange(transactions, startDate, endDate) {
            return transactions.filter(transaction => {
                const transactionDate = new Date(transaction.date);
                const start = new Date(startDate);
                const end = new Date(endDate);

                // Adjust end date to include the entire day
                end.setHours(23, 59, 59, 999);

                // Check if transaction date is within the range
                return transactionDate >= start && transactionDate <= end;
            });
        }

        // Function to create chart data
        function prepareChartData(filteredIncomes, filteredExpenses) {
            // Group transactions by date
            const dateGroups = {};
            
            // Combine and sort all transactions
            const allTransactions = [
                ...filteredIncomes.map(t => ({...t, type: 'income'})),
                ...filteredExpenses.map(t => ({...t, type: 'expense'}))
            ].sort((a, b) => new Date(a.date) - new Date(b.date));

            // Group transactions by date
            allTransactions.forEach(transaction => {
                const date = new Date(transaction.date).toISOString().split('T')[0];
                if (!dateGroups[date]) {
                    dateGroups[date] = { income: 0, expense: 0 };
                }
                
                if (transaction.type === 'income') {
                    dateGroups[date].income += parseFloat(transaction.amount);
                } else {
                    dateGroups[date].expense += parseFloat(transaction.amount);
                }
            });

            // Prepare data for chart
            return {
                labels: Object.keys(dateGroups),
                income: Object.values(dateGroups).map(group => group.income),
                expenses: Object.values(dateGroups).map(group => group.expense)
            };
        }

        // Function to create or update the chart
        function createOrUpdateChart(chartData) {
            // Destroy existing chart if it exists
            if (chart) {
                chart.destroy();
            }

            // Create new chart
 chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: chartData.labels,
                    datasets: [
                        {
                            label: 'Income',
                            data: chartData.income,
                            backgroundColor: 'rgba(40, 167, 69, 0.5)',
                            borderRadius: 10,
                            borderSkipped: false,
                            hoverBackgroundColor: 'rgba(40, 167, 69, 0.8)'
                        },
                        {
                            label: 'Expenses',
                            data: chartData.expenses,
                            backgroundColor: 'rgba(220, 53, 69, 0.5)',
                            borderRadius: 10,
                            borderSkipped: false,
                            hoverBackgroundColor: 'rgba(220, 53, 69, 0.8)'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                usePointStyle: true,
                                pointStyle: 'circle',
                                font: {
                                    size: 14
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    return `${context.dataset.label}: Rp ${context.parsed.y.toLocaleString('id-ID')}`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Date'
                            },
                            grid: {
                                display: false // Remove gridlines for x-axis
                            }
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Amount'
                            },
                            ticks: {
                                callback: function (value) {
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            },
                            grid: {
                                display: false // Remove gridlines for y-axis
                            }
                        }
                    }
                }
            });
        }

        // Initialize chart with default date range
        function initializeChart() {
            const defaultRange = getDefaultDateRange();
            
            // Set date inputs to default range
            document.getElementById('startDate').value = defaultRange.startDate;
            document.getElementById('endDate').value = defaultRange.endDate;

            // Filter transactions
            const filteredIncomes = filterTransactionsByDateRange(
                originalData.incomes, 
                defaultRange.startDate, 
                defaultRange.endDate
            );
            const filteredExpenses = filterTransactionsByDateRange(
                originalData.expenses, 
                defaultRange.startDate, 
                defaultRange.endDate
            );

            // Prepare and create chart
            const chartData = prepareChartData(filteredIncomes, filteredExpenses);
            createOrUpdateChart(chartData);
        }

        // Event listener for applying filter
        document.getElementById('applyFilter').addEventListener('click', function () {
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;

            // Filter incomes and expenses
            const filteredIncomes = filterTransactionsByDateRange(originalData.incomes, startDate, endDate);
            const filteredExpenses = filterTransactionsByDateRange(originalData.expenses, startDate, endDate);

            // Prepare and create chart
            const chartData = prepareChartData(filteredIncomes, filteredExpenses);
            createOrUpdateChart(chartData);
        });

        // Event listener for resetting filter
        document.getElementById('resetFilter').addEventListener('click', function () {
            // Reset date inputs
            const defaultRange = getDefaultDateRange();
            document.getElementById('startDate').value = defaultRange.startDate;
            document.getElementById('endDate').value = defaultRange.endDate;

            // Reinitialize chart with default data
            initializeChart();
        });

        // Initialize chart on page load
        initializeChart();
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Store original data
        const originalIncomes = <?php echo json_encode($incomes); ?>;
        const originalExpenses = <?php echo json_encode($expenses); ?>;
        const incomeCategoriesList = <?php echo json_encode($categoriesIncomeList); ?>;
        const expenseCategoriesList = <?php echo json_encode($categoriesExpenseList); ?>;

        let incomeCategoryChart;
        let expenseCategoryChart;

        // Set to store unique colors
        const usedColors = new Set();

        // Utility function to generate a random color
        function getRandomColor(alpha = 1) {
            let color;
            do {
                const r = Math.floor(Math.random() * 255);
                const g = Math.floor(Math.random() * 255);
                const b = Math.floor(Math.random() * 255);
                color = `rgba(${r}, ${g}, ${b}, ${alpha})`;
            } while (usedColors.has(color)); // Ensure the color is unique
            usedColors.add(color); // Add the new color to the set
            return color;
        }

        // Function to filter transactions by date range
        function filterTransactionsByDateRange(transactions, startDate, endDate) {
            return transactions.filter(transaction => {
                const transactionDate = new Date(transaction.date);
                const start = startDate ? new Date(startDate) : null;
                const end = endDate ? new Date(endDate) : null;

                // Adjust end date to include the entire day
                if (end) {
                    end.setHours(23, 59, 59, 999);
                }

                // Check if transaction date is within the range
                return (!start || transactionDate >= start) &&
                    (!end || transactionDate <= end);
            });
        }

        // Function to prepare data for line chart (grouped by date)
        function prepareLineChartData(transactions, categories) {
            const groupedTransactions = transactions.reduce((acc, transaction) => {
                const date = new Date(transaction.date).toISOString().split('T')[0];
                if (!acc[date]) {
                    acc[date] = {};
                    categories.forEach(cat => {
                        acc[date][cat.category_id] = 0;
                    });
                }
                acc[date][transaction.category_id] += parseFloat(transaction.amount);
                return acc;
            }, {});

            const sortedDates = Object.keys(groupedTransactions).sort();

            const datasets = categories.map(category => {
                const color = getRandomColor(1); // Generate a unique color for the category
                return {
                    label: category.name,
                    data: sortedDates.map(date => groupedTransactions[date][category.category_id] || 0),
                    borderColor: color, // Set the border color
                    backgroundColor: color.replace(/rgba\((\d+), (\d+), (\d+), (\d+)\)/, (match, r, g, b) => `rgba(${r}, ${g}, ${b}, 0.2)`), // Set the fill color with reduced opacity
                    tension: 0.4, // Creates curved line
                    fill: true // Enable fill
                };
            });

            return {
                labels: sortedDates,
                datasets: datasets
            };
        }

        // Create or Update Line Chart
        function createOrUpdateChart(chartId, chartData, chartTitle) {
            const ctx = document.getElementById(chartId).getContext('2d');

            // Destroy existing chart if it exists
            const existingChart = Chart.getChart(chartId);
            if (existingChart) {
                existingChart.destroy();
            }

            return new Chart(ctx, {
                type: 'line',
                data: chartData,
                options: {
                    responsive: true,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    plugins: {
                        title: {
                            display: true,
                            text: chartTitle,
                            font: {
                                size: 18,
                                weight: 'bold'
                            },
                            padding: {
                                top: 10,
                                bottom: 30
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            borderColor: '#fff',
                            borderWidth: 1,
                            callbacks: {
                                label: function (context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.y !== null) {
                                        label += new Intl.NumberFormat('id-ID', {
                                            style: 'currency',
                                            currency: 'IDR'
                                        }).format(context.parsed.y);
                                    }
                                    return label;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Date',
                                font: {
                                    size: 14,
                                    weight: 'bold'
                                }
                            },
                            grid: {
                                color: 'rgba(255, 255, 255, 0.2)'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Amount',
                                font: {
                                    size: 14,
                                    weight: 'bold'
                                }
                            },
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(255, 255, 255, 0.2)'
                            }
                        }
                    },
                    animation: {
                        duration: 1500, // Increased animation duration for smoother transitions
                        easing: 'easeInOutQuad' // Changed easing function for smoother effect
                    }
                }
            });
        }

        // Function to get last week's start and end dates
        function getLastWeekDateRange() {
            const endDate = new Date();
            const startDate = new Date();
            startDate.setDate(endDate.getDate() - 7);
            return { startDate, endDate };
        }

        // Income Chart Initialization and Filtering
        function initializeIncomeChart() {
            const { startDate, endDate } = getLastWeekDateRange();
            const filteredIncomes = filterTransactionsByDateRange(originalIncomes, startDate, endDate);
            const chartData = prepareLineChartData(filteredIncomes, incomeCategoriesList);
            incomeCategoryChart = createOrUpdateChart(
                'incomeCategoryChart',
                chartData,
                'Income Trends by Category (Last Week)'
            );
        }

        // Expense Chart Initialization and Filtering
        function initializeExpenseChart() {
            const { startDate, endDate } = getLastWeekDateRange();
            const filteredExpenses = filterTransactionsByDateRange(originalExpenses, startDate, endDate);
            const chartData = prepareLineChartData(filteredExpenses, expenseCategoriesList);
            expenseCategoryChart = createOrUpdateChart(
                'expenseCategoryChart',
                chartData,
                'Expense Trends by Category (Last Week)'
            );
        }

        // Event listeners for filtering charts
        document.getElementById('applyIncomeChartFilter').addEventListener('click', function () {
            const startDate = document.getElementById('incomeChartStartDate').value;
            const endDate = document.getElementById('incomeChartEndDate').value;
            const filteredIncomes = filterTransactionsByDateRange(originalIncomes, startDate, endDate);
            const chartData = prepareLineChartData(filteredIncomes, incomeCategoriesList);
            createOrUpdateChart('incomeCategoryChart', chartData, 'Income Trends by Category');
        });

        document.getElementById('resetIncomeChartFilter').addEventListener('click', function () {
            document.getElementById('incomeChartStartDate').value = '';
            document.getElementById('incomeChartEndDate').value = '';
            initializeIncomeChart();
        });

        document.getElementById('applyExpenseChartFilter').addEventListener('click', function () {
            const startDate = document.getElementById('expenseChartStartDate').value;
            const endDate = document.getElementById('expenseChartEndDate').value;
            const filteredExpenses = filterTransactionsByDateRange(originalExpenses, startDate, endDate);
            const chartData = prepareLineChartData(filteredExpenses, expenseCategoriesList);
            createOrUpdateChart('expenseCategoryChart', chartData, 'Expense Trends by Category');
        });

        document.getElementById('resetExpenseChartFilter').addEventListener('click', function () {
            document.getElementById('expenseChartStartDate').value = '';
            document.getElementById('expenseChartEndDate').value = '';
            initializeExpenseChart();
        });

        // Initialize both charts on page load
        initializeIncomeChart();
        initializeExpenseChart();
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const newPasswordInput = document.getElementById('new_password');
        const confirmPasswordInput = document.getElementById('confirm_password');
        const toggleNewPassword = document.getElementById('toggleNewPassword');
        const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
        const newPasswordIcon = document.getElementById('newPasswordIcon');
        const confirmPasswordIcon = document.getElementById('confirmPasswordIcon');
        const passwordStrength = document.getElementById('passwordStrength');
        const passwordMatchStatus = document.getElementById('passwordMatchStatus');
        const changePasswordForm = document.getElementById('changePasswordForm');

        // Fungsi toggle password visibility
        function togglePasswordVisibility(input, icon) {
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye-fill');
                icon.classList.add('bi-eye-slash-fill');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye-slash-fill');
                icon.classList.add('bi-eye-fill');
            }
        }

        // Event listener untuk toggle password
        toggleNewPassword.addEventListener('click', function () {
            togglePasswordVisibility(newPasswordInput, newPasswordIcon);
        });

        toggleConfirmPassword.addEventListener('click', function () {
            togglePasswordVisibility(confirmPasswordInput, confirmPasswordIcon);
        });


        // Validasi konfirmasi password
        function checkPasswordMatch() {
            if (newPasswordInput.value !== confirmPasswordInput.value) {
                passwordMatchStatus.innerHTML = '<span class="text-danger">Passwords do not match</span>';
                return false;
            } else {
                passwordMatchStatus.innerHTML = '<span class="text-success">Passwords match</span>';
                return true;
            }
        }



        confirmPasswordInput.addEventListener('input', function () {
            checkPasswordMatch();
        });

        // Validasi form sebelum submit
        changePasswordForm.addEventListener('submit', function (e) {
            const strengthScore = checkPasswordStrength(newPasswordInput.value);
            const passwordsMatch = checkPasswordMatch();

            if (strengthScore < 3 || !passwordsMatch) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Password Invalid',
                    text: 'Pastikan password kuat dan sesuai dengan kriteria',
                    showConfirmButton: true
                });
            }
        });
    });
</script>