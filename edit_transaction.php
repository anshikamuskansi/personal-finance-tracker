<?php
session_start();
include 'main/db.php';

if(!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$id = mysqli_real_escape_string($conn, $_GET['id']);

// FIXED QUERY: Using 'journal_entries', 'entry_id', and 'account_id'
$query = mysqli_query($conn, "SELECT * FROM journal_entries WHERE entry_id='$id' AND account_id='$user_id'");
$transaction = mysqli_fetch_assoc($query);

if(!$transaction) {
    echo "Entry not found or unauthorized access.";
    exit();
}

if(isset($_POST['update'])) {
    $type = mysqli_real_escape_string($conn, $_POST['type']);
    $amount = mysqli_real_escape_string($conn, $_POST['amount']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);

    // FIXED QUERY: Matching your specific database update mapping schema definitions
    $sql = "UPDATE journal_entries 
            SET flow_type='$type', amount='$amount', ledger_category='$category', memo='$description', cleared_date='$date' 
            WHERE entry_id='$id' AND account_id='$user_id'";
            
    if(mysqli_query($conn, $sql)) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Entry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center" style="height: 100vh;">

<div class="container" style="max-width: 500px;">
    <div class="card p-4 shadow-sm border-0 rounded-4">
        <h3 class="mb-4 text-center fw-bold text-dark">Edit Ledger Entry</h3>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label fw-semibold text-secondary small">Type</label>
                <select name="type" class="form-select">
                    <option value="income" <?php if($transaction['flow_type'] == 'income') echo 'selected'; ?>>Income</option>
                    <option value="expense" <?php if($transaction['flow_type'] == 'expense') echo 'selected'; ?>>Expense</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold text-secondary small">Amount (₹)</label>
                <input type="number" step="0.01" name="amount" class="form-control" value="<?php echo $transaction['amount']; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold text-secondary small">Category</label>
                <input type="text" name="category" class="form-control" value="<?php echo htmlspecialchars($transaction['ledger_category']); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold text-secondary small">Memo / Notes</label>
                <input type="text" name="description" class="form-control" value="<?php echo htmlspecialchars($transaction['memo']); ?>">
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold text-secondary small">Clearance Date</label>
                <input type="date" name="date" class="form-control" value="<?php echo $transaction['cleared_date']; ?>" required>
            </div>
            <button type="submit" name="update" class="btn btn-warning w-100 fw-bold text-dark py-2">Update Entry</button>
            <a href="dashboard.php" class="btn btn-link w-100 text-center mt-2 text-decoration-none text-muted small">Cancel Changes</a>
        </form>
    </div>
</div>

</body>
</html>