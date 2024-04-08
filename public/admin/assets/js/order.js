$(document).ready(function () {
  // Function to fetch orders from the API and render them in the table
  const fetchAndRenderOrders = async () => {
    try {
      // Fetch orders using fetch
      const response = await fetch(
        "http://localhost/web_adidas_shoes/public/dao/order_dao.php?action=getAllOrders"
      );
      if (!response.ok) {
        throw new Error("Error fetching orders");
      }
      const orders = await response.json();
      renderOrders(orders);
    } catch (error) {
      console.error("Error fetching orders:", error);
    }
  };
  const updateOrderStatus = async (orderId, status) => {
    try {
      const response = await fetch(
        `http://localhost/web_adidas_shoes/public/dao/order_dao.php`,
        {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({ action: 'updateOrder', order_id: orderId, status: status }),
        }
      );
      if (!response.ok) {
        throw new Error("Error updating order status");
      }
      const result = await response.json();
      fetchAndRenderOrders(); // Reload orders after updating status
    } catch (error) {
      console.error("Error updating order status:", error);
    }
  };
  const deleteOrder = async (orderId) => {
    try {
      // Fetch to delete order
      const response = await fetch(
        `http://localhost/web_adidas_shoes/public/dao/order_dao.php`,
        {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({ action: "deleteOrder", order_id: orderId }),
        }
      );
      if (!response.ok) {
        throw new Error("Error deleting order");
      }
      const result = await response.json();
      fetchAndRenderOrders();
    } catch (error) {
      console.error("Error deleting order:", error);
    }
  };
  // Function to render orders in the table
  const renderOrders = (orders) => {
    const orderTableBody = $("#orderTableBody");
    orderTableBody.empty();
    orders.forEach((order) => {
      const row = `
        <tr>
          <td>${order.order_id}</td>
          <td>${order.total_price}</td>
          <td>${order.note}</td>
          <td>${order.status}</td>
    
          <td>${order.customer_name}</td> <!-- Thêm thông tin tên khách hàng -->
          <td>${order.email}</td> <!-- Thêm thông tin email -->
          <td>${order.city}</td> <!-- Thêm thông tin địa chỉ -->
          <td>${order.phone_number}</td> <!-- Thêm thông tin số điện thoại -->
          <td>
            <button class="btn btn-primary btn-sm detail-btn" onclick="showOrderDetails(${order.order_id})">Chi tiết</button>
            <button class="btn btn-warning btn-sm update-status-btn" data-toggle="modal" data-target="#updateStatusModal" data-orderid="${order.order_id}">Cập nhật</button>
            <button class="btn btn-danger btn-sm delete-btn" data-toggle="modal" data-target="#deleteOrderModal" data-orderid="${order.order_id}">Xóa</button>

          </td>
        </tr>
      `;
      orderTableBody.append(row);
    });
  };

  // Define showOrderDetails in the global scope
  window.showOrderDetails = async (orderId) => {
    try {
      const response = await fetch(
        `http://localhost/web_adidas_shoes/public/dao/order_detail_dao.php?action=getOrderDetailsByOrderID&order_id=${orderId}`
      );
      if (!response.ok) {
        throw new Error("Error fetching order details");
      }
      const orderDetails = await response.json();
      renderOrderDetails(orderDetails);
      $("#detailOrderModal").modal("show"); // Show the detail modal
    } catch (error) {
      console.error("Error fetching order details:", error);
    }
  };

  const formatMoney = (amount) => {
    return amount.toLocaleString("vi-VN");
  };

  const renderOrderDetails = (orderDetails) => {
    const orderDetailsContainer = $("#orderDetailsContainer");
    orderDetailsContainer.empty();

    // Khởi tạo tổng tiền và bảng chi tiết đơn hàng
    let total = 0;
    const tableHtml = `
      <table class="table">
        <thead>
          <tr>
            <th>Ảnh</th>
            <th>Sản phẩm</th>
            <th>Kích cỡ</th>
            <th>Số lượng</th>
            <th>Giá</th>
          </tr>
        </thead>
        <tbody id="orderDetailsTableBody">
        </tbody>
      </table>
      <p>Tổng tiền: <span id="totalPrice"></span></p>
    `;
    orderDetailsContainer.append(tableHtml);
    const orderDetailsTableBody = $("#orderDetailsTableBody");

    // Lặp qua từng sản phẩm để hiển thị trong bảng
    orderDetails.forEach((detail) => {
      total += detail.unit_price * detail.quantity;
      const imageHtml = `<img src="../${detail.image_url}" alt="${detail.product_name}" style="max-height: 100px;">`;
      const detailHtml = `
        <tr>
          <td>${imageHtml}</td>
          <td>${detail.product_name}</td>
          <td>${detail.size_value}</td>
          <td>${detail.quantity}</td>
          <td>${formatMoney(detail.unit_price)}</td>
        </tr>
      `;
      orderDetailsTableBody.append(detailHtml);
    });

    $("#totalPrice").text(formatMoney(total) + " VNĐ");
  };

  $(document).on("click", ".delete-btn", function () {
    const orderId = $(this).data("orderid");
    $("#confirmDeleteButton").data("orderid", orderId);

    $("#deleteOrderModal").modal("show");
  });

  $("#confirmDeleteButton").click(function () {
    const orderId = $(this).data("orderid");
    deleteOrder(orderId);
    $("#deleteOrderModal").modal("hide");
  });

  $(document).on("click", ".update-status-btn", function () {
    const orderId = $(this).data("orderid");
    $("#confirmUpdateButton").data("orderid", orderId);
    $("#updateStatusModal").modal("show");
  });

  $("#confirmUpdateButton").click(function () {
    const orderId = $(this).data("orderid");
    const status = $("#statusSelect").val();
    updateOrderStatus(orderId, status);
    $("#updateStatusModal").modal("hide");
  });
  fetchAndRenderOrders();
});
