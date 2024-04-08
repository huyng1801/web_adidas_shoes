<!DOCTYPE html>
<html lang="en">

<?php include './includes/head.php'; ?>

<body>

  <!-- Header -->
  <?php include './includes/header.php'; ?>


  <!-- Content -->
  <div class="container-fluid mt-5">
    <div class="row">
      <div class="col-md-6">
        <img id="productImage" class="img-fluid rounded" alt="Product Image">
      </div>
      <div class="col-md-6">
        <h2 id="productName"></h2>
        <p id="productDescription"></p>
        <p id="productPrice"></p>
        <div class="form-group">
          <label>Kích thước</label>
          <!-- Radio buttons for sizes will be dynamically added here -->
        </div>
        <button id="addToCartBtn" class="btn btn-primary">Thêm vào giỏ hàng</button>

        <div class="product-single__policy">
    <div class="product-policy">
        <div class="row">
            <div class="col-md-4">
                <div class="product-policy__item">
                    <div class="product-policy__icon">
                        <i class="fas fa-wrench"></i>
                    </div>
                    <span class="product-policy__title">
                        Bảo hành keo vĩnh viễn
                    </span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="product-policy__item">
                    <div class="product-policy__icon">
                        <i class="fas fa-shipping-fast"></i>
                    </div>
                    <span class="product-policy__title">
                        Miễn phí vận chuyển toàn quốc<br> cho đơn hàng từ 150k
                    </span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="product-policy__item">
                    <div class="product-policy__icon">
                        <i class="fas fa-exchange-alt"></i>
                    </div>
                    <span class="product-policy__title">
                        Đổi trả dễ dàng <br>  (trong vòng 7 ngày nếu lỗi nhà sản xuất)
                    </span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="product-policy__item">
                    <div class="product-policy__icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <span class="product-policy__title">
                        Hotline 1900.633.349<br>
                        hỗ trợ từ 8h30-21h30
                    </span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="product-policy__item">
                    <div class="product-policy__icon">
                        <i class="fas fa-truck"></i>
                    </div>
                    <span class="product-policy__title">
                        Giao hàng tận nơi,<br> nhận hàng xong thanh toán
                    </span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="product-policy__item">
                    <div class="product-policy__icon">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <span class="product-policy__title">
                        Ưu đãi tích điểm và <br>hưởng quyền lợi thành viên từ MWC
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>
      </div>
    </div>
    <div id="relativeProductContainer" class="mb-4">
    <h3>Các sản phẩm liên quan</h3>
    <div id="relativeProduct"  class="row">

    </div>
    </div> 
  </div>
  <hr>
  <?php include './includes/footer.php'; ?>
  
  <!-- Custom JS -->
  <script src="assets/js/main.js"></script>
  <script src="assets/js/details.js"></script>
</body>

</html>
