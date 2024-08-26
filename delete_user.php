<?php
try {
    $user = 'admin';
    $pass = 'smpP4ssw0rd!';
    $conn = new PDO(
        'mysql:host=localhost;dbname=admin',
        $user,
        $pass,
        [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    // Проверяем, был ли отправлен запрос на удаление пользователя
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['user_delete']) && $_SERVER['PHP_AUTH_USER'] == 'admin' &&
    md5($_SERVER['PHP_AUTH_PW']) == md5('admin')) {
        $user_id = intval($_GET['user_delete']);

        $conn->beginTransaction();

        // Удаление связанных записей из других таблиц
        $sql_delete_user_languages = "DELETE FROM user_languages WHERE user_id = :user_id";
        $stmt_delete_user_languages = $conn->prepare($sql_delete_user_languages);
        $stmt_delete_user_languages->execute(['user_delete' => $user_id]);

        // SQL запрос для удаления пользователя
        $sql_delete_user = "DELETE FROM main WHERE user_id = :user_id";
        $stmt_delete_user = $conn->prepare($sql_delete_user);
        $stmt_delete_user->execute(['user_id' => $user_id]);

        if ($stmt_delete_user->rowCount() > 0) {
            $conn->commit();
            echo "Пользователь успешно удален.";
            // Перенаправление на страницу admin.php
            //header("Location: admin.php");
            //exit(0);
        } else {
            echo "Пользователь с указанным ID не найден.";
            //header("Location: admin.php");
            //exit(0);
        }
    }
} catch (PDOException $e) {
    echo "Ошибка при удалении пользователя: " . $e->getMessage();
    if ($conn) {
        $conn->rollBack();
    }
}

// Закрываем соединение с базой данных
$conn = null;
?>