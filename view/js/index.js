function fetchAndProcess(uri, request, action) {
    fetch(uri, request).then(response => response.json()
    ).then(response => {
        if (!response.success) throw new Error(response.message);
        action();
    }).catch(error => {
        console.error(error);
    });
}

function getUri(base, paramName, param) {
    return base + encodeURI(`?${paramName}=${param}`);
}

function setListItemEventListeners(item) {
    item.querySelector(".delete-anime-button")?.addEventListener("click", function() {
        if (confirm("Вы уверены, что хотите удалить аниме из списка?"))
            fetchAndProcess(getUri("/anime/deleteListItem", "id", item.id), {method: "POST"},
            function() {window.location.reload();})
    });

    let rating = item.querySelector(`#rating-${item.id}`);
    rating?.addEventListener("blur", function() {
        if (!/^((10)|[0-9])$/.test(rating.value))
            rating.value = "";
    });

    let watchedCheckbox = item.querySelector(`#watched-${item.id}`);
    watchedCheckbox?.addEventListener("click", function() {
        if (watchedCheckbox.checked)
            item.querySelector(".watched").classList.remove("hidden");
        else
            item.querySelector(".watched").classList.add("hidden");
    });

    item.querySelector(".user-info-form")?.addEventListener("submit", function(e) {
        e.preventDefault();
        fetchAndProcess(getUri("/anime/updateListItem", "id", item.id), {method: "POST", body: new FormData(this)},
            function() {window.location.reload();})
    });

    item.querySelector(".add-anime-button")?.addEventListener("click", function() {
        fetchAndProcess(getUri("/anime/addListItem", "id", item.id), {method: "POST"},
            function() {window.location.reload();});
    });
}

let items = document.querySelectorAll(".anime-list-item");
for (let i = 0; i < items.length; i++) {
    items[i].querySelector(".rus-name").addEventListener("click", function () {
        items[i].querySelector(".anime-info").classList.toggle("hidden");
    });
    setListItemEventListeners(items[i]);
}

document.querySelector("#search-button")?.addEventListener("click", function () {
    let name = document.querySelector("#anime-search").value;
    if (name !== "") {
        window.location = getUri("/anime/search", "name", name);
    }
});