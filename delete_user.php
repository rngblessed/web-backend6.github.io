<?php
try {
    $user = 'u67307';
    $pass = '2532509';
    $conn = new PDO(
        'mysql:host=localhost;dbname=u67307',
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
        $sql_delete_user = "DELETE FROM users WHERE user_id = :user_id";
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
    <title>POFFIZADANIE3</title>
    <link rel="stylesheet" href="main.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/icheck-material@1.0.1/icheck-material.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/icheck-material@1.0.1/icheck-material-custom.min.css" />

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

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