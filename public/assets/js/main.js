$(function () {
    const handleSearchSubmit = (event) => {
        event.preventDefault();
        const searchInput = document.getElementById("searchInput").value.trim();
        if (searchInput) {
            window.location.href = `search.php?query=${encodeURIComponent(searchInput)}`;
        }
    };

    const searchForm = document.getElementById("searchForm");
    if (searchForm) {
        searchForm.addEventListener("submit", handleSearchSubmit);
    }

    const btnSearch = document.getElementById("btn-search");
    if (btnSearch) {
        btnSearch.addEventListener("click", handleSearchSubmit);
    }
});

  
const formatPrice = price => price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.') + ' đ';

const loadCartItemCount = () => {
  try {
    const cart = JSON.parse(localStorage.getItem("cart")) || {};
    const totalQuantity = Object.keys(cart).length;
    const cartItemCountElement = document.getElementById("cartItemCount");
    cartItemCountElement.textContent = totalQuantity;
  } catch (error) {
    console.error("Error loading cart item count:", error);
  }
};
const loadCategoriesToNavbar = async () => {
  try {
    const response = await fetch(
      "http://localhost/web_adidas_shoes/public/dao/category_dao.php?action=getCategoriesHasProducts"
    );
    if (!response.ok) {
      throw new Error("Failed to fetch categories");
    }
    const categories = await response.json();
    const categoryNav = document.getElementById("categoryNav");
    categories.forEach((category) => {
      const listItem = document.createElement("li");
      listItem.classList.add("nav-item", "mr-2");
      const link = document.createElement("a");
      link.classList.add("nav-link");
      link.href = `product.php?category_id=${category.category_id}`;
      link.textContent = category.category_name;
      listItem.appendChild(link);
      categoryNav.appendChild(listItem);
    });
  } catch (error) {
    console.error("Error fetching categories:", error);
  }
};

loadCategoriesToNavbar();
loadCartItemCount();