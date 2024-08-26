<?php
// Подключение к базе данных
$user = 'admin';
$pass = 'smpP4ssw0rd!';
$db = new PDO(
    'mysql:host=localhost;dbname=admin',
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
    $query = "UPDATE main SET Name = :Name, phone = :phone, email = :email, birth_date = :birth_date, gender = :gender, Biographi = :Biographi WHERE user_id = :user_id";
    $statement = $db->prepare($query);
    $statement->execute([
        'Name' => $fullName,
        'phone' => $phone,
        'email' => $email,
        'birth_date' => $birthDate,
        'gender' => $gender,
        'Biographi' => $bio,
        'user_id' => $userId
    ]);

    // Перенаправление на страницу с информацией о пользователе
    header("Location: admin.php?id=" . $userId);
    exit();
}

// Получение информации о пользователе для редактирования
$userId = $_GET['id'];
$query = "SELECT * FROM main WHERE user_id = :user_id";
$statement = $db->prepare($query);
$statement->execute(['user_id' => $userId]);
$user = $statement->fetch(PDO::FETCH_ASSOC);

// Отображение формы для редактирования данных пользователя
?>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ZADANIE6</title>


</head>
<div>
    <div>
        <form method="POST" id="form">

            <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
            <div>
                <label>Имя:</label>
                <input type="text" name="full_name" value="<?= $user['Name'] ?>"><br>
            </div>
            </br>
            <div>
                <label>Телефон:</label>
                <input type="text" name="phone" value="<?= $user['phone'] ?>"><br>
            </div>
            <div>
                <label>Email:</label>
                <input type="text" name="email" value="<?= $user['email'] ?>"><br>
            </div>
            <div>
                <label>Дата рождения:</label>
                <input type="date" name="birth_date"
                    value="<?= $user['birth_date'] ?>"><br>
            </div>
            <div>
                <label>Пол:</label>
                <select name="gender">
                    <option value="male" <?= ($user['gender'] == 'male') ? 'selected' : '' ?>>Мужской</option>
                    <option value="female" <?= ($user['gender'] == 'female') ? 'selected' : '' ?>>Женский</option>
                </select><br>
            </div>
            <div>
                <label>Биография:</label><br>
                <textareaname="bio"><?= $user['Biographi'] ?></textarea><br>
            </div>
            <div>
                <button type="submit">Сохранить</button>
            </div>
        </form>
    </div>


</div>