function fetchAndProcess(uri, request, action) {
    fetch(uri, request).then(response => response.json()
    ).then(response => {
        if (!response.success) throw new Error(response.message);
        action();
    }).catch(error => {
        console.error(error);
    });
}

function getUri(base) {
    return base + encodeURI("?path=" + document.querySelector("#path").innerHTML);
}

function setEventListeners() {
    document.querySelector("#add-file-form")?.addEventListener("submit", function(e) {
        e.preventDefault();
        if (document.querySelector("#add-file-input").files.length !== 0) {
            fetchAndProcess(getUri("/admin/addFile"), {method: "POST", body: new FormData(this)},
                function() {window.location.reload();})
        }
    });

    document.querySelector("#add-dir-form")?.addEventListener("submit", function(e) {
        e.preventDefault();
        if (document.querySelector("#add-dir-input").value.length !== 0) {
            fetchAndProcess(getUri("/admin/addDir"), {method: "POST", body: new FormData(this)},
                function() {window.location.reload();})
        }
    });
    
    document.querySelector("#delete-dir-button")?.addEventListener("click", function() {
        if (confirm("Вы уверены, что хотите удалить папку?")) {
            fetchAndProcess(getUri("/admin/deleteDir"), { method: "POST", },
                function() {window.location.href = window.location.href.substring(0, window.location.href.lastIndexOf('/'));});
        }
    });

    document.querySelector("#delete-file-button")?.addEventListener("click", function() {
        if (confirm("Вы уверены, что хотите удалить файл?")) {
            fetchAndProcess(getUri("/admin/deleteFile"), { method: "POST", },
                function() {window.location.href = window.location.href.substring(0, window.location.href.lastIndexOf('/'));});
        }
    });
    
    document.querySelector("#save-changes-button")?.addEventListener("click", function() {
        let data = new FormData();
        data.append("file", document.querySelector("#file-contents").value);
        fetchAndProcess(getUri("/admin/updateFile"), {method: "POST", body: data},
            function() {window.location.reload()});
    });
    
    document.querySelector("#rename-file-form")?.addEventListener("submit", function(e) {
        e.preventDefault();
        if (document.querySelector("#rename-file-input").value.length !== 0) {
            fetchAndProcess(getUri("/admin/renameFile"), {method: "POST", body: new FormData(this)},
                function() {window.location.href = window.location.href.substring(0, window.location.href.lastIndexOf('/') + 1)
                    + document.querySelector("#rename-file-input").value;})
        }
    });
}

function setURIs() {
    for (let a of document.querySelectorAll(".dir-list a")) {
        a.href = "/admin/getFile?path=" + encodeURI(a.id);
    }
}

setURIs();
setEventListeners();