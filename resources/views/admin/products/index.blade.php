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
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
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
                    @foreach ($products as $product)
                        <tr>
                            <td>
                                <input type="checkbox" class="product-checkbox" value="{{ $product->id }}">
                            </td>
                            <td>
                                <img src="{{ asset('storage/' . $product->image_url) }}" alt="Ảnh sản phẩm" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                            </td>
                            <td>
                                <div class="fw-bold">{{ $product->name }}</div>
                                <small class="text-muted">SKU: {{ $product->sku ?? 'N/A' }}</small>
                            </td>
                            <td>
                                <span class="badge
                                    {{ $product->category->color_class ?? 'bg-secondary' }}">
                                    {{ $product->category->name ?? 'Chưa phân loại' }}
                                </span>
                            </td>
                            <td class="fw-bold text-success">
                                {{ number_format($product->price, 0, ',', '.') }} ₫
                            </td>
                            <td>
                                <span class="badge
                                    {{ $product->stock_quantity == 0 ? 'bg-danger' : ($product->stock_quantity <= 5 ? 'bg-warning' : 'bg-success') }}">
                                    {{ $product->stock_quantity }} {{ $product->unit }}
                                </span>
                            </td>
                            <td>
                                @if ($product->stock_quantity == 0)
                                    <span class="badge bg-danger">
                                        <i class="fas fa-times-circle"></i> Hết hàng
                                    </span>
                                @elseif ($product->stock_quantity <= 5)
                                    <span class="badge bg-warning">
                                        <i class="fas fa-exclamation-triangle"></i> Sắp hết
                                    </span>
                                @else
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle"></i> Đang bán
                                    </span>
                                @endif
                            </td>
                            <td>{{ $product->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-sm btn-outline-warning" onclick="editProduct({{ $product->id }})" title="Chỉnh sửa">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                {{ $products->links('pagination::bootstrap-5') }}
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

            <!-- Bổ sung method POST và enctype để gửi ảnh -->
            <form id="addProductForm" method="POST" enctype="multipart/form-data">
                @csrf <!-- Nếu dùng trong Blade -->
                <div class="modal-body">
                    <div class="row">
                        <!-- Tên sản phẩm -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                        </div>

                        <!-- Slug -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="slug" class="form-label">Slug <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="slug" name="slug" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Danh mục -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Danh mục <span class="text-danger">*</span></label>
                                <select class="form-select" id="category_id" name="category_id" required>
                                    <option value="">Chọn danh mục</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Giá -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="price" class="form-label">Giá (₫) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" min="0" class="form-control" id="price" name="price" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Số lượng tồn -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="stock_quantity" class="form-label">Số lượng tồn <span class="text-danger">*</span></label>
                                <input type="number" min="0" class="form-control" id="stock_quantity" name="stock_quantity" required>
                            </div>
                        </div>

                        <!-- Đơn vị -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="unit" class="form-label">Đơn vị <span class="text-danger">*</span></label>
                                <select class="form-select" id="unit" name="unit" required>
                                    <option value="">Chọn đơn vị</option>
                                    <option value="kg">Kilogram (kg)</option>
                                    <option value="g">Gram (g)</option>
                                    <option value="bó">Bó</option>
                                    <option value="gói">Gói</option>
                                    <option value="cái">Cái</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Mô tả -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Mô tả</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>

                    <!-- Hình ảnh -->
                    <div class="mb-3">
                        <label for="image_url" class="form-label">Hình ảnh</label>
                        <input type="file" class="form-control" id="image_url" name="image_url" accept="image/*">
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

    // Edit product
    function editProduct(id) {
        // Fetch product data từ server
        fetch(`/admin/products/${id}/edit`)
            .then(response => response.json())
            .then(product => {
                // Thay đổi title và button của modal
                document.getElementById('addProductModalLabel').textContent = 'Chỉnh sửa sản phẩm';
                document.querySelector('#addProductModal .btn-primary').textContent = 'Cập nhật sản phẩm';

                // Thêm input hidden để lưu ID sản phẩm
                const form = document.getElementById('addProductForm');
                let hiddenId = document.getElementById('productId');
                if (!hiddenId) {
                    hiddenId = document.createElement('input');
                    hiddenId.type = 'hidden';
                    hiddenId.id = 'productId';
                    hiddenId.name = 'id';
                    form.appendChild(hiddenId);
                }
                hiddenId.value = id;

                // Thêm method override cho PUT request
                let methodField = document.getElementById('methodField');
                if (!methodField) {
                    methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.id = 'methodField';
                    methodField.name = '_method';
                    methodField.value = 'PUT';
                    form.appendChild(methodField);
                }

                // Điền dữ liệu vào form
                document.getElementById('name').value = product.name || '';
                document.getElementById('slug').value = product.slug || '';
                document.getElementById('category_id').value = product.category_id || '';
                document.getElementById('price').value = product.price || '';
                document.getElementById('stock_quantity').value = product.stock_quantity || '';
                document.getElementById('unit').value = product.unit || '';
                document.getElementById('description').value = product.description || '';

                // Hiển thị ảnh hiện tại nếu có
                const imageInput = document.getElementById('image_url');
                const imagePreview = document.getElementById('imagePreview');

                if (product.image_url) {
                    if (!imagePreview) {
                        const preview = document.createElement('div');
                        preview.id = 'imagePreview';
                        preview.className = 'mb-2';
                        preview.innerHTML = `
                            <img src="${product.image_url}" alt="Current image"
                                style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px;">
                            <small class="text-muted d-block">Ảnh hiện tại</small>
                        `;
                        imageInput.parentNode.insertBefore(preview, imageInput);
                    } else {
                        imagePreview.innerHTML = `
                            <img src="${product.image_url}" alt="Current image"
                                style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px;">
                            <small class="text-muted d-block">Ảnh hiện tại</small>
                        `;
                    }
                }

                // Đổi action của form
                form.action = `/admin/products/${id}`;

                // Hiển thị modal
                const modal = new bootstrap.Modal(document.getElementById('addProductModal'));
                modal.show();
            })
            .catch(error => {
                console.error('Error fetching product data:', error);
                alert('Có lỗi xảy ra khi tải thông tin sản phẩm!');
            });
    }

    // Hàm reset modal về trạng thái thêm mới
    function resetModalToAdd() {
        // Reset title và button
        document.getElementById('addProductModalLabel').textContent = 'Thêm sản phẩm mới';
        document.querySelector('#addProductModal .btn-primary').textContent = 'Thêm sản phẩm';

        // Xóa các field ẩn
        const hiddenId = document.getElementById('productId');
        const methodField = document.getElementById('methodField');
        const imagePreview = document.getElementById('imagePreview');

        if (hiddenId) hiddenId.remove();
        if (methodField) methodField.remove();
        if (imagePreview) imagePreview.remove();

        // Reset form action
        document.getElementById('addProductForm').action = '/admin/products';

        // Clear form
        document.getElementById('addProductForm').reset();
    }

    // Sửa đổi form submission handler
    document.getElementById('addProductForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const isEdit = document.getElementById('productId') !== null;
        const url = isEdit ? this.action : '/admin/products';
        const method = 'POST';

        fetch(url, {
            method: method,
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
                            document.querySelector('input[name="_token"]')?.value
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(isEdit ? 'Cập nhật sản phẩm thành công!' : 'Thêm sản phẩm thành công!');
                bootstrap.Modal.getInstance(document.getElementById('addProductModal')).hide();
                location.reload(); // Reload trang để cập nhật danh sách
            } else {
                alert('Có lỗi xảy ra: ' + (data.message || 'Vui lòng thử lại!'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra khi xử lý yêu cầu!');
        });
    });

    // Reset modal khi đóng
    document.getElementById('addProductModal').addEventListener('hidden.bs.modal', function() {
        resetModalToAdd();
    });

    // Khi click button "Thêm sản phẩm", đảm bảo modal ở trạng thái add
    document.querySelector('[data-bs-target="#addProductModal"]').addEventListener('click', function() {
        resetModalToAdd();
    });

    // Thêm categories động từ server (nếu cần)
    function loadCategories() {
        fetch('/admin/categories/list')
            .then(response => response.json())
            .then(categories => {
                const categorySelect = document.getElementById('category_id');
                categorySelect.innerHTML = '<option value="">Chọn danh mục</option>';

                categories.forEach(category => {
                    const option = document.createElement('option');
                    option.value = category.id;
                    option.textContent = category.name;
                    categorySelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error loading categories:', error);
            });
    }

    // Load categories khi trang được tải
    document.addEventListener('DOMContentLoaded', function() {
        loadCategories();
    });

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

    function deleteSelected() {
        const checkedBoxes = document.querySelectorAll('.product-checkbox:checked');
        if (checkedBoxes.length === 0) return;

        if (confirm(`Bạn có chắc chắn muốn xóa ${checkedBoxes.length} sản phẩm đã chọn?`)) {
            const ids = Array.from(checkedBoxes).map(cb => cb.value);
            const idsParam = ids.join(',');

            fetch(`/admin/products/${idsParam}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                if (!response.ok) throw new Error('Xóa thất bại.');
                return response.json();
            })
            .then(data => {
                alert(data.message);
                location.reload();
            })
            .catch(error => {
                console.error(error);
                alert('Có lỗi xảy ra khi xóa.');
            });
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

@endsection

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
