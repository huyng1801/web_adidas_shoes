// checkout.js

document.getElementById('checkoutForm').addEventListener('submit', async function(event) {
    event.preventDefault();
    const action = "insertOrder";
    const customerName = document.getElementById('customerName').value;
    const phoneNumber = document.getElementById('phoneNumber').value;
    const email = document.getElementById('email').value;
    const city = document.getElementById('city').value;
    const district = document.getElementById('district').value;
    const address = document.getElementById('address').value;
    const note = document.getElementById('note').value;
    try {
        const cart = JSON.parse(localStorage.getItem('cart')) || {};

        if (Object.keys(cart).length === 0) {
            alert('Giỏ hàng của bạn đang trống.');
            return;
        }
        
        const order_details = Object.keys(cart).map(productId => {
            return {
                product_id: productId,
                quantity: cart[productId].quantity,
                size_value: cart[productId].size
            };
        });

        const status = 'Chờ xử lý'; 
        const data = {
            action: action,
            customer_name: customerName,
            phone_number: phoneNumber,
            email: email,
            city: city,
            district: district,
            address: address,
            note: note,
            status: status,
            order_details: order_details
        };
        console.log(data);
        // Send combined data to the server
        const response = await fetch('http://localhost/web_adidas_shoes/public/dao/order_dao.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });

        if (!response.ok) {
            throw new Error('Failed to add order');
        }
        console.log(response);
        localStorage.removeItem('cart');
        loadCartItemCount();
        alert('Đơn hàng đã được đặt thành công!');
        window.location.href = "cart.php";
    } catch (error) {
        console.error('Error during checkout:', error);
        alert('Đã xảy ra lỗi khi đặt hàng. Vui lòng thử lại sau.');
    }
});
