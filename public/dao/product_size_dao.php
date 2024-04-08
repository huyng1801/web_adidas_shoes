<?php
include '../config/db.php';
function getAllSizes() {
    global $conn;
    $sql = "SELECT DISTINCT size_value FROM product_size";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function getProductSizesByProductID($productID) {
    global $conn;
    $sql = "SELECT * FROM product_size WHERE product_id = :product_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':product_id', $productID, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function insertProductSize($productID, $sizeValue) {
    global $conn;
    $sql = "INSERT INTO product_size (product_id, size_value) VALUES (:product_id, :size_value)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':product_id', $productID, PDO::PARAM_INT);
    $stmt->bindParam(':size_value', $sizeValue, PDO::PARAM_INT);
    $stmt->execute();
    return true;
}


function deleteProductSize($variantID) {
    global $conn;
    $sql = "DELETE FROM product_size WHERE product_size_id = :product_size";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':product_size', $variantID, PDO::PARAM_INT);
    $stmt->execute();
    return true;
}

$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'GET':
        $action = isset($_GET['action']) ? $_GET['action'] : '';
        switch ($action) {
            case 'getAllSizes':
                $sizes = getAllSizes();
                header('Content-Type: application/json');
                echo json_encode($sizes);
                break;
            case 'getProductSizesByProductID':
                $productID = isset($_GET['product_id']) ? $_GET['product_id'] : null;
                if ($productID !== null) {
                    $productSizes = getProductSizesByProductID($productID);
                    header('Content-Type: application/json');
                    echo json_encode($productSizes);
                } else {
                    echo json_encode(['error' => 'Invalid product ID']);
                }
                break;
            default:
                echo json_encode(['error' => 'Invalid action']);
                break;
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        $action = isset($data['action']) ? $data['action'] : '';
        switch ($action) {
            case 'insertProductSize':
                $productID = isset($data['product_id']) ? $data['product_id'] : null;
                $sizeValue = isset($data['size_value']) ? $data['size_value'] : null;
                if ($productID !== null && $sizeValue !== null) {
                    if (insertProductSize($productID, $sizeValue)) {
                        echo json_encode(['message' => 'Product size inserted successfully']);
                    } else {
                        echo json_encode(['error' => 'Failed to insert product size']);
                    }
                } else {
                    echo json_encode(['error' => 'Invalid data']);
                }
                break;
                case 'deleteProductSize':
                    $variantID = isset($data['product_size_id']) ? $data['product_size_id'] : null;
                    if ($variantID !== null) {
                        if (deleteProductSize($variantID)) {
                            echo json_encode(['message' => 'Product size deleted successfully']);
                        } else {
                            echo json_encode(['error' => 'Failed to delete product size']);
                        }
                    } else {
                        echo json_encode(['error' => 'Invalid data']);
                    }
                    break;
            default:
                echo json_encode(['error' => 'Invalid action']);
                break;
        }
        break;




    default:
        echo json_encode(['error' => 'Invalid request method']);
        break;
}
?>
