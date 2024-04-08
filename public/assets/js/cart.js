
const removeFromCart = (productId) => {
    try {
        let cart = JSON.parse(localStorage.getItem('cart')) || {};
        delete cart[productId];
        localStorage.setItem('cart', JSON.stringify(cart));
        loadCartItems();
        loadCartItemCount();
        calculateTotal();
    } catch (error) {
        console.error('Error removing item from cart:', error);
    }
};

const increaseQuantity = (productId) => {
    try {
        let cart = JSON.parse(localStorage.getItem('cart')) || {};

        cart[productId] = (cart[productId].quantity || 0) + 1;

        localStorage.setItem('cart', JSON.stringify(cart));

    } catch (error) {
        console.error('Error increasing quantity:', error);
    }
};

const decreaseQuantity = (productId) => {
    try {
        let cart = JSON.parse(localStorage.getItem('cart')) || {};
        cart[productId] = Math.max(1, (cart[productId].quantity || 0) - 1);

        localStorage.setItem('cart', JSON.stringify(cart));
    } catch (error) {
        console.error('Error decreasing quantity:', error);
    }
};
const updateQuantity = (productId, newQuantity) => {
    try {
        let cart = JSON.parse(localStorage.getItem('cart')) || {};
        cart[productId].quantity = newQuantity;
        localStorage.setItem('cart', JSON.stringify(cart));

    } catch (error) {
        console.error('Error updating quantity:', error);
    }
};

const calculateTotal = async () => {
    try {
        let totalAmount = 0;
        const cart = JSON.parse(localStorage.getItem('cart')) || {};
        for (const productId of Object.keys(cart)) {
            const product = await getProductById(productId);
            const quantity = cart[productId].quantity;
            const subtotal = product.price * quantity;
            totalAmount += subtotal;
        }
  
        const totalAmountElement = document.getElementById('totalAmount');
        totalAmountElement.innerHTML = `
        <td colspan="5" class="text-end font-weight-bold lead">Tổng cộng:</td>
        <td class="font-weight-bold lead">${formatPrice(totalAmount)}</td>
        <td></td>
    `;
    } catch (error) {
        console.error('Error calculating total:', error);
    }
};

const loadCartItems = async () => {
    try {
        const cart = JSON.parse(localStorage.getItem('cart')) || {};
        const cartItemsContainer = document.getElementById('cartItems');
        cartItemsContainer.innerHTML = ''; 

        if (Object.keys(cart).length === 0) {
            const emptyCartMessage = document.createElement('h3');
            emptyCartMessage.textContent = 'Giỏ hàng của bạn đang trống.';
            cartItemsContainer.appendChild(emptyCartMessage);
            const checkoutBtn = document.getElementById('checkoutBtn');
            checkoutBtn.style.display = 'none';
            return;
        }
        const table = document.createElement('table');
        table.classList.add('table', 'table', 'mt-3');
        const tableHead = document.createElement('thead');
        tableHead.innerHTML = `
            <tr>
                <th colspan="2" scope="col">Sản phẩm</th>
                <th scope="col">Kích cỡ</th>
                <th scope="col">Giá</th>
                <th scope="col">Số lượng</th>
                <th scope="col">Thành tiền</th>
                <th scope="col">Thao tác</th>
            </tr>
        `;
        table.appendChild(tableHead);
        const tableBody = document.createElement('tbody');

        let totalAmount = 0;
        console.log(cart);
        for (const productId of Object.keys(cart)) {
            const product = await getProductById(productId);
            const size = cart[productId].size;
            let quantity = cart[productId].quantity;
            const subtotal = product.price * quantity;
            totalAmount += subtotal;

            const row = document.createElement('tr');
            const imgCell = document.createElement('td');
            const img = document.createElement('img');
            img.src = `${product.image_url}`;
            img.alt = product.product_name;
            img.classList.add('img-thumbnail');
            img.style.maxHeight = '100px'; 
            imgCell.appendChild(img);
            row.appendChild(imgCell);

            const nameCell = document.createElement('td');
            nameCell.textContent = product.product_name;
            row.appendChild(nameCell);

            const sizeCell = document.createElement('td');
            sizeCell.textContent = size;
            row.appendChild(sizeCell);

            const priceCell = document.createElement('td');
            priceCell.textContent = formatPrice(product.price);
            row.appendChild(priceCell);

            const quantityCell = document.createElement('td');
            const quantityInput = document.createElement('input');
            quantityInput.type = 'number';
            quantityInput.value = quantity;
            quantityInput.min = '1';
            quantityInput.addEventListener('input', () => {
                quantity = parseInt(quantityInput.value);
                updateQuantity(productId, quantity); 
                calculateTotal();
                subtotalCell.textContent = formatPrice(product.price * quantity); 
            });
            
            quantityCell.appendChild(quantityInput);
            row.appendChild(quantityCell);

            const subtotalCell = document.createElement('td');
            subtotalCell.textContent = formatPrice(subtotal);
            row.appendChild(subtotalCell);

            const removeCell = document.createElement('td');
            const removeBtn = document.createElement('button');
            removeBtn.classList.add('btn', 'btn-transparent');

            removeBtn.textContent = 'Xóa';
            removeBtn.addEventListener('click', () => removeFromCart(productId));
            removeCell.appendChild(removeBtn);
            row.appendChild(removeCell);

            tableBody.appendChild(row);
        }

        const totalRow = document.createElement('tr');
        totalRow.id = 'totalAmount';

        tableBody.appendChild(totalRow);

        table.appendChild(tableBody);
        cartItemsContainer.appendChild(table);

        const checkoutBtn = document.getElementById('checkoutBtn');
        checkoutBtn.style.display = 'block';
        calculateTotal();
    } catch (error) {
        console.error('Error loading cart items:', error);
    }
};


const getProductById = async (productId) => {
    try {
        const response = await fetch(`http://localhost/web_adidas_shoes/public/dao/product_dao.php?action=getProductByID&product_id=${productId}`);
        if (!response.ok) {
            throw new Error('Failed to fetch product details');
        }
        const product = await response.json();
        return product;
    } catch (error) {
        console.error('Error fetching product details:', error);
    }
};
const checkout = async () => {
   window.location.href = 'checkout.php';
};

window.onload = () => {
    loadCartItems();
    loadCartItemCount();

       const checkoutBtn = document.getElementById('checkoutBtn');
       checkoutBtn.addEventListener('click', checkout);
};
