 <?php

$sql = "SELECT * FROM transactions
        WHERE user_id='$user_id'
        ORDER BY transaction_date DESC";

$result = mysqli_query($conn,$sql);

while($row = mysqli_fetch_assoc($result)) {
?>

<div>
    <h4><?php echo $row['category']; ?></h4>
    <p><?php echo $row['amount']; ?></p>
    <p><?php echo $row['type']; ?></p>
</div>

<?php } ?> 