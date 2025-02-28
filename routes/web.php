<?php

require_once __DIR__ . '/../core/Router.php';
require_once __DIR__ . '/../controllers/Homecontrollers.php';

require_once __DIR__ . '/../controllers/ProductsControllers.php';
require_once __DIR__ ."/../module/module.php";
require_once __DIR__ ."/../module/reviewsModule.php";


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
session_start();
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
           header("location:/MIKEPHP/");
        }
    } else {
        echo "Không có dữ liệu được gửi!";
    }
});

$router->post('/' . $nameProject . "/product/:slug", function($slug) use ($nameProject) {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["commentPost"])) {
        
        // Lấy nội dung bình luận
        $textComment = isset($_POST["textComment"]) ? trim($_POST["textComment"]) : "";

        // Kiểm tra nếu bình luận trống
        if (empty($textComment)) {
            exit("Bình luận không được để trống!");
        }

        // Kiểm tra nếu người dùng đã đăng nhập
        if (!isset($_SESSION["user_id"])) {
            exit("Bạn cần đăng nhập để bình luận.");
        }

        // Lấy thông tin người dùng từ session
        $userId = $_SESSION["user_id"];
        
        $product = new ProductsModule;
        // Giả sử product_id được lấy từ slug hoặc một nguồn khác
        $productId =$product->getProductIdFromSlug($slug);


        $userComment = new ReviewsModule();
        

        $userComment->postComment($userId, (int) implode(", ",$productId), 2, $textComment); 
        require_once __DIR__ . '/../views/navbar.php';
        require_once __DIR__ . '/../views/information.php';
        
    }
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
