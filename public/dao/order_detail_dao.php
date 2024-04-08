<?php
include '../config/db.php';


function getOrderDetailsByOrderID($orderID) {
    global $conn;
    $sql = "SELECT od.*, p.product_name, p.image_url FROM order_details od 
            INNER JOIN products p ON od.product_id = p.product_id
            WHERE od.order_id = :order_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':order_id', $orderID, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}




function deleteOrderDetail($orderDetailID) {
    global $conn;
    $sql = "DELETE FROM order_details WHERE order_detail_id = :order_detail_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':order_detail_id', $orderDetailID, PDO::PARAM_INT);
    $stmt->execute();
    return true;
}

$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'GET':
        $action = isset($_GET['action']) ? $_GET['action'] : '';
        switch ($action) {
            case 'getOrderDetailsByOrderID':
                $orderID = isset($_GET['order_id']) ? $_GET['order_id'] : null;
                if ($orderID !== null) {
                    $orderDetails = getOrderDetailsByOrderID($orderID);
                    header('Content-Type: application/json');
                    echo json_encode($orderDetails);
                } else {
                    echo json_encode(['error' => 'Invalid order ID']);
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
            case 'insertOrderDetail':
                $orderID = isset($data['order_id']) ? $data['order_id'] : null;
                $productID = isset($data['product_id']) ? $data['product_id'] : null;
                $quantity = isset($data['quantity']) ? $data['quantity'] : null;
                $unitPrice = isset($data['unit_price']) ? $data['unit_price'] : null;
                if ($orderID !== null && $productID !== null && $quantity !== null && $unitPrice !== null) {
                    if (insertOrderDetail($orderID, $productID, $quantity, $unitPrice)) {
                        echo json_encode(['message' => 'Order detail inserted successfully']);
                    } else {
                        echo json_encode(['error' => 'Failed to insert order detail']);
                    }
                } else {
                    echo json_encode(['error' => 'Invalid data']);
                }
                break;
                case 'deleteOrderDetail':
                    $orderDetailID = isset($data['order_detail_id']) ? $data['order_detail_id'] : null;
                    if ($orderDetailID !== null) {
                        if (deleteOrderDetail($orderDetailID)) {
                            echo json_encode(['message' => 'Order detail deleted successfully']);
                        } else {
                            echo json_encode(['error' => 'Failed to delete order detail']);
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
