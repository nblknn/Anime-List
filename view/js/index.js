function createUserInfoDiv(anime, li) {
    let div = document.createElement("div");
    div.innerHTML = `<input type="checkbox" id="watched-${anime.id}">
                    <label for="watched-${anime.id}">Просмотрено</label><br>
                    <div class="watched">
                        <label for="rating-${anime.id}">Оценка:</label>
                        <input id="rating-${anime.id}" value="${anime.rating == null ? "" : anime.rating}">/10<br>
                        <label for="comment-${anime.id}"">Комментарий:</label>
                        <textarea id="comment-${anime.id}">${anime.comment == null ? "" : anime.comment}</textarea>
                    </div>
                    <button class="save-changes">Сохранить изменения</button>
                    <button class="delete-anime">Удалить из списка</button>`;

    div.querySelector(".delete-anime").addEventListener("click", function() {
        localStorage.removeItem(anime.id);
        li.remove();
    });
    let rating = div.querySelector(`#rating-${anime.id}`);
    rating.addEventListener("blur", function() {
        if (!/^((10)|[0-9])$/.test(rating.value))
            rating.value = "";
    })
    div.querySelector(`#watched-${anime.id}`).checked = anime.isWatched;
    if (!anime.isWatched) {
        div.querySelector(".watched").classList.add("hidden");
    }
    div.querySelector(`#watched-${anime.id}`).addEventListener("click", function() {
        if (div.querySelector(`#watched-${anime.id}`).checked)
            div.querySelector(".watched").classList.remove("hidden");
        else
            div.querySelector(".watched").classList.add("hidden");
    })
    div.querySelector(".save-changes").addEventListener("click", function() {
        anime.isWatched = div.querySelector(`#watched-${anime.id}`).checked;
        anime.rating = div.querySelector(`#rating-${anime.id}`).value;
        anime.comment = div.querySelector(`#comment-${anime.id}`).value;
        localStorage.setItem(anime.id, JSON.stringify(anime));
    });

    li.querySelector(".anime-info > div").append(div);
}


function createAddButton(anime, li) {
    let button = document.createElement("button");
    button.className = ".add-anime";
    button.textContent = "Добавить в список";
    button.addEventListener("click", function() {
        localStorage.setItem(anime.id, JSON.stringify(anime));
        createUserInfoDiv(anime, li);
        button.remove();
    });

    li.querySelector(".anime-info > div").append(button);
}


function createListItem(anime, isInList) {
    let li = document.createElement("li");
    li.className = "anime-list-item";
    li.id = anime.id;
    li.innerHTML = `
        <span class="rus-name">${anime.russian}</span>
        <div class="anime-info hidden">
            <img src="${anime.poster.originalUrl}" alt="poster">
            <div>
                <span class="eng-name">${anime.name}</span>
                <span class="year">${anime.airedOn.year}</span><br>
                <span class="episodes-count">Эпизоды: ${anime.episodes}</span>
                <div class="description">${anime.descriptionHtml}
                </div>
            </div>
        </div>`;
    li.querySelector(".rus-name").addEventListener("click", function() {
        li.querySelector(".anime-info").classList.toggle("hidden");
    });
    if (isInList) {
        createUserInfoDiv(anime, li);
    } else {
        createAddButton(anime, li);
    }
    return li;
}


function addAnimeToDocument(anime, isAdded) {
    let li = createListItem(anime, isAdded);
    document.querySelector(".anime-list").append(li);
}


function showList(isWatched) {
    let isEmpty = true;
    for (let key of Object.keys(localStorage)) {
        if (JSON.parse(localStorage.getItem(key)).isWatched === isWatched) {
            addAnimeToDocument(JSON.parse(localStorage.getItem(key)), true);
            isEmpty = false;
        }
    }
    if (isEmpty)
        document.querySelector(".no-items").classList.remove("hidden");
}


document.querySelector(".clear").addEventListener("click", function() {
    if (confirm("Вы уверены, что хотите очистить списки?")) {
        localStorage.clear();
    }
})


async function requestAPI(name) {
    let request = await fetch("https://shikimori.one/api/graphql",
        {
            method: "POST",
            headers: {"Content-Type": "application/json"},
            body: JSON.stringify({
                query: `{
                      animes(search: "${name}", limit: 10, rating: "!rx") {
                      id
                      name
                      russian
                      episodes
                      airedOn { year }                    
                      poster { originalUrl }                  
                      descriptionHtml
                    }
                }`
            })
        });
    return await request.json();
}


function setSearchEvent() {
    document.querySelector("#search-button").addEventListener("click", function () {
        document.querySelector(".anime-list").innerHTML = "";
        let name = document.querySelector("#anime-search").value;
        if (name !== "") {
            let anime;
            requestAPI(name).then(resolve => {
                anime = resolve.data.animes;
                if (anime.length === 0) document.querySelector(".anime-list").innerHTML = "Ничего не найдено";
                for (let i = 0; i < anime.length; i++) {
                    if (anime[i].russian == null) anime[i].russian = anime[i].name;
                    if (localStorage.getItem(anime[i].id) != null)
                        addAnimeToDocument(anime[i], true);
                    else {
                        anime[i].isWatched = false;
                        addAnimeToDocument(anime[i], false);
                    }
                }
            });
        }
    })
}