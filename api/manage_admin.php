<?php
header('Content-Type: application/json');
require_once '../includes/db_connect.php';

// Security Check
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'ADMIN') {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'Sesi admin berakhir. Silakan login kembali.']);
    exit;
}

$input = $_POST;
if (empty($input)) {
    $input = json_decode(file_get_contents('php://input'), true) ?? [];
}
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
        case 'settings':
            handleSettings($pdo, $method, $action, $input);
            break;
        case 'system':
            handleSystem($pdo, $method, $action, $input);
            break;
        case 'sales':
            handleSales($pdo, $method, $action, $input);
            break;
        case 'crafts':
            handleCrafts($pdo, $method, $action, $input);
            break;
        case 'articles':
            handleArticles($pdo, $method, $action, $input);
            break;
        default:
            echo json_encode(['status' => 'error', 'message' => 'Invalid entity']);
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'DB Error: ' . $e->getMessage()]);
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
        } else {
            // Handle Product Image Upload
            $image_url = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                if (!is_dir('../uploads/products')) mkdir('../uploads/products', 0777, true);
                $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $filename = 'product_' . time() . '_' . uniqid() . '.' . $ext;
                $upload_path = '../uploads/products/' . $filename;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                    $image_url = '../uploads/products/' . $filename;
                }
            }

            // category_id: Jika kosong atau 0, ubah jadi NULL
            $category_id = (!isset($data['parent_id']) || $data['parent_id'] === '' || $data['parent_id'] == 0) ? null : $data['parent_id'];

            if (isset($data['id']) && $data['id'] > 0) {
                if ($image_url) {
                    $stmt = $pdo->prepare("UPDATE products SET name=?, slug=?, description=?, price_per_kg=?, icon=?, is_popular=?, category_id=?, image_url=? WHERE id=?");
                    $stmt->execute([
                        $data['name'],
                        $data['slug'],
                        $data['description'],
                        $data['price_per_kg'],
                        $data['icon'],
                        $data['is_popular'] ? 1 : 0,
                        $category_id,
                        $image_url,
                        $data['id']
                    ]);
                } else {
                    $stmt = $pdo->prepare("UPDATE products SET name=?, slug=?, description=?, price_per_kg=?, icon=?, is_popular=?, category_id=? WHERE id=?");
                    $stmt->execute([
                        $data['name'],
                        $data['slug'],
                        $data['description'],
                        $data['price_per_kg'],
                        $data['icon'],
                        $data['is_popular'] ? 1 : 0,
                        $category_id,
                        $data['id']
                    ]);
                }
            } else {
                $stmt = $pdo->prepare("INSERT INTO products (name, slug, description, price_per_kg, icon, is_popular, category_id, image_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([
                    $data['name'],
                    $data['slug'],
                    $data['description'],
                    $data['price_per_kg'],
                    $data['icon'],
                    $data['is_popular'] ? 1 : 0,
                    $category_id,
                    $image_url
                ]);
            }
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
        $stmt = $pdo->query("SELECT id, name, whatsapp, email, role, balance, total_kg, tier, created_at FROM users ORDER BY created_at DESC");
        echo json_encode(['status' => 'success', 'data' => $stmt->fetchAll()]);
    } elseif ($method === 'POST') {
        if ($action === 'delete') {
            $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
            $stmt->execute([$data['id']]);
        } elseif ($action === 'update_balance') {
            $stmt = $pdo->prepare("UPDATE users SET balance = ? WHERE id = ?");
            $stmt->execute([$data['balance'], $data['id']]);
        } elseif (isset($data['id']) && $data['id'] > 0) {
            $stmt = $pdo->prepare("UPDATE users SET name=?, whatsapp=?, role=?, tier=? WHERE id=?");
            $stmt->execute([
                $data['name'],
                $data['whatsapp'],
                $data['role'],
                $data['tier'],
                $data['id']
            ]);
        } else {
            // Create New Member with default password
            $stmt_check = $pdo->prepare("SELECT id FROM users WHERE whatsapp = ?");
            $stmt_check->execute([$data['whatsapp']]);
            if ($stmt_check->fetch()) {
                echo json_encode(['status' => 'error', 'message' => 'Nomor WhatsApp sudah terdaftar.']);
                exit;
            }
            
            $default_password = password_hash('123456', PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (name, whatsapp, role, tier, password) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([
                $data['name'],
                $data['whatsapp'],
                $data['role'],
                $data['tier'],
                $default_password
            ]);
        }
        echo json_encode(['status' => 'success']);
    }
}

function handleTransactions($pdo, $method, $action, $data) {
    if ($method === 'GET') {
        $query = "SELECT t.*, u.name as user_name, p.name as category_name 
                  FROM transactions t 
                  JOIN users u ON t.user_id = u.id 
                  JOIN products p ON t.product_id = p.id 
                  ORDER BY t.created_at DESC";
        $stmt = $pdo->query($query);
        echo json_encode(['status' => 'success', 'data' => $stmt->fetchAll()]);
    } elseif ($method === 'POST') {
        if ($action === 'verify') {
            $pdo->beginTransaction();
            try {
                // Fetch transaction details (joining with the new products table)
                $stmt_tx = $pdo->prepare("SELECT t.*, p.price_per_kg FROM transactions t JOIN products p ON t.product_id = p.id WHERE t.id = ?");
                $stmt_tx->execute([$data['id']]);
                $tx = $stmt_tx->fetch();

                $weight_actual = (float)$data['weight_actual'];
                $total_payout = $weight_actual * $tx['price_per_kg'];

                // Update Transaction
                $stmt_up = $pdo->prepare("UPDATE transactions SET status = 'VERIFIED', weight_actual = ?, total_payout = ? WHERE id = ?");
                $stmt_up->execute([$weight_actual, $total_payout, $data['id']]);

                // Update User Balance
                $stmt_user = $pdo->prepare("UPDATE users SET balance = balance + ?, total_kg = total_kg + ? WHERE id = ?");
                $stmt_user->execute([$total_payout, $weight_actual, $tx['user_id']]);

                $pdo->commit();
                echo json_encode(['status' => 'success']);
            } catch (Exception $e) {
                $pdo->rollBack();
                echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
            }
        } elseif ($action === 'reject') {
            $stmt = $pdo->prepare("UPDATE transactions SET status = 'REJECTED' WHERE id = ?");
            $stmt->execute([$data['id']]);
            echo json_encode(['status' => 'success']);
        }
    }
}

function handleSettings($pdo, $method, $action, $data) {
    if ($method === 'POST' && $action === 'update') {
        unset($data['entity'], $data['action']); // remove routing params
        $stmt = $pdo->prepare("INSERT INTO settings (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)");
        foreach ($data as $key => $value) {
            $stmt->execute([$key, $value]);
        }
        echo json_encode(['status' => 'success']);
    }
}

function handleSystem($pdo, $method, $action, $data) {
    if ($method === 'POST' && $action === 'reset') {
        // For Demo: Bypass password check if not provided or just allow it
        // If we want to keep it simple for demo:
        /*
        $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $admin = $stmt->fetch();
        
        if ($admin['password'] && !password_verify($data['password'], $admin['password'])) {
            echo json_encode(['status' => 'error', 'message' => 'Kata sandi salah!']);
            return;
        }
        */

        try {
            $pdo->beginTransaction();
            // Delete all transactions and sales (this resets inventory quantities)
            $pdo->exec("DELETE FROM transactions");
            $pdo->exec("DELETE FROM sales");
            
            // Reset users balances and total_kg
            $pdo->exec("UPDATE users SET balance = 0, total_kg = 0 WHERE role = 'USER'");
            
            $pdo->commit();
            echo json_encode(['status' => 'success']);
        } catch (Exception $e) {
            $pdo->rollBack();
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}

function handleSales($pdo, $method, $action, $data) {
    if ($method === 'GET') {
        $stmt = $pdo->query("SELECT s.*, p.name as product_name FROM sales s JOIN products p ON s.product_id = p.id ORDER BY s.created_at DESC");
        echo json_encode(['status' => 'success', 'data' => $stmt->fetchAll()]);
    } elseif ($method === 'POST') {
        if ($action === 'create') {
            $stmt = $pdo->prepare("INSERT INTO sales (product_id, weight_sold, price_per_kg, total_price, buyer_name) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([
                $data['product_id'],
                $data['weight_sold'],
                $data['price_per_kg'],
                $data['total_price'],
                $data['buyer_name']
            ]);
            echo json_encode(['status' => 'success', 'id' => $pdo->lastInsertId()]);
        } elseif ($action === 'delete') {
            $stmt = $pdo->prepare("DELETE FROM sales WHERE id = ?");
            $stmt->execute([$data['id']]);
            echo json_encode(['status' => 'success']);
        }
    }
}

function handleCrafts($pdo, $method, $action, $data) {
    if ($method === 'GET') {
        $stmt = $pdo->query("SELECT * FROM crafts ORDER BY created_at DESC");
        echo json_encode(['status' => 'success', 'data' => $stmt->fetchAll()]);
    } elseif ($method === 'POST') {
        if ($action === 'delete') {
            $stmt = $pdo->prepare("DELETE FROM crafts WHERE id = ?");
            $stmt->execute([$data['id']]);
            echo json_encode(['status' => 'success']);
        } else {
            // Handle Image Upload
            $image_url = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $filename = 'craft_' . time() . '.' . $ext;
                $upload_path = '../uploads/crafts/' . $filename;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                    $image_url = '../uploads/crafts/' . $filename;
                }
            }

            if (isset($data['id']) && $data['id'] > 0) {
                if ($image_url) {
                    $stmt = $pdo->prepare("UPDATE crafts SET title=?, price=?, description=?, cta_link=?, image_url=? WHERE id=?");
                    $stmt->execute([$data['title'], $data['price'], $data['description'], $data['cta_link'], $image_url, $data['id']]);
                } else {
                    $stmt = $pdo->prepare("UPDATE crafts SET title=?, price=?, description=?, cta_link=? WHERE id=?");
                    $stmt->execute([$data['title'], $data['price'], $data['description'], $data['cta_link'], $data['id']]);
                }
            } else {
                $stmt = $pdo->prepare("INSERT INTO crafts (title, price, description, cta_link, image_url) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$data['title'], $data['price'], $data['description'], $data['cta_link'], $image_url]);
            }
            echo json_encode(['status' => 'success']);
        }
    }
}

function handleArticles($pdo, $method, $action, $data) {
    if ($method === 'GET') {
        try {
            ob_start();
            $stmt = $pdo->query("SELECT * FROM content ORDER BY id DESC");
            $res_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ob_clean();
            echo json_encode(['status' => 'success', 'data' => $res_data]);
        } catch (Exception $e) {
            ob_clean();
            echo json_encode(['status' => 'error', 'message' => 'DB Query Error: ' . $e->getMessage()]);
        }
    } elseif ($method === 'POST') {
        if ($action === 'delete') {
            $stmt = $pdo->prepare("DELETE FROM content WHERE id = ?");
            $stmt->execute([$data['id']]);
            echo json_encode(['status' => 'success']);
        } else {
            // Handle Image Upload
            $image_url = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                if (!is_dir('../uploads/articles')) mkdir('../uploads/articles', 0777, true);
                $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $filename = 'article_' . time() . '.' . $ext;
                $upload_path = '../uploads/articles/' . $filename;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                    $image_url = '../uploads/articles/' . $filename;
                }
            }

            if (isset($data['id']) && $data['id'] > 0) {
                if ($image_url) {
                    $stmt = $pdo->prepare("UPDATE content SET title=?, subtitle=?, content=?, category=?, event_date=?, location=?, cta_link=?, image_url=? WHERE id=?");
                    $stmt->execute([
                        $data['title'], $data['subtitle'], $data['content'], 
                        $data['category'], $data['event_date'] ?: null, $data['location'], 
                        $data['cta_link'], $image_url, $data['id']
                    ]);
                } else {
                    $stmt = $pdo->prepare("UPDATE content SET title=?, subtitle=?, content=?, category=?, event_date=?, location=?, cta_link=? WHERE id=?");
                    $stmt->execute([
                        $data['title'], $data['subtitle'], $data['content'], 
                        $data['category'], $data['event_date'] ?: null, $data['location'], 
                        $data['cta_link'], $data['id']
                    ]);
                }
            } else {
                $stmt = $pdo->prepare("INSERT INTO content (title, subtitle, content, category, event_date, location, cta_link, image_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([
                    $data['title'], $data['subtitle'], $data['content'], 
                    $data['category'], $data['event_date'] ?: null, $data['location'], 
                    $data['cta_link'], $image_url
                ]);
            }
            echo json_encode(['status' => 'success']);
        }
    }
}
?>
