
// fetch('https://api.myjson.online/v1/records/e14b5978-ff2c-4db7-951a-5a127e6d1dcb')
//   .then(response => response.json())
//   .then(data => {
//     const productList = document.getElementById('product-list');
//     const searchInput = document.getElementById('search-input');
//     const allProducts = data.data;

//     allProducts.forEach(product => {
//       const productCard = document.createElement('div');
//       productCard.className = 'product-card';

//       productCard.innerHTML = `
//         <img class="product-image" src="${product.image_url}" alt="${product.name}">
//         <h2>${product.name}</h2>
//         <p>${product.description}</p>
//         <h3>£${product.price_per_day}/day</h3>
//         <button ${!product.available ? "disabled" : ""}>
//             ${product.available ? "Rent Now" : "Unavailable"}
//         </button>
//       `;

//       productList.appendChild(productCard);
//     });
//   })
//   .catch(error => console.error('Error loading JSON:', error));
// 





let allProducts = [];


document.addEventListener("DOMContentLoaded", () => { // runs a callback function whenever the page loads
  const productList = document.getElementById('product-list');
  const searchInput = document.getElementById('search-input');

  fetch('./data/products.json') // fetches a json file from a file in this folder
    .then(response => response.json())
    .then(data => {
      allProducts = data; // strore the fetched data in a variable
      renderProducts(allProducts); // renders the product on the page using the render function based on the product array passed in as an arguement
    })
    .catch(error => console.error('Failed to load JSON:', error));

  searchInput.addEventListener('input', (e) => {
    const searchTerm = e.target.value.toLowerCase();

    const filtered = allProducts.filter(product =>
      product.name.toLowerCase().includes(searchTerm) ||
      product.price.toString().includes(searchTerm) ||
      product.description.toLowerCase().includes(searchTerm)
    );

    renderProducts(filtered);
  });

  function renderProducts(products) {
    productList.innerHTML = ''; // clear old results

    products.forEach(product => {
      const productCard = document.createElement('div');
      productCard.className = 'product-card';

      productCard.innerHTML = `
        <img src="${product.image_url}" alt="${product.name}" class="product-image" />
        <h2>${product.name}</h2>
        <p>${product.description}</p>
        <h3>£${product.price_per_day}/day</h3>
        <div>
            <button ${!product.available ? "disabled" : ""}>
                ${product.available ? "Rent Now" : "Unavailable"}
            </button>
            <button ${!product.available ? "disabled" : ""}>
                ${product.available ? "Add to Cart" : "Unavailable"}
            </button>
        </div>
      `;

      productList.appendChild(productCard);
    });
  }
});















// fetch("https://api.myjson.online/v1/records/e14b5978-ff2c-4db7-951a-5a127e6d1dcb")
// .then(res => res.json())
// .then(data => {
//     const productList = document.getElementById("product-list");
//     const searchInput = document.getElementById("search-input");
//     const allProducts = data.data;

//     // create the function
//     function renderProducts(products) {
//         productList.innerHTML = "";

//         products.forEach(product => {
//             const productCard = document.createElement("div");
//             productCard.className = "product-card";

//             productCard.innerHTML = `
//             <img class="product-image" src="${product.image_url}" alt="${product.name}">
//             <h2>${product.name}</h2>
//             <p>${product.description}</p>
//             <h3>£${product.price_per_day}/day</h3>
//             <h3>£${product.price}</h3>
//             <button ${!product.available ? "disabled" : ""}>
//                 ${product.available ? "Rent Now" : "Unavailable"}
//             </button>`

//             productList.appendChild(productCard)
//         });

//         productList.appendChild(productCard)
//     }

//     renderProducts(allProducts);
// })
// .catch(error => console.error("Error Loading JSON", error));









        // <div>
        //     <button ${!product.available ? "disabled" : ""}>
        //         ${product.available ? "Rent Now" : "Unavailable"}
        //     </button>
        //     <button ${!product.available ? "disabled" : ""}>
        //         ${product.available ? "Buy Now" : "Out of Stock"}
        //     </button>
        // </div>

// let searchInput = document.getElementById("search-input");

// searchInput.addEventListener("input", ()=> {
//     let searchText = searchInput.value.toLowerCase();

//     fetch("https://api.myjson.online/v1/records/e14b5978-ff2c-4db7-951a-5a127e6d1dcb")
//     .then(res => res.json())
//     .then(data => {
//         const products = data.data;

//         products.forEach(product => {
//             if(product.name.includes(searchText) || product.category.includes(searchText)) {
//                 productCard.style.display = "none";
//             } else {
//                 productCard.style.display = "";
//             }
//         })
//     })
// })