<!doctype html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" 
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Главная страница</title>

    <link rel="stylesheet" href="/public/css/main.css" charset="utf-8">
    <link rel="stylesheet" href="/public/css/form.css" charset="utf-8">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" crossorigin="anonymous">
</head>

<body>
    <?php require 'public/blocks/header.php' ?>

    <div class="container main">
        <h1>Сокра.тим</h1>
        <?php if ($_COOKIE['login'] == '') : ?>
            <p>
                Вам нужно сократить ссылку? Прежде чем это сделать зарегестрируйтесь на сайте!
            </p>
            <form action="/" method="post" class="form-control">
                <input type="email" name="email" placeholder="Введите email" value="<?= $_POST['email'] ?>"><br>
                <input type="text" name="login" placeholder="Введите логин" value="<?= $_POST['login'] ?>"><br>
                <input type="password" name="pass" placeholder="Введите пароль" value="<?= $_POST['pass'] ?>"><br>
                <div class="error"><?= $data['message'] ?></div>
                <button class="btn" type="submit">Зарегистрироваться</button>
            </form>
            <p style="text-align: left;">
                Есть аккаунт? Тогда ва можете
                <a href="user/auth">авторизоваться</a>!
            </p>
        <?php else : ?>
            <p>Вам нужно сократить ссылку? Сейчас мы это сделаем!</p>
            <form action="/" method="post" class="form-control">
                <input type="text" name="link" placeholder="Длинная ссылка" value="<?= $_POST['link'] ?>"><br>
                <input type="text" name="short_link" placeholder="Короткое название" value="<?= $_POST['short_link']?>">
                <br>
                <div class="error"><?= $data['message'] ?></div>
                <button class="btn" type="submit">Уменьшить</button>
            </form>

            <?php if (count($data['links']) > 0) : ?>
                <h2 style="text-align: center; margin-top: 40px;">Сокращенные ссылки</h2>
                <?php foreach ($data['links'] as $link) : ?>
                    <div class="link">
                        <p><b>Длинная ссылка: </b><?= $link->link ?></p>
                        <p><b>Короткая ссылка: </b>
                            <a href="<?= $link->link ?>">
                            <?= $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/s/' . $link->short_link?>
                            </a>
                        </p>
                        <form action="/home/delete" method="post">
                            <input type="hidden" name="id" value="<?= $link->id ?>">
                            <button type="submit" class="btn">Удалить <i class="fa fa-trash"></i></button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <?php require 'public/blocks/footer.php' ?>
</body>

</html>