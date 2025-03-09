<?php

require_once __DIR__ . '/../core/Router.php';
require_once __DIR__ . '/../controllers/Homecontrollers.php';


require_once __DIR__ . '/../controllers/ProductsControllers.php';
require_once __DIR__ ."/../module/module.php";
require_once __DIR__ ."/../module/reviewsModule.php";
require_once __DIR__ ."/../module/carftModule.php";

$router = new Router();
$nameProject = "MIKEPHP";

$router->get('/' . $nameProject . '/', [HomeController::class, 'index']);


$router->get('/' . $nameProject . '/admin', function(){
    require_once __DIR__ . '/../dashboard/index.php';
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
        $loginResult = $userModule->login($email,$pass);

        if ($loginResult && password_verify($pass, $loginResult["password"])) {
            session_start();
            session_regenerate_id(true);

            
            $_SESSION["user_id"] = $loginResult["id"];
            $_SESSION["user_email"] = $loginResult["email"];
            $_SESSION["logged_in"] = true;

            
            setcookie(session_name(), session_id(), [
                'httponly' => true,
                'secure' => isset($_SERVER["HTTPS"]),
                'samesite' => 'Strict'
            ]);

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


return $router;
