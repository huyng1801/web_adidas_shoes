<!DOCTYPE html>
<html lang="en">

<?php 
  include '../admin/includes/head.php';
  ?>

<body>

      <!-- Navigation Sidebar -->
      <?php 
        include '../admin/includes/navigation.php';
      ?>
 
      <main class="container mt-5">
    <div class="row">
      <div class="col-md-12">
        <div class="d-flex justify-content-center flex-wrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="text-center text-uppercase">Danh mục sản phẩm</h1>
        </div>
        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addCategoryModal">Thêm</button>
        <table class="table">
          <thead>
            <tr>
              <th>Mã danh mục</th>
              <th>Tên danh mục</th>
              <th class="text-center">Số lượng sản phẩm</th>
              <th>Thao tác</th>
            </tr>
          </thead>
          <tbody id="categoryTableBody">
            <!-- Category items will be dynamically added here -->
          </tbody>
        </table>
      </div>
    </div>
  </main>
   
  <!-- Add Category Modal -->
  <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addCategoryModalLabel">Thêm danh mục</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="addCategoryForm">
            <div class="form-group">
              <label for="categoryName">Tên danh mục</label>
              <input type="text" class="form-control" id="categoryName" required maxlength="50">
            </div>
            <button type="submit" class="btn btn-primary">Lưu</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- Edit Category Modal -->
  <div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-labelledby="editCategoryModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editCategoryModalLabel">Cập nhật danh mục</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="editCategoryForm">
            <div class="form-group">
              <input type="hidden" class="form-control" id="editCategoryId">
            </div>
            <div class="form-group">
              <label for="editCategoryName">Tên danh mục</label>
              <input type="text" class="form-control" id="editCategoryName" required maxlength="50">
            </div>
            <button type="submit" class="btn btn-primary">Lưu</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- Delete Confirmation Modal -->
  <div class="modal fade" id="deleteCategoryModal" tabindex="-1" role="dialog"
    aria-labelledby="deleteCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteCategoryModalLabel">Xác nhận xóa</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Bạn có chắc chắn muốn xóa?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
          <button type="button" class="btn btn-danger" id="confirmDeleteButton">Đồng ý</button>
        </div>
      </div>
    </div>
  </div>
  <hr>
  <!-- Footer -->
  <?php 
  include '../admin/includes/footer.php';
  ?>
  <!-- Category Service -->
  <script src="assets/js/category.js"></script>

</body>

</html>
