<header>
    <h1>My anime list</h1>
    <nav>
        <ul>
            <li><a href="/user/login" {{if ($page === 'login')}}class="this-page"{{endif}}>Вход</a></li>
            <li><a href="/user/registration" {{if ($page === 'registration')}}class="this-page"{{endif}}>Регистрация</a></li>
        </ul>
    </nav>
</header>