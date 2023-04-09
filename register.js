 function register() {
        var username = document.getElementById("username2").value;
        var password = document.getElementById("password2").value;
        var confirmPassword = document.getElementById("confirm-password2").value;
        if (password !== confirmPassword) {
            document.getElementById("message").innerHTML = "Passwords do not match.";
            return;
        }
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var users = this.responseText.split("\n");
                for (var i = 0; i < users.length; i++) {
                    var user = users[i].split(":");
                    if (username == user[0]) {
                        document.getElementById("message").innerHTML = "Username already taken.";
                        return;
                    }
                }
                var newUser = username + ":" + password + "\n";
                var fileWriter = new XMLHttpRequest();
                fileWriter.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("message").innerHTML = "Registration successful!";
                    }
                };
                fileWriter.open("POST", "register.php", true);
                fileWriter.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                fileWriter.send("newUser=" + encodeURIComponent(newUser));
            }
        };
        xhr.open("GET", "users.txt", true);
        xhr.send();
    }