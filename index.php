<?php
include("./server/setup.php");
require_once "./module/userModule.php";
session_start(); 
if (!isset($_SESSION["logged_in"]) && isset($_COOKIE["auto_login"])) {
    $data = json_decode(base64_decode($_COOKIE["auto_login"]), true);

    if ($data && isset($data["email"], $data["password"])) {
        $userModule = new UserModule();
        $loginResult = $userModule->login($data["email"], null);

        if ($loginResult && $data["password"] === $loginResult["password"]) {
            $_SESSION["user_id"] = $loginResult["id"];
            $_SESSION["user_email"] = $loginResult["email"];
            $_SESSION["logged_in"] = true;
        } else {
            // Nếu cookie không hợp lệ, xoá luôn
            setcookie("token", "", time() - 3600, "/");
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/MIKEPHP/css/style.css">
    <link rel="stylesheet" href="/MIKEPHP/dashboard/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
</head>

<body style="background-color: #f5f5f5;">
<?php require_once __DIR__ . '/routes/web.php'; $router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);?>



    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    
</body>

</html>