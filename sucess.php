<?php
require_once 'config.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$conn = getConnection();
$volunteer_id = intval($_GET['id']);
$sql = "SELECT * FROM volunteers WHERE id = $volunteer_id";
$result = mysqli_query($conn, $sql);
$volunteer = mysqli_fetch_assoc($result);

if (!$volunteer) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Successful!</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .success-container {
            max-width: 700px;
            margin: 50px auto;
            background: white;
            border-radius: 20px;
            padding: 50px;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        .success-icon {
            font-size: 100px;
            margin-bottom: 20px;
        }
        .details-box {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            border-radius: 15px;
            padding: 30px;
            margin: 30px 0;
            text-align: left;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #d1d5db;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .detail-label {
            font-weight: 600;
            color: #374151;
        }
        .detail-value {
            color: #6b7280;
        }
        h2 {
            color: #10b981;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="success-container">
        <div class="success-icon">✅</div>
        <h2>Registration Successful!</h2>
        <p class="lead">Thank you for joining our volunteer community</p>
        
        <div class="details-box">
            <h4>📋 Your Registration Details:</h4>
            <div class="detail-row">
                <span class="detail-label">ID:</span>
                <span class="detail-value">#<?php echo $volunteer['id']; ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Name:</span>
                <span class="detail-value"><?php echo htmlspecialchars($volunteer['full_name']); ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Email:</span>
                <span class="detail-value"><?php echo htmlspecialchars($volunteer['email']); ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Phone:</span>
                <span class="detail-value"><?php echo htmlspecialchars($volunteer['phone']); ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Event:</span>
                <span class="detail-value"><?php echo htmlspecialchars($volunteer['event_preference']); ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Skills:</span>
                <span class="detail-value"><?php echo htmlspecialchars($volunteer['skills']); ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Registered:</span>
                <span class="detail-value"><?php echo date('M d, Y H:i', strtotime($volunteer['registration_date'])); ?></span>
            </div>
        </div>
        
        <div class="mt-4">
            <a href="index.php" class="btn btn-success btn-lg me-2">Register Another</a>
            <a href="volunteers.php" class="btn btn-outline-success btn-lg">View All Volunteers</a>
        </div>
    </div>
</body>
</html>
<?php closeConnection($conn); ?>