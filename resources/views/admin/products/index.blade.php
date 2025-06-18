@extends('layouts.admin')

@section('title', 'Quản lý sản phẩm')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Quản lý sản phẩm</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Sản phẩm</li>
            </ol>
        </nav>
    </div>

    <!-- Toolbar -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
                    <i class="fas fa-plus"></i> Thêm sản phẩm
                </button>
                <button type="button" class="btn btn-outline-secondary" onclick="exportProducts()">
                    <i class="fas fa-download"></i> Xuất Excel
                </button>
                <button type="button" class="btn btn-outline-danger" onclick="deleteSelected()" id="deleteSelectedBtn" disabled>
                    <i class="fas fa-trash"></i> Xóa đã chọn
                </button>
            </div>
        </div>
        <div class="col-md-4">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Tìm kiếm sản phẩm..." id="searchInput">
                <button class="btn btn-outline-primary" type="button" onclick="searchProducts()">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="row mb-3">
        <div class="col-md-3">
            <select class="form-select" id="categoryFilter" onchange="filterProducts()">
                <option value="">Tất cả danh mục</option>
                <option value="1">Rau lá</option>
                <option value="2">Rau củ</option>
                <option value="3">Trái cây</option>
                <option value="4">Gia vị</option>
            </select>
        </div>
        <div class="col-md-3">
            <select class="form-select" id="statusFilter" onchange="filterProducts()">
                <option value="">Tất cả trạng thái</option>
                <option value="active">Đang bán</option>
                <option value="inactive">Ngừng bán</option>
                <option value="out_of_stock">Hết hàng</option>
            </select>
        </div>
        <div class="col-md-3">
            <select class="form-select" id="sortBy" onchange="sortProducts()">
                <option value="created_at_desc">Mới nhất</option>
                <option value="created_at_asc">Cũ nhất</option>
                <option value="name_asc">Tên A-Z</option>
                <option value="name_desc">Tên Z-A</option>
                <option value="price_asc">Giá thấp đến cao</option>
                <option value="price_desc">Giá cao đến thấp</option>
            </select>
        </div>
        <div class="col-md-3">
            <button type="button" class="btn btn-outline-secondary w-100" onclick="resetFilters()">
                <i class="fas fa-undo"></i> Làm mới
            </button>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Tổng sản phẩm</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalProducts ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-box fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Đang bán</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $activeProducts ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Sắp hết hàng</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $lowStockProducts ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Hết hàng</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $outOfStockProducts ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Danh sách sản phẩm</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="productsTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" id="selectAll" onchange="toggleSelectAll()">
                            </th>
                            <th>Hình ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th>Danh mục</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Sample data - Replace with actual data from controller --}}
                        <tr>
                            <td><input type="checkbox" class="product-checkbox" value="1"></td>
                            <td>
                                <img src="{{ asset('images/products/sample1.jpg') }}" alt="Product" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                            </td>
                            <td>
                                <div class="fw-bold">Cà chua cherry</div>
                                <small class="text-muted">SKU: TCH001</small>
                            </td>
                            <td><span class="badge bg-success">Rau lá</span></td>
                            <td class="fw-bold text-success">45.000 ₫</td>
                            <td>
                                <span class="badge bg-success">120 kg</span>
                            </td>
                            <td>
                                <span class="badge bg-success">
                                    <i class="fas fa-check-circle"></i> Đang bán
                                </span>
                            </td>
                            <td>15/03/2024</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="viewProduct(1)" title="Xem chi tiết">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-warning" onclick="editProduct(1)" title="Chỉnh sửa">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteProduct(1)" title="Xóa">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" class="product-checkbox" value="2"></td>
                            <td>
                                <img src="{{ asset('images/products/sample2.jpg') }}" alt="Product" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                            </td>
                            <td>
                                <div class="fw-bold">Cà rốt baby</div>
                                <small class="text-muted">SKU: CRB002</small>
                            </td>
                            <td><span class="badge bg-warning">Rau củ</span></td>
                            <td class="fw-bold text-success">35.000 ₫</td>
                            <td>
                                <span class="badge bg-warning">5 kg</span>
                            </td>
                            <td>
                                <span class="badge bg-warning">
                                    <i class="fas fa-exclamation-triangle"></i> Sắp hết
                                </span>
                            </td>
                            <td>12/03/2024</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="viewProduct(2)" title="Xem chi tiết">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-warning" onclick="editProduct(2)" title="Chỉnh sửa">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteProduct(2)" title="Xóa">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" class="product-checkbox" value="3"></td>
                            <td>
                                <img src="{{ asset('images/products/sample3.jpg') }}" alt="Product" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                            </td>
                            <td>
                                <div class="fw-bold">Táo Fuji</div>
                                <small class="text-muted">SKU: TF003</small>
                            </td>
                            <td><span class="badge bg-info">Trái cây</span></td>
                            <td class="fw-bold text-success">85.000 ₫</td>
                            <td>
                                <span class="badge bg-danger">0 kg</span>
                            </td>
                            <td>
                                <span class="badge bg-danger">
                                    <i class="fas fa-times-circle"></i> Hết hàng
                                </span>
                            </td>
                            <td>10/03/2024</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="viewProduct(3)" title="Xem chi tiết">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-warning" onclick="editProduct(3)" title="Chỉnh sửa">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteProduct(3)" title="Xóa">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>

