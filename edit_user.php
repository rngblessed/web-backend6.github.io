<?php
// Подключение к базе данных
$user = 'u67307';
$pass = '2532509';
$db = new PDO(
    'mysql:host=localhost;dbname=u67307',
    $user,
    $pass,
    [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

// Проверка, был ли отправлен запрос на обновление данных
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['user_id'];
    $fullName = $_POST['full_name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $birthDate = $_POST['birth_date'];
    $gender = $_POST['gender'];
    $bio = $_POST['bio'];

    // Запрос на обновление данных пользователя
    $query = "UPDATE users SET full_name = :full_name, phone = :phone, email = :email, birth_date = :birth_date, gender = :gender, bio = :bio WHERE user_id = :user_id";
    $statement = $db->prepare($query);
    $statement->execute([
        'full_name' => $fullName,
        'phone' => $phone,
        'email' => $email,
        'birth_date' => $birthDate,
        'gender' => $gender,
        'bio' => $bio,
        'user_id' => $userId
    ]);

    // Перенаправление на страницу с информацией о пользователе
    header("Location: admin.php?id=" . $userId);
    exit();
}

// Получение информации о пользователе для редактирования
$userId = $_GET['id'];
$query = "SELECT * FROM users WHERE user_id = :user_id";
$statement = $db->prepare($query);
$statement->execute(['user_id' => $userId]);
$user = $statement->fetch(PDO::FETCH_ASSOC);

// Отображение формы для редактирования данных пользователя
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
        <form method="POST" id="form" class="row g-3 needs-validation">

            <input type="hidden" class="form-control rounded-pill" name="user_id" value="<?= $user['user_id'] ?>">
            <div class="col-auto">
                <label>Имя:</label>
                <input type="text" class="form-control rounded-pill" name="full_name"
                    value="<?= $user['full_name'] ?>"><br>
            </div>
            <div class="col-auto">
                <label>Телефон:</label>
                <input type="text" class="form-control rounded-pill" name="phone" value="<?= $user['phone'] ?>"><br>
            </div>
            <div class="col-auto">
                <label>Email:</label>
                <input type="text" class="form-control rounded-pill" name="email" value="<?= $user['email'] ?>"><br>
            </div>
            <div class="col-auto">
                <label>Дата рождения:</label>
                <input type="date" class="form-control rounded-pill" name="birth_date"
                    value="<?= $user['birth_date'] ?>"><br>
            </div>
            <div class="col-auto">
                <label>Пол:</label>
                <select name="gender">
                    <option value="male" <?= ($user['gender'] == 'male') ? 'selected' : '' ?>>Мужской</option>
                    <option value="female" <?= ($user['gender'] == 'female') ? 'selected' : '' ?>>Женский</option>
                </select><br>
            </div>
            <div class="col-auto">
                <label>Биография:</label><br>
                <textarea class="form-control rounded-pill" name="bio"><?= $user['bio'] ?></textarea><br>
            </div>
            <div class="col-auto">
                <button class="form-control rounded-pill" type="submit">Сохранить</button>
            </div>
        </form>
    </div>


</div>