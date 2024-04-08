<?php
// Include database connection
include '../config/db.php';

// Function to retrieve daily revenue
function getDailyRevenue() {
    global $conn;
    $sql = "SELECT IFNULL(SUM(unit_price * quantity), 0) AS total_revenue FROM orders JOIN order_details ON orders.order_id = order_details.order_id WHERE DATE(order_date) = CURDATE()";
    $result = execute_select_query($sql);
    if ($result) {
        return $result[0]['total_revenue'];
    } else {
        return 0;
    }
}

// Function to retrieve monthly revenue
function getMonthlyRevenue() {
    global $conn;
    $sql = "SELECT IFNULL(SUM(unit_price * quantity), 0) AS total_revenue FROM orders JOIN order_details ON orders.order_id = order_details.order_id WHERE MONTH(order_date) = MONTH(CURDATE()) AND YEAR(order_date) = YEAR(CURDATE())";
    $result = execute_select_query($sql);
    if ($result) {
        return $result[0]['total_revenue'];
    } else {
        return 0;
    }
}

// Function to retrieve yearly revenue
function getYearlyRevenue() {
    global $conn;
    $sql = "SELECT MONTH(order_date) AS month, IFNULL(SUM(unit_price * quantity), 0) AS total_revenue FROM orders JOIN order_details ON orders.order_id = order_details.order_id WHERE YEAR(order_date) = YEAR(CURDATE()) GROUP BY MONTH(order_date)";
    $result = execute_select_query($sql);
    return $result ? $result : [];
}

// Handle HTTP requests
$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'GET':
        $action = isset($_GET['action']) ? $_GET['action'] : '';
        switch ($action) {
            case 'getDailyRevenue':
                $dailyRevenue = getDailyRevenue();
                header('Content-Type: application/json');
                echo json_encode(['daily_revenue' => $dailyRevenue]);
                break;
            case 'getMonthlyRevenue':
                $monthlyRevenue = getMonthlyRevenue();
                header('Content-Type: application/json');
                echo json_encode(['monthly_revenue' => $monthlyRevenue]);
                break;
            case 'getYearlyRevenue':
                $yearlyRevenue = getYearlyRevenue();
                header('Content-Type: application/json');
                echo json_encode(['yearly_revenue' => $yearlyRevenue]);
                break;
            default:
                echo json_encode(['error' => 'Invalid action']);
                break;
        }
        break;
    default:
        // Handle other cases
        break;
}
?>
