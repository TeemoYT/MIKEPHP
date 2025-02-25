<?php

require_once __DIR__ . '/../core/Router.php';
require_once __DIR__ . '/../controllers/Homecontrollers.php';

require_once __DIR__ . '/../controllers/ProductsControllers.php';
require_once __DIR__ ."/../module/module.php";


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

$router->post('/' . $nameProject . '/login', function () {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["dangnhap"])) {
        $email = isset($_POST["email"]) ? $_POST["email"] : "";
        $pass = isset($_POST["password"]) ? $_POST["password"] : "";

        if (empty($email) || empty($pass)) {
            
            require_once __DIR__ . '/../views/login.php';
            exit(); 
        }
        $userModule = new UserModule();
        $loginResult = $userModule->login($email, $pass);

        if ($loginResult) {
           header("location:index.php");
        } else {
            echo "Sai email hoặc mật khẩu!";
        }
    } else {
        echo "Không có dữ liệu được gửi!";
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
