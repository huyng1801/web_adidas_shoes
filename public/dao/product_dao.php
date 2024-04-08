<?php
include '../config/db.php';

function getAllProducts() {
    global $conn;
    $sql = 'SELECT p.*, c.category_name 
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.category_id
            ORDER BY p.product_id DESC';
    $result = execute_select_query( $sql );
    return $result;
}
function getProductsByName($productName) {
    global $conn;
    $sql = 'SELECT * FROM products WHERE product_name LIKE :product_name';
    $stmt = $conn->prepare($sql);
    $productName = '%' . $productName . '%';
    $stmt->bindParam(':product_name', $productName, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function getProductsByCategory( $categoryID ) {
    global $conn;
    $sql = 'SELECT * FROM products WHERE category_id = :category_id';
    $stmt = $conn->prepare( $sql );
    $stmt->bindParam( ':category_id', $categoryID, PDO::PARAM_INT );
    $stmt->execute();
    $result = $stmt->fetchAll( PDO::FETCH_ASSOC );
    return $result;
}

function getProductByID( $productID ) {
    global $conn;
    $sql = 'SELECT * FROM products WHERE product_id = :product_id';
    $stmt = $conn->prepare( $sql );
    $stmt->bindParam( ':product_id', $productID, PDO::PARAM_INT );
    $stmt->execute();
    $result = $stmt->fetch( PDO::FETCH_ASSOC );
    return $result;
}

function insertProduct( $productName, $description, $price, $imageURL, $categoryID ) {
    global $conn;
    $sql = 'INSERT INTO products (product_name, description, price, image_url, category_id) VALUES (:product_name, :description, :price, :image_url, :category_id)';
    $stmt = $conn->prepare( $sql );
    $stmt->bindParam( ':product_name', $productName, PDO::PARAM_STR );
    $stmt->bindParam( ':description', $description, PDO::PARAM_STR );
    $stmt->bindParam( ':price', $price, PDO::PARAM_INT );
    $stmt->bindParam( ':image_url', $imageURL, PDO::PARAM_STR );
    $stmt->bindParam( ':category_id', $categoryID, PDO::PARAM_INT );
    $stmt->execute();
    return true;
}

function updateProduct( $productID, $productName, $description, $price, $imageURL, $categoryID ) {
    global $conn;
    $sql = 'UPDATE products SET product_name = :product_name, description = :description, price = :price, image_url = :image_url, category_id = :category_id WHERE product_id = :product_id';
    $stmt = $conn->prepare( $sql );
    $stmt->bindParam( ':product_id', $productID, PDO::PARAM_INT );
    $stmt->bindParam( ':product_name', $productName, PDO::PARAM_STR );
    $stmt->bindParam( ':description', $description, PDO::PARAM_STR );
    $stmt->bindParam( ':price', $price, PDO::PARAM_INT );
    $stmt->bindParam( ':image_url', $imageURL, PDO::PARAM_STR );
    $stmt->bindParam( ':category_id', $categoryID, PDO::PARAM_INT );
    $stmt->execute();
    return true;
}

function deleteProduct( $productID ) {
    global $conn;
    $sql = 'DELETE FROM products WHERE product_id = :product_id';
    $stmt = $conn->prepare( $sql );
    $stmt->bindParam( ':product_id', $productID, PDO::PARAM_INT );
    $stmt->execute();
    return true;
}

$request_method = $_SERVER[ 'REQUEST_METHOD' ];

switch ( $request_method ) {
    case 'GET':
    $action = isset( $_GET[ 'action' ] ) ? $_GET[ 'action' ] : '';
    switch ( $action ) {
        case 'getAllProducts':
        $products = getAllProducts();
        header( 'Content-Type: application/json' );
        echo json_encode( $products );
        break;
        case 'getProductByID':
        $productID = isset( $_GET[ 'product_id' ] ) ? $_GET[ 'product_id' ] : null;
        if ( $productID !== null ) {
            $product = getProductByID( $productID );
            header( 'Content-Type: application/json' );
            echo json_encode( $product );
        } else {
            echo json_encode( [ 'error' => 'Invalid product ID' ] );
        }
        break;
        case 'getProductsByCategory':
        $categoryID = isset( $_GET[ 'category_id' ] ) ? $_GET[ 'category_id' ] : null;
        if ( $categoryID !== null ) {
            $products = getProductsByCategory( $categoryID );
            header( 'Content-Type: application/json' );
            echo json_encode( $products );
        } else {
            echo json_encode( [ 'error' => 'Invalid category ID' ] );
        }
        break;
        case 'searchProduct':
            $productName = isset($_GET['query']) ? $_GET['query'] : null;
            if ($productName !== null) {
                $products = getProductsByName($productName);
                header('Content-Type: application/json');
                echo json_encode($products);
            } else {
                echo json_encode(['error' => 'Invalid product name']);
            }
            break;
        default:
        echo json_encode( [ 'error' => 'Invalid action' ] );
        break;
    }
    break;

    case 'POST':
    $action = isset( $_POST[ 'action' ] ) ? $_POST[ 'action' ] : '';
    switch ( $action ) {
        case 'insertProduct':
        $productName = isset( $_POST[ 'product_name' ] ) ? $_POST[ 'product_name' ] : null;
        $description = isset( $_POST[ 'description' ] ) ? $_POST[ 'description' ] : null;
        $price = isset( $_POST[ 'price' ] ) ? $_POST[ 'price' ] : null;
        $categoryID = isset( $_POST[ 'category_id' ] ) ? $_POST[ 'category_id' ] : null;

        if ( isset( $_FILES[ 'image' ] ) && $_FILES[ 'image' ][ 'error' ] === UPLOAD_ERR_OK ) {
            $imageFile = $_FILES[ 'image' ][ 'tmp_name' ];
            $imageName = $_FILES[ 'image' ][ 'name' ];

            $fileHash = md5( uniqid( rand(), true ) );
            $fileExtension = pathinfo( $imageName, PATHINFO_EXTENSION );
            $uploadDir = '../uploads/';
            if ( !file_exists( $uploadDir ) ) {
                mkdir( $uploadDir, 0777, true );
            }
            $newFileName = $fileHash . '.' . $fileExtension;
            $destination = $uploadDir . $newFileName;
            if ( !move_uploaded_file( $imageFile, $destination ) ) {
                echo json_encode( [ 'error' => 'Failed to move uploaded file' ] );
                exit();
            }

            $imageURL = 'uploads/' . $newFileName;
        } else {
            echo json_encode( [ 'error' => 'No image uploaded' ] );
            exit();
        }

        if ( $productName && $description && $price !== null && $categoryID !== null ) {
            if ( insertProduct( $productName, $description, $price, $imageURL, $categoryID ) ) {
                echo json_encode( [ 'message' => 'Product inserted successfully' ] );
            } else {
                echo json_encode( [ 'error' => 'Failed to insert product' ] );
            }
        } else {
            echo json_encode( [ 'error' => 'Invalid data' ] );
        }
        break;
        case 'updateProduct':
        $productID = isset( $_POST[ 'product_id' ] ) ? $_POST[ 'product_id' ] : null;
        $productName = isset( $_POST[ 'product_name' ] ) ? $_POST[ 'product_name' ] : null;
        $description = isset( $_POST[ 'description' ] ) ? $_POST[ 'description' ] : null;
        $price = isset( $_POST[ 'price' ] ) ? $_POST[ 'price' ] : null;
        $categoryID = isset( $_POST[ 'category_id' ] ) ? $_POST[ 'category_id' ] : null;

        if ( isset( $_FILES[ 'image' ] ) && $_FILES[ 'image' ][ 'error' ] === UPLOAD_ERR_OK ) {
            $imageFile = $_FILES[ 'image' ][ 'tmp_name' ];
            $imageName = md5( uniqid() ) . '_' . $_FILES[ 'image' ][ 'name' ];

            $uploadDir = '../uploads/';
            if ( !file_exists( $uploadDir ) ) {
                mkdir( $uploadDir, 0777, true );
            }
            $destination = $uploadDir . $imageName;
            if ( !move_uploaded_file( $imageFile, $destination ) ) {
                echo json_encode( [ 'error' => 'Failed to move uploaded file' ] );
                exit();
            }

            $imageURL = 'uploads/' . $imageName;
        } else {
            $imageURL = isset( $_POST[ 'image_url' ] ) ? $_POST[ 'image_url' ] : null;
        }

        if ( $productID && $productName && $description && $price !== null && $categoryID !== null ) {
            if ( updateProduct( $productID, $productName, $description, $price, $imageURL, $categoryID ) ) {
                echo json_encode( [ 'message' => 'Product updated successfully' ] );
            } else {
                echo json_encode( [ 'error' => 'Failed to update product' ] );
            }
        } else {
            echo json_encode( [ 'error' => 'Invalid data' ] );
        }
        break;
        case 'deleteProduct':
        $productID = isset( $_POST[ 'product_id' ] ) ? $_POST[ 'product_id' ] : null;
        if ( $productID !== null ) {
            if ( deleteProduct( $productID ) ) {
                echo json_encode( [ 'message' => 'Product deleted successfully' ] );
            } else {
                echo json_encode( [ 'error' => 'Failed to delete product' ] );
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
