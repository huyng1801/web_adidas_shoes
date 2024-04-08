const API_URL = 'http://localhost/web_adidas_shoes/public/dao/product_dao.php';

const categoryService = {
  getAllCategories: async () => {
    try {
      const response = await fetch(`http://localhost/web_adidas_shoes/public/dao/category_dao.php?action=getAllCategories`);
      if (!response.ok) {
        throw new Error('Không thể lấy danh sách danh mục');
      }
      const data = await response.json();
      return data;
    } catch (error) {
      console.error('Lỗi khi lấy danh sách danh mục:', error);
      throw error;
    }
  }
};

const loadCategoriesIntoDropdown = async (selectElementId, selectedCategoryId) => {
  try {
    const categories = await categoryService.getAllCategories();
  
    const selectElement = document.getElementById(selectElementId);
    selectElement.innerHTML = '';
    categories.forEach(category => {
      const option = document.createElement('option');
      option.value = category.category_id;
      option.textContent = category.category_name;
    
      if (category.category_id == selectedCategoryId) { 
        option.selected = true;
      }
      selectElement.appendChild(option);
    });
  } catch (error) {
    console.error('Lỗi khi tải danh sách danh mục vào dropdown:', error);
  }
};

$('#addProductModal').on('show.bs.modal', async () => {
  await loadCategoriesIntoDropdown('productCategory');
});

const productService = {
  getAllProducts: async () => {
    try {
      const response = await fetch(`${API_URL}?action=getAllProducts`);
      if (!response.ok) {
        throw new Error('Không thể lấy danh sách sản phẩm');
      }
      const data = await response.json();
      return data;
    } catch (error) {
      console.error('Lỗi khi lấy danh sách sản phẩm:', error);
      throw error;
    }
  },

  getProductById: async (productId) => {
    try {
      const response = await fetch(`${API_URL}?action=getProductByID&product_id=${productId}`);
      if (!response.ok) {
        throw new Error('Không thể lấy sản phẩm theo ID');
      }
      const data = await response.json();
      return data;
    } catch (error) {
      console.error('Lỗi khi lấy sản phẩm theo ID:', error);
      throw error;
    }
  },

  addProduct: async (productData) => {
    try {
      productData.append('action', 'insertProduct');
      const response = await fetch(API_URL, {
        method: 'POST',
        body: productData
      });
      if (!response.ok) {
        throw new Error('Không thể thêm sản phẩm');
      }
      const data = await response.json();
      return data;
    } catch (error) {
      console.error('Lỗi khi thêm sản phẩm:', error);
      throw error;
    }
  },

  updateProduct: async (productData) => {
    try {
    
      productData.append('action', 'updateProduct');
   
      const response = await fetch(`${API_URL}`, {
        method: 'POST',
        body: productData
      });
      if (!response.ok) {
        throw new Error('Không thể cập nhật sản phẩm');
      }
      const data = await response.json();
      return data;
    } catch (error) {
      console.error('Lỗi khi cập nhật sản phẩm:', error);
      throw error;
    }
  },

  deleteProduct: async (productId) => {
    try {
      const formData = new FormData();
      formData.append('action', 'deleteProduct');
      formData.append('product_id', productId);
      const response = await fetch(`${API_URL}`, {
        method: 'POST',
        body: formData
      });
      if (!response.ok) {
        throw new Error('Không thể xóa sản phẩm');
      }
      const data = await response.json();
      return data;
    } catch (error) {
      console.error('Lỗi khi xóa sản phẩm:', error);
      throw error;
    }
  }
};

const renderProducts = async () => {
  try {
    const products = await productService.getAllProducts();
    const productTableBody = document.getElementById('productTableBody');
    productTableBody.innerHTML = '';

    products.forEach(product => {
      const row = `
        <tr>
          <td><img src="../${product.image_url}" alt="Ảnh sản phẩm" style="max-height: 100px;"></td>
          <td>${product.product_name}</td>
          <td class="text-right">${formatPrice(product.price)}</td>
          <td>${product.category_name}</td>
          <td>
            <button class="btn btn-primary btn-sm edit-btn" onclick="handleEdit('${product.product_id}', '${product.product_name}', '${product.description}', '${product.price}', '${product.category_id}', '${product.image_url}')">Sửa</button>
            <button class="btn btn-danger btn-sm delete-btn" onclick="handleDelete('${product.product_id}')">Xóa</button>
            <button class="btn btn-info btn-sm view-size-btn" onclick="handleViewSizes('${product.product_id}')">Xem Size</button>
          </td>
        </tr>
      `;
      productTableBody.innerHTML += row;
    });
  } catch (error) {
    console.error('Lỗi khi render sản phẩm:', error);
  }
};
function formatPrice(price) {
  return price.toLocaleString('vi-VN');
}
const handleEdit = async (productId, productName, description, price, categoryId, imageUrl) => {
  document.getElementById('editProductId').value = productId;
  document.getElementById('editProductName').value = productName;
  document.getElementById('editDescription').value = description;
  document.getElementById('editPrice').value = price;
  document.getElementById('editImageUrl').value = imageUrl;
  await loadCategoriesIntoDropdown('editProductCategory', categoryId);

  $('#editProductModal').modal('show');

  const editProductForm = document.getElementById('editProductForm');
  editProductForm.onsubmit = async (event) => {
    event.preventDefault();
    const updatedProductId = document.getElementById('editProductId').value;
    const updatedProductName = document.getElementById('editProductName').value;
    const updatedDescription = document.getElementById('editDescription').value;
    const updatedPrice = document.getElementById('editPrice').value;
    const updatedCategoryId = document.getElementById('editProductCategory').value;
    const updatedImageUrl = document.getElementById('editImageUrl').value;
    const updatedImage = document.getElementById('editProductImage').files[0];
    const formData = new FormData();;
    if (updatedImage) {
      formData.append('product_id', updatedProductId);
      formData.append('product_name', updatedProductName);
      formData.append('description', updatedDescription);
      formData.append('price', updatedPrice);
      formData.append('image', updatedImage);
      formData.append('category_id', updatedCategoryId);

    } else {
      formData.append('product_id', updatedProductId);
      formData.append('product_name', updatedProductName);
      formData.append('description', updatedDescription);
      formData.append('price', updatedPrice);
      formData.append('category_id', updatedCategoryId);
      formData.append('image_url', updatedImageUrl);
    }
   
    try {
      await productService.updateProduct(formData);
      $('#editProductModal').modal('hide');
      renderProducts();
    } catch (error) {
      console.error('Lỗi khi cập nhật sản phẩm:', error);
    }
  };
};

const handleDelete = (productId) => {
  $('#deleteProductModal').modal('show');

  const confirmDeleteButton = document.getElementById('confirmDeleteButton');
  confirmDeleteButton.onclick = async () => {
    try {
      await productService.deleteProduct(productId);
      $('#deleteProductModal').modal('hide');
      renderProducts();
    } catch (error) {
      console.error('Lỗi khi xóa sản phẩm:', error);
    }
  };
};

const handleAddProduct = async (event) => {
  event.preventDefault();

  const productName = document.getElementById('productName').value;
  const productDescription = document.getElementById('productDescription').value;
  const productPrice = document.getElementById('productPrice').value;
  const productImage = document.getElementById('productImage').files[0];
  const categoryId = document.getElementById('productCategory').value;
  try {
    const formData = new FormData();
    formData.append('product_name', productName);
    formData.append('description', productDescription);
    formData.append('price', productPrice);
    formData.append('image', productImage);
    formData.append('category_id', categoryId);
    await productService.addProduct(formData);
    $('#addProductModal').modal('hide');
    renderProducts();
  } catch (error) {
    console.error('Lỗi khi thêm sản phẩm:', error);
  }
};
$('#addProductModal').on('hide.bs.modal', () => {
  document.getElementById('productName').value = '';
  document.getElementById('productDescription').value = '';
  document.getElementById('productPrice').value = '';
  document.getElementById('productImage').value = ''; 
  document.getElementById('productCategory').selectedIndex = 0; 
});
$('#editProductModal').on('hide.bs.modal', () => {
  document.getElementById('editProductId').value = '';
  document.getElementById('editProductName').value = '';
  document.getElementById('editDescription').value = '';
  document.getElementById('editPrice').value = 0;
  document.getElementById('editProductForm').reset(); 
  document.getElementById('editImageUrl').value = '';
});

const handleAddSize = async (event) => {
  event.preventDefault();
  const productId = document.getElementById('productIdForSize').value;
  const sizeValue = document.getElementById('sizeValue').value;

  try {
    const response = await fetch("http://localhost/web_adidas_shoes/public/dao/product_size_dao.php", {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        action: 'insertProductSize',
        product_id: productId,
        size_value: sizeValue
      })
    });

    if (!response.ok) {
      throw new Error('Không thể thêm size sản phẩm');
    }

    const data = await response.json();
    console.log('Size mới đã được thêm:', data);
    renderProductSizes(productId);
  } catch (error) {
    console.error('Lỗi khi thêm size sản phẩm:', error);
  }
};



const handleDeleteSize = async (sizeId, productId) => {
  try {
    const response = await fetch("http://localhost/web_adidas_shoes/public/dao/product_size_dao.php", {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        action: 'deleteProductSize', 
        product_size_id: sizeId
      })
    });
    if (!response.ok) {
      throw new Error('Không thể xóa size sản phẩm');
    }

    const data = await response.json();
    console.log('Size đã được xóa:', data);
    renderProductSizes(productId);
  } catch (error) {
    console.error('Lỗi khi xóa size sản phẩm:', error);
  }
};

const renderProductSizes = async (productId) => {
  try {
    console.log(productId);
    const response = await fetch(`http://localhost/web_adidas_shoes/public/dao/product_size_dao.php?action=getProductSizesByProductID&product_id=${productId}`);

    if (!response.ok) {
      throw new Error('Không thể lấy danh sách size sản phẩm');
    }

    const sizes = await response.json();
    const productSizeList = document.getElementById('productSizeList');
    productSizeList.innerHTML = ''; 

    sizes.forEach(size => {
      const listItem = document.createElement('li');
      listItem.textContent = size.size_value;

      const deleteButton = document.createElement('button');
      deleteButton.textContent = 'x';
      deleteButton.classList.add('delete-size-btn', 'btn', 'text-danger', 'btn-sm');
      deleteButton.dataset.sizeId = size.product_size_id;

      listItem.appendChild(deleteButton);
      productSizeList.appendChild(listItem);

      deleteButton.addEventListener('click', async () => {
        await handleDeleteSize(size.product_size_id, size.product_id);
      });
    });

  } catch (error) {
    console.error('Lỗi khi lấy danh sách size sản phẩm:', error);
  }
};




const handleViewSizes = async (productId) => {
  $('#productIdForSize').val(productId); 
  $('#sizeModal').modal('show');
 
  await renderProductSizes(productId);
};

$('#addSizeForm').on('submit', handleAddSize);

$('#productSizeList').on('click', '.delete-size-btn', function () {
  const sizeId = $(this).data('size-id');
});

const addProductForm = document.getElementById('addProductForm');
addProductForm.addEventListener('submit', handleAddProduct);

window.onload = () => {
  renderProducts();
};
