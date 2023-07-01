function toggleFavWindow() {
    var cartWindow = document.getElementById("fav-window");

    if (cartWindow.style.display === "block") {

        cartWindow.style.display = "none";
    } else {
        fetchFavItems();

        cartWindow.style.display = "block";
    }
}

function updateFavDisplay() {
    var cartItemsElement = document.getElementById("fav-items");
    var cartTotalElement = document.getElementById("fav-total");

    // Clear the cart display
    cartItemsElement.innerHTML = "";

    // Populate the cart display with items
    cartItems.forEach(function(item) {
        var li= document.createElement("li");

        // Create quantity container
        var quantityContainer = document.createElement("div");




        // Display item name, price, and quantity
        li.textContent = item.name;
        li.appendChild(quantityContainer);
        cartItemsElement.appendChild(li);
    });

    // Update the cart total
    // Create save button

    // Add save button to the cart


// Add the button to your HTML
    var emptyButton = document.createElement("button");
    emptyButton.textContent = "Empty Basket";
    emptyButton.setAttribute('type', 'button');
    emptyButton.addEventListener("click", emptyCartFav);
    cartItemsElement.appendChild(emptyButton);



}

function fetchFavItems() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '../php/fetch_fav.php', true);

    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                // Parse the response and update the cart items
                var response = JSON.parse(xhr.responseText);
                cartItems = response.items;
                cartTotal = response.total;

                // Update the cart display
                updateFavDisplay();
            } else {
                console.error('Error: ' + xhr.status);
            }
        }
    };

    xhr.send();
}