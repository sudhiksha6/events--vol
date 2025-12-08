<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = getConnection();
    
    $fullName = mysqli_real_escape_string($conn, $_POST['fullName']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $age = !empty($_POST['age']) ? intval($_POST['age']) : NULL;
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $availability = mysqli_real_escape_string($conn, $_POST['availability']);
    $eventPreference = mysqli_real_escape_string($conn, $_POST['eventPreference']);
    
    $skills = '';
    if (isset($_POST['skills']) && is_array($_POST['skills'])) {
        $skills = implode(', ', $_POST['skills']);
    }
    
    $resumePath = '';
    if (isset($_FILES['resume']) && $_FILES['resume']['error'] === 0) {
        $uploadDir = 'uploads/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $fileName = time() . '_' . basename($_FILES['resume']['name']);
        $targetPath = $uploadDir . $fileName;
        if (move_uploaded_file($_FILES['resume']['tmp_name'], $targetPath)) {
            $resumePath = $targetPath;
        }
    }
    
    $sql = "INSERT INTO volunteers (full_name, email, phone, age, address, skills, availability, event_preference, resume_path) 
            VALUES ('$fullName', '$email', '$phone', $age, '$address', '$skills', '$availability', '$eventPreference', '$resumePath')";
    
    if (mysqli_query($conn, $sql)) {
        $volunteer_id = mysqli_insert_id($conn);
        header("Location: success.php?id=$volunteer_id");
        exit();
    }
    
    closeConnection($conn);
}

$conn = getConnection();
$events_result = mysqli_query($conn, "SELECT event_name FROM events");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Volunteer Registration System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .main-container {
            max-width: 800px;
            background: white;
            border-radius: 20px;
            padding: 40px;
            margin: 20px auto;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            color: #6366f1;
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
            transition: color 0.3s;
        }
        .nav-bar a:hover {
            color: #8b5cf6;
        }
        .form-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
        }
        .required {
            color: #ef4444;
        }
        .form-control, .form-select {
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            padding: 12px 16px;
            transition: all 0.3s;
        }
        .form-control:focus, .form-select:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
        }
        .skills-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            margin-top: 10px;
        }
        .skill-item {
            padding: 12px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .skill-item:hover {
            border-color: #6366f1;
            background: #f9fafb;
        }
        .skill-item input[type="checkbox"] {
            margin-right: 8px;
        }
        .btn-submit {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border: none;
            color: white;
            padding: 15px 30px;
            font-size: 18px;
            font-weight: bold;
            border-radius: 10px;
            width: 100%;
            margin-top: 20px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(99,102,241,0.3);
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

    <div class="main-container">
        <div class="header">
            <h1>🤝 Event Volunteer Registration</h1>
            <p>Join our community and make a difference!</p>
        </div>

        <form method="POST" enctype="multipart/form-data">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">👤 Full Name <span class="required">*</span></label>
                    <input type="text" name="fullName" class="form-control" placeholder="John Doe" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">📧 Email <span class="required">*</span></label>
                    <input type="email" name="email" class="form-control" placeholder="john@example.com" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">📱 Phone <span class="required">*</span></label>
                    <input type="tel" name="phone" class="form-control" placeholder="+91 9876543210" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">🎂 Age</label>
                    <input type="number" name="age" class="form-control" placeholder="25" min="16">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">📍 Address</label>
                <textarea name="address" class="form-control" rows="3" placeholder="Enter your complete address"></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">🏆 Skills <span class="required">*</span> (Select at least one)</label>
                <div class="skills-grid">
                    <label class="skill-item">
                        <input type="checkbox" name="skills[]" value="First Aid"> First Aid
                    </label>
                    <label class="skill-item">
                        <input type="checkbox" name="skills[]" value="Teaching"> Teaching
                    </label>
                    <label class="skill-item">
                        <input type="checkbox" name="skills[]" value="Event Management"> Event Management
                    </label>
                    <label class="skill-item">
                        <input type="checkbox" name="skills[]" value="Technical Support"> Technical Support
                    </label>
                    <label class="skill-item">
                        <input type="checkbox" name="skills[]" value="Photography"> Photography
                    </label>
                    <label class="skill-item">
                        <input type="checkbox" name="skills[]" value="Cooking"> Cooking
                    </label>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">⏰ Availability</label>
                <select name="availability" class="form-select">
                    <option value="">Select availability</option>
                    <option value="Weekdays">Weekdays</option>
                    <option value="Weekends">Weekends</option>
                    <option value="Flexible">Flexible</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">📅 Preferred Event <span class="required">*</span></label>
                <select name="eventPreference" class="form-select" required>
                    <option value="">Choose an event</option>
                    <?php while ($event = mysqli_fetch_assoc($events_result)): ?>
                        <option value="<?php echo $event['event_name']; ?>">
                            <?php echo $event['event_name']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">📎 Upload Resume (PDF, DOC, DOCX)</label>
                <input type="file" name="resume" class="form-control" accept=".pdf,.doc,.docx">
            </div>

            <button type="submit" class="btn-submit">✅ Register as Volunteer</button>
        </form>
    </div>
</body>
</html>
<?php closeConnection($conn); ?>