<!-- Add Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLabel">Thêm sản phẩm mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addProductForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="productName" class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="productName" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="productSku" class="form-label">Mã SKU <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="productSku" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="productCategory" class="form-label">Danh mục <span class="text-danger">*</span></label>
                                <select class="form-select" id="productCategory" required>
                                    <option value="">Chọn danh mục</option>
                                    <option value="1">Rau lá</option>
                                    <option value="2">Rau củ</option>
                                    <option value="3">Trái cây</option>
                                    <option value="4">Gia vị</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="productPrice" class="form-label">Giá (₫) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="productPrice" min="0" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="productQuantity" class="form-label">Số lượng <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="productQuantity" min="0" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="productUnit" class="form-label">Đơn vị <span class="text-danger">*</span></label>
                                <select class="form-select" id="productUnit" required>
                                    <option value="">Chọn đơn vị</option>
                                    <option value="kg">Kilogram (kg)</option>
                                    <option value="g">Gram (g)</option>
                                    <option value="piece">Cái</option>
                                    <option value="pack">Gói</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="productDescription" class="form-label">Mô tả</label>
                        <textarea class="form-control" id="productDescription" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="productImage" class="form-label">Hình ảnh</label>
                        <input type="file" class="form-control" id="productImage" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Toggle select all checkboxes
    function toggleSelectAll() {
        const selectAll = document.getElementById('selectAll');
        const checkboxes = document.querySelectorAll('.product-checkbox');
        const deleteBtn = document.getElementById('deleteSelectedBtn');

        checkboxes.forEach(checkbox => {
            checkbox.checked = selectAll.checked;
        });

        deleteBtn.disabled = !selectAll.checked;
    }

    // Update delete button state when individual checkboxes change
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('product-checkbox')) {
            const checkboxes = document.querySelectorAll('.product-checkbox');
            const checkedBoxes = document.querySelectorAll('.product-checkbox:checked');
            const deleteBtn = document.getElementById('deleteSelectedBtn');
            const selectAll = document.getElementById('selectAll');

            deleteBtn.disabled = checkedBoxes.length === 0;
            selectAll.checked = checkboxes.length === checkedBoxes.length;
            selectAll.indeterminate = checkedBoxes.length > 0 && checkedBoxes.length < checkboxes.length;
        }
    });

    // Search products
    function searchProducts() {
        const searchInput = document.getElementById('searchInput').value;
        // Implement search logic here
        console.log('Searching for:', searchInput);
    }

    // Filter products
    function filterProducts() {
        const categoryFilter = document.getElementById('categoryFilter').value;
        const statusFilter = document.getElementById('statusFilter').value;
        // Implement filter logic here
        console.log('Filtering - Category:', categoryFilter, 'Status:', statusFilter);
    }

    // Sort products
    function sortProducts() {
        const sortBy = document.getElementById('sortBy').value;
        // Implement sort logic here
        console.log('Sorting by:', sortBy);
    }

    // Reset filters
    function resetFilters() {
        document.getElementById('searchInput').value = '';
        document.getElementById('categoryFilter').value = '';
        document.getElementById('statusFilter').value = '';
        document.getElementById('sortBy').value = 'created_at_desc';
        // Reload data
        filterProducts();
    }

    // View product details
    function viewProduct(id) {
        // Implement view product logic
        console.log('Viewing product:', id);
    }

    // Edit product
    function editProduct(id) {
        // Implement edit product logic
        console.log('Editing product:', id);
    }

    // Delete single product
    function deleteProduct(id) {
        if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')) {
            // Implement delete logic
            console.log('Deleting product:', id);
        }
    }

    // Delete selected products
    function deleteSelected() {
        const checkedBoxes = document.querySelectorAll('.product-checkbox:checked');
        if (checkedBoxes.length === 0) return;

        if (confirm(`Bạn có chắc chắn muốn xóa ${checkedBoxes.length} sản phẩm đã chọn?`)) {
            const ids = Array.from(checkedBoxes).map(cb => cb.value);
            // Implement bulk delete logic
            console.log('Deleting products:', ids);
        }
    }

    // Export products
    function exportProducts() {
        // Implement export logic
        console.log('Exporting products...');
    }

    // Handle add product form submission
    document.getElementById('addProductForm').addEventListener('submit', function(e) {
        e.preventDefault();
        // Implement add product logic
        console.log('Adding new product...');
        // Close modal after successful addition
        // bootstrap.Modal.getInstance(document.getElementById('addProductModal')).hide();
    });

    // Auto-generate SKU based on product name
    document.getElementById('productName').addEventListener('input', function(e) {
        const name = e.target.value;
        const sku = name.toUpperCase().replace(/\s+/g, '').substring(0, 6) + Math.floor(Math.random() * 1000);
        document.getElementById('productSku').value = sku;
    });

    // Search on Enter key
    document.getElementById('searchInput').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            searchProducts();
        }
    });

    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush

@push('styles')
<style>
    .border-left-primary {
        border-left: 0.25rem solid #4e73df !important;
    }
    .border-left-success {
        border-left: 0.25rem solid #1cc88a !important;
    }
    .border-left-warning {
        border-left: 0.25rem solid #f6c23e !important;
    }
    .border-left-danger {
        border-left: 0.25rem solid #e74a3b !important;
    }
    .text-gray-800 {
        color: #5a5c69 !important;
    }
    .text-gray-300 {
        color: #dddfeb !important;
    }
    .shadow {
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
    }
    .img-thumbnail {
        border-radius: 0.5rem;
    }
    .btn-group .btn {
        margin-right: 0;
    }
    .table th {
        background-color: #f8f9fc;
        border-color: #e3e6f0;
    }
    .badge {
        font-size: 0.75em;
    }
</style>
@endpush
