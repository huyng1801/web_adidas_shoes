<?php

include '../config/db.php';



function getAllOrders() {
    global $conn;
    $sql = "SELECT orders.*, SUM(order_details.unit_price * order_details.quantity) AS total_price
            FROM orders
            JOIN order_details ON orders.order_id = order_details.order_id
            GROUP BY orders.order_id";
    $stmt = $conn->prepare( $sql );
    $stmt->execute();
    $result = $stmt->fetchAll( PDO::FETCH_ASSOC );
    return $result;
}



function getOrderByID( $orderID ) {
    global $conn;
    $sql = 'SELECT * FROM orders WHERE order_id = :order_id';
    $stmt = $conn->prepare( $sql );
    $stmt->bindParam( ':order_id', $orderID, PDO::PARAM_INT );
    $stmt->execute();
    $result = $stmt->fetch( PDO::FETCH_ASSOC );
    return $result;
}

function getProductPrice($productID) {
    global $conn;
    $sql = 'SELECT price FROM products WHERE product_id = :product_id';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':product_id', $productID, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['price'];
}

function insertOrderDetail($orderID, $productID, $quantity, $sizeValue) {
    global $conn;
    $unitPrice = getProductPrice($productID);
    $sql = 'INSERT INTO order_details (order_id, product_id, quantity, size_value, unit_price) VALUES (:order_id, :product_id, :quantity, :size_value, :unit_price)';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':order_id', $orderID, PDO::PARAM_INT);
    $stmt->bindParam(':product_id', $productID, PDO::PARAM_INT);
    $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
    $stmt->bindParam(':size_value', $sizeValue, PDO::PARAM_STR);
    $stmt->bindParam(':unit_price', $unitPrice, PDO::PARAM_INT); 
    $stmt->execute();
    return true;
}


function insertOrder($customerName, $phoneNumber, $email, $city, $district, $address, $note, $status, $orderDetails) {
    global $conn;
    try {
        $conn->beginTransaction();
        $sql = 'INSERT INTO orders (customer_name, phone_number, email, city, district, address, note, status) VALUES (:customer_name, :phone_number, :email, :city, :district, :address, :note, :status)';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':customer_name', $customerName, PDO::PARAM_STR);
        $stmt->bindParam(':phone_number', $phoneNumber, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':city', $city, PDO::PARAM_STR);
        $stmt->bindParam(':district', $district, PDO::PARAM_STR);
        $stmt->bindParam(':address', $address, PDO::PARAM_STR);
        $stmt->bindParam(':note', $note, PDO::PARAM_STR);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->execute();
        $orderID = $conn->lastInsertId();
        foreach ($orderDetails as $orderDetail) {
            insertOrderDetail($orderID, $orderDetail['product_id'], $orderDetail['quantity'], $orderDetail['size_value']);
        }
        $conn->commit();
        return true;
    } catch (PDOException $e) {
        $conn->rollback();
        throw $e;
    }
}



function updateOrder( $orderID, $status ) {
    global $conn;
    $sql = 'UPDATE orders SET status = :status WHERE order_id = :order_id';
    $stmt = $conn->prepare( $sql );
    $stmt->bindParam( ':order_id', $orderID, PDO::PARAM_INT );
    $stmt->bindParam( ':status', $status, PDO::PARAM_STR );
    $stmt->execute();
    return true;
}


function deleteOrder( $orderID ) {
    global $conn;
    $sql = 'DELETE FROM orders WHERE order_id = :order_id';
    $stmt = $conn->prepare( $sql );
    $stmt->bindParam( ':order_id', $orderID, PDO::PARAM_INT );
    $stmt->execute();
    return true;
}


$request_method = $_SERVER[ 'REQUEST_METHOD' ];

switch ( $request_method ) {
    case 'GET':
    $action = isset( $_GET[ 'action' ] ) ? $_GET[ 'action' ] : '';
    switch ( $action ) {
        case 'getAllOrders':
        $orders = getAllOrders();
        header( 'Content-Type: application/json' );
        echo json_encode( $orders );
        break;
        case 'getOrderByID':
        $orderID = isset( $_GET[ 'order_id' ] ) ? $_GET[ 'order_id' ] : null;
        if ( $orderID !== null ) {
            $order = getOrderByID( $orderID );
            header( 'Content-Type: application/json' );
            echo json_encode( $order );
        } else {
            echo json_encode( [ 'error' => 'Invalid order ID' ] );
        }
        break;
        default:
        echo json_encode( [ 'error' => 'Invalid action' ] );
        break;
    }
    break;

    case 'POST':

    $data = json_decode( file_get_contents( 'php://input' ), true );
    $action = isset( $data[ 'action' ] ) ? $data[ 'action' ] : '';
    switch ( $action ) {
        case 'insertOrder':
            $data = json_decode(file_get_contents('php://input'), true);
            $customerName = isset($data['customer_name']) ? $data['customer_name'] : null;
            $phoneNumber = isset($data['phone_number']) ? $data['phone_number'] : null;
            $email = isset($data['email']) ? $data['email'] : null;
            $city = isset($data['city']) ? $data['city'] : null;
            $district = isset($data['district']) ? $data['district'] : null;
            $address = isset($data['address']) ? $data['address'] : null;
            $note = isset($data['note']) ? $data['note'] : null;
            $status = isset($data['status']) ? $data['status'] : null;
            $orderDetails = isset($data['order_details']) ? $data['order_details'] : null;
            if ($customerName !== null && $phoneNumber !== null && $email !== null && $city !== null && $district !== null && $address !== null && $note !== null && $status !== null && $orderDetails !== null) {
                if (insertOrder($customerName, $phoneNumber, $email, $city, $district, $address, $note, $status, $orderDetails)) {
                    echo json_encode(['message' => 'Order inserted successfully']);
                } else {
                    echo json_encode(['error' => 'Failed to insert order']);
                }
            } else {
                echo json_encode(['error' => 'Invalid data']);
            }
            break;
        
        case 'updateOrder':
            $orderID = isset( $data[ 'order_id' ] ) ? $data[ 'order_id' ] : null;
            $status = isset( $data[ 'status' ] ) ? $data[ 'status' ] : null;
            if ( $orderID !== null && $status !== null ) {
                if ( updateOrder( $orderID, $status ) ) {
                    echo json_encode( [ 'message' => 'Order updated successfully' ] );
                } else {
                    echo json_encode( [ 'error' => 'Failed to update order' ] );
                }
            } else {
                echo json_encode( [ 'error' => 'Invalid data' ] );
            }
            break;
        case 'deleteOrder':
        $data = json_decode( file_get_contents( 'php://input' ), true );
        $orderID = isset( $data[ 'order_id' ] ) ? $data[ 'order_id' ] : null;
        if ( $orderID !== null ) {
            if ( deleteOrder( $orderID ) ) {
                echo json_encode( [ 'message' => 'Order deleted successfully' ] );
            } else {
                echo json_encode( [ 'error' => 'Failed to delete order' ] );
            }
        } else {
            echo json_encode( [ 'error' => 'Invalid data' ] );
        }
        break;
        default:
        echo json_encode( [ 'error' => 'Invalid action' ] );
        break;
    }
    break;

    default:
    echo json_encode( [ 'error' => 'Invalid request method' ] );
    break;
}
?>
