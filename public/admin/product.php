<!DOCTYPE html>
<html lang="vi">

<?php 
  include '../admin/includes/head.php';
  ?>

<body>

      <!-- Thanh điều hướng bên -->
      <?php 
      include '../admin/includes/navigation.php';
      ?>
<main class="container mt-5">
    <div class="row">
      <div class="col-md-12">
        <div class="d-flex justify-content-center flex-wrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="text-center text-uppercase">Quản lý Sản phẩm</h1>
        </div>
        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addProductModal">Thêm</button>
        <table class="table">
          <thead>
            <tr>
              <th>Ảnh</th>
              <th>Tên sản phẩm</th>
              <th class="text-right">Giá</th>

              <th>Danh mục</th>
              <th>Hành động</th>
            </tr>
          </thead>
          <tbody id="productTableBody">
            <!-- Các mục sản phẩm sẽ được thêm vào đây động -->
          </tbody>
        </table>
      </div>
    </div>
  </main>
<!-- Modal Danh sách Size và Thêm/Xóa Size -->
<div class="modal fade" id="sizeModal" tabindex="-1" role="dialog" aria-labelledby="sizeModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="sizeModalLabel">Danh sách Size</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Hiển thị danh sách size -->
        <ul id="productSizeList">
          <!-- Các mục size sẽ được thêm vào đây động -->
        </ul>
        <!-- Form Thêm Size -->
        <form id="addSizeForm">
          <!-- Input hidden để lưu product ID -->
          <input type="hidden" id="productIdForSize" name="productIdForSize">
          <div class="form-group">
            <label for="sizeValue">Size mới:</label>
            <input type="text" class="form-control" id="sizeValue" required>
          </div>
          <button type="submit" class="btn btn-primary">Thêm</button>
        </form>
      </div>
    </div>
  </div>
</div>


  <!-- Modal Thêm Sản phẩm -->
  <div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addProductModalLabel">Thêm Sản phẩm</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- Form Thêm Sản phẩm -->
          <form id="addProductForm">
            <div class="form-group">
              <label for="productName">Tên Sản phẩm</label>
              <input type="text" class="form-control" id="productName" required>
            </div>
            <div class="form-group">
              <label for="productDescription">Mô tả</label>
              <input type="text" class="form-control" id="productDescription" required maxlength="100">
            </div>
            <div class="form-group">
              <label for="productPrice">Giá</label>
              <input type="number" class="form-control" id="productPrice" required min="0">
            </div>
            <div class="form-group">
              <label for="productImage">Ảnh sản phẩm</label>
              <input type="file" class="form-control-file" id="productImage" accept="image/*">
            </div>
            <div class="form-group">
              <label for="productCategory">Danh mục</label>
              <select class="form-control" id="productCategory">
                <!-- Các lựa chọn danh mục sẽ được thêm vào đây động -->
              </select>
            </div>
            <!-- Thêm các trường khác cho các thuộc tính sản phẩm -->
            <button type="submit" class="btn btn-primary">Lưu</button>
          </form>
        </div>
      </div>
    </div>
  </div>

<!-- Modal Sửa Sản phẩm -->
<div class="modal fade" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="editProductModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editProductModalLabel">Sửa Sản phẩm</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Form Sửa Sản phẩm -->
        <form id="editProductForm">
          <div class="form-group">
            <input type="hidden" class="form-control" id="editProductId">
          </div>
          <div class="form-group">
            <label for="editProductName">Tên Sản phẩm</label>
            <input type="text" class="form-control" id="editProductName" required>
          </div>
          <div class="form-group">
            <label for="editDescription">Mô tả</label>
            <textarea class="form-control" id="editDescription" rows="3"></textarea>
          </div>
          <div class="form-group">
            <label for="editPrice">Giá</label>
            <input type="number" class="form-control" id="editPrice" required>
          </div>

          <div class="form-group">
            <label for="editProductCategory">Danh mục</label>
            <select class="form-control" id="editProductCategory" required>
              <!-- Danh sách danh mục sẽ được tải bằng JavaScript -->
            </select>
          </div>
          <div class="form-group">
            <label for="editProductImage">Hình ảnh</label>
            <input type="hidden" id="editImageUrl">
            <input type="file" class="form-control-file" id="editProductImage">
          </div>
       
          <br>
          <button type="submit" class="btn btn-primary">Lưu</button>
        </form>
      </div>
    </div>
  </div>
</div>

  <!-- Modal Xác nhận Xóa -->
  <div class="modal fade" id="deleteProductModal" tabindex="-1" role="dialog"
    aria-labelledby="deleteProductModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteProductModalLabel">Xác nhận Xóa</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Bạn có chắc chắn muốn xóa sản phẩm này?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
          <button type="button" class="btn btn-danger" id="confirmDeleteButton">Xác nhận</button>
        </div>
      </div>
    </div>
  </div>
  <hr>
  <!-- Footer -->
  <?php 
  include '../admin/includes/footer.php';
  ?>


  <!-- Bootstrap JavaScript và các phụ thuộc -->

  <!-- JavaScript cho Quản lý Sản phẩm -->
  <script src="assets/js/product.js"></script>

  <!-- Tải thanh điều hướng và chân trang -->

</body>

</html>
