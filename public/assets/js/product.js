let allProducts = [];
function redirectToDetails(productId) {
    window.location.href = `details.php?id=${productId}`;
}
const loadCategoryName = async (categoryId) => {
    try {
        if (categoryId === 'all') {
            document.getElementById('currentCategory').textContent = 'Tất cả';
        } else {
 
            const response = await fetch(`http://localhost/web_adidas_shoes/public/dao/category_dao.php?action=getCategoryByID&category_id=${categoryId}`);
            if (!response.ok) {
                throw new Error('Failed to fetch category');
            }


            const category = await response.json();
            document.getElementById('currentCategory').textContent = category.category_name;
        }
    } catch (error) {
        console.error('Error fetching category name:', error);
    }
};
const loadProductsByCategory = async (categoryId) => {
    try {
        let url;
        if (categoryId === 'all') {
            url = 'http://localhost/web_adidas_shoes/public/dao/product_dao.php?action=getAllProducts';
        } else {
            url = `http://localhost/web_adidas_shoes/public/dao/product_dao.php?action=getProductsByCategory&category_id=${categoryId}`;
        }

        const response = await fetch(url);
        if (!response.ok) {
            throw new Error('Failed to fetch products');
        }
        const products = await response.json();
        productsData = products; // Lưu trữ danh sách sản phẩm vào biến productsData
        renderProducts(products); // Hiển thị sản phẩm ban đầu
    } catch (error) {
        console.error('Error fetching products:', error);
    }
};

const handleSortChange = (value) => {
    switch (value) {
        case 'az':
            // Sắp xếp theo A-Z
            productsData.sort((a, b) => a.product_name.localeCompare(b.product_name));
            break;
        case 'za':
            // Sắp xếp theo Z-A
            productsData.sort((a, b) => b.product_name.localeCompare(a.product_name));
            break;
        case 'priceAsc':
            // Sắp xếp theo giá tăng dần
            productsData.sort((a, b) => a.price - b.price);
            break;
        case 'priceDesc':
            // Sắp xếp theo giá giảm dần
            productsData.sort((a, b) => b.price - a.price);
            break;
        case 'default':
            // Sắp xếp theo mặc định, sử dụng lại danh sách sản phẩm ban đầu
            renderProducts(productsData);
            return;
    }
    renderProducts(productsData); // Hiển thị danh sách sản phẩm sau khi sắp xếp
};

const renderProducts = (products) => {
    const content = document.getElementById('content');
    content.innerHTML = ''; 
    // Tạo hàng và thêm sản phẩm vào hàng
    let row;
    products.forEach((product, index) => {
        if (index % 4 === 0) {
            row = document.createElement('div');
            row.classList.add('row', 'row-cols-1', 'row-cols-md-3', 'g-3');
            content.appendChild(row);
        }
        
        const card = document.createElement('div');
        card.classList.add('col-md-3');
        card.innerHTML = `<div onclick="redirectToDetails(${product.product_id})">
            <img src="${product.image_url}" class="card-img-top" alt="${product.product_name}">
            <div class="card-body">
                <p class="card-title text-center">${product.product_name}</p>
                <p class="card-text text-center lead font-weight-bold">${formatPrice(product.price)}</p>
            </div>
            </div>
        `;
        row.appendChild(card);
    });
};

const sortProducts = (order) => {
    const sortedProducts = [...allProducts]; // Tạo bản sao của danh sách sản phẩm
    sortedProducts.sort((a, b) => {
        // Thực hiện sắp xếp theo thứ tự A-Z hoặc Z-A
        if (order === 'asc') {
            return a.product_name.localeCompare(b.product_name);
        } else {
            return b.product_name.localeCompare(a.product_name);
        }
    });
    renderProducts(sortedProducts);
};

const sortProductsByPrice = (order) => {
    const sortedProducts = [...allProducts]; // Tạo bản sao của danh sách sản phẩm
    sortedProducts.sort((a, b) => {
        // Thực hiện sắp xếp theo giá tăng dần hoặc giảm dần
        if (order === 'asc') {
            return a.price - b.price;
        } else {
            return b.price - a.price;
        }
    });
    renderProducts(sortedProducts);
};

document.addEventListener("DOMContentLoaded", function() {

    const urlParams = new URLSearchParams(window.location.search);
    const categoryId = urlParams.get('category_id');
    loadProductsByCategory(categoryId);

    loadCategoryName(categoryId);
});