<?php
session_start();
include 'main/db.php';

if(!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$id = mysqli_real_escape_string($conn, $_GET['id']);

// FIXED QUERY: Uses 'journal_entries' and matches 'entry_id' and 'account_id'
$sql = "DELETE FROM journal_entries WHERE entry_id='$id' AND account_id='$user_id'";

if(mysqli_query($conn, $sql)) {
    header("Location: dashboard.php");
    exit();
} else {
    echo "Error removing data entry: " . mysqli_error($conn);
}
?>