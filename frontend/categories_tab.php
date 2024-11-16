<div class="tab-pane fade" id="v-pills-categories" role="tabpanel">
    <div class="container-fluid">
        <h2 class="text-center my-5 fw-bold text-dark">Category Management</h2>

        <!-- Add Category Section -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header custom-bg-blue2  d-flex align-items-center">
                <i class="bi bi bi-tag me-3 fs-4"></i>
                <h4 class="mb-0">Add New Category</h4>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="../backend/controll.php">
                    <input type="hidden" name="action" value="addCategory">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="categoryName" class="form-label fw-semibold">Category Name</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-tag"></i>
                                </span>
                                <input type="text" class="form-control form-control-lg" id="categoryName" name="name"
                                    placeholder="Enter category name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="categoryType" class="form-label fw-semibold">Category Type</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-list-task"></i>
                                </span>
                                <select class="form-select form-select-lg" id="categoryType" name="type" required>
                                    <option value="">Select Category Type</option>
                                    <option value="Income">Income</option>
                                    <option value="Expense">Expense</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn custom-bg-blue2  btn-lg w-100 mt-3">
                                <i class="bi bi-plus-circle me-2"></i>Add Category
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Existing Categories Section -->
        <div class="card border-0 shadow-sm">
            <div class="card-header custom-bg-blue2 y d-flex align-items-center">
                <i class="bi bi-tags me-3 fs-4"></i>
                <h4 class="mb-0">Existing Categories</h4>
            </div>
            <div class="card-body p-4">
                <div class="row mb-4">
                    <div class="col-12">
                        <form method="GET" class="mb-3">
                            <div class="row align-items-end">
                                <div class="col-md-3">
                                    <label for="entriesPerPage" class="form-label">Entries per page</label>
                                    <select id="entriesPerPage" name="entriesPerPage" class="form-select">
                                        <?php
                                        $entries = [5, 10, 15, 20];
                                        foreach ($entries as $entry): ?>
                                            <option value="<?php echo $entry; ?>" <?php echo (isset($_GET['entriesPerPage']) && $_GET['entriesPerPage'] == $entry) ? 'selected' : ''; ?>>
                                                <?php echo $entry; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label for="filterType" class="form-label">Filter by Type</label>
                                    <select id="filterType" name="filterType" class="form-select">
                                        <option value="">All Types</option>
                                        <option value="Income" <?php echo (isset($_GET['filterType']) && $_GET['filterType'] == 'Income') ? 'selected' : ''; ?>>Income</option>
                                        <option value="Expense" <?php echo (isset($_GET['filterType']) && $_GET['filterType'] == 'Expense') ? 'selected' : ''; ?>>Expense</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                <div class="d-flex">
                                    <button type="submit" class="btn custom-bg-blue2 me-2">
                                        <i class="bi bi-funnel"></i> Apply Filters
                                    </button>
                                    <a href="?" class="btn btn-secondary">
                                        <i class="bi bi-arrow-clockwise"></i> Reset fillters
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php if (!empty($categoriesToDisplay)): ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="">
                                <tr>
                                    <th class="">#</th>
                                    <th class="">Category Name</th>
                                    <th class="">Category Type</th>
                                    <th class="">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($categoriesToDisplay as $index => $category): ?>
                                    <tr>
                                        <td><?php echo $startIndex + $index + 1; ?></td>
                                        <td><?php echo htmlspecialchars($category['name']); ?></td>
                                        <td>
                                            <span
                                                class="badge 
                                                <?php echo $category['type'] == 'Income' ? 'bg-success' : 'bg-danger'; ?>">
                                                <?php echo htmlspecialchars($category['type']); ?>
                                            </span>
                                        </td>
                                        <td>

                                            <button type="button" class="btn btn-sm custom-bg-blue1 m-1" data-bs-toggle="modal"
                                                data-bs-target="#editCategoryModal<?php echo $category['category_id']; ?>">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm custom-bg-blue4 m-1" data-bs-toggle="modal"
                                                data-bs-target="#deleteCategoryModal<?php echo $category['category_id']; ?>">
                                                <i class="bi bi-trash"></i>
                                            </button>

                                        </td>
                                    </tr>

                                    <!-- Edit Category Modal -->
                                    <div class="modal fade" id="editCategoryModal<?php echo $category['category_id']; ?>"
                                        tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header custom-bg-blue2  text-white">
                                                    <h5 class="modal-title">Edit Category</h5>
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <form method="POST" action="../backend/controll.php">
                                                    <div class="modal-body">
                                                        <input type="hidden" name="action" value="editCategory">
                                                        <input type="hidden" name="category_id"
                                                            value="<?php echo $category['category_id']; ?>">
                                                        <div class="mb-3">
                                                            <label for="editCategoryName<?php echo $category['category_id']; ?>"
                                                                class="form-label">Category Name</label>
                                                            <input type="text" class="form-control"
                                                                id="editCategoryName<?php echo $category['category_id']; ?>"
                                                                name="name"
                                                                value="<?php echo htmlspecialchars($category['name']); ?>"
                                                                required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="editCategoryType<?php echo $category['category_id']; ?>"
                                                                class="form-label">Category Type</label>
                                                            <select class="form-select"
                                                                id="editCategoryType<?php echo htmlspecialchars($category['category_id']); ?>"
                                                                name="type" required>
                                                                <option value="Income" <?php echo (isset($category['type']) && $category['type'] == 'Income') ? 'selected' : ''; ?>>Income
                                                                </option>
                                                                <option value="Expense" <?php echo (isset($category['type']) && $category['type'] == 'Expense') ? 'selected' : ''; ?>>Expense
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn custom-bg-blue2 me-2">Save
                                                            Changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Delete Category Modal -->
                                    <div class="modal fade" id="deleteCategoryModal<?php echo $category['category_id']; ?>"
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
                                                        <input type="hidden" name="action" value="deleteCategory">
                                                        <input type="hidden" name="category_id"
                                                            value="<?php echo $category['category_id']; ?>">
                                                        <p>Are you sure you want to delete this category?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn custom-bg-blue2">Delete</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Edit and Delete Modal HTML remains unchanged -->
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="mb-3">
                        <p>Total Categories: <?php echo $totalItems; ?></p>
                    </div>

                    <nav aria-label="Categories Pagination">
                        <ul class="pagination justify-content-center">
                            <!-- Previous Button -->
                            <li class="page-item <?php echo ($currentPage <= 1) ? 'disabled' : ''; ?>">
                                <a class="page-link"
                                    href="?page=<?php echo max(1, $currentPage - 1); ?>&entriesPerPage=<?php echo $itemsPerPage; ?>&filterType=<?php echo htmlspecialchars($filterType); ?>"
                                    aria-label="Previous">
                                    <span aria-hidden="true">&laquo; Previous</span>
                                </a>
                            </li>

                            <!-- Page Numbers -->
                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="page-item <?php echo ($i == $currentPage) ? 'active' : ''; ?>">
                                    <a class="page-link"
                                        href="?page=<?php echo $i; ?>&entriesPerPage=<?php echo $itemsPerPage; ?>&filterType=<?php echo htmlspecialchars($filterType); ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>

                            <!-- Next Button -->
                            <li class="page-item <?php echo ($currentPage >= $totalPages) ? 'disabled' : ''; ?>">
                                <a class="page-link"
                                    href="?page=<?php echo min($totalPages, $currentPage + 1); ?>&entriesPerPage=<?php echo $itemsPerPage; ?>&filterType=<?php echo htmlspecialchars($filterType); ?>"
                                    aria-label="Next">
                                    <span aria-hidden="true">Next &raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                <?php else: ?>
                    <p class="text-muted">No categories found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>