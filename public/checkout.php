<!DOCTYPE html>
<html lang="en">
<?php include './includes/head.php'; ?>

<body>
    <!-- Header -->
    <?php include './includes/header.php'; ?>


    <div class="container">
    <h2 class="mt-4 mb-4 text-center">Thông tin khách hàng</h2>
    <form id="checkoutForm">
        <div class="row">
            <!-- Cột trái -->

            <div class="col-md-6">
                <div class="mb-3">
                
                   
                        <div class="mb-3">
                            <label for="customerName" class="form-label">Họ và tên</label>
                            <input type="text" class="form-control" id="customerName" name="customerName" required>
                        </div>
                        <div class="mb-3">
                            <label for="phoneNumber" class="form-label">Số điện thoại</label>
                            <input type="tel" class="form-control" id="phoneNumber" name="phoneNumber" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                    <label for="city" class="form-label">Thành phố</label>
                    <input type="text" class="form-control" id="city" name="city" required>
                </div>
                 
                </div>
            </div>

            <!-- Cột phải -->
            <div class="col-md-6">
            
                <div class="mb-3">
                    <label for="district" class="form-label">Quận/Huyện</label>
                    <input type="text" class="form-control" id="district" name="district" required>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Địa chỉ</label>
                    <input type="text" class="form-control" id="address" name="address" required>
                </div>
                <div class="mb-3">
                    <label for="note" class="form-label">Ghi chú</label>
                    <textarea class="form-control" id="note" name="note"></textarea>
                </div>
               
            </div>
        </div>
        <div class="row justify-content-end mb-5">
        <div class="col-auto">
        <button type="submit" class="btn" id="btn-order">Xác nhận đơn hàng</button>
        </div>
    </div>

        </form>
    </div>

    <!-- Footer -->
    <?php include './includes/footer.php'; ?>

    <!-- Bootstrap JS và jQuery -->

    <!-- Custom JS -->
    <script src="assets/js/checkout.js"></script>
    <script src="assets/js/main.js"></script>
</body>

</html>
