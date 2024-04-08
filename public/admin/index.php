<!DOCTYPE html>
<html lang="en">
<?php 
  include '../admin/includes/head.php';
  ?>
<body>


      <!-- Thanh điều hướng -->
      <?php 
      include '../admin/includes/navigation.php';
      ?>
  <main class="container mt-5">
        <div class="d-flex justify-content-center flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="text-center text-uppercase">THỐNG KÊ DOANH THU</h1>
        </div>
        <div class="container-fluid mt-5">
          <!-- Nội dung trang ở đây -->
          <div class="row">
            <!-- Thẻ doanh thu hàng ngày -->
            <div class="col-md-6 mb-4">
              <div class="card">
                <div class="card-header">
                  Tổng doanh thu trong ngày
                </div>
                <div class="card-body" id="dailyRevenueCard">
                  <!-- Dữ liệu doanh thu hàng ngày sẽ được chèn ở đây -->
                </div>
              </div>
            </div>
            <!-- Thẻ doanh thu hàng tháng -->
            <div class="col-md-6 mb-4">
              <div class="card">
                <div class="card-header">
                  Tổng doanh thu trong tháng
                </div>
                <div class="card-body" id="monthlyRevenueCard">
                  <!-- Dữ liệu doanh thu hàng tháng sẽ được chèn ở đây -->
                </div>
              </div>
            </div>
          </div>
          <!-- Biểu đồ doanh thu -->
          <div class="card">
            <div class="card-header">
              Biểu đồ doanh thu
            </div>
            <div class="card-body">
              <canvas id="revenueChart"></canvas>
            </div>
          </div>
        </div>
      </main>
 
  <hr>
  <!-- Chân trang -->
  <?php 
  include '../admin/includes/footer.php';
  ?>

  <!-- Bootstrap JavaScript và các phụ thuộc -->

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <!-- JavaScript tùy chỉnh -->
  <script src="../admin/assets/js/index.js"></script>

</body>

</html>
