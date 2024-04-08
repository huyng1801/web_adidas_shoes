// Function để lấy thông tin từ query string
const getQueryParams = () => {
    const params = {};
    const queryString = window.location.search.substring(1);
    const pairs = queryString.split('&');
    pairs.forEach(pair => {
      const parts = pair.split('=');
      const key = decodeURIComponent(parts[0]);
      const value = decodeURIComponent(parts[1]);
      params[key] = value;
    });
    return params;
  };
  function redirectToDetails(productId) {
    window.location.href = `details.php?id=${productId}`;
}
// Function để gửi yêu cầu tìm kiếm đến server và hiển thị kết quả
const searchProducts = async () => {
    try {
      const queryParams = getQueryParams();
      const searchQuery = queryParams['query'];
      if (!searchQuery) {
        console.error('Missing search query');
        return;
      }
      document.getElementById('searchString').textContent = `"${searchQuery}"`;
      // Gửi yêu cầu tìm kiếm đến server
      const response = await fetch(`http://localhost/web_adidas_shoes/public/dao/product_dao.php?action=searchProduct&query=${encodeURIComponent(searchQuery)}`);
      if (!response.ok) {
        throw new Error('Failed to search for products');
      }
  
      // Lấy kết quả từ server
      const products = await response.json();
  
      // Hiển thị kết quả tìm kiếm trên trang
      const searchResultsContainer = document.querySelector('.search-results');
      searchResultsContainer.innerHTML = ''; // Xóa nội dung cũ trước khi hiển thị kết quả mới
  
      if (products.length === 0) {
        searchResultsContainer.innerHTML = '<p>Không tìm thấy kết quả nào.</p>';
      } else {
        let row; // Biến để lưu trữ hàng (row) hiện tại
        products.forEach((product, index) => {
          if (index % 4 === 0) {
            // Nếu là sản phẩm đầu tiên của hàng mới, tạo một hàng mới
            row = document.createElement('div');
            row.classList.add('row', 'mb-3');
            searchResultsContainer.appendChild(row);
          }
  
          // Tạo một card sản phẩm
          const productCard = document.createElement('div');
          productCard.classList.add('col-md-3');
  
          productCard.innerHTML = `<div onclick="redirectToDetails(${product.product_id})">
          <img src="${product.image_url}" class="card-img-top" alt="${product.product_name}">
          <div class="card-body">
              <p class="card-title text-center">${product.product_name}</p>
              <p class="card-text text-center lead font-weight-bold">${formatPrice(product.price)}</p>
          </div>
          </div>
      `;
  
          // Thêm card sản phẩm vào hàng hiện tại
          row.appendChild(productCard);
        });
      }
    } catch (error) {
      console.error('Error searching for products:', error);
    }
  };
  
  // Khi trang web được tải, gọi hàm để thực hiện tìm kiếm và hiển thị kết quả
  window.onload = searchProducts;
  