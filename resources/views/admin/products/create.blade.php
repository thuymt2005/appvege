@extends('layouts.admin')

@section('title', 'Thêm sản phẩm mới')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-0">Thêm sản phẩm mới</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Sản phẩm</a></li>
                            <li class="breadcrumb-item active">Thêm mới</li>
                        </ol>
                    </nav>
                </div>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Quay lại
                </a>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
        @csrf
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Basic Information -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">
                            <i class="fas fa-info-circle me-2"></i>Thông tin cơ bản
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="name" class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       id="name" name="name" value="{{ old('name') }}" required
                                       placeholder="Nhập tên sản phẩm...">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="category_id" class="form-label">Danh mục <span class="text-danger">*</span></label>
                                <select class="form-select @error('category_id') is-invalid @enderror"
                                        id="category_id" name="category_id" required>
                                    <option value="">Chọn danh mục</option>
                                    @foreach($categories ?? [] as $category)
                                        <option value="{{ $category->id }}"
                                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="unit" class="form-label">Đơn vị tính <span class="text-danger">*</span></label>
                                <select class="form-select @error('unit') is-invalid @enderror"
                                        id="unit" name="unit" required>
                                    <option value="">Chọn đơn vị</option>
                                    <option value="kg" {{ old('unit') == 'kg' ? 'selected' : '' }}>Kilogram (kg)</option>
                                    <option value="gram" {{ old('unit') == 'gram' ? 'selected' : '' }}>Gram (g)</option>
                                    <option value="bó" {{ old('unit') == 'bó' ? 'selected' : '' }}>Bó</option>
                                    <option value="gói" {{ old('unit') == 'gói' ? 'selected' : '' }}>Gói</option>
                                    <option value="hộp" {{ old('unit') == 'hộp' ? 'selected' : '' }}>Hộp</option>
                                    <option value="chai" {{ old('unit') == 'chai' ? 'selected' : '' }}>Chai</option>
                                    <option value="lon" {{ old('unit') == 'lon' ? 'selected' : '' }}>Lon</option>
                                    <option value="cái" {{ old('unit') == 'cái' ? 'selected' : '' }}>Cái</option>
                                    <option value="chiếc" {{ old('unit') == 'chiếc' ? 'selected' : '' }}>Chiếc</option>
                                    <option value="lít" {{ old('unit') == 'lít' ? 'selected' : '' }}>Lít</option>
                                </select>
                                @error('unit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="description" class="form-label">Mô tả sản phẩm <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                          id="description" name="description" rows="6" required
                                          placeholder="Mô tả chi tiết về sản phẩm...">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pricing & Inventory -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">
                            <i class="fas fa-dollar-sign me-2"></i>Giá & Kho hàng
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label">Giá bán <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" class="form-control @error('price') is-invalid @enderror"
                                           id="price" name="price" value="{{ old('price') }}"
                                           min="0" step="0.01" required placeholder="0.00">
                                    <span class="input-group-text">VNĐ</span>
                                </div>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="stock_quantity" class="form-label">Số lượng tồn kho <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('stock_quantity') is-invalid @enderror"
                                       id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', 0) }}"
                                       min="0" required>
                                @error('stock_quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Product Images -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">
                            <i class="fas fa-images me-2"></i>Hình ảnh sản phẩm
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="image_url" class="form-label">Hình ảnh sản phẩm</label>
                            <input type="file" class="form-control @error('image_url') is-invalid @enderror"
                                   id="image_url" name="image_url" accept="image/*">
                            @error('image_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Khuyến nghị: 800x800px, định dạng JPG/PNG</small>
                        </div>
                    </div>
                </div>

                <!-- SEO Settings -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">
                            <i class="fas fa-search me-2"></i>URL SLUG
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="slug" class="form-label">URL Slug <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                   id="slug" name="slug" value="{{ old('slug') }}" required
                                   placeholder="url-san-pham">
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Tự động tạo từ tên sản phẩm nếu bỏ trống</small>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="card shadow">
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i>Lưu sản phẩm
                            </button>
                            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-danger">
                                <i class="fas fa-times me-2"></i>Hủy bỏ
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('styles')
<style>
    .form-label {
        font-weight: 600;
        color: #374151;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }

    .card {
        border: 1px solid #e3e6f0;
        border-radius: 0.5rem;
    }

    .card-header {
        border-bottom: 1px solid #e3e6f0;
        background-color: #f8f9fa !important;
    }

    .text-danger {
        color: #dc3545 !important;
    }

    .form-check-input:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }

    .btn-primary {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }

    .btn-primary:hover {
        background-color: #0b5ed7;
        border-color: #0a58ca;
    }

    .invalid-feedback {
        display: block;
    }

    .img-preview {
        max-width: 100%;
        max-height: 200px;
        object-fit: cover;
        border-radius: 0.375rem;
        border: 1px solid #dee2e6;
    }

    .breadcrumb-item + .breadcrumb-item::before {
        content: ">";
        color: #6c757d;
    }

    .breadcrumb a {
        color: #0d6efd;
        text-decoration: none;
    }

    .breadcrumb a:hover {
        color: #0b5ed7;
        text-decoration: underline;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto generate slug from product name
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');

    nameInput.addEventListener('input', function() {
        if (!slugInput.value || slugInput.dataset.auto !== 'false') {
            const slug = this.value
                .toLowerCase()
                .replace(/[áàảãạăắằẳẵặâấầẩẫậ]/g, 'a')
                .replace(/[éèẻẽẹêếềểễệ]/g, 'e')
                .replace(/[íìỉĩị]/g, 'i')
                .replace(/[óòỏõọôốồổỗộơớờởỡợ]/g, 'o')
                .replace(/[úùủũụưứừửữự]/g, 'u')
                .replace(/[ýỳỷỹỵ]/g, 'y')
                .replace(/đ/g, 'd')
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim('-');
            slugInput.value = slug;
        }
    });

    slugInput.addEventListener('input', function() {
        this.dataset.auto = 'false';
    });

    // Image preview functionality
    const imageInput = document.getElementById('image_url');
    const imagePreview = document.getElementById('image-preview');
    const previewImg = document.getElementById('preview-img');

    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                imagePreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            imagePreview.style.display = 'none';
        }
    });

    // Form validation
    const form = document.getElementById('productForm');
    form.addEventListener('submit', function(e) {
        if (!form.checkValidity()) {
            e.preventDefault();
            e.stopPropagation();
        }
        form.classList.add('was-validated');
    });

    // Price formatting
    const priceInput = document.getElementById('price');
    priceInput.addEventListener('blur', function() {
        if (this.value) {
            const value = parseFloat(this.value);
            if (!isNaN(value)) {
                this.value = value.toFixed(2);
            }
        }
    });
});

// Show success/error messages
function showAlert(type, message) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type === 'error' ? 'danger' : type} alert-dismissible fade show`;
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

    const container = document.querySelector('.container-fluid');
    container.insertBefore(alertDiv, container.firstChild);

    setTimeout(() => {
        alertDiv.remove();
    }, 5000);
}
</script>
@endpush
