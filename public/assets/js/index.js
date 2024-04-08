function redirectToDetails(productId) {
    window.location.href = `details.php?id=${productId}`;
}

const getCategoriesWithProducts = async () => {
    try {
        const response = await fetch('http://localhost/web_adidas_shoes/public/dao/category_dao.php?action=getCategoriesWithProducts');
        if (!response.ok) {
            throw new Error('Failed to fetch products by category');
        }
        const categories = await response.json();
        const productsContainer = document.getElementById('content');
        
        if (typeof categories !== 'object' || categories === null) {
            throw new Error('Invalid data format for categories');
        }

        for (const categoryID in categories) {
            if (categories.hasOwnProperty(categoryID)) {
                const category = categories[categoryID];
                
                const section = document.createElement('section');
                section.classList.add('category-section', 'mt-4');
                
                const categoryTitle = document.createElement('h2');
                categoryTitle.textContent = category.category_name;
                section.appendChild(categoryTitle);
                
                const hrElement = document.createElement('hr');
                section.appendChild(hrElement);
                
                const productContainer = document.createElement('div');
                productContainer.classList.add('row');

                category.products.forEach(product => {
                    const card = document.createElement('div');
                    card.classList.add('col-md-4', 'mb-3');
                    card.innerHTML = `<div onclick="redirectToDetails(${product.product_id})">
                    <img src="${product.image_url}" class="card-img-top" alt="${product.product_name}">
                    <div class="card-body">
                        <p class="card-title text-center">${product.product_name}</p>
                        <p class="card-text text-center lead font-weight-bold">${formatPrice(product.price)}</p>
                    </div>
                    </div>
                `;
                    productContainer.appendChild(card);
                });

                section.appendChild(productContainer);
                productsContainer.appendChild(section);
            }
        }

    } catch (error) {
        console.error('Error fetching products by category:', error);
    }
};

getCategoriesWithProducts();

