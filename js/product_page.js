let allProducts = [];


document.addEventListener("DOMContentLoaded", () => { // runs a callback function whenever the page loads
    const productList = document.getElementById('product-list');
    const searchInput = document.getElementById('search-input');

    fetch('./data/products.json') // fetches a json file from a file in this folder
        .then(response => response.json()) // converts the response pay load to JSON
        .then(data => {
        allProducts = data; // strore the fetched data in a variable
        renderProducts(allProducts); // renders the product on the page using the render function based on the product array passed in as an arguement
        })
        .catch(error => console.error('Failed to load JSON:', error)); // catches the error

    // Add event listener when the user types in the input field
    searchInput.addEventListener('input', (e) => {
        const searchTerm = e.target.value.toLowerCase(); // creates a variable and assign the value as the input text from the user

        // Filters the allProducts array containing the data from the fetch result
        const filtered = allProducts.filter(product =>
        product.name.toLowerCase().includes(searchTerm) ||
        product.price.toString().includes(searchTerm) ||
        product.description.toLowerCase().includes(searchTerm)
        );

        renderProducts(filtered); // calls the renderProducts() function and pass in the filtered data as the argument
    });

    // The renderProducts() function run takes a parameter
    // 
    function renderProducts(products) {
        productList.innerHTML = ''; // clear old results from the div with a class name of productList

        // loops throught the products parameter and runs a callback function for each of the element in the array
        products.forEach(product => {
        const productCard = document.createElement('div'); // creates a new element div
        productCard.className = 'product-card'; // gives the new element a class name called 'product-card'

        // populate and create a div with a class of product-card for each element of the products parameter array.
        productCard.innerHTML = `
            <img src="${product.image_url}" alt="${product.name}" class="product-image" />
            <h2>${product.name}</h2>
            <p>${product.description}</p>
            <h3>£${product.price_per_day}/day</h3>
            <div>
                <button class="rent-btn" name="rent-btn" type="submit" data-product-id="${product.id}" ${!product.available ? "disabled" : ""}>
                    ${product.available ? "Rent Now" : "Unavailable"}
                </button>
                <button id="add-to-cart-btn" ${!product.available ? "disabled" : ""}>
                    ${product.available ? "Add to Cart" : "Unavailable"}
                </button>
            </div>
            `;

            productList.appendChild(productCard);
        });

        // rent now functionality
        const rentBtn = document.querySelectorAll(".rent-btn");

        rentBtn.forEach(button => {
            button.addEventListener("click", (e) => {
                const productId = e.target.dataset.productId;

                // Send the ID to your PHP handler
                fetch("../includes/product_page_contr.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                    },
                    body: `product_id=${productId}`
                })
                .then(res => res.text())
                .then(data => {
                    console.log("Server says:", data);
                    alert("Rental Request Sent!");
                })
                .catch(error => console.error("Fetch error:", error))
            })
        })
    }
});




