<?php
include 'db_connect.php';

// Function to archive inactive users from all roles (Admin, Librarian, Student)
function archiveInactiveUsers()
{
    global $conn;

    // Get the current date and subtract 1 year to check for users who haven't logged in for a year
    $one_year_ago = date('Y-m-d H:i:s', strtotime('-1 year'));

    // Define the roles and corresponding tables and their user_id fields
    $roles_tables = [
        'admin_acc' => ['role' => 'Admin', 'user_id_field' => 'admin_no'],
        'librarian_acc' => ['role' => 'Librarian', 'user_id_field' => 'librarian_no'],
        'stud_acc' => ['role' => 'Student', 'user_id_field' => 'stud_no']
    ];

    // Loop through each table for each role and archive inactive users
    foreach ($roles_tables as $table => $info) {
        archiveFromTable($table, $one_year_ago, $info['role'], $info['user_id_field'], $conn);
    }
}

// Function to handle the archiving process for each table
function archiveFromTable($table, $one_year_ago, $role, $user_id_field, $conn)
{
    // Step 1: Fetch users from the given table who haven't logged in for 1 year
    $sql = "SELECT * FROM $table WHERE last_logged_in <= ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $one_year_ago);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($user = $result->fetch_assoc()) {
        if (!isset($user[$user_id_field])) {
            error_log("Missing user ID field ($user_id_field) in table $table. User: " . print_r($user, true));
            continue; // Skip to next user
        }

        $user_id = $user[$user_id_field];

        $insert_sql = "INSERT INTO archived_acc (user_id, first_name, last_name, email, role, archived_at)
                   VALUES (?, ?, ?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        $current_time = date('Y-m-d H:i:s');
        $insert_stmt->bind_param("isssss", $user_id, $user['first_name'], $user['last_name'], $user['email'], $role, $current_time);
        $insert_stmt->execute();

        $delete_sql = "DELETE FROM $table WHERE $user_id_field = ?";
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bind_param("i", $user_id);
        $delete_stmt->execute();
    }
}

// Run the archiving process
archiveInactiveUsers();
