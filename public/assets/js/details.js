function redirectToDetails(productId) {
    window.location.href = `details.php?id=${productId}`;
}
const loadRelatedProducts = async (productId, categoryId) => {
    try {
        const response = await fetch(`http://localhost/web_adidas_shoes/public/dao/product_dao.php?action=getProductsByCategory&category_id=${categoryId}`);
        if (!response.ok) {
            throw new Error('Failed to fetch related products');
        }
        const relatedProducts = await response.json();
        
        // Filter out the current product from the related products list
        const filteredRelatedProducts = relatedProducts.filter(product => product.product_id != productId);

        // Limit the number of related products to 4
        const limitedRelatedProducts = filteredRelatedProducts.slice(0, 4);

        const relativeProductContainer = document.getElementById('relativeProduct');
        relativeProductContainer.innerHTML = ''; // Clear previous content
        
        limitedRelatedProducts.forEach(product => {
            const card = document.createElement('div');
            card.classList.add('col-md-3');
            card.innerHTML = `
                <div onclick="redirectToDetails(${product.product_id})">
                    <img src="${product.image_url}" class="card-img-top" alt="${product.product_name}">
                    <div class="card-body">
                        <p class="card-title text-center">${product.product_name}</p>
                        <p class="card-text text-center lead font-weight-bold">${formatPrice(product.price)}</p>
                    </div>
                </div>
            `;
            relativeProductContainer.appendChild(card);
        });
    } catch (error) {
        console.error('Error fetching related products:', error);
    }
};
const loadProductDetails = async () => {
    try {
        const urlParams = new URLSearchParams(window.location.search);
        const productId = urlParams.get('id');
        if (!productId) {
            throw new Error('Product ID is missing in the URL');
        }

        const response = await fetch(`http://localhost/web_adidas_shoes/public/dao/product_dao.php?action=getProductByID&product_id=${productId}`);
        if (!response.ok) {
            throw new Error('Failed to fetch product details');
        }
        const product = await response.json();

        document.getElementById('productName').textContent = product.product_name;
        document.getElementById('productDescription').textContent = `${product.description}`;
        document.getElementById('productPrice').textContent = `${formatPrice(product.price)}`;
        document.getElementById('productImage').src = `${product.image_url}`;

        const sizeResponse = await fetch(`http://localhost/web_adidas_shoes/public/dao/product_size_dao.php?action=getProductSizesByProductID&product_id=${productId}`);
        if (!sizeResponse.ok) {
            throw new Error('Failed to fetch product sizes');
        }
        const sizes = await sizeResponse.json();

        const sizeContainer = document.querySelector('.form-group');
        sizes.forEach(size => {
            const button = document.createElement('button');
            button.textContent = size.size_value; 
            button.classList.add('button-size');
            button.id = `size-${size.size_value}`;
            button.onclick = () => selectSize(button);

            sizeContainer.appendChild(button);
        });

        // Mặc định chọn button đầu tiên
        const firstButton = document.querySelector('.button-size');
        if (firstButton) {
            firstButton.classList.add('selected');
        }

        document.getElementById('addToCartBtn').addEventListener('click', () => addToCartPageDetails(productId));
        await loadRelatedProducts(productId, product.category_id);
    } catch (error) {
        console.error('Error fetching product details:', error);
    }
};

const selectSize = (selectedButton) => {
    const buttons = document.querySelectorAll('.button-size');
    buttons.forEach(button => {
        if (button === selectedButton) {
            button.classList.add('selected');
        } else {
            button.classList.remove('selected');
        }
    });
};

const addToCartPageDetails = async (productId) => {
    try {
        const selectedButton = document.querySelector('.button-size.selected');

        if (!selectedButton) {
            alert('Vui lòng chọn kích thước.');
            return;
        }

        let cart = JSON.parse(localStorage.getItem('cart')) || {};

        cart[productId] = {
            quantity: 1,
            size: selectedButton.textContent 
        };

        localStorage.setItem('cart', JSON.stringify(cart));
        alert('Đã thêm sản phẩm vào giỏ hàng');
        loadCartItemCount();
    } catch (error) {
        console.error('Error adding item to cart:', error);
    }
};


window.onload = () => {
    loadProductDetails();
};
