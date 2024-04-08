
    <div class="container-fluid py-2">
        <div class="row">
            <div class="col-md-2 d-flex align-items-center justify-content-center">
                <!-- Logo -->
                <img src="./assets/images/Adidas_Logo.png" alt="Logo" class="logo" height="50">
            </div>
            <nav class="col-md-7 navbar navbar-expand-lg navbar-light">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mr-auto" id="categoryNav">
                            <li class="nav-item mr-2">
                                <a class="nav-link" href="index.php">Trang chủ</a>
                            </li>
                            <li class="nav-item  mr-2">
                                <a class="nav-link" href="product.php?category_id=all">Tất cả</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="col-md-2 d-flex justify-content-center align-items-center">
                <!-- Search bar -->
                <form id="searchForm" class="w-100">
                    <div class="form-row">
                        <div class="col">
                            <div class="input-group">
                                <input type="search" class="form-control border-secondary" id="searchInput" placeholder="Tìm kiếm">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-secondary" id="btn-search">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
            <div class="col-md-1 text-right d-flex align-items-center justify-content-start">
                <!-- Giỏ hàng -->
                <div class="position-relative">
                    <a href="./cart.php" class="header-link">
                        <i class="fas fa-shopping-cart"></i>
                        <span id="cartItemCount" class="badge badge-secondary position-absolute">0</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
