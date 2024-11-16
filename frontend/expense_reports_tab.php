<div class="tab-pane fade" id="v-pills-expense_reports" role="tabpanel">
    <div class="container-fluid">
        <h2 class="text-center my-5">Expense Reports</h2>
        <!-- Expense Records Section -->
        <div class="mb-3">
            <div class="custom-bg-blue2 shadow-sm rounded p-3" role="alert">
                <h4 class="alert-heading">Total Expenses</h4>
                <p class="lead total-expenses">Rp. <?php echo number_format($totalExpensesMoney, 2); ?></p>
                <hr>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <p class="mb-0">Keep track of your spending to stay on budget!</p>
                    <button id="printExpenseReportBtn" class="btn custom-bg-blue2">
                        <i class="bi bi-printer p-1"></i> Print Expense Report
                    </button>
                </div>
            </div>
        </div>
        <div class="card mt-4 shadow-sm">
            <div class="card-header custom-bg-blue2">
                <h4 class="mb-0"><i class="bi bi-cash-coin me-3 fs-4"></i>Expense Records</h4>
            </div>
            <div class="card-body">
                <!-- Filtering Form -->
                <form method="GET" class="mb-4">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label for="expensesPerPage">Entries per page:</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-list-ol"></i>
                                </span>
                                <select id="expensesPerPage" name="expensesPerPage" class="form-select">
                                    <option value="10" <?php echo (isset($_GET['expensesPerPage']) && $_GET['expensesPerPage'] == 10) ? 'selected' : ''; ?>>10</option>
                                    <option value="25" <?php echo (isset($_GET['expensesPerPage']) && $_GET['expensesPerPage'] == 25) ? 'selected' : ''; ?>>25</option>
                                    <option value="50" <?php echo (isset($_GET['expensesPerPage']) && $_GET['expensesPerPage'] == 50) ? 'selected' : ''; ?>>50</option>
                                    <option value="100" <?php echo (isset($_GET['expensesPerPage']) && $_GET['expensesPerPage'] == 100) ? 'selected' : ''; ?>>100</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="categoryFilter">Category:</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-tags"></i>
                                </span>
                                <select id="categoryFilter" name="category_filter" class="form-select">
                                    <option value="">All Categories</option>
                                    <?php
                                    // Check if $categoriesExpenseList exists and is an array
                                    if (!empty($categoriesExpenseList) && is_array($categoriesExpenseList)):
                                        foreach ($categoriesExpenseList as $category):
                                            // Ensure category has required keys and sanitize output
                                            $categoryId = isset($category['category_id']) ? htmlspecialchars($category['category_id']) : '';
                                            $categoryName = isset($category['name']) ? htmlspecialchars($category['name']) : 'Unnamed Category';

                                            // Check if category_filter is set in GET and matches current category
                                            $selected = (isset($_GET['category_filter']) && $_GET['category_filter'] == $categoryId) ? 'selected' : '';
                                            ?>
                                            <option value="<?php echo $categoryId; ?>" <?php echo $selected; ?>>
                                                <?php echo $categoryName; ?>
                                            </option>
                                            <?php
                                        endforeach;
                                    else:
                                        ?>
                                        <option value="">No categories available</option>
                                        <?php
                                    endif;
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="startDate">Start Date:</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-calendar"></i>
                                </span>
                                <input type="date" id="startDate" name="start_date" class="form-control"
                                    value="<?php echo isset($_GET['start_date']) ? htmlspecialchars($_GET['start_date']) : ''; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="endDate">End Date:</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-calendar"></i>
                                </span>
                                <input type="date" id="endDate" name="end_date" class="form-control"
                                    value="<?php echo isset($_GET['end_date']) ? htmlspecialchars($_GET['end_date']) : ''; ?>">
                            </div>
                        </div>
                        <div class="col-12 mt-3">
                            <button type="submit" class="btn custom-bg-blue2 me-2">
                                <i class="bi bi-funnel"></i> Apply Filters
                            </button>
                            <a href="?#v-pills-expense_reports" class="btn btn-secondary">
                                <i class="bi bi-arrow-clockwise"></i> Reset Filters
                            </a>
                        </div>
                    </div>
                </form>

                <!-- pagination -->
                <?php if (!empty($pageExpenses)): ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Amount</th>
                                    <th>Category</th>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pageExpenses as $index => $expense): ?>
                                    <tr>
                                        <td><?php echo $expenseOffset + $index + 1; ?></td>
                                        <td>Rp. <?php echo number_format($expense['amount'], 2); ?></td>
                                        <td><?php echo htmlspecialchars($expense['category_name'] ?? 'Unknown Category'); ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($expense['date']); ?></td>
                                        <td><?php echo htmlspecialchars($expense['description'] ?? 'N/A'); ?></td>
                                        <td>
                                            <!-- Edit Modal Trigger -->
                                            <button type="button" class="btn btn-sm custom-bg-blue1 m-1" data-bs-toggle="modal"
                                                data-bs-target="#editExpenseModal<?php echo $expense['expense_id']; ?>">
                                                <i class="bi bi-pencil"></i>
                                            </button>

                                            <!-- Delete Modal Trigger -->
                                            <button type="button" class="btn btn-sm custom-bg-blue4 m-1" data-bs-toggle="modal"
                                                data-bs-target="#deleteExpenseModal<?php echo $expense['expense_id']; ?>">
                                                <i class="bi bi-trash"></i>
                                            </button>

                                            <!-- Edit Expense Modal -->
                                            <div class="modal fade" id="editExpenseModal<?php echo $expense['expense_id']; ?>"
                                                tabindex="-1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header custom-bg-blue2 text-white">
                                                            <h5 class="modal-title">Edit Expense</h5>
                                                            <button type="button" class="btn-close btn-close-white"
                                                                data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <form method="POST" action="../backend/controll.php">
                                                            <div class="modal-body">
                                                                <input type="hidden" name="action" value="editExpense">
                                                                <input type="hidden" name="expense_id"
                                                                    value="<?php echo $expense['expense_id']; ?>">

                                                                <div class="mb-3">
                                                                    <label for="expense<?php echo $expense['expense_id']; ?>"
                                                                        class="form-label">Expense
                                                                        Amount</label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">$</span>
                                                                        <input type="number" class="form-control"
                                                                            id="expense<?php echo $expense['expense_id']; ?>"
                                                                            name="expense" required step="0.01" min="0"
                                                                            value="<?php echo $expense['amount']; ?>">
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6 mb-3">
                                                                    <label for="category_id" class="form-label">Category</label>
                                                                    <select class="form-select" id="category_id"
                                                                        name="category_id" required>
                                                                        <option value="">Select Expense
                                                                            Category</option>
                                                                        <?php

                                                                        foreach ($categoriesExpenseList as $category):
                                                                            // Check if $expense is defined and has category_id
                                                                            $selected = (isset($expense['category_id']) && $category['category_id'] == $expense['category_id']) ? 'selected' : '';
                                                                            ?>
                                                                            <option
                                                                                value="<?php echo htmlspecialchars($category['category_id']); ?>"
                                                                                <?php echo $selected; ?>>
                                                                                <?php echo htmlspecialchars($category['name']); ?>
                                                                            </option>
                                                                            <?php
                                                                        endforeach;

                                                                        ?>
                                                                    </select>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="date<?php echo $expense['expense_id']; ?>"
                                                                        class="form-label">Date</label>
                                                                    <input type="date" class="form-control"
                                                                        id="date<?php echo $expense['expense_id']; ?>"
                                                                        name=" date" required
                                                                        value="<?php echo $expense['date']; ?>">
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label
                                                                        for="description<?php echo $expense['expense_id']; ?>"
                                                                        class="form-label">Description
                                                                        (Optional)</label>
                                                                    <textarea class="form-control"
                                                                        id="description<?php echo $expense['expense_id']; ?>"
                                                                        name="description" rows="3"
                                                                        maxlength="255"><?php echo htmlspecialchars($expense['description'] ?? ''); ?></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn custom-bg-blue2">Save
                                                                    Changes</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Delete Expense Modal -->
                                            <div class="modal fade" id="deleteExpenseModal<?php echo $expense['expense_id']; ?>"
                                                tabindex="-1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header custom-bg-blue2 text-white">
                                                            <h5 class="modal-title">Confirm Deletion</h5>
                                                            <button type="button" class="btn-close btn-close-white"
                                                                data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <form method="POST" action="../backend/controll.php">
                                                            <div class="modal-body">
                                                                <input type="hidden" name="action" value="deleteExpense">
                                                                <input type="hidden" name="expense_id"
                                                                    value="<?php echo $expense['expense_id']; ?>">
                                                                <p>Are you sure you want to delete this
                                                                    expense record?</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Cancel</button>
                                                                <button type="submit"
                                                                    class="btn custom-bg-blue2">Delete</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <div>
                            <!-- Show total filtered expenses count -->
                            <div class="mb-3">
                                <p>Total Expenses Record: <?php echo $totalExpenses; ?></p>
                            </div>

                            <nav aria-label="Expense Records Pagination">
                                <ul class="pagination justify-content-center">
                                    <!-- Previous Button -->
                                    <li class="page-item <?php echo ($expenseCurrentPage <= 1) ? 'disabled' : ''; ?>">
                                        <a class="page-link"
                                            href="?expense_page=<?php echo max(1, $expenseCurrentPage - 1); ?>&expensesPerPage=<?php echo $expensesPerPage; ?>#v-pills-reports"
                                            aria-label="Previous">
                                            <span aria-hidden="true">&laquo; Previous</span>
                                        </a>
                                    </li>

                                    <!-- Page Numbers -->
                                    <?php for ($i = 1; $i <= $totalExpensePages; $i++): ?>
                                        <li class="page-item <?php echo ($i == $expenseCurrentPage) ? 'active' : ''; ?>">
                                            <a class="page-link"
                                                href="?expense_page=<?php echo $i; ?>&expensesPerPage=<?php echo $expensesPerPage; ?>#v-pills-reports"><?php echo $i; ?></a>
                                        </li>
                                    <?php endfor; ?>

                                    <!-- Next Button -->
                                    <li
                                        class="page-item <?php echo ($expenseCurrentPage >= $totalExpensePages) ? 'disabled' : ''; ?>">
                                        <a class="page-link"
                                            href="?expense_page=<?php echo min($totalExpensePages, $expenseCurrentPage + 1); ?>&expensesPerPage=<?php echo $expensesPerPage; ?>#v-pills-reports"
                                            aria-label="Next">
                                            <span aria-hidden="true">Next &raquo;</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>



                <?php else: ?>
                    <p class="text-muted">No expense records found. Add your first expense!</p>
                <?php endif; ?>
            </div>
        </div>
        <!-- Expense Chart -->
        <div class="card mb-4 mt-3 shadow-sm">
            <div class="card-header custom-bg-blue2">
                <h4 class="mb-0">Expense Trend</h4>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="expenseChartStartDate">Start Date:</label>
                        <input type="date" id="expenseChartStartDate" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label for="expenseChartEndDate">End Date:</label>
                        <input type="date" id="expenseChartEndDate" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label>&nbsp;</label>
                        <button id="applyExpenseChartFilter" class="btn custom-bg-blue2 form-control">Apply
                            Filter</button>
                    </div>
                    <div class="col-md-3">
                        <label>&nbsp;</label>
                        <button id="resetExpenseChartFilter" class="btn btn-secondary form-control">Reset
                            Filter</button>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-12">
                        <canvas id="expenseCategoryChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>