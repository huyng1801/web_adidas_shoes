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
      <!-- Nội dung chính -->
      <main class="container-fluid mt-5">
        <div class="d-flex justify-content-center flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="text-center text-uppercase">đơn đặt hàng</h1>
        </div>
   
          <table class="table mt-3">
            <thead>
              <tr>
                <th>Mã đơn hàng</th>
                <th>Tổng giá</th>
                <th>Ghi chú</th>
                <th>Trạng thái</th>
             
                <th>Tên khách hàng</th>
                <th>Email</th>
                <th>Địa chỉ</th>
                <th>Số điện thoại</th>
                <th>Hành động</th>
              </tr>
            </thead>
            <tbody id="orderTableBody">
              <!-- Dữ liệu đơn hàng sẽ được thêm động ở đây -->
            </tbody>
            
          </table>
      
      </main>

<!-- Detail Order Modal -->
<div class="modal fade" id="detailOrderModal" tabindex="-1" role="dialog" aria-labelledby="detailOrderModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detailOrderModalLabel">Chi tiết Đơn hàng</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Chi tiết đơn hàng sẽ được hiển thị ở đây -->
        <div id="orderDetailsContainer"></div>
      </div>
    </div>
  </div>
</div>
<!-- Update Status Modal -->
<div class="modal fade" id="updateStatusModal" tabindex="-1" role="dialog" aria-labelledby="updateStatusModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateStatusModalLabel">Cập Nhật Trạng Thái Đơn Hàng</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="statusSelect">Chọn Trạng Thái Mới:</label>
          <select class="form-control" id="statusSelect">
            <option value="Đang xử lý">Đang xử lý</option>
            <option value="Chưa xác nhận">Chưa xác nhận</option>
            <option value="Đã xác nhận">Đã xác nhận</option>
            <option value="Hoàn thành">Hoàn thành</option>
            <!-- Thêm các trạng thái khác tùy theo yêu cầu -->
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
        <button type="button" class="btn btn-primary" id="confirmUpdateButton">Cập Nhật</button>
      </div>
    </div>
  </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteOrderModal" tabindex="-1" role="dialog" aria-labelledby="deleteOrderModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteOrderModalLabel">Xác nhận xóa đơn hàng</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Bạn có chắc chắn muốn xóa đơn hàng này?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
        <button type="button" class="btn btn-danger" id="confirmDeleteButton">Đồng ý</button>
      </div>
    </div>
  </div>
</div>

  <!-- Footer -->
  <?php 
  include '../admin/includes/footer.php';
  ?>

  <!-- JavaScript của Đơn đặt hàng -->
  <script src="assets/js/order.js"></script>
  <!-- Script để load sidebar và footer -->

</body>

</html>
