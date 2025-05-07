<header>
    <h1>My anime list</h1>
    <nav>
        <ul>
            <li><a href="/anime/watched" {{if ($page === 'watched')}}class="this-page"{{endif}}>Просмотренное</a></li>
            <li><a href="/anime/planned" {{if ($page === 'planned')}}class="this-page"{{endif}}>Запланированное</a></li>
            <li><a href="/anime/search" {{if ($page === 'search')}}class="this-page"{{endif}}>Поиск</a></li>
            <li class="user"><a>{{echo $user->getFirstName() . ' ' . $user->getLastName()}}</a></li>
            <li class="user-options">
                {{if (!$user->getIsVerified())}}
                <div><a href="/user/verify">Подтвердить почту</a></div>
                {{endif}}
                <div><a href="/user/logout">Выйти</a></div>
            </li>
        </ul>
    </nav>
</header>