<?php
try {
    $user = 'u67323';
    $pass = '3649631';
    $conn = new PDO(
        'mysql:host=localhost;dbname=u67323',
        $user,
        $pass,
        [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    // Проверяем, был ли отправлен запрос на удаление пользователя
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
        $user_id = $_POST['user_id'];

        $conn->beginTransaction();

        // Удаление связанных записей из других таблиц
        $sql_delete_user_languages = "DELETE FROM user_languages WHERE user_id = :user_id";
        $stmt_delete_user_languages = $conn->prepare($sql_delete_user_languages);
        $stmt_delete_user_languages->execute(['user_id' => $user_id]);

        // SQL запрос для удаления пользователя
        $sql_delete_user = "DELETE FROM main WHERE user_id = :user_id";
        $stmt_delete_user = $conn->prepare($sql_delete_user);
        $stmt_delete_user->execute(['user_id' => $user_id]);

        if ($stmt_delete_user->rowCount() > 0) {
            $conn->commit();
            echo "Пользователь успешно удален.";
            // Перенаправление на страницу admin.php
            header("Location: admin.php");
            exit();
        } else {
            echo "Пользователь с указанным ID не найден.";
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

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ZADANIE6</title>


</head>
<div class="osnova">
    <div class="wrap1 lh-lg font-monospace">
        <form method="POST" id="form" class="row g-3 needs-validation" action="delete_user.php">

            <label for="user_id">ID пользователя:</label>
            <input type="text" name="user_id" id="user_id">
            <button type="submit">Удалить пользователя</button>
        </form>
    </div>
</div>