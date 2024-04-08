const API_URL = 'http://localhost/web_adidas_shoes/public/dao/category_dao.php';

const categoryService = {
  getAllCategories: async () => {
    try {
      const response = await fetch(API_URL + '?action=getAllCategories');
      if (!response.ok) {
        throw new Error('Failed to get categories');
      }
      const data = await response.json();
      return data;
    } catch (error) {
      console.error('Error getting categories:', error);
      throw error;
    }
  },

  addCategory: async (category_name) => {
    try {
      const response = await fetch(API_URL, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({ action: 'insertCategory', category_name: category_name })

      });
      if (!response.ok) {
        throw new Error('Failed to add category');
      }
      const data = await response.json();
      return data;
    } catch (error) {
      console.error('Error adding category:', error);
      throw error;
    }
  },

  updateCategory: async (category_id, category_name) => {
    try {
      const response = await fetch(API_URL, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({ action: 'updateCategory', category_id: category_id, category_name: category_name })
      });
      if (!response.ok) {
        throw new Error('Failed to update category');
      }
      
      const data = await response.json();
    
      return data;
    } catch (error) {
      console.error('Error updating category:', error);
      throw error;
    }
  },

  deleteCategory: async (category_id) => {
    try {
      const response = await fetch(API_URL, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({ action: 'deleteCategory', category_id: category_id })
      });
      if (!response.ok) {
        throw new Error('Failed to delete category');
      }
      const data = await response.json();
      return data;
    } catch (error) {
      console.error('Error deleting category:', error);
      throw error;
    }
  }
};

// Rest of the code remains the same


const renderCategories = async () => {
  try {
    const categories = await categoryService.getAllCategories();
    displayCategories(categories);
  } catch (error) {
    console.error('Error fetching categories:', error);
  }
};

const displayCategories = (categories) => {
  const categoryTableBody = document.getElementById('categoryTableBody');
  categoryTableBody.innerHTML = '';
  categories.forEach(category => {
    const row = `
      <tr>
        <td>${category.category_id}</td>
        <td>${category.category_name}</td>
        <td class="text-center">${category.product_count}</td>
        <td>
          <button class="btn btn-primary btn-sm edit-btn" onclick="handleEdit(${category.category_id}, '${category.category_name}')">Sửa</button>
          <button class="btn btn-danger btn-sm delete-btn" onclick="handleDelete(${category.category_id})">Xóa</button>
        </td>
      </tr>
    `;
    categoryTableBody.innerHTML += row;
  });
};

const addCategory = async (categoryName) => {
  try {
    await categoryService.addCategory(categoryName);
    $('#addCategoryModal').modal('hide');
    renderCategories();
  } catch (error) {
    $('#addCategoryModal').modal('hide');
    console.error('Error adding category:', error);
  }
};

const addCategoryForm = document.getElementById('addCategoryForm');
addCategoryForm.addEventListener('submit', async (e) => {
  e.preventDefault();
  const categoryName = document.getElementById('categoryName').value;
  addCategory(categoryName);
});
const handleEdit = async (categoryId, categoryName) => {
  try {
    document.getElementById('editCategoryId').value = categoryId;
    document.getElementById('editCategoryName').value = categoryName;
    $('#editCategoryModal').modal('show');
    
    const editCategoryForm = document.getElementById('editCategoryForm');
    editCategoryForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      await confirmEdit();
    });
  } catch (error) {
    console.error('Error updating category:', error);
  }
};

const confirmEdit = async () => {
  try {
    const categoryId = document.getElementById('editCategoryId').value;
    const updatedCategoryName = document.getElementById('editCategoryName').value;
    await categoryService.updateCategory(categoryId, updatedCategoryName);
    $('#editCategoryModal').modal('hide');
    renderCategories();
  } catch (error) {
    $('#editCategoryModal').modal('hide');
    console.error('Error updating category:', error);
  }
};

const handleDelete = async (categoryId) => {
  try {
    $('#deleteCategoryModal').modal('show');
    const confirmButton = document.getElementById('confirmDeleteButton');
    // Xác định sự kiện khi nút đồng ý được nhấn
    confirmButton.addEventListener('click', async () => {
      await categoryService.deleteCategory(categoryId);
      $('#deleteCategoryModal').modal('hide');
      renderCategories();
    });
  } catch (error) {
    $('#deleteCategoryModal').modal('hide');
    console.error('Error deleting category:', error);
    
  }
};


window.onload = renderCategories;
