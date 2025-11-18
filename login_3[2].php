<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $login = $_POST['login']; // телефон или email
    $password = $_POST['password'];
    $captcha = $_POST['captcha'];

    // Простая проверка капчи
    if ($captcha !== '1234') {  
        echo "Подтвердите, что вы не робот!";
        exit;
    }

    // Проверка логина и пароля
    $users = json_decode(file_get_contents("users.json"), true);
    $found = false;

    foreach ($users as $user) {
        if (($user['phone'] === $login || $user['email'] === $login) 
            && $user['password'] === $password) {
            $found = true;
            $_SESSION['user'] = $user;
            header("Location: profile_3.php");
            exit;
        }
    }

    if (!$found) {
        echo "Неверный логин или пароль!";
    }
}
?>

<h2>Вход</h2>
<form method="POST" action="">
    <input type="text" name="login" placeholder="Телефон или Email" required><br>
    <input type="password" name="password" placeholder="Пароль" required><br>

    <!-- Простая капча -->
    Введите число 1234: <input type="text" name="captcha" required><br>

    <button type="submit">Войти</button>
</form>

<p>Если ещё нет аккаунта, <a href="register_3.php">зарегистрируйтесь</a>.</p>