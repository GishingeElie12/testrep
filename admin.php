<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Feedback</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-5">
        <h1 class="text-2xl font-bold mb-5">Feedback Submissions</h1>
        <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-lg">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Name</th>
                    <th class="py-3 px-6 text-left">Email</th>
                    <th class="py-3 px-6 text-left">Rating</th>
                    <th class="py-3 px-6 text-left">Comments</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Database configuration
                $servername = "localhost"; // Change if your database server is different
                $username = "root"; // Your database username
                $password = ""; // Your database password
                $dbname = "feedback_db"; // Your database name

                // Create connection
                $conn = new mysqli($servername, $username, $password, $dbname);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Pagination variables
                $limit = 5; // Number of entries per page
                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                $offset = ($page - 1) * $limit;

                // Fetch feedback from the database
                $sql = "SELECT * FROM feedback LIMIT $limit OFFSET $offset";
                $result = $conn->query($sql);

                // Display feedback entries
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr class='border-b border-gray-200 hover:bg-gray-100'>";
                        echo "<td class='py-3 px-6 text-left'>{$row['name']}</td>";
                        echo "<td class='py-3 px-6 text-left'>{$row['email']}</td>";
                        echo "<td class='py-3 px-6 text-left'>{$row['rating']}</td>";
                        echo "<td class='py-3 px-6 text-left'>{$row['comments']}</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' class='py-3 px-6 text-center'>No feedback available</td></tr>";
                }

                // Count total feedback entries for pagination
                $countSql = "SELECT COUNT(*) as total FROM feedback";
                $countResult = $conn->query($countSql);
                $totalEntries = $countResult->fetch_assoc()['total'];
                $totalPages = ceil($totalEntries / $limit);

                // Close the database connection
                $conn->close();
                ?>
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="flex justify-between items-center mt-5">
            <div>
                <span class="text-gray-600">Page <?php echo $page; ?> of <?php echo $totalPages; ?></span>
            </div>
            <div>
                <nav class="flex">
                    <?php if ($page > 1): ?>
                        <a href="?page=<?php echo $page - 1; ?>" class="bg-blue-500 text-white px-4 py-2 rounded-l">Previous</a>
                    <?php endif; ?>
                    <?php if ($page < $totalPages): ?>
                        <a href="?page=<?php echo $page + 1; ?>" class="bg-blue-500 text-white px-4 py-2 rounded-r">Next</a>
                    <?php endif; ?>
                </nav>
            </div>
        </div>
    </div>
</body>
</html>