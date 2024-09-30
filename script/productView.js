function displayProduct(product, reviews) {
    // Select the product container where details will be shown
    const productContainer = document.getElementById('product-container');

    // Create a wrapper div for the product details
    const productDetails = document.createElement('div');
    productDetails.className = 'product-details';

    // Create the image element (enlarged)
    const productImage = document.createElement('img');
    productImage.src = product.img_url;
    productImage.alt = product.product_name;
    productImage.className = 'product-image-large';

    // Create the product name element
    const productName = document.createElement('h3');
    productName.textContent = product.product_name;

    // Create the price element
    const productPrice = document.createElement('p');
    productPrice.textContent = `Price: $${product.price.toFixed(2)}`;

    // Create the description element
    const productDescription = document.createElement('p');
    productDescription.textContent = product.description;

    // Create a container for reviews
    const reviewContainer = document.createElement('div');
    reviewContainer.className = 'review-container';

    // Add a title for reviews
    const reviewTitle = document.createElement('h4');
    reviewTitle.textContent = 'Customer Reviews:';
    reviewContainer.appendChild(reviewTitle);

    // Loop through the reviews and add them
    reviews.forEach(review => {
        const reviewItem = document.createElement('div');
        reviewItem.className = 'review-item';

        // Display reviewer name and comment
        const reviewerName = document.createElement('p');
        reviewerName.className = 'reviewer-name';
        reviewerName.textContent = review.reviewer_name;

        const reviewComment = document.createElement('p');
        reviewComment.className = 'review-comment';
        reviewComment.textContent = review.comment;

        // Create a star rating (assuming review.rating is a number between 1 and 5)
        const reviewRating = document.createElement('div');
        reviewRating.className = 'review-rating';
        for (let i = 0; i < 5; i++) {
            const star = document.createElement('span');
            star.className = i < review.rating ? 'star filled' : 'star';
            reviewRating.appendChild(star);
        }

        // Append the review details
        reviewItem.appendChild(reviewerName);
        reviewItem.appendChild(reviewComment);
        reviewItem.appendChild(reviewRating);
        reviewContainer.appendChild(reviewItem);
    });

    // Append everything to the product details container
    productDetails.appendChild(productImage);
    productDetails.appendChild(productName);
    productDetails.appendChild(productPrice);
    productDetails.appendChild(productDescription);
    productDetails.appendChild(reviewContainer);

    // Append the product details to the main container
    productContainer.appendChild(productDetails);
}
