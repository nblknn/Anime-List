async function getHash(str, algorithm = 'SHA-256') {
    // Кодируем строку в Uint8Array (UTF-8)
    const encoder = new TextEncoder();
    const data = encoder.encode(str);
    // Получаем хеш с помощью Web Crypto API
    const hashBuffer = await crypto.subtle.digest(algorithm, data);
    // Конвертируем ArrayBuffer в hex-строку
    const hashArray = Array.from(new Uint8Array(hashBuffer));
    return hashArray.map(b => b.toString(16).padStart(2, '0')).join('');
}

function fetchAndProcess(uri, request, action) {
    fetch(uri, request).then(response => response.json()
    ).then(response => {
        if (!response.success) throw new Error(response.message);
        action();
    }).catch(error => {
        alert(error);
    });
}

document.querySelector("#registration-form")?.addEventListener("submit", async function (e) {
    e.preventDefault();
    let inputs = document.querySelectorAll("#registration-form > div > input");
    for (let i = 0; i < inputs.length; i++)
        if (inputs[i].value.length === 0) return;
    if (!grecaptcha.getResponse()) {
        alert("Подтвердите, что вы не робот!");
        return;
    }
    let password = await getHash(document.querySelector("#password-input").value);
    let salt = await getHash(Math.random().toString());
    let formData = new FormData(this);
    formData.set("password", password);
    formData.set("salt", salt);
    fetchAndProcess("/user/confirmRegistration/", {method: "POST", body: formData},
        function () {window.location.href = "/anime";});
});

document.querySelector("#login-form")?.addEventListener("submit", async function (e) {
    e.preventDefault();
    if (document.querySelector("#password-input").value.length === 0) return;
    if (document.querySelector("#email-input").value.length === 0) return;
    if (!grecaptcha.getResponse()) {
        alert("Подтвердите, что вы не робот!");
        return;
    }
    let password = await getHash(document.querySelector("#password-input").value);
    let formData = new FormData(this);
    formData.set("password", password);
    formData.set("rememberMe", document.querySelector("#remember-me-input").checked);
    fetchAndProcess("/user/confirmLogin/", {method: "POST", body: formData},
        function () {window.location.href = "/anime";});
});