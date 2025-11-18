<?php
session_start();

// Только для авторизованных пользователей
if (!isset($_SESSION['user'])) {
    header("Location: login_3.php");
    exit;
}

$user = $_SESSION['user'];

// Обновление данных
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_name = $_POST['new_username'];
    $new_phone = $_POST['new_tel'];
    $new_email = $_POST['new_email'];
    $new_password = $_POST['new_password'];

    $users = json_decode(file_get_contents("users.json"), true);

    foreach ($users as &$u) {
        if ($u['username'] === $user['username'] && $u['phone'] === $user['phone'] && $u['email'] === $user['email']) {
            if (!empty($new_name)) $u['username'] = $new_name;
            if (!empty($new_phone)) $u['phone'] = $new_phone;
            if (!empty($new_email)) $u['email'] = $new_email;
            if (!empty($new_password)) $u['password'] = $new_password;

            $_SESSION['user'] = $u; // обновляем сессию
            break;
        }
    }

    file_put_contents("users.json", json_encode($users, JSON_PRETTY_PRINT));
    echo "Данные успешно обновлены!";
}
?>

<h2>Профиль</h2>
<p>Привет, <?php echo $user['username']; ?>!</p>
<a href="logout_3.php">Выйти</a>

<h3>Текущие данные</h3>
<input type="text" value="<?php echo $user['username']; ?>" readonly>
<input type="tel" value="<?php echo $user['phone']; ?>" readonly>
<input type="email" value="<?php echo $user['email']; ?>" readonly>
<input type="password" value="<?php echo $user['password']; ?>" readonly>

<h3>Новые данные</h3>
<form method="POST" action="">
    <input type="text" name="new_username" placeholder="Новое имя">
    <input type="tel" name="new_tel" placeholder="Новый телефон">
    <input type="email" name="new_email" placeholder="Новый Email">
    <input type="password" name="new_password" placeholder="Новый пароль">
    <button type="submit">Сохранить</button>
</form>