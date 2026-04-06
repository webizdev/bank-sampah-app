<?php
require_once '../includes/db_connect.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
}

$user_id = $_SESSION['user_id'];

// Handle File Uploads
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'avatar_upload') {
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        $filename = $_FILES['avatar']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid file type']);
            exit;
        }

        $new_filename = 'avatar_' . $user_id . '_' . time() . '.' . $ext;
        
        // Use absolute path to avoid relative mapping issues
        $target_dir = __DIR__ . '/../uploads/avatars/';
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }
        
        $upload_path = $target_dir . $new_filename;

        if (move_uploaded_file($_FILES['avatar']['tmp_name'], $upload_path)) {
            // URL to be stored in DB (relative to site root if possible, or consistent)
            $avatar_url = '../uploads/avatars/' . $new_filename;
            
            // Update DB
            $stmt = $pdo->prepare("UPDATE users SET avatar_url = ? WHERE id = ?");
            $stmt->execute([$avatar_url, $user_id]);

            echo json_encode(['status' => 'success', 'url' => $avatar_url]);
            exit;
        } else {
            $error = error_get_last();
            echo json_encode(['status' => 'error', 'message' => 'Move failed: ' . ($error['message'] ?? 'Unknown error')]);
            exit;
        }
    }
    echo json_encode(['status' => 'error', 'message' => 'No file uploaded or upload error code: ' . ($_FILES['avatar']['error'] ?? 'None')]);
    exit;
}

// Handle Profile Updates (JSON)
$input = json_decode(file_get_contents('php://input'), true);
if ($input && isset($input['action']) && $input['action'] === 'update_profile') {
    try {
        $stmt = $pdo->prepare("UPDATE users SET 
            name = ?, 
            bank_name = ?, 
            account_number = ?, 
            latitude = ?, 
            longitude = ?, 
            address = ?, 
            organization = ? 
            WHERE id = ?");
        
        $stmt->execute([
            $input['name'],
            $input['bank_name'],
            $input['account_number'],
            $input['latitude'],
            $input['longitude'],
            $input['address'],
            $input['organization'],
            $user_id
        ]);

        // Updated session name
        $_SESSION['user_name'] = $input['name'];

        echo json_encode(['status' => 'success', 'message' => 'Profile updated']);
        exit;
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        exit;
    }
}

echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
?>
