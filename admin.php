<?php


// Проверка авторизации
if (
    empty($_SERVER['PHP_AUTH_USER']) ||
    empty($_SERVER['PHP_AUTH_PW']) ||
    $_SERVER['PHP_AUTH_USER'] != 'admin' ||
    md5($_SERVER['PHP_AUTH_PW']) != md5('admin')
) {
    header('HTTP/1.1 401 Unanthorized');
    header('WWW-Authenticate: Basic realm="My site"');
    print ('<h1>401 Требуется авторизация</h1>');
    exit();
}

print ('Вы успешно авторизовались и видите защищенные паролем данные.');

?>






<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ZADANIE6</title>


</head>


<body>

    <div class="osnova">
        <div class="wrap3 lh-lg font-monospace">
            <?php
            $user = 'u67323';
            $pass = '3649631';
            $conn = new PDO(
                'mysql:host=localhost;dbname=u67323',
                $user,
                $pass,
                [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
            $languageStatsQuery = "SELECT language_name, COUNT(user_id) AS user_count
                      FROM user_languages
                      GROUP BY language_name";

            $languageStatsStatement = $conn->query($languageStatsQuery);
            $languageStats = $languageStatsStatement->fetchAll(PDO::FETCH_ASSOC);

            // Отображение статистики
            print "<h2>Статистика по языкам:</h2>";
            foreach ($languageStats as $language) {
                print "<p>Язык: " . $language['language_name'] . ", Количество пользователей: " . $language['user_count'] . "</p>";
            }
            ?>
        </div>

        <div class="wrap1 lh-lg font-monospace">
            <?php
            $user = 'u67323';
            $pass = '3649631';
            $conn = new PDO(
                'mysql:host=localhost;dbname=u67323',
                $user,
                $pass,
                [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );

            $query = "SELECT u.user_id, u.Name, u.phone, u.email, u.birth_date, u.gender, u.Biographi, u.contract_agreed, 
            GROUP_CONCAT(l.language_name) AS languages
     FROM main u
     LEFT JOIN user_languages l ON u.user_id = l.user_id
     GROUP BY u.user_id";
            $statement = $conn->query($query);
            $users = $statement->fetchAll(PDO::FETCH_ASSOC);
            foreach ($users as $user) {
                print "<div class='info'>";
                print "<p>ID: " . $user['user_id'] . "</p>";
                print "<p>Имя: " . $user['Name'] . "</p>";
                print "<p>Телефон: " . $user['phone'] . "</p>";
                print "<p>Email: " . $user['email'] . "</p>";
                print "<p>Дата рождения: " . $user['birth_date'] . "</p>";
                print "<p>Язык: " . $user['languages'] . "</p>";
                print "<p>Пол: " . $user['gender'] . "</p>";
                print "<p>Биография: " . $user['Biographi'] . "</p>";
                print "<p>С политикой: " . $user['contract_agreed'] . "</p>";
                print "<a href='edit_user.php?id=" . $user['user_id'] . "'>Редактировать</a></br>";
                print "<a href='delete_user.php?id=" . $user['user_id'] . "'>Удалить</a>";
                print "</div>";

            }
            ?>

        </div>

    </div>

</body>

</html>