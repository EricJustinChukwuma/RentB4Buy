let allProducts = [];

document.addEventListener("DOMContentLoaded", () => {
    const productList = document.getElementById('product-list');
    const searchInput = document.getElementById('search-input');

    // Fetch products from PHP API instead of static JSON
    fetch('../includes/get_products.php') 
        .then(response => response.json()) // converts response to JSON
        .then(data => {
            if (Array.isArray(data)) { // Checks if data gotten is actually an array
                allProducts = data; // reassign the value of allProducts to the data gotten from API request 
                renderProducts(allProducts); 
            } else {
                console.error("Unexpected response:", data);
            }
        })
        .catch(error => console.error('Failed to load products:', error));

    // Filter products based on search
    searchInput.addEventListener('input', (e) => {
        const searchTerm = e.target.value.toLowerCase();
        const filtered = allProducts.filter(product =>
            product.name.toLowerCase().includes(searchTerm) ||
            product.price_per_day.toString().includes(searchTerm) ||
            product.description.toLowerCase().includes(searchTerm)
        );
        renderProducts(filtered);
    });

    // Function to render products
    function renderProducts(products) {
        productList.innerHTML = '';

        products.forEach(product => {
            const productCard = document.createElement('div');
            productCard.className = 'product-card';

            productCard.innerHTML = `
                <img src="${product.product_image}" alt="${product.name}" class="product-image" />
                <h2>${product.name}</h2>
                <p>${product.description}</p>
                <h3>£${product.price_per_day}/day</h3>
                <p><strong>Available:</strong> ${product.available_qty}</p>
                <div>
                    <button class="rent-btn" type="button" data-product-id="${product.product_id}" ${!product.available_qty ? "disabled" : ""}>
                        ${product.available_qty > 0 ? "Rent Now" : "Unavailable"}
                    </button>
                    <button class="add-to-cart-btn" ${!product.available_qty ? "disabled" : ""}>
                        ${product.available_qty > 0 ? "Add to Cart" : "Unavailable"}
                    </button>
                </div>
            `;
            productList.appendChild(productCard);
        });

        // Attach event listeners for rent buttons
        document.querySelectorAll(".rent-btn").forEach(button => {
            button.addEventListener("click", function () {
                const productId = this.getAttribute("data-product-id");

                fetch("../includes/product_page_contr.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: "product_id=" + productId
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === "success") {
                        alert("Product rental being processed!");
                    } else {
                        alert(data.message || "Something went wrong.");
                    }
                })
                .catch(error => console.error("Error:", error));
            });
        });
    }
});