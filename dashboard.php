<?php
session_start();
include 'includes/db.php';

$user_id = $_SESSION['user_id'];

$incomeQuery = mysqli_query($conn,
"SELECT SUM(amount) as total_income
FROM transactions
WHERE type='income' AND user_id='$user_id'");

$expenseQuery = mysqli_query($conn,
"SELECT SUM(amount) as total_expense
FROM transactions
WHERE type='expense' AND user_id='$user_id'");

$income = mysqli_fetch_assoc($incomeQuery)['total_income'];
$expense = mysqli_fetch_assoc($expenseQuery)['total_expense'];

$balance = $income - $expense;
?>

<h2>Total Income: ₹<?php echo $income; ?></h2>
<h2>Total Expense: ₹<?php echo $expense; ?></h2>
<h2>Balance: ₹<?php echo $balance; ?></h2>