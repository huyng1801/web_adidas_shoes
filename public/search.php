<!DOCTYPE html>
<html lang="en">

<?php include './includes/head.php'; ?>


<body>
  <!-- Header -->
  <?php
  include './includes/header.php'; 
  ?>


  <!-- Kết quả tìm kiếm -->
  <div class="container-fluid mt-4">
    <!-- Hiển thị chuỗi tìm kiếm -->
    <h2>Kết quả tìm kiếm cho từ khóa <span id="searchString"></span></h2>
    <!-- Nội dung kết quả tìm kiếm sẽ được thêm vào đây -->
    <div class="search-results">

    </div>
  </div>

  <!-- Footer -->
  <?php
  include './includes/footer.php'; 
  ?>

  <!-- Custom JS -->
  <script src="assets/js/search.js"></script>
  <script src="assets/js/main.js"></script>

</body>

</html>
