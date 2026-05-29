<?php
session_start();
include 'main/db.php';

// Verify user session
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if(isset($_POST['add'])) {
    // Collect and clean form input parameters
    $type = mysqli_real_escape_string($conn, $_POST['type']);
    $amount = mysqli_real_escape_string($conn, $_POST['amount']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);

    // FIXED QUERY: Inserting into 'journal_entries' using your exact new schema column names
    $sql = "INSERT INTO journal_entries (account_id, flow_type, amount, ledger_category, memo, cleared_date)
            VALUES ('$user_id', '$type', '$amount', '$category', '$description', '$date')";

    if(mysqli_query($conn, $sql)) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error saving data: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Transaction - Personal Finance Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center" style="height: 100vh;">

<div class="container" style="max-width: 500px;">
    <div class="card p-4 shadow-sm border-0 rounded-4">
        <h3 class="mb-4 text-center fw-bold text-dark">Add New Entry</h3>
        <form method="POST" action="add_transaction.php">
            <div class="mb-3">
                <label class="form-label fw-semibold text-secondary small">Transaction Type</label>
                <select name="type" class="form-select">
                    <option value="income">Income</option>
                    <option value="expense">Simple Expense</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold text-secondary small">Amount (₹)</label>
                <input type="number" step="0.01" name="amount" class="form-control" placeholder="0.00" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold text-secondary small">Category</label>
                <input type="text" name="category" class="form-control" placeholder="e.g., Food, Rent, Salary" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold text-secondary small">Memo / Notes</label>
                <input type="text" name="description" class="form-control" placeholder="Optional brief note">
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold text-secondary small">Clearance Date</label>
                <input type="date" name="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
            </div>
            <button type="submit" name="add" class="btn btn-primary w-100 fw-bold py-2">Save Ledger Entry</button>
            <a href="dashboard.php" class="btn btn-link w-100 text-center mt-2 text-decoration-none text-muted small">Back to Dashboard</a>
        </form>
    </div>
</div>

</body>
</html>