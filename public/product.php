<!DOCTYPE html>
<html lang="en">

<?php
  include './includes/head.php'; 
?>

<body>
  <!-- Header -->
  <?php
  include './includes/header.php'; 
  ?>


  <!-- Sidebar -->
  <div class="container-fluid mt-4">
    <h4 class="text-uppercase" id="currentCategory"></h4>

    <div class="row">
    <div class="col-md-9"></div> 
    <div class="col-md-3 d-flex align-items-center">
        <label for="sortSelect" class="flex-grow-1">Sắp xếp theo: </label>
        <div class="form-group flex-grow-1">
            <select class="form-control" id="sortSelect" onchange="handleSortChange(this.value)">
                <option value="default">Mặc định</option>
                <option value="az">A-Z</option>
                <option value="za">Z-A</option>
                <option value="priceAsc">Giá tăng dần</option>
                <option value="priceDesc">Giá giảm dần</option>
            </select>
        </div>
    </div>
</div>

    <div class="row">
      <!-- Content -->
      <div id="content" class="col-md-12">
        <!-- Mỗi section sẽ hiển thị danh sách sản phẩm theo từng category -->
        <!-- Các sản phẩm sẽ được load từ server và thêm vào đây -->
      </div>
    </div>
  </div>
  <hr>
  <?php
  include './includes/footer.php'; 
  ?>
  <!-- Bootstrap JS và jQuery -->
  <!-- Custom JS -->
  <script src="assets/js/product.js"></script>
  <script src="assets/js/main.js"></script>
</body>

</html>
