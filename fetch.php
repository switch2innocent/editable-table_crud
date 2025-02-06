<?php
include('db.php');

$query = "SELECT * FROM users";
$stmt = $pdo->prepare($query);
$stmt->execute();

$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($data);
?>
