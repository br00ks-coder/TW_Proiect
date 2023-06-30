var cartItems = [];
var cartTotal = 0;

function addToCart(name, price, user_id) {


    var data = {
        name: name,
        price: price,
        user_id: user_id
    };

    fetch('php/insert_cart_items.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })




    // Update the cart display
    updateCartDisplay();
}

function updateCartDisplay() {
    var cartItemsElement = document.getElementById("cart-items");
    var cartTotalElement = document.getElementById("cart-total");

    // Clear the cart display
    cartItemsElement.innerHTML = "";

    // Populate the cart display with items
    cartItems.forEach(function(item) {
        var li= document.createElement("li");
        var price = parseFloat(item.price); // Convert price to a number

        // Create quantity container
        var quantityContainer = document.createElement("div");

        // Create decrease button
        var decreaseBtn = document.createElement("button");
        decreaseBtn.textContent = "-";
        decreaseBtn.classList.add("quantity-btn");
        decreaseBtn.addEventListener("click", function() {
            decreaseQuantity(item);
            updateCartDisplay();
        });
        quantityContainer.appendChild(decreaseBtn);

        // Display quantity
        var quantityText = document.createElement("span");
        quantityText.textContent = item.quantity;
        quantityContainer.appendChild(quantityText);

        // Create increase button
        var increaseBtn = document.createElement("button");
        increaseBtn.textContent = "+";
        increaseBtn.classList.add("quantity-btn");
        increaseBtn.addEventListener("click", function() {
            increaseQuantity(item);
            updateCartDisplay();
        });
        quantityContainer.appendChild(increaseBtn);

        // Display item name, price, and quantity
        li.textContent = item.name + " - $" + price.toFixed(2) + " Quantity: ";
        li.appendChild(quantityContainer);
        cartItemsElement.appendChild(li);
    });

    // Update the cart total
    cartTotalElement.textContent = cartTotal.toFixed(2);
    // Create save button
    var saveBtn = document.createElement("button");
    saveBtn.textContent = "Save";
    saveBtn.classList.add("save-btn");
    saveBtn.addEventListener("click", function() {
        saveCart();
    });

    // Add save button to the cart
    cartItemsElement.appendChild(saveBtn);
// Add the button to your HTML
    var emptyButton = document.createElement("button");
    emptyButton.textContent = "Empty Basket";
    emptyButton.addEventListener("click", emptyCart);


    cartItemsElement.appendChild(emptyButton);
}
function emptyCart() {
    // Clear the cartItems array (assuming it's a global variable)
    cartItems = [];
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '../php/cart_empty.php', true);
    xhr.setRequestHeader('Content-type', 'application/json');

    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                // Cart emptied successfully
                console.log('Cart emptied successfully!');
                // Update the cart display or perform any other necessary actions
                updateCartDisplay();
            } else {
                // Failed to empty the cart
                console.log('Error emptying cart: ' + xhr.responseText);
            }
        }
    };

    // Send the request with the user ID
    var jwtCookie = getCookie("jwt_token");
    var data = JSON.stringify({ token: jwtCookie });
    xhr.send(data);
    // Update the cart display
    updateCartDisplay();
}

function saveCart() {
    // Make an AJAX request to a PHP script that modifies the database
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../php/cart_update.php", true);
    xhr.setRequestHeader("Content-Type", "application/json");

    var jwtCookie = getCookie("jwt_token");

    // Add the user_id to the cartItems data
    var cartItemsWithUserId = { "cartItems": cartItems, "token": jwtCookie };

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Handle the response from the server if needed
            console.log(xhr.responseText);
        }
    };

    xhr.send(JSON.stringify(cartItemsWithUserId));
}
function getCookie(name) {
    var cookieArray = document.cookie.split(';');
    for (var i = 0; i < cookieArray.length; i++) {
        var cookie = cookieArray[i].trim();
        if (cookie.indexOf(name + '=') === 0) {
            var cookieValue = cookie.substring(name.length + 1); // Extract the value part of the cookie
            return cookieValue;
        }
    }
    return "";
}

// Function to decrease quantity
function decreaseQuantity(item) {
    if (item.quantity > 1) {
        item.quantity--;
        cartTotal -= parseFloat(item.price);
    }
}

// Function to increase quantity
function increaseQuantity(item) {
    item.quantity++;
    cartTotal += parseFloat(item.price);
}

function toggleCartWindow() {
    var cartWindow = document.getElementById("cart-window");

    if (cartWindow.style.display === "block") {
        cartWindow.style.display = "none";
    } else {
        fetchCartItems();
        cartWindow.style.display = "block";
    }
}

function fetchCartItems() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '../php/fetch_cart.php', true);

    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                // Parse the response and update the cart items
                var response = JSON.parse(xhr.responseText);
                cartItems = response.items;
                cartTotal = response.total;

                // Update the cart display
                updateCartDisplay();
            } else {
                console.error('Error: ' + xhr.status);
            }
        }
    };

    xhr.send();
}
