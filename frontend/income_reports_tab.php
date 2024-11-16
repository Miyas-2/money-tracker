<div class="tab-pane fade" id="v-pills-income_reports" role="tabpanel">
    <div class="container-fluid my-5">
        <h2 class="text-center my-5">Income Reports</h2>
        <!-- Income Records Section -->
        <div class="mb-3">
            <div class="custom-bg-blue2 p-3 rounded shadow-sm">
                <h4 class="">Total Income</h4>
                <p class="lead">Rp. <?php echo number_format($totalIncomesMoney, 2); ?></p>
                <hr>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <p class="mb-0">Thank you for managing your finances with us!</p>
                    <button id="printIncomeReportBtn" class="btn custom-bg-blue2"> <i class="bi bi-printer p-1"></i>Print Income Report</button>
                </div>
            </div>
        </div>
        <div class="card mt-4 shadow-sm">
            <div class="card-header custom-bg-blue2">
                <h4 class="mb-0"><i class="bi bi-cash-stack me-3 fs-4"></i>Income Records</h4>
            </div>
            <div class="card-body ">
                <!-- Filtering Form -->
                <form method="GET" class="mb-4">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label for="incomesPerPage">Entries per page:</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-list-ol"></i>
                                </span>
                                <select id="incomesPerPage" name="incomesPerPage" class="form-select">
                                    <option value="10" <?php echo (isset($_GET['incomesPerPage']) && $_GET['incomesPerPage'] == 10) ? 'selected' : ''; ?>>10</option>
                                    <option value="25" <?php echo (isset($_GET['incomesPerPage']) && $_GET['incomesPerPage'] == 25) ? 'selected' : ''; ?>>25</option>
                                    <option value="50" <?php echo (isset($_GET['incomesPerPage']) && $_GET['incomesPerPage'] == 50) ? 'selected' : ''; ?>>50</option>
                                    <option value="100" <?php echo (isset($_GET['incomesPerPage']) && $_GET['incomesPerPage'] == 100) ? 'selected' : ''; ?>>100</option>
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
                                    // Check if $categoriesIncomeList exists and is an array
                                    if (!empty($categoriesIncomeList) && is_array($categoriesIncomeList)):
                                        foreach ($categoriesIncomeList as $category):
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
                            <a href="?#v-pills-income_reports" class="btn btn-secondary">
                                <i class="bi bi-arrow-clockwise"></i> Reset Filters
                            </a>
                        </div>
                    </div>
                </form>


                <!-- Rest of the existing code remains the same -->
                <!-- Just replace $incomes with $filteredIncomes and $pageIncomes -->

                <?php if (!empty($pageIncomes)): ?>
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
                                <?php foreach ($pageIncomes as $index => $income): ?>
                                    <tr>
                                        <td><?php echo $incomeOffset + $index + 1; ?></td>
                                        <td>Rp. <?php echo number_format($income['amount'], 2); ?></td>
                                        <td><?php echo htmlspecialchars($income['category_name'] ?? 'Unknown Category'); ?></td>
                                        <td><?php echo htmlspecialchars($income['date']); ?></td>
                                        <td><?php echo htmlspecialchars($income['description'] ?? 'N/A'); ?></td>
                                        <td>

                                            <button type="button" class="btn btn-sm custom-bg-blue1 m-1" data-bs-toggle="modal"
                                                data-bs-target="#editIncomeModal<?php echo $income['income_id']; ?>">
                                                <i class="bi bi-pencil"></i>
                                            </button>

                                            <!-- Delete Modal Trigger -->
                                            <button type="button" class="btn btn-sm custom-bg-blue4 m-1" data-bs-toggle="modal"
                                                data-bs-target="#deleteIncomeModal<?php echo $income['income_id']; ?>">
                                                <i class="bi bi-trash"></i>
                                            </button>


                                            <!-- Edit Income Modal -->
                                            <div class="modal fade" id="editIncomeModal<?php echo $income['income_id']; ?>"
                                                tabindex="-1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header custom-bg-blue2 text-white">
                                                            <h5 class="modal-title">Edit Income</h5>
                                                            <button type="button" class="btn-close btn-close-white"
                                                                data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <form method="POST" action="../backend/controll.php">
                                                            <div class="modal-body">
                                                                <input type="hidden" name="action" value="editIncome">
                                                                <input type="hidden" name="income_id"
                                                                    value="<?php echo $income['income_id']; ?>">

                                                                <div class="mb-3">
                                                                    <label for="income<?php echo $income['income_id']; ?>"
                                                                        class="form-label">Income
                                                                        Amount</label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">$</span>
                                                                        <input type="number" class="form-control"
                                                                            id="income<?php echo $income['income_id']; ?>"
                                                                            name="income" required step="0.01" min="0"
                                                                            value="<?php echo $income['amount']; ?>">
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6 mb-3">
                                                                    <label for="category_id" class="form-label">Category</label>
                                                                    <select class="form-select" id="category_id"
                                                                        name="category_id">
                                                                        <option value="">Select Income
                                                                            Category</option>
                                                                        <?php

                                                                        foreach ($categoriesIncomeList as $category2):
                                                                            // Check if $income is defined and has category_id
                                                                            $selected = (isset($income['category_id']) && $category2['category_id'] == $income['category_id']) ? 'selected' : '';
                                                                            ?>
                                                                            <option
                                                                                value="<?php echo htmlspecialchars($category2['category_id']); ?>"
                                                                                <?php echo $selected; ?>>
                                                                                <?php echo htmlspecialchars($category2['name']); ?>
                                                                            </option>
                                                                            <?php
                                                                        endforeach;

                                                                        ?>
                                                                    </select>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="date<?php echo $income['income_id']; ?>"
                                                                        class="form-label">Date</label>
                                                                    <input type="date" class="form-control"
                                                                        id="date<?php echo $income['income_id']; ?>" name="date"
                                                                        required value="<?php echo $income['date']; ?>">
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="description<?php echo $income['income_id']; ?>"
                                                                        class="form-label">Description
                                                                        (Optional)</label>
                                                                    <textarea class="form-control"
                                                                        id="description<?php echo $income['income_id']; ?>"
                                                                        name="description" rows="3"
                                                                        maxlength="255"><?php echo htmlspecialchars($income['description'] ?? ''); ?></textarea>
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

                                            <!-- Delete Confirmation Modal -->
                                            <div class="modal fade" id="deleteIncomeModal<?php echo $income['income_id']; ?>"
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
                                                                <input type="hidden" name="action" value="deleteIncome">
                                                                <input type="hidden" name="income_id"
                                                                    value="<?php echo $income['income_id']; ?>">
                                                                <p>Are you sure you want to delete this
                                                                    income record?</p>
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
                            <div class="mb-3">
                                <p>Total Income Records: <?php echo $totalIncomes; ?></p>
                            </div>

                            <!-- Modify pagination links to include filter parameters -->
                            <nav aria-label="Income Records Pagination">
                                <ul class="pagination justify-content-center">
                                    <!-- Previous Button -->
                                    <li class="page-item <?php echo ($incomeCurrentPage <= 1) ? 'disabled' : ''; ?>">
                                        <a class="page-link"
                                            href="?income_page=<?php echo max(1, $incomeCurrentPage - 1); ?>&incomesPerPage=<?php echo $incomesPerPage; ?>&category_filter=<?php echo isset($_GET['category_filter']) ? $_GET['category_filter'] : ''; ?>&start_date=<?php echo isset($_GET['start_date']) ? $_GET['start_date'] : ''; ?>&end_date=<?php echo isset($_GET['end_date']) ? $_GET['end_date'] : ''; ?>#v-pills-income_reports"
                                            aria-label="Previous">
                                            <span aria-hidden="true">&laquo; Previous</span>
                                        </a>
                                    </li>

                                    <!-- Page Numbers -->
                                    <?php for ($i = 1; $i <= $totalIncomePages; $i++): ?>
                                        <li class="page-item <?php echo ($i == $incomeCurrentPage) ? 'active' : ''; ?>">
                                            <a class="page-link"
                                                href="?income_page=<?php echo $i; ?>&incomesPerPage=<?php echo $incomesPerPage; ?>&category_filter=<?php echo isset($_GET['category_filter']) ? $_GET['category_filter'] : ''; ?>&start_date=<?php echo isset($_GET['start_date']) ? $_GET['start_date'] : ''; ?>&end_date=<?php echo isset($_GET['end_date']) ? $_GET['end_date'] : ''; ?>#v-pills-income_reports"><?php echo $i; ?></a>
                                        </li>
                                    <?php endfor; ?>

                                    <!-- Next Button -->
                                    <li
                                        class="page-item <?php echo ($incomeCurrentPage >= $totalIncomePages) ? 'disabled' : ''; ?>">
                                        <a class="page-link"
                                            href="?income_page=<?php echo min($totalIncomePages, $incomeCurrentPage + 1); ?>&incomesPerPage=<?php echo $incomesPerPage; ?>&category_filter=<?php echo isset($_GET['category_filter']) ? $_GET['category_filter'] : ''; ?>&start_date=<?php echo isset($_GET['start_date']) ? $_GET['start_date'] : ''; ?>&end_date=<?php echo isset($_GET['end_date']) ? $_GET['end_date'] : ''; ?>#v-pills-income_reports"
                                            aria-label="Next">
                                            <span aria-hidden="true">Next &raquo;</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                <?php else: ?>
                    <p class="text-muted">No income records found. Add your first expense!</p>
                <?php endif; ?>
            </div>
        </div>



        <div class="card-body mt-3">
            <!-- Income Chart -->
            <div class="card mb-4 shadow-sm">
                <div class="card-header custom-bg-blue2">
                    <h4 class="mb-0">Income Trend</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="incomeChartStartDate">Start Date:</label>
                            <input type="date" id="incomeChartStartDate" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label for="incomeChartEndDate">End Date:</label>
                            <input type="date" id="incomeChartEndDate" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label>&nbsp;</label>
                            <button id="applyIncomeChartFilter" class="btn custom-bg-blue2 form-control">Apply
                                Filter</button>
                        </div>
                        <div class="col-md-3">
                            <label>&nbsp;</label>
                            <button id="resetIncomeChartFilter" class="btn btn-secondary form-control">Reset
                                Filter</button>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-12">
                            <canvas id="incomeCategoryChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>