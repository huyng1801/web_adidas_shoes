<?php
include '../config/db.php';

function getAllCategories() {
    global $conn;
    $sql = 'SELECT c.*, COUNT(p.product_id) AS product_count 
            FROM categories c 
            LEFT JOIN products p ON c.category_id = p.category_id 
            GROUP BY c.category_id';
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}


function getCategoriesHasProducts() {
    global $conn;
    $sql = "SELECT c.category_id, c.category_name
            FROM categories c
            WHERE EXISTS (
                SELECT 1 FROM products p WHERE p.category_id = c.category_id
            )";
    $stmt = $conn->prepare( $sql );
    $stmt->execute();
    $result = $stmt->fetchAll( PDO::FETCH_ASSOC );
    return $result;
}

function getCategoriesWithProducts() {
    global $conn;
    $result = array();
    $sql_categories = 'SELECT * FROM categories';
    $stmt_categories = $conn->prepare( $sql_categories );
    $stmt_categories->execute();
    $categories = $stmt_categories->fetchAll( PDO::FETCH_ASSOC );

    foreach ( $categories as $category ) {
        $categoryID = $category[ 'category_id' ];
        $sql_products = 'SELECT * FROM products WHERE category_id = :category_id';
        $stmt_products = $conn->prepare( $sql_products );
        $stmt_products->bindParam( ':category_id', $categoryID, PDO::PARAM_INT );
        $stmt_products->execute();
        $products = $stmt_products->fetchAll( PDO::FETCH_ASSOC );

        $result[ $categoryID ][ 'category_id' ] = $categoryID;
        $result[ $categoryID ][ 'category_name' ] = $category[ 'category_name' ];
        $result[ $categoryID ][ 'products' ] = $products;
    }

    return $result;
}

function getCategoryByID( $categoryID ) {
    global $conn;
    $sql = 'SELECT * FROM categories WHERE category_id = :category_id';
    $stmt = $conn->prepare( $sql );
    $stmt->bindParam( ':category_id', $categoryID, PDO::PARAM_INT );
    $stmt->execute();
    $result = $stmt->fetch( PDO::FETCH_ASSOC );
    return $result;
}

function insertCategory( $categoryName ) {
    global $conn;
    $sql = 'INSERT INTO categories (category_name) VALUES (:category_name)';
    $stmt = $conn->prepare( $sql );
    $stmt->bindParam( ':category_name', $categoryName, PDO::PARAM_STR );
    $stmt->execute();
    return true;
}

function updateCategory( $categoryID, $categoryName ) {
    global $conn;
    $sql = 'UPDATE categories SET category_name = :category_name WHERE category_id = :category_id';
    $stmt = $conn->prepare( $sql );
    $stmt->bindParam( ':category_id', $categoryID, PDO::PARAM_INT );
    $stmt->bindParam( ':category_name', $categoryName, PDO::PARAM_STR );
    $stmt->execute();
    return true;
}

function deleteCategory( $categoryID ) {
    global $conn;
    $sql = 'DELETE FROM categories WHERE category_id = :category_id';
    $stmt = $conn->prepare( $sql );
    $stmt->bindParam( ':category_id', $categoryID, PDO::PARAM_INT );
    $stmt->execute();
    return true;
}

$request_method = $_SERVER[ 'REQUEST_METHOD' ];

switch ( $request_method ) {
    case 'GET':
    $action = isset( $_GET[ 'action' ] ) ? $_GET[ 'action' ] : '';
    switch ( $action ) {
        case 'getAllCategories':
        $categories = getAllCategories();
        header( 'Content-Type: application/json; charset=utf-8' );
        echo json_encode( $categories, JSON_UNESCAPED_UNICODE );
        break;
        case 'getCategoriesHasProducts':
        $categoriesWithProducts = getCategoriesHasProducts();
        header( 'Content-Type: application/json; charset=utf-8' );
        echo json_encode( $categoriesWithProducts, JSON_UNESCAPED_UNICODE );
        break;
        case 'getCategoriesWithProducts':
        $category_products = getCategoriesWithProducts();
        header( 'Content-Type: application/json; charset=utf-8' );
        echo json_encode( $category_products, JSON_UNESCAPED_UNICODE );
        break;
        case 'getCategoryByID':
            $categoryID = isset($_GET['category_id']) ? $_GET['category_id'] : null;
            if ($categoryID) {
                $category = getCategoryByID($categoryID);
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode($category, JSON_UNESCAPED_UNICODE);
            } else {
                echo json_encode(['error' => 'Invalid data']);
            }
            break;
        default:
        echo json_encode( [ 'error' => 'Invalid action' ] );
        break;
    }
    break;

    case 'POST':
    // Lấy raw body của HTTP request
    $request_body = file_get_contents('php://input');

    // Giải mã JSON thành mảng assciated
    $data = json_decode($request_body, true);

    // Truy cập vào các trường dữ liệu cụ thể
    $action = isset($data['action']) ? $data['action'] : '';

    switch ( $action ) {
        case 'insertCategory':
        if ( isset( $data[ 'category_name' ] ) ) {
            $categoryName = $data[ 'category_name' ];
            if ( insertCategory( $categoryName ) ) {
                echo json_encode( [ 'message' => 'Category inserted successfully' ] );
            } else {
                echo json_encode( [ 'error' => 'Failed to insert category' ] );
            }
        } else {
            echo json_encode( [ 'error' => 'Invalid data' ] );
        }
        break;
        case 'updateCategory':
        $categoryID = isset( $data[ 'category_id' ] ) ? $data[ 'category_id' ] : null;
        $categoryName = isset( $data[ 'category_name' ] ) ? $data[ 'category_name' ] : null;
        if ( $categoryID && $categoryName ) {
            if ( updateCategory( $categoryID, $categoryName ) ) {
                echo json_encode( [ 'message' => 'Category updated successfully' ] );
            } else {
                echo json_encode( [ 'error' => 'Failed to update category' ] );
            }
        } else {
            echo json_encode( [ 'error' => 'Invalid data' ] );
        }
        break;
        case 'deleteCategory':
        $categoryID = isset( $data[ 'category_id' ] ) ? $data[ 'category_id' ] : null;
        if ( $categoryID ) {
            if ( deleteCategory( $categoryID ) ) {
                echo json_encode( [ 'message' => 'Category deleted successfully' ] );
            } else {
                echo json_encode( [ 'error' => 'Failed to delete category' ] );
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
