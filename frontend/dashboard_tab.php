<div class="tab-pane fade" id="v-pills-dashboard" role="tabpanel">
    <h1 class="card-title text-center my-4">Welcome to Money Tracker,
        <span class="text-primary"><?php echo htmlspecialchars($_SESSION['user']['username']); ?>!</span>
    </h1>
    <p class="text-center mb-5">This is your Dashboard.</p>

    <!-- Financial Summary Card -->
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card shadow-sm ">
                <div class="card-body">
                    <h5 class="card-title text-center">Financial Summary</h5>
                    <div class="row">
                        <div class="col-md-4">
                            <strong>Total Income (Year):</strong>
                            <p class="text-success">
                                Rp.<?php echo number_format($totalIncomeYear, 2); ?></p>
                        </div>
                        <div class="col-md-4">
                            <strong>Total Expense (Year):</strong>
                            <p class="text-danger">
                                Rp.<?php echo number_format($totalExpenseYear, 2); ?></p>
                        </div>
                        <div class="col-md-4">
                            <strong>Net Balance (Year):</strong>
                            <?php
                            $netBalance = $totalIncomeYear - $totalExpenseYear;
                            $balanceClass = $netBalance >= 0 ? 'text-success' : 'text-danger';
                            ?>
                            <p class="<?php echo $balanceClass; ?>">
                                Rp.<?php echo number_format($netBalance, 2); ?>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mt-5"><?php echo generateWaveSVG('#007bff'); ?></div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Total Income Today -->
        <div class="col-md-4 mb-4">
            <div class="card  shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-success"><i class="fas fa-wallet"></i> Total Income Today</h5>
                    <h2 class="card-text">Rp.<?php echo number_format($totalIncomeToday, 2); ?></h2>
                    <small class="text-muted">Today</small>
                    <?php if ($percentageIncomeToday != 0): ?>
                        <p class="<?php echo ($percentageIncomeToday > 0) ? 'text-success' : 'text-danger'; ?>">
                            <?php echo ($percentageIncomeToday > 0 ? '+' : '') . number_format($percentageIncomeToday, 2) . '% from Yesterday'; ?>
                        </p>
                    <?php endif; ?>
                </div>
                <?php echo generateWaveSVG('#28a745'); ?>
            </div>
        </div>

        <!-- Total Income This Week -->
        <div class="col-md-4 mb-4">
            <div class="card  shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-success"><i class="fas fa-wallet"></i> Total Income This Week</h5>
                    <h2 class="card-text">Rp.<?php echo number_format($totalIncomeWeek, 2); ?></h2>
                    <small class="text-muted">This Week</small>
                    <?php if ($percentageIncomeWeek != 0): ?>
                        <p class="<?php echo ($percentageIncomeWeek > 0) ? 'text-success' : 'text-danger'; ?>">
                            <?php echo ($percentageIncomeWeek > 0 ? '+' : '') . number_format($percentageIncomeWeek, 2) . '% from Last Week'; ?>
                        </p>
                    <?php endif; ?>
                </div>
                <?php echo generateWaveSVG('#28a745'); ?>
            </div>
        </div>

        <!-- Total Income This Month -->
        <div class="col-md-4 mb-4">
            <div class="card  shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-success"><i class="fas fa-wallet"></i> Total Income This Month</h5>
                    <h2 class="card-text">Rp.<?php echo number_format($totalIncomeMonth, 2); ?></h2>
                    <small class="text-muted">This Month</small>
                    <?php if ($percentageIncomeMonth != 0): ?>
                        <p class="<?php echo ($percentageIncomeMonth > 0) ? 'text-success' : 'text-danger'; ?>">
                            <?php echo ($percentageIncomeMonth > 0 ? '+' : '') . number_format($percentageIncomeMonth, 2) . '% from Last Month'; ?>
                        </p>
                    <?php endif; ?>
                </div>
                <?php echo generateWaveSVG('#28a745'); ?>
            </div>
        </div>

        <!-- Total Expense Today -->
        <div class="col-md-4 mb-4">
            <div class="card  shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-danger"><i class="fas fa-wallet"></i> Total Expense Today</h5>
                    <h2 class="card-text">Rp.<?php echo number_format($totalExpenseToday, 2); ?></h2>
                    <small class="text-muted">Today</small>
                    <?php if ($percentageExpenseToday != 0): ?>
                        <p class="<?php echo ($percentageExpenseToday < 0) ? 'text-success' : 'text-danger'; ?>">
                            <?php echo ($percentageExpenseToday > 0 ? '+' : '') . number_format($percentageExpenseToday, 2) . '% from Yesterday'; ?>
                        </p>
                    <?php endif; ?>
                </div>
                <?php echo generateWaveSVG('#dc3545'); ?>
            </div>
        </div>
        <!-- Total Expense This Week -->
        <div class="col-md-4 mb-4">
            <div class="card  shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-danger"><i class="fas fa-wallet"></i> Total Expense This Week</h5>
                    <h2 class="card-text">Rp.<?php echo number_format($totalExpenseWeek, 2); ?></h2>
                    <small class="text-muted">This Week</small>
                    <?php if ($percentageExpenseWeek != 0): ?>
                        <p class="<?php echo ($percentageExpenseWeek < 0) ? 'text-success' : 'text-danger'; ?>">
                            <?php echo ($percentageExpenseWeek > 0 ? '+' : '') . number_format($percentageExpenseWeek, 2) . '% from Last Week'; ?>
                        </p>
                    <?php endif; ?>
                </div>
                <?php echo generateWaveSVG('#dc3545'); ?>
            </div>
        </div>
        <!-- Total Expense This Month -->
        <div class="col-md-4 mb-4">
            <div class="card  shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-danger"><i class="fas fa-wallet"></i> Total Expense This Month</h5>
                    <h2 class="card-text">Rp.<?php echo number_format($totalExpenseMonth, 2); ?></h2>
                    <small class="text-muted">This Month</small>
                    <?php if ($percentageExpenseMonth != 0): ?>
                        <p class="<?php echo ($percentageExpenseMonth < 0) ? 'text-success' : 'text-danger'; ?>">
                            <?php echo ($percentageExpenseMonth > 0 ? '+' : '') . number_format($percentageExpenseMonth, 2) . '% from Last Month'; ?>
                        </p>
                    <?php endif; ?>
                </div>
                <?php echo generateWaveSVG('#dc3545'); ?>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- Total Income Last Today -->
        <div class="col-md-4 mb-4">
            <div class="card  shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-success"><i class="fas fa-wallet"></i> Total Income Yesterday</h5>
                    <h2 class="card-text">Rp.<?php echo number_format($totalIncomeYesterday, 2); ?></h2>
                    <small class="text-muted">Today</small>
                </div>
                <?php echo generateWaveSVG('#28a745'); ?>
            </div>
        </div>
        <!-- Total Income Last Week -->
        <div class="col-md-4 mb-4">
            <div class="card  shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-success"><i class="fas fa-wallet"></i> Total Income Last Week</h5>
                    <h2 class="card-text">Rp.<?php echo number_format($totalIncomeLastWeek, 2); ?></h2>
                    <small class="text-muted">This Week</small>
                </div>
                <?php echo generateWaveSVG('#28a745'); ?>
            </div>
        </div>
        <!-- Total Income Last Month -->
        <div class="col-md-4 mb-4">
            <div class="card  shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-success"><i class="fas fa-wallet"></i> Total Income Last Month</h5>
                    <h2 class="card-text">Rp.<?php echo number_format($totalIncomeLastMonth, 2); ?></h2>
                    <small class="text-muted">This Month</small>
                </div>
                <?php echo generateWaveSVG('#28a745'); ?>
            </div>
        </div>
        <!-- Total Expense Yesterday -->
        <div class="col-md-4 mb-4">
            <div class="card  shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-danger"><i class="fas fa-wallet"></i> Total Expense Yesterday</h5>
                    <h2 class="card-text">Rp.<?php echo number_format($totalExpenseYesterday, 2); ?></h2>
                    <small class="text-muted">Yesterday</small>
                </div>
                <?php echo generateWaveSVG('#dc3545'); ?>
            </div>
        </div>

        <!-- Total Expense Last Week -->
        <div class="col-md-4 mb-4">
            <div class="card  shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-danger"><i class="fas fa-wallet"></i> Total Expense Last Week</h5>
                    <h2 class="card-text">Rp.<?php echo number_format($totalExpenseLastWeek, 2); ?></h2>
                    <small class="text-muted">Last Week</small>
                </div>
                <?php echo generateWaveSVG('#dc3545'); ?>
            </div>
        </div>

        <!-- Total Expense Last Month -->
        <div class="col-md-4 mb-4">
            <div class="card  shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-danger"><i class="fas fa-wallet"></i> Total Expense Last Month</h5>
                    <h2 class="card-text">Rp.<?php echo number_format($totalExpenseLastMonth, 2); ?></h2>
                    <small class="text-muted">Last Month</small>
                </div>
                <?php echo generateWaveSVG('#dc3545'); ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card  shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-success"><i class="fas fa-wallet"></i> Total Income This Year</h5>
                    <h2 class="card-text">Rp.<?php echo number_format($totalIncomeYear, 2); ?></h2>
                    <small class="text-muted">Current Year</small>
                    <?php echo generateWaveSVG('#28a745'); ?>
                </div>
            </div>
        </div>
        <!-- Total Expense This Year -->
        <div class="col-md-6 mb-4">
            <div class="card  shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-danger"><i class="fas fa-money-bill-wave"></i> Total Expense This Year
                    </h5>
                    <h2 class="card-text">Rp.<?php echo number_format($totalExpenseYear, 2); ?></h2>
                    <small class="text-muted">Current Year</small>
                </div>
                <?php echo generateWaveSVG('#dc3545'); ?>
            </div>
        </div>

        <!-- Total Income Last 6 Months -->
        <div class="col-md-6 mb-4">
            <div class="card  shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-success"><i class="fas fa-wallet"></i> Total Income Last 6 Months</h5>
                    <h2 class="card-text">Rp.<?php echo number_format($totalIncomeLast6Months, 2); ?></h2>
                    <small class="text-muted">Last 6 Months</small>
                </div>
                <?php echo generateWaveSVG('#28a745'); ?>
            </div>
        </div>

        <!-- Total Expense Last 6 Months -->
        <div class="col-md-6 mb-4">
            <div class="card  shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-danger"><i class="fas fa-money-bill-wave"></i> Total Expense Last 6
                        Months</h5>
                    <h2 class="card-text">Rp.<?php echo number_format($totalExpenseLast6Months, 2); ?></h2>
                    <small class="text-muted">Last 6 Months</small>
                    <?php echo generateWaveSVG('#dc3545'); ?>
                </div>
            </div>

        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm p-4">
                <div class="filter-container">
                    <div class="date-filter d-flex align-items-center justify-content-between">
                        <div class="form-group me-3">
                            <label for="startDate" class="mb-1">
                                <i class="fas fa-calendar-alt"></i> Start Date:
                            </label>
                            <input type="date" class="form-control" id="startDate">
                        </div>

                        <div class="form-group me-3">
                            <label for="endDate" class="mb-1">
                                <i class="fas fa-calendar-alt"></i> End Date:
                            </label>
                            <input type="date" class="form-control" id="endDate">
                        </div>

                        <div class="button-group">
                            <button id="applyFilter" class="btn btn-success me-2">
                                <i class="fas fa-filter"></i> Apply Filter
                            </button>
                            <button id="resetFilter" class="btn btn-danger">
                                <i class="fas fa-undo"></i> Reset Filter
                            </button>
                        </div>
                    </div>

                    <canvas id="minimalistColumnChart" class="mt-4"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>