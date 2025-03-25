<?php

require_once __DIR__ . '/../core/Router.php';
require_once __DIR__ . '/../controllers/Homecontrollers.php';
require_once __DIR__ . '/../controllers/Collectionscontrollers.php';


require_once __DIR__ . '/../controllers/ProductsControllers.php';
require_once __DIR__ ."/../module/module.php";
require_once __DIR__ ."/../module/reviewsModule.php";
require_once __DIR__ ."/../module/carftModule.php";
require_once __DIR__ ."/../module/productCategoryModule.php";
require_once __DIR__ ."/../module/productColorModule.php";
require_once __DIR__ ."/../module/customerModule.php";
require_once __DIR__ ."/../module/loginHistoryModule.php";
$router = new Router();
$nameProject = "MIKEPHP";

function checkAdminAccess() {
    if (!isset($_SESSION['user_id'])) {
        header("location:/MIKEPHP/login");
        exit();
    }
    
    $userModule = new UserModule();
    $user = $userModule->getUserById($_SESSION['user_id']);
    
    if (!$user || $user['role'] !== 'admin') {
        header("location:/MIKEPHP/");
        exit();
    }
}

$router->get('/' . $nameProject . '/', [HomeController::class, 'index']);


$router->get('/' . $nameProject . '/admin/overview', function(){
    checkAdminAccess();
    require_once __DIR__ . '/../dashboard/index.php';
    require_once __DIR__ . '/../dashboard/views/dashboard.php';
});
$router->get('/' . $nameProject . '/admin/product', function(){
    checkAdminAccess();
    require_once __DIR__ . '/../dashboard/index.php';
    require_once __DIR__ . '/../dashboard/views/product.php';
});
$router->post('/'.$nameProject.'/admin/product/add', function() {
    checkAdminAccess();
    ob_clean();
    header('Content-Type: application/json');
    
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(["success" => false, "message" => "Bạn cần đăng nhập để thực hiện thao tác này"]);
        exit();
    }

    $jsonData = file_get_contents("php://input");
    $data = json_decode($jsonData, true);

    if (!isset($data['productId']) || !isset($data['categoryId'])) {
        echo json_encode(["success" => false, "message" => "Invalid input"]);
        exit();
    }

    try {
        $productId = intval($data['productId']);
        $categoryId = intval($data['categoryId']);
        $productCategories = new ProductCategoryModule();
        
        $productCategories->addCategory($productId, $categoryId);
        echo json_encode(["success" => true, "message" => "Category added successfully"]);
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => "Error adding category: " . $e->getMessage()]);
    }
    exit();
});
$router->post('/'.$nameProject.'/admin/product/remove', function() {
    checkAdminAccess();
    ob_clean();
    header('Content-Type: application/json');
    
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(["success" => false, "message" => "Bạn cần đăng nhập để thực hiện thao tác này"]);
        exit();
    }

    $jsonData = file_get_contents("php://input");
    $data = json_decode($jsonData, true);

    if (!isset($data['id']) || !isset($data['nameCate'])) {
        echo json_encode(["success" => false, "message" => "Invalid input"]);
        exit();
    }

    try {
        $productId = intval($data['id']);
        $categoryName = $data['nameCate'];
        $productCategories = new ProductCategoryModule();
        
        $result = $productCategories->removeCategory($productId, $categoryName);
        echo json_encode($result);
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => "Lỗi khi xóa danh mục: " . $e->getMessage()]);
    }
    exit();
});


$router->get('/' . $nameProject . '/admin/order', function(){
    checkAdminAccess();
    require_once __DIR__ . '/../dashboard/index.php';
    require_once __DIR__ . '/../dashboard/views/order.php';
});
$router->get('/' . $nameProject . '/admin/payment', function(){
    checkAdminAccess();
    require_once __DIR__ . '/../dashboard/index.php';
    require_once __DIR__ . '/../dashboard/views/payment.php';
});
$router->get('/' . $nameProject . '/admin/customer', function(){
    checkAdminAccess();
    require_once __DIR__ . '/../dashboard/index.php';
    require_once __DIR__ . '/../dashboard/views/customer.php';
});
$router->get('/' . $nameProject . '/admin/reports', function(){
    checkAdminAccess();
    require_once __DIR__ . '/../dashboard/index.php';
    require_once __DIR__ . '/../dashboard/views/reports.php';
});

$router->get('/' . $nameProject . '/about', function () {
    echo "Giới thiệu";
});

$router->get('/' . $nameProject . '/login', function () {
    require_once __DIR__ . '/../views/navbar.php';
    require_once __DIR__ . '/../views/login.php';
});
$router->get('/' . $nameProject . '/register', function () {
    require_once __DIR__ . '/../views/navbar.php';
    require_once __DIR__ . '/../views/register.php';
});
$router->post('/' . $nameProject . '/login', function () {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["dangnhap"])) {
        $email = trim($_POST["email"] ?? "");
        $pass = trim($_POST["password"] ?? "");

        if (empty($email) || empty($pass)) {
            echo "Email và mật khẩu không được để trống!";
            exit();
        }

        $userModule = new UserModule();
        $loginResult = $userModule->login($email, $pass);

        if ($loginResult && password_verify($pass, $loginResult["password"])) {
            session_start();
            session_regenerate_id(true);

            $_SESSION["user_id"] = $loginResult["id"];
            $_SESSION["user_email"] = $loginResult["email"];
            $_SESSION["logged_in"] = true;

            // Ghi log login (nếu có)
            $loginHistoryModule = new LoginHistoryModule();
            $ipAddress = $_SERVER['REMOTE_ADDR'];
            $loginHistoryModule->addLoginHistory($loginResult["id"], $ipAddress);

            // ✅ LƯU COOKIE tự động (KHÔNG dùng DB)
            $expire = time() + (30 * 24 * 60 * 60); // 30 ngày
            setcookie("token", base64_encode(json_encode([
                "email" => $loginResult["email"],
                "password" => $loginResult["password"] // đã mã hóa từ DB
            ])), $expire, "/", "", isset($_SERVER["HTTPS"]), true);

            // Chuyển trang
            header("location:/MIKEPHP/");
            exit();
        } else {
            echo "Sai email hoặc mật khẩu!";
        }
    } else {
        echo "Không có dữ liệu được gửi!";
    }
});

$router->post('/' . $nameProject . '/register', function () {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["dangky"])) {
        $fullName = isset($_POST["nameUser"]) ? $_POST["nameUser"] : "";
        $email = isset($_POST["email"]) ? $_POST["email"] : "";
        $pass = isset($_POST["password"]) ? $_POST["password"] : "";
        $numPhone = isset($_POST["phone"]) ? $_POST["phone"] : "";
        if (empty($email) || empty($pass)||empty($fullName) || empty($numPhone)) {
            require_once __DIR__ . '/../views/navbar.php';
            require_once __DIR__ . '/../views/register.php';
            exit(); 
        }
        $userModule = new UserModule();
        $loginResult = $userModule->createUser($fullName,$email, $pass,$numPhone);

        if ($loginResult) {
           header("location:/MIKEPHP/login");
        }
    } else {
        echo "Không có dữ liệu được gửi!";
    }
});
$router->get('/' . $nameProject . '/logout', function () {
    session_start();

    
    $_SESSION = [];
    session_unset();
    session_destroy();

   
    if (isset($_COOKIE["token"])) {
        setcookie("token", "", time() - 3600, "/");
    }

  
    header("location:/MIKEPHP/login");
    exit();
});


$router->get('/'.$nameProject.'/cart',function(){
    require_once __DIR__ . '/../views/navbar.php';
    require_once __DIR__ . '/../views/carft.php';
});

$router->post('/' . $nameProject . "/product/:slug", function($slug) use ($nameProject) {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["commentPost"])) {
        
        
        $textComment = isset($_POST["textComment"]) ? trim($_POST["textComment"]) : "";

       
        if (empty($textComment)) {

            require_once __DIR__ . '/../views/navbar.php';
            require_once __DIR__ . '/../views/information.php';
            exit();
        }

      
        if (!isset($_SESSION["user_id"])) {
            header('location: /MIKEPHP/login');
        }

       
        $userId = $_SESSION["user_id"];
        
        $product = new ProductsModule;
       
        $productId =$product->getProductIdFromSlug($slug);


        $userComment = new ReviewsModule();
        

        $userComment->postComment($userId, (int) implode(", ",$productId), 2, $textComment); 
        require_once __DIR__ . '/../views/navbar.php';
        require_once __DIR__ . '/../views/information.php';
        
    }
});
$router->post('/MIKEPHP/cart/delete', function(){
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['item_id'])) {
        $itemId = $_POST['item_id'];
        $cartModel = new CarftModule();
        $cartModel->deleteCartItem($itemId);
        header('location: /MIKEPHP/cart');
        exit;
    } else {
        echo "Không có sản phẩm để xóa!";
        exit;
    }
});
$router->post('/MIKEPHP/cart/add', function(){
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(["status" => "error", "message" => "Bạn cần đăng nhập để thêm vào giỏ hàng"]);
        exit();
    }


    $jsonData = file_get_contents("php://input");
    $data = json_decode($jsonData, true);

    if (!isset($data['id'], $data['size'], $data['quantity'])) {
        echo json_encode(["status" => "error", "message" => "Thiếu thông tin sản phẩm"]);
        exit();
    }

    $userId = $_SESSION['user_id'];
    $productId = $data['id'];
    $productSize = $data['size'];
    $quantity = intval($data['quantity']);

    if ($quantity <= 0) {
        echo json_encode(["status" => "error", "message" => "Số lượng phải lớn hơn 0"]);
        exit();
    }


    $cartModel = new CarftModule(); 
    $success = $cartModel->addCart($userId, $productId, $productSize, $quantity);

    if ($success) {
        echo json_encode(["status" => "success", "message" => "Đã thêm vào giỏ hàng!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Không thể thêm vào giỏ hàng"]);
    }

    exit();
});
$router->get('/'.$nameProject."/user/account/profile",function(){
    require_once __DIR__ . '/../views/navbar.php';
    require_once __DIR__ . '/../views/profile.php';
});


$router->get('/' . $nameProject . '/admin/product/colors/:id', function($id) {
    checkAdminAccess();
    ob_clean();
    header('Content-Type: application/json');
    
    try {
        $productColorModule = new ProductColorModule();
        $result = $productColorModule->getProductColorsAndSizes($id);
        echo json_encode($result);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit();
});


$router->post("/$nameProject/admin/product/save", function() use ($nameProject) {
   
    ob_clean();
    
  
    header('Content-Type: application/json');
    
    try {
       
        if (!isset($_SESSION['user_id'])) {
            echo json_encode([
                'success' => false,
                'message' => 'Bạn cần đăng nhập để thực hiện thao tác này'
            ]);
            exit;
        }

        $userModule = new UserModule();
        $user = $userModule->getUserById($_SESSION['user_id']);
        
        if (!$user || $user['role'] !== 'admin') {
            echo json_encode([
                'success' => false,
                'message' => 'Unauthorized access'
            ]);
            exit;
        }

      
        if (empty($_POST['name']) || empty($_POST['description']) || empty($_POST['price']) || empty($_POST['trademark_id'])) {
            echo json_encode([
                'success' => false,
                'message' => 'Vui lòng điền đầy đủ thông tin sản phẩm'
            ]);
            exit;
        }

       
        $productsModule = new ProductsModule();
        
      
        $result = $productsModule->saveProduct($_POST);
        
       
        echo json_encode($result);
        
    } catch (Exception $e) {
        error_log("Product save error: " . $e->getMessage());

        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
    exit;
});

$router->post('/'.$nameProject.'/admin/product/delete', function() {
    checkAdminAccess();
    ob_clean();
    header('Content-Type: application/json');
    
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(["success" => false, "message" => "Bạn cần đăng nhập để thực hiện thao tác này"]);
        exit();
    }

    $jsonData = file_get_contents("php://input");
    $data = json_decode($jsonData, true);

    if (!isset($data['id'])) {
        echo json_encode(["success" => false, "message" => "Invalid input"]);
        exit();
    }

    try {
        $productId = intval($data['id']);
        $productModule = new ProductsModule();
        $result = $productModule->deleteProduct($productId);
        echo json_encode($result);
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => "Error deleting product: " . $e->getMessage()]);
    }
    exit();
});


$router->get('/'.$nameProject.'/admin/customer/:id', function($id) use ($nameProject) {
    checkAdminAccess();
    ob_clean();
    header('Content-Type: application/json');

    try {
        $customerModule = new CustomerModule();
        $customer = $customerModule->getCustomerDetails($id);
        
        if ($customer) {
            echo json_encode(['success' => true, 'data' => $customer]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Không tìm thấy thông tin khách hàng']);
        }
    } catch (Exception $e) {
        error_log("Error getting customer details: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Có lỗi xảy ra khi lấy thông tin khách hàng']);
    }
   exit();
});



require_once __DIR__ . '/../server/server.php';

try {
    $db = Database::getInstance()->getConnection();
    $stmt = $db->query("SELECT slug FROM products"); 
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($products as $product) {
        $slug = $product['slug'];
        $router->get("/$nameProject/product/$slug", function () use ($slug) {
            $controller = new ProductsController();
            $controller->showProduct($slug);
        });
    }
    
} catch (PDOException $e) {
    die("Lỗi lấy sản phẩm: " . $e->getMessage());
}
try {
    $db = Database::getInstance()->getConnection();
    $stmt = $db->query("SELECT slug, name, id FROM categories"); 
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($categories as $category) {
        $slug = $category['slug'];
        $name = $category['name'];
        $category_id = $category['id'];

        $router->get("/$nameProject/collections/$slug", function () use ($slug, $name, $category_id) {
            $controller = new CollectionsController();
            $controller->showCollection($slug, $name, $category_id);
        });
    }
    
} catch (PDOException $e) {
    die("Lỗi lấy danh mục: " . $e->getMessage());
}

return $router;
