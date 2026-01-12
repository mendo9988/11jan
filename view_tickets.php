
<!-- Display them in an HTML table
Show:
Customer Name
Subject
Status
Created Date
Format the date nicely (e.g., d M Y) -->

<?php
require_once "db.php";
$sql = "SELECT customer_name, subject, status, created_at FROM tickets";
$stmt = $pdo -> prepare($sql);
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>View data</title>
</head>
<body>
	<?php if (empty($data)): ?>
	    <p><strong>No tickets found.</strong></p>
	<?php else: ?>
	<table border="1">
		<tr>
			<td>Customer Name</td>
			<td>Subject</td>
			<td>Status</td>
			<td>Created At</td>
		</tr>
		<?php foreach ($data as $row): ?>
			<tr>
				<td><?= htmlspecialchars($row['customer_name']) ?></td>
				<td><?= htmlspecialchars($row['subject']) ?></td>
				<!-- <td><?= htmlspecialchars(ucfirst('status')) ?></td> -->
				<td><?= $row['status'] ?></td>
				<td><?= date("d M Y", strtotime($row['created_at'])) ?></td>

			</tr>
		<?php endforeach; ?>
	</table>
<?php endif; ?>
	<a href="add_ticket.php">Add ticket</a>
</body>
</html>