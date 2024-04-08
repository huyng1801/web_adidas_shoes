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

 
    <div class="container">

        <div id="cartItems" class="mb-4">
            <!-- Danh sách sản phẩm trong giỏ hàng sẽ được hiển thị ở đây -->
        </div>
        <div class="row justify-content-end">
        <div class="col-auto">
            <button id="checkoutBtn" class="btn btn-primary">Thanh toán</button>
        </div>
    </div>
    </div>
    <hr>
    <?php
  include './includes/footer.php'; 
  ?>
  <!-- Bootstrap JS và jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Custom JS -->
    <script src="assets/js/main.js"></script>
    <script src="assets/js/cart.js"></script>
</body>
</html>
