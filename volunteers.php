<?php
require_once 'config.php';
$conn = getConnection();

// Handle deletion
if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM volunteers WHERE id = $delete_id");
    header('Location: volunteers.php');
    exit();
}

$sql = "SELECT * FROM volunteers ORDER BY registration_date DESC";
$result = mysqli_query($conn, $sql);
$count = mysqli_num_rows($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Volunteers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            background: white;
            border-radius: 20px;
            padding: 30px;
            margin-top: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        .nav-bar {
            background: rgba(255,255,255,0.95);
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .nav-bar a {
            margin: 0 15px;
            color: #6366f1;
            text-decoration: none;
            font-weight: 600;
        }
        .count-badge {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: bold;
            display: inline-block;
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <div class="nav-bar">
        <a href="index.php">🏠 Register</a>
        <a href="volunteers.php">👥 View All</a>
        <a href="resume.html">📄 Resume 1</a>
        <a href="resume2.html">📄 Resume 2</a>
        <a href="assignment2.html">📝 Assignment 2</a>
    </div>

    <div class="container">
        <h2 class="mb-4">
            📋 Registered Volunteers 
            <span class="count-badge"><?php echo $count; ?> Total</span>
        </h2>
        
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Skills</th>
                        <th>Event</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($count > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><strong>#<?php echo $row['id']; ?></strong></td>
                            <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['phone']); ?></td>
                            <td><small><?php echo htmlspecialchars($row['skills']); ?></small></td>
                            <td><?php echo htmlspecialchars($row['event_preference']); ?></td>
                            <td><?php echo date('M d, Y', strtotime($row['registration_date'])); ?></td>
                            <td>
                                <a href="success.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-info">👁️ View</a>
                                <a href="?delete=<?php echo $row['id']; ?>" 
                                   class="btn btn-sm btn-danger" 
                                   onclick="return confirm('Are you sure you want to delete this volunteer?')">🗑️ Delete</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center">
                                <p class="mt-4 mb-4">No volunteers registered yet. Be the first one!</p>
                                <a href="index.php" class="btn btn-primary">Register Now</a>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
<?php closeConnection($conn); ?>