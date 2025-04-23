{{if (count($list) > 0)}}
{{foreach ($list as $item)}}
<li class="anime-list-item" id="{{echo $item['id']}}">
    <span class="rus-name">{{echo $item['russianname']}}</span>
    <div class="anime-info hidden">
        <img src="{{echo $item['posterURL']}}" alt="poster">
        <div>
            <span class="eng-name">{{echo $item['name']}}</span>
            <span class="year">{{echo $item['year']}}</span><br>
            <span class="episodes-count">Эпизоды: {{echo $item['episodes']}}</span>
            <div class="description">{{echo $item['description']}}</div>
            {{if ($item['isInList'])}}
            <form class="user-info-form">
                <input name="isWatched" type="checkbox" id="watched-{{echo $item['id']}}" {{if ($item['isWatched'])}}checked{{endif}}>
                <label for="watched-{{echo $item['id']}}">Просмотрено</label><br>
                <div class="watched{{if (!$item['isWatched'])}} hidden{{endif}}">
                    <label for="rating-{{echo $item['id']}}">Оценка:</label>
                    <input name="rating" id="rating-{{echo $item['id']}}" value="{{echo $item['rating'] ?? ''}}">/10<br>
                    <label for="comment-{{echo $item['id']}}">Комментарий:</label>
                    <textarea name="comment" id="comment-{{echo $item['id']}}">{{echo $item['comment'] ?? ''}}</textarea>
                </div>
                <button class="save-changes-button" type="submit">Сохранить изменения</button>
                <button class="delete-anime-button" type="button">Удалить из списка</button>
            </form>
            {{else}}
            <button class="add-anime-button">Добавить в список</button>
            {{endif}}
        </div>
    </div>
</li>
{{endforeach}}
{{else}}
<div>Ничего не найдено</div>
{{endif}}