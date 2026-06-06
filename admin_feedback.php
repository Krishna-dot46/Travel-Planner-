<?php
session_start();

include 'db.php';

// Delete feedback if delete button clicked
if(isset($_GET['delete_id'])){
    $delete_id = $_GET['delete_id'];
  $delete_query = "DELETE FROM feedback WHERE id=$1";
pg_query_params($conn,$delete_query,array($delete_id));
    header("Location: admin_feedback.php");
    exit();
}

// Fetch all feedback
$query = "SELECT * FROM feedback ORDER BY submitted_at DESC";
$result = pg_query($conn, $query);
$feedbacks = pg_fetch_all($result);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Feedback - Admin Panel</title>
    <link rel="stylesheet" href="style.css">
    <style>
    body {
        margin: 0;
        padding: 0;
        font-family: 'Poppins', sans-serif;
        background: #f5f5f5;
    }

    .admin-container {
        display: flex;
        min-height: 100vh;
    }

    .main-content {
        flex: 1;
        margin-left: 220px;
        padding: 40px;
    }

    .feedback-container {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        padding: 30px;
    }

    .feedback-container h1 {
        color: #2c3e50;
        margin-bottom: 30px;
        border-bottom: 3px solid #c9a24d;
        padding-bottom: 10px;
    }

    .feedback-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .feedback-table thead {
        background: #2c3e50;
        color: white;
    }

    .feedback-table th,
    .feedback-table td {
        padding: 15px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    .feedback-table tr:hover {
        background: #f9f9f9;
    }

    .feedback-table tbody tr:nth-child(even) {
        background: #f5f5f5;
    }

    .action-btn {
        display: inline-block;
        padding: 8px 15px;
        margin-right: 5px;
        border-radius: 4px;
        text-decoration: none;
        cursor: pointer;
        border: none;
        font-size: 13px;
        transition: 0.3s;
    }

    .view-btn {
        background: #3498db;
        color: white;
    }

    .view-btn:hover {
        background: #2980b9;
    }

    .delete-btn {
        background: #e74c3c;
        color: white;
    }

    .delete-btn:hover {
        background: #c0392b;
    }

    .no-feedback {
        text-align: center;
        padding: 40px;
        color: #7f8c8d;
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
        background: white;
        margin: 5% auto;
        padding: 30px;
        width: 600px;
        border-radius: 8px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
    }

    .modal-content h2 {
        color: #2c3e50;
        margin-top: 0;
        border-bottom: 2px solid #c9a24d;
        padding-bottom: 10px;
    }

    .close-btn {
        float: right;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
        color: #999;
    }

    .close-btn:hover {
        color: #000;
    }

    .modal-row {
        margin-bottom: 15px;
    }

    .modal-row strong {
        color: #2c3e50;
        display: block;
        margin-bottom: 5px;
    }

    .modal-row p {
        margin: 0;
        color: #555;
        background: #f5f5f5;
        padding: 10px;
        border-radius: 4px;
    }
    </style>
</head>

<body>

    <div class="admin-container">
        <!-- Sidebar -->
        <?php include 'admin_menu.php'; ?>

        <!-- Main Content -->
        <div class="main-content">
            <div class="feedback-container">
                <h1>Contact Form Submissions</h1>

                <?php if($feedbacks && count($feedbacks) > 0): ?>
                <table class="feedback-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Service</th>
                            <th>Submitted Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($feedbacks as $feedback): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($feedback['name']); ?></td>
                            <td><?php echo htmlspecialchars($feedback['email']); ?></td>
                            <td><?php echo htmlspecialchars($feedback['phone']); ?></td>
                            <td><?php echo htmlspecialchars($feedback['service']); ?></td>
                            <td><?php echo date('d-M-Y H:i', strtotime($feedback['submitted_at'])); ?></td>
                            <td>
                                <button class="action-btn view-btn"
                                    onclick="viewFeedback(<?php echo $feedback['id']; ?>)">View</button>
                                <a href="admin_feedback.php?delete_id=<?php echo $feedback['id']; ?>"
                                    class="action-btn delete-btn"
                                    onclick="return confirm('Delete this feedback?')">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <div class="no-feedback">
                    <p>No feedback submissions yet.</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Modal for viewing full message -->
    <div id="feedbackModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeFeedback()">&times;</span>
            <h2>Full Message</h2>
            <div id="modalBody"></div>
        </div>
    </div>

    <script>
    // Get feedback data passed from PHP
    const feedbackData = <?php echo json_encode($feedbacks ?? []); ?>;

    function viewFeedback(id) {
        const feedback = feedbackData.find(f => f.id == id);
        if (feedback) {
            const modalBody = document.getElementById('modalBody');
            modalBody.innerHTML = `
                    <div class="modal-row">
                        <strong>Name:</strong>
                        <p>${feedback.name}</p>
                    </div>
                    <div class="modal-row">
                        <strong>Email:</strong>
                        <p>${feedback.email}</p>
                    </div>
                    <div class="modal-row">
                        <strong>Phone:</strong>
                        <p>${feedback.phone}</p>
                    </div>
                    <div class="modal-row">
                        <strong>Service:</strong>
                        <p>${feedback.service}</p>
                    </div>
                    <div class="modal-row">
                        <strong>Message:</strong>
                        <p>${feedback.message}</p>
                    </div>
                    <div class="modal-row">
                        <strong>Submitted:</strong>
                        <p>${new Date(feedback.submitted_at).toLocaleString()}</p>
                    </div>
                `;
            document.getElementById('feedbackModal').style.display = 'block';
        }
    }

    function closeFeedback() {
        document.getElementById('feedbackModal').style.display = 'none';
    }

    window.onclick = function(event) {
        const modal = document.getElementById('feedbackModal');
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
    </script>

</body>

</html>