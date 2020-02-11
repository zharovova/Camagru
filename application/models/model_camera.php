<?php
session_start();
class Model_Camera extends Model
{
    public function authenticate()
    {
        if (!isset($_SESSION['login']))
            return false;
        return true;
    }

public function upload_image_base()
{
    if (!isset($_POST['base_img']))
        return ('no_image');
    else {
        $sticker = $_POST['sent_sticker'];
        $sticker = explode('_', $sticker);
        $sticker[2] = intval($sticker[2]);
        $sticker[3] = intval($sticker[3]);
        $data = explode(',' , $_POST['base_img']);
        $img = imagecreatefromstring(base64_decode($data[1])); //переводим из base64 в изображение
        if ($img === false)
            return 'no_image';
        $image_name = hash('crc32', rand()) . '.jpg'; //хешируем название
        $src = imagecreatefrompng('images/'.$sticker[1].'.png');
        imagesavealpha($src, true); //сохраняем альфа канал у стикера
        $img = imagescale($img, 640, 480); //ставим размер изображения
        $src = imagescale($src, 180, 180);
// объединение изображений
        imagecopy($img, $src, $sticker[2]-10, $sticker[3]-50, 0, 0, imagesx($src), imagesy($src));
// сохраняем изображение в папку
        imagejpeg($img,  "images/user_image/$image_name");
        //чистим память
        imagedestroy($img);
        imagedestroy($src);
        $this->update_db($image_name);
        return ('success');
    }
}
    private function update_db($image_name) {
        require 'config/database.php';

        $pdo = new PDO($dsn, $db_user, $db_password, $options);
        $pdo->exec('USE camagru_db');
        $sql = 'SELECT User_ID, login
        FROM users WHERE login = ?';
        $sql = $pdo->prepare($sql);
        $sql->execute(array($_SESSION['login']));
        $id = $sql->fetch();
        $sql = 'INSERT INTO `post_img` (`User_ID`, `Image`, `Message`, `Creation_Date`) VALUES (?, ?, ?, NOW())';

        $id = $id['User_ID'];
        $message = 'hello pizza!';//isset($_POST['description']) ? mb_strimwidth($_POST['description'], 0, 250) : null;

        $sth = $pdo->prepare($sql);
        $sth->execute(array($id, $image_name, $message));
    }
    public function upload()
    {
        $path = 'images/user_image/';
        $type = explode('/',$_FILES['picture']['type']);
        $image_name = hash('crc32', rand()) . '.' . $type[1]; //хешируем название
// Массив допустимых значений типа файла
        $types = array('image/gif', 'image/png', 'image/jpeg');
        $type = explode('/',$_FILES['picture']['type']);

// Максимальный размер файла
        $size = 100240000;
// Обработка запроса
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Проверяем тип файла
            if (!in_array($_FILES['picture']['type'], $types))
                die('Запрещённый тип файла. <a href="#">Попробовать другой файл?</a>');
            // Проверяем размер файла
            if ($_FILES['picture']['size'] > $size)
                die('Слишком большой размер файла. <a href="?">Попробовать другой файл?</a>');
            // Загрузка файла и вывод сообщения
            if (!@copy($_FILES['picture']['tmp_name'], $path . $image_name))
                echo 'Что-то пошло не так';
            else {
                $this->update_db($image_name);
               // $data = base64_encode(file_get_contents($path));
               // echo "<img src='data:image/$type;base64,$data'>\n";
            }
        }
    }
}