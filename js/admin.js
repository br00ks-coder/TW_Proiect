function fetchUserData() {
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "../php/fetch_users.php", true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                let response = xhr.responseText;
                document.getElementById("user-container").innerHTML = response;
            } else {
                console.log("AJAX request error:", xhr.status);
            }
        }
    };
    xhr.send();
}

function handlePasswordChangeFormSubmit(event) {
    event.preventDefault();

    let form = event.target;
    let url = form.getAttribute("action");
    let formData = new FormData(form);

    let xhr = new XMLHttpRequest();
    xhr.open("POST", url, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                let response = xhr.responseText;
                console.log(response);
                fetchUserData();
            } else {
                console.log("AJAX request error:", xhr.status);
            }
        }
    };
    xhr.send(formData);
}

function handleDeleteUserFormSubmit(event) {
    event.preventDefault();

    let form = event.target;
    let url = form.getAttribute("action");
    let formData = new FormData(form);

    let xhr = new XMLHttpRequest();
    xhr.open("POST", url, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                let response = xhr.responseText;
                console.log(response);
                fetchUserData();
            } else {
                console.log("AJAX request error:", xhr.status);
            }
        }
    };
    xhr.send(formData);
}

function pollUserData() {
    fetchUserData();
    setTimeout(pollUserData, 5000);
}

fetchUserData();
pollUserData();

document.addEventListener("submit", function (event) {
    let target = event.target;
    if (target.getAttribute("id") === "change-password-form") {
        event.preventDefault();
        handlePasswordChangeFormSubmit(event);
    } else if (target.getAttribute("id") === "delete-user-form") {
        event.preventDefault();
        handleDeleteUserFormSubmit(event);
    }
});


