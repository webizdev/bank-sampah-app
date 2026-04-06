<?php
require_once '../includes/db_connect.php';

header('Content-Type: application/json');

// Security Check
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'ADMIN') {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized access']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$method = $_SERVER['REQUEST_METHOD'];
$entity = $_GET['entity'] ?? $input['entity'] ?? '';
$action = $_GET['action'] ?? $input['action'] ?? '';

try {
    switch ($entity) {
        case 'categories':
            handleCategories($pdo, $method, $action, $input);
            break;
        case 'products':
            handleProducts($pdo, $method, $action, $input);
            break;
        case 'services':
            handleServices($pdo, $method, $action, $input);
            break;
        case 'users':
            handleUsers($pdo, $method, $action, $input);
            break;
        case 'transactions':
            handleTransactions($pdo, $method, $action, $input);
            break;
        default:
            echo json_encode(['status' => 'error', 'message' => 'Invalid entity']);
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

function handleCategories($pdo, $method, $action, $data) {
    if ($method === 'GET') {
        $stmt = $pdo->query("SELECT * FROM categories ORDER BY name ASC");
        echo json_encode(['status' => 'success', 'data' => $stmt->fetchAll()]);
    } elseif ($method === 'POST') {
        if ($action === 'delete') {
            $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
            $stmt->execute([$data['id']]);
        } elseif (isset($data['id']) && $data['id'] > 0) {
            $stmt = $pdo->prepare("UPDATE categories SET name=?, slug=?, description=?, icon=?, is_popular=? WHERE id=?");
            $stmt->execute([
                $data['name'],
                $data['slug'],
                $data['description'],
                $data['icon'],
                $data['is_popular'] ? 1 : 0,
                $data['id']
            ]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO categories (name, slug, description, icon, is_popular) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([
                $data['name'],
                $data['slug'],
                $data['description'],
                $data['icon'],
                $data['is_popular'] ? 1 : 0
            ]);
        }
        echo json_encode(['status' => 'success']);
    }
}

function handleProducts($pdo, $method, $action, $data) {
    if ($method === 'GET') {
        $stmt = $pdo->query("SELECT * FROM products ORDER BY name ASC");
        echo json_encode(['status' => 'success', 'data' => $stmt->fetchAll()]);
    } elseif ($method === 'POST') {
        if ($action === 'delete') {
            $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
            $stmt->execute([$data['id']]);
        } elseif (isset($data['id']) && $data['id'] > 0) {
            $stmt = $pdo->prepare("UPDATE products SET name=?, slug=?, description=?, price_per_kg=?, icon=?, is_popular=?, category_id=? WHERE id=?");
            $stmt->execute([
                $data['name'],
                $data['slug'],
                $data['description'],
                $data['price_per_kg'],
                $data['icon'],
                $data['is_popular'] ? 1 : 0,
                $data['category_id'],
                $data['id']
            ]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO products (name, slug, description, price_per_kg, icon, is_popular, category_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $data['name'],
                $data['slug'],
                $data['description'],
                $data['price_per_kg'],
                $data['icon'],
                $data['is_popular'] ? 1 : 0,
                $data['category_id']
            ]);
        }
        echo json_encode(['status' => 'success']);
    }
}

function handleServices($pdo, $method, $action, $data) {
    if ($method === 'GET') {
        $stmt = $pdo->query("SELECT * FROM services ORDER BY name ASC");
        echo json_encode(['status' => 'success', 'data' => $stmt->fetchAll()]);
    } elseif ($method === 'POST') {
        if ($action === 'delete') {
            $stmt = $pdo->prepare("DELETE FROM services WHERE id = ?");
            $stmt->execute([$data['id']]);
        } elseif (isset($data['id']) && $data['id'] > 0) {
            $stmt = $pdo->prepare("UPDATE services SET name=?, description=?, type=?, is_active=? WHERE id=?");
            $stmt->execute([
                $data['name'],
                $data['description'],
                $data['type'],
                $data['is_active'] ? 1 : 0,
                $data['id']
            ]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO services (name, description, type, is_active) VALUES (?, ?, ?, ?)");
            $stmt->execute([
                $data['name'],
                $data['description'],
                $data['type'],
                $data['is_active'] ? 1 : 0
            ]);
        }
        echo json_encode(['status' => 'success']);
    }
}

function handleUsers($pdo, $method, $action, $data) {
    if ($method === 'GET') {
        $stmt = $pdo->query("SELECT id, name, email, role, balance, total_kg, tier, created_at FROM users ORDER BY created_at DESC");
        echo json_encode(['status' => 'success', 'data' => $stmt->fetchAll()]);
    } elseif ($method === 'POST') {
        if ($action === 'delete') {
            $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
            $stmt->execute([$data['id']]);
        } elseif ($action === 'update_balance') {
            $stmt = $pdo->prepare("UPDATE users SET balance = ? WHERE id = ?");
            $stmt->execute([$data['balance'], $data['id']]);
        } elseif (isset($data['id']) && $data['id'] > 0) {
            $stmt = $pdo->prepare("UPDATE users SET name=?, email=?, role=?, tier=? WHERE id=?");
            $stmt->execute([
                $data['name'],
                $data['email'],
                $data['role'],
                $data['tier'],
                $data['id']
            ]);
        }
        echo json_encode(['status' => 'success']);
    }
}

function handleTransactions($pdo, $method, $action, $data) {
    if ($method === 'GET') {
        $query = "SELECT t.*, u.name as user_name, p.name as product_name, c.name as category_name 
                  FROM transactions t 
                  JOIN users u ON t.user_id = u.id 
                  JOIN products p ON t.category_id = p.id 
                  JOIN categories c ON p.category_id = c.id 
                  ORDER BY t.created_at DESC";
        $stmt = $pdo->query($query);
        echo json_encode(['status' => 'success', 'data' => $stmt->fetchAll()]);
    }
}
?>
