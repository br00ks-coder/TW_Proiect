function toggleFavWindow() {
    let cartWindow = document.getElementById("fav-window");

    if (cartWindow.style.display === "block") {

        cartWindow.style.display = "none";
    } else {
        fetchFavItems();

        cartWindow.style.display = "block";
    }
}

function updateFavDisplay() {
    let cartItemsElement = document.getElementById("fav-items");
    let cartTotalElement = document.getElementById("fav-total");

    // Clear the cart display
    cartItemsElement.innerHTML = "";

    // Populate the cart display with items
    cartItems.forEach(function (item) {
        let li = document.createElement("li");

        // Create quantity container
        let quantityContainer = document.createElement("div");


        // Display item name, price, and quantity
        li.textContent = item.name;
        li.appendChild(quantityContainer);
        cartItemsElement.appendChild(li);
    });

    // Update the cart total
    // Create save button

    // Add save button to the cart


// Add the button to your HTML
    let emptyButton = document.createElement("button");
    emptyButton.textContent = "Empty Basket";
    emptyButton.setAttribute('type', 'button');
    emptyButton.addEventListener("click", emptyCartFav);
    cartItemsElement.appendChild(emptyButton);


}

function fetchFavItems() {
    let xhr = new XMLHttpRequest();
    xhr.open('GET', '../php/fetch_fav.php', true);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                // Parse the response and update the cart items
                let response = JSON.parse(xhr.responseText);
                this.cartItems = response.items;
                this.cartTotal = response.total;

                // Update the cart display
                updateFavDisplay();
            } else {
                console.error('Error: ' + xhr.status);
            }
        }
    };

    xhr.send();
}