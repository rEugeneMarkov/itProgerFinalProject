<header>
    <div class="container top-menu">
        <div class="logo">
            <img src="/public/img/logo.svg" alt="Logo">
            <span>Уберем все лишнее из ссылки!</span>
        </div>
        <div class="nav">
            <a href="/">Главная</a>
            <a href="/contact/about">Про нас</a>
            <a href="/contact">Контакты</a>

            <?php if ($_COOKIE['login'] == '') : ?>
                <a href="/user/auth">Войти</a>
            <?php else : ?>
                <a href="/user">Кабинет пользователя</a>
            <?php endif; ?>
        </div>
    </div>
</header>