function login() {

    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var users = this.responseText.split("\n");
            var valid = false;
            for (var i = 0; i < users.length; i++) {
                var user = users[i].split(":");
                var trimmedUsername = user[0].trim();
                var trimmedPassword = user[1].trim();
             
                if (username == trimmedUsername && password == trimmedPassword) {
                    valid = true;
                    break;
                }
            }
            if (valid) {
                window.location.href = "second.html";
                } else {
              document.getElementById("message").innerHTML = "Invalid username or password";
            }
        }
    };
    xhr.open("GET", "users.txt", true);
    xhr.send();
}
