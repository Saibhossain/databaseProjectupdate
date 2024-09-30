function updateQuantity(product_id, price, change) {
    let quantityElement = document.getElementById(`quantity-${product_id}`);
    let totalPriceElement = document.getElementById(`total-price-${product_id}`);
    let currentQuantity = parseInt(quantityElement.textContent);

    console.log(`Product ID: ${product_id}, Price: ${price}, Change: ${change}, Current Quantity: ${currentQuantity}`);
    
    // Adjust the quantity
    let newQuantity = currentQuantity + change;
    if (newQuantity < 1) {
        newQuantity = 1; // Prevent negative or zero quantity
    }

    // Update the quantity in the frontend
    quantityElement.textContent = newQuantity;

    // Calculate the new total price
    let newTotalPrice = newQuantity * price;
    totalPriceElement.textContent = newTotalPrice.toFixed(2);

    console.log(`New Quantity: ${newQuantity}, New Total Price: ${newTotalPrice}`);

    // Send the update to the server using AJAX
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "/saibsCode/action/cart_action.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log(xhr.responseText); 
            // Optional: handle server response if needed
        }
    };
    xhr.send(`product_id=${product_id}&new_quantity=${newQuantity}`);
}
