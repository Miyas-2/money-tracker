<div class="tab-pane fade" id="v-pills-income" role="tabpanel">
    <div class="container-fluid">
        <h2 class="text-center my-5 fw-bold text-dark">Add Your Income</h2>
        <div class="card border-0 shadow-sm border-succes">
            <div class="card-header custom-bg-blue2 ">
                <div class="d-flex align-items-center">
                    <i class="bi bi-cash-coin me-3 fs-4"></i>
                    <h4 class="mb-0">Add Income</h4>
                </div>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="../backend/controll.php" id="incomeForm">
                    <input type="hidden" name="action" value="addIncome">

                    <div class="row g-3">
                        <div class="col-md-6 mb-3">
                            <label for="income" class="form-label fw-semibold text-dark">Income Amount</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-currency-dollar"></i>
                                </span>
                                <input type="number" class="form-control form-control-lg" id="income" name="income"
                                    placeholder="Enter income amount" required step="0.01" min="0"
                                    aria-describedby="incomeHelp">
                            </div>
                            <small id="incomeHelp" class="form-text text-muted">
                                Enter the total amount of your income.
                            </small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="category_id" class="form-label fw-semibold text-dark">Category</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-tag"></i>
                                </span>
                                <select class="form-select form-select-lg" id="category_id" name="category_id" required
                                    aria-describedby="categoryHelp">
                                    <option value="">Select Income Category</option>
                                    <?php foreach ($categoriesIncomeList as $category): ?>
                                        <option value="<?php echo $category['category_id']; ?>">
                                            <?php echo htmlspecialchars($category['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <small id="categoryHelp" class="form-text text-muted">
                                Choose the most appropriate category for your income.
                            </small>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6 mb-3">
                            <label for="date" class="form-label fw-semibold text-dark">Date</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-calendar-date"></i>
                                </span>
                                <input type="date" class="form-control form-control-lg" id="date" name="date" required
                                    aria-describedby="dateHelp">
                            </div>
                            <small id="dateHelp" class="form-text text-muted">
                                Select the date of the income.
                            </small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="description" class="form-label fw-semibold text-dark">Description</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-pencil"></i>
                                </span>
                                <textarea class="form-control form-control-lg" id="description" name="description"
                                    rows="1" placeholder="Additional details" maxlength="255"></textarea>
                            </div>
                            <small class="form-text text-muted">
                                Optional: Add any additional notes (max 255 characters).
                            </small>
                        </div>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn custom-bg-blue2 btn-lg">
                            <i class="bi bi-plus-circle me-2"></i>Add Income
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>