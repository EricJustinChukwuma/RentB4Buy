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
            let count = 0;

            productCard.innerHTML = `
                <img src="${product.product_image}" alt="${product.product_name}" class="product-image" />
                <h2>${product.product_name}</h2>
                <p>${product.description}</p>
                <h3>£${product.price_per_day}/day</h3>
                <p><strong>Available:</strong> ${product.available_qty}</p>
                <div class="counter-div">
                    <span class="minus-product" type="button" >-</span>
                    <span class="product-count">${count}</span>
                    <span class="add-product" type="button" >+</span>
                </div>
                <div>
                    <button class="rent-btn" type="button" data-product-id="${product.product_id}" data-product-price="${product.price}" ${!product.available_qty ? "disabled" : ""}>
                        ${product.available_qty > 0 ? "Rent Now" : "Unavailable"}
                    </button>
                    <button class="add-to-cart-btn" data-product-id="${product.product_id}" data-product-image="${product.product_image}" data-product-price="${product.price}" ${!product.available_qty ? "disabled" : ""}>
                        ${product.available_qty > 0 ? "Add to Cart" : "Unavailable"}
                    </button>
                </div>
            `;
            productList.appendChild(productCard);

            // Counter logic for each product
            const productCount = productCard.querySelector(".product-count");
            const minusBtn = productCard.querySelector(".minus-product");
            const addBtn = productCard.querySelector(".add-product");

            addBtn.addEventListener("click", function() {
                if (count < product.available_qty) {
                    count++;
                productCount.innerHTML = count;
                } else {
                    alert("Avalaible product quantity exceeded")
                }
            });

            minusBtn.addEventListener("click", function() {
                if (count > 0) {
                    count--;
                    productCount.innerHTML = count;
                }
            });
        });



        // RENTAL FUNCTIONALITY
        // Attach event listeners for rent buttons
        document.querySelectorAll(".rent-btn").forEach(button => {
            button.addEventListener("click", function () {
                // gets the attribute from the body element in the product page and checks if it's equal to true
                const isLoggedIn = document.body.getAttribute("data-logged-in") === "true";  
        
                // if 'isLoggedIn' is not equal to true then alert the user they need to log in and redirects them to the login page
                if (!isLoggedIn) {
                    alert("You must log in to rent a product.");
                    window.location.href = "../Login.php"; // Redirect to login page
                    return;
                } 
                // else {
                //     // window.location.href = "../Checkout_rental.php";
                // }
        
                const productId = this.getAttribute("data-product-id");
                console.log("Product ID sent:", productId);

                // const productId = this.getAttribute("data-product-id");
                window.location.href = `checkout.php?product_id=${productId}`;
        
                // fetch("../includes/product_page_contr.php", {
                //     method: "POST",
                //     headers: { "Content-Type": "application/json" },
                //     body: JSON.stringify({ product_id: productId })
                // })
                // .then(response => response.json())
                // .then(data => {
                //     alert(data.message);
                // })
                // .catch(error => console.error("Error:", error));
            });
        });



        // ADD TO CART FUNCTIONALITY
        document.querySelectorAll(".add-to-cart-btn").forEach(button => {
            button.addEventListener("click", function () {
                const productId = parseInt(this.getAttribute("data-product-id"));
                const selectedQuantity = parseInt(
                    this.closest(".product-card").querySelector(".product-count").innerText
                ) || 1;

                const isLoggedIn = document.body.getAttribute("data-logged-in") === "true"; 
                
                if (!isLoggedIn) {
                    alert("You must log in to add items to the cart.");
                    window.location.href = "../Login.php"; 
                    return;
                }

                // Send product details to cart_handler.php
                fetch("../includes/cart_handler.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: selectedQuantity
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log("Server Response:", data); // Debug
                    if (data.status === "success") {
                        alert(`Added ${selectedQuantity} item(s) to cart!`);
                    } else {
                        alert(data.message || "Something went wrong.");
                    }
                })
                .catch(error => {
                    console.error("Fetch Error:", error);
                    alert("Error adding product to cart. Check console for details.");
                });
            });
        });


        // ADD TO CART FUNCTIONALITY
        // document.querySelectorAll(".add-to-cart-btn").forEach(button => {
        //     button.addEventListener("click", function() {
        //         const productId = this.getAttribute("data-product-id");
        //         const selectedQuantity =  parseInt(this.closest(".product-card").querySelector(".product-count").innerText) || 1;

        //         /* This 3 lines need to be taken out once bug id fixed */
        //         // const productImg =  this.getAttribute("data-product-image");
        //         // const productName = this.closest(".product-card").querySelector("h2").innerText;
        //         // const productPrice = this.getAttribute("data-product-price");


        //         const isLoggedIn = document.body.getAttribute("data-logged-in") === "true"; 
                
        //         // if 'isLoggedIn' is not equal to true then alert the user they need to log in and redirects them to the login page
        //         if (!isLoggedIn) {
        //             alert("You must log in to add items to the cart.");
        //             window.location.href = "../Login.php"; // Redirect to login page
        //             return;
        //         } 
        //         // else {
        //         //     // window.location.href = "../Checkout_rental.php";
        //         // }
        
        //         if (selectedQuantity > 0) {
        //             // SEND A POST REQUEST TO THE PHP FILE
        //             fetch("../includes/cart_handler.php", {
        //                 method: "POST",
        //                 headers: {
        //                     "Content-Type": "application/json"
        //                 },
        //                 body: JSON.stringify({
        //                     product_id: parseInt(productId),
        //                     quantity: selectedQuantity,
        //                 })
        //             })
        //             .then(response => response.json())
        //             .then(data => {
        //                 if (data.status === "success") {
        //                     alert("Product added to cart!");
        //                 } else {
        //                     alert(data.message || "Something went wrong.");
        //                 }
        //                 console.log("raw data", data)
        //             })
        //             .catch(error => console.log("Error:", error));
        //         } else {
        //             alert("Please choose a product amount")
        //         }
        //     });
        // });

    }
});