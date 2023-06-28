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
