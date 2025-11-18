<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $repeat_password = $_POST['repeat_password'];

    // Проверка совпадения паролей
    if ($password !== $repeat_password) {
        echo "Пароли не совпадают!";
        exit;
    }

    $users = [];
    if (file_exists("users.json")) {
        $users = json_decode(file_get_contents("users.json"), true);
        if (!is_array($users)) $users = [];
    }

    // Проверка уникальности
    foreach ($users as $user) {
        if ($user['username'] === $username || $user['phone'] === $phone || $user['email'] === $email) {
            echo "Имя, телефон или email уже используются!";
            exit;
        }
    }

    // Сохраняем нового пользователя
    $users[] = [
        'username' => $username,
        'phone' => $phone,
        'email' => $email,
        'password' => $password
    ];
    file_put_contents("users.json", json_encode($users, JSON_PRETTY_PRINT));

    // Перенаправление на страницу входа после регистрации
    header("Location: login_3.php");
    exit;
}
?>

<h2>Регистрация</h2>
<form method="POST" action="">
    <input type="text" name="username" placeholder="Имя пользователя" required><br>
    <input type="tel" name="phone" placeholder="Телефон" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Пароль" required><br>
    <input type="password" name="repeat_password" placeholder="Повторите пароль" required><br>
    <button type="submit">Зарегистрироваться</button>
</form>

<p>Если пользователь уже зарегистрирован, <a href="login_3.php">войдите</a>.</p>