<?php
session_start();
include 'main/db.php';

// Check if user is logged in via account_id session variable
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// --- FIXED QUERIES: Matching 'journal_entries', 'flow_type', and 'account_id' ---
$incomeQuery = mysqli_query($conn, "SELECT SUM(amount) as total_income FROM journal_entries WHERE flow_type='income' AND account_id='$user_id'");
$expenseQuery = mysqli_query($conn, "SELECT SUM(amount) as total_expense FROM journal_entries WHERE flow_type='expense' AND account_id='$user_id'");

$income = mysqli_fetch_assoc($incomeQuery)['total_income'] ?? 0;
$expense = mysqli_fetch_assoc($expenseQuery)['total_expense'] ?? 0;
$balance = $income - $expense;

// --- Handle Filters ---
$category_filter = $_GET['category'] ?? '';
$date_filter = $_GET['date'] ?? '';

$sql = "SELECT * FROM journal_entries WHERE account_id='$user_id'";

if(!empty($category_filter)) {
    $cat = mysqli_real_escape_string($conn, $category_filter);
    $sql .= " AND ledger_category LIKE '%$cat%'";
}
if(!empty($date_filter)) {
    $dt = mysqli_real_escape_string($conn, $date_filter);
    $sql .= " AND cleared_date = '$dt'";
}

$sql .= " ORDER BY cleared_date DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Personal Finance Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Financial Summary Dashboard</h2>
        <div>
            <a href="add_transaction.php" class="btn btn-primary">+ Add Entry</a>
            <a href="logout.php" class="btn btn-outline-danger btn-sm ms-2">Logout</a>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card bg-success text-white p-3 shadow-sm">
                <h5>Total Income</h5>
                <h3>₹<?php echo number_format($income, 2); ?></h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-danger text-white p-3 shadow-sm">
                <h5>Total Expense</h5>
                <h3>₹<?php echo number_format($expense, 2); ?></h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-info text-white p-3 shadow-sm">
                <h5>Net Balance</h5>
                <h3>₹<?php echo number_format($balance, 2); ?></h3>
            </div>
        </div>
    </div>

    <div class="card p-3 mb-4 shadow-sm">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-4">
                <label class="form-label small fw-bold text-secondary">Filter by Category</label>
                <input type="text" name="category" class="form-control form-control-sm" placeholder="e.g., Food, Salary" value="<?php echo htmlspecialchars($category_filter); ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-bold text-secondary">Filter by Date</label>
                <input type="date" name="date" class="form-control form-control-sm" value="<?php echo htmlspecialchars($date_filter); ?>">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-secondary btn-sm">Apply Filters</button>
                <a href="dashboard.php" class="btn btn-link btn-sm text-decoration-none">Clear</a>
            </div>
        </form>
    </div>

    <div class="card p-3 shadow-sm">
        <h4 class="mb-3">Recent Journal Entries</h4>
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Category</th>
                    <th>Memo/Description</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if(mysqli_num_rows($result) > 0): ?>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo date('d M Y', strtotime($row['cleared_date'])); ?></td>
                            <td><span class="badge bg-secondary"><?php echo htmlspecialchars($row['ledger_category']); ?></span></td>
                            <td><?php echo htmlspecialchars($row['memo']); ?></td>
                            <td>
                                <span class="badge bg-<?php echo ($row['flow_type'] == 'income') ? 'success' : 'danger'; ?>">
                                    <?php echo ucfirst($row['flow_type']); ?>
                                </span>
                            </td>
                            <td class="fw-bold text-<?php echo ($row['flow_type'] == 'income') ? 'success' : 'danger'; ?>">
                                ₹<?php echo number_format($row['amount'], 2); ?>
                            </td>
                            <td>
                                <a href="edit_transaction.php?id=<?php echo $row['entry_id']; ?>" class="btn btn-warning btn-sm me-1">Edit</a>
                                <a href="delete_transaction.php?id=<?php echo $row['entry_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this entry?')">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted">No journal entries recorded yet.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>