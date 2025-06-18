@extends('layouts.admin')

@section('title', 'Quản lý danh mục')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 mb-0 text-gray-800">
            <i class="fas fa-list-ul me-2"></i>Quản lý danh mục
        </h2>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
            <i class="fas fa-plus me-2"></i>Thêm danh mục
        </button>
    </div>

    <!-- Search and Filter -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.categories.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label for="search" class="form-label">Tìm kiếm</label>
                    <input type="text" class="form-control" id="search" name="search"
                           placeholder="Tên danh mục..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label">Trạng thái</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">Tất cả</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Hoạt động</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Tạm dừng</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="sort" class="form-label">Sắp xếp</label>
                    <select class="form-select" id="sort" name="sort">
                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Tên A-Z</option>
                        <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Tên Z-A</option>
                        <option value="created_desc" {{ request('sort') == 'created_desc' ? 'selected' : '' }}>Mới nhất</option>
                        <option value="created_asc" {{ request('sort') == 'created_asc' ? 'selected' : '' }}>Cũ nhất</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-outline-primary me-2">
                        <i class="fas fa-search"></i>
                    </button>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Categories Table -->
    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Danh sách danh mục
                <span class="badge bg-primary rounded-pill ms-2">{{ $categories->total() ?? 0 }}</span>
            </h6>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th width="50px">#</th>
                            <th width="80px">Hình ảnh</th>
                            <th>Tên danh mục</th>
                            <th>Slug</th>
                            <th width="100px">Sản phẩm</th>
                            <th width="100px">Trạng thái</th>
                            <th width="120px">Ngày tạo</th>
                            <th width="150px">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories ?? [] as $index => $category)
                            <tr>
                                <td>{{ ($categories->currentPage() - 1) * $categories->perPage() + $index + 1 }}</td>
                                <td>
                                    @if($category->image)
                                        <img src="{{ asset('storage/categories/' . $category->image) }}"
                                             alt="{{ $category->name }}"
                                             class="img-thumbnail"
                                             style="width: 50px; height: 50px; object-fit: cover;">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center"
                                             style="width: 50px; height: 50px;">
                                            <i class="fas fa-image text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $category->name }}</strong>
                                    @if($category->description)
                                        <br><small class="text-muted">{{ Str::limit($category->description, 50) }}</small>
                                    @endif
                                </td>
                                <td>
                                    <code>{{ $category->slug }}</code>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $category->products_count ?? 0 }}</span>
                                </td>
                                <td>
                                    @if($category->status == 'active')
                                        <span class="badge bg-success">
                                            <i class="fas fa-check me-1"></i>Hoạt động
                                        </span>
                                    @else
                                        <span class="badge bg-warning">
                                            <i class="fas fa-pause me-1"></i>Tạm dừng
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <small>{{ $category->created_at->format('d/m/Y H:i') }}</small>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button"
                                                class="btn btn-sm btn-outline-primary"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editCategoryModal"
                                                onclick="editCategory({{ $category->id }}, '{{ $category->name }}', '{{ $category->slug }}', '{{ $category->description }}', '{{ $category->status }}', '{{ $category->image }}')">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button"
                                                class="btn btn-sm btn-outline-danger"
                                                onclick="confirmDelete({{ $category->id }}, '{{ $category->name }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-inbox fa-3x mb-3"></i>
                                        <p>Không có danh mục nào</p>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                                            <i class="fas fa-plus me-2"></i>Thêm danh mục đầu tiên
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if(isset($categories) && $categories->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted small">
                        Hiển thị {{ $categories->firstItem() }} - {{ $categories->lastItem() }}
                        trong tổng số {{ $categories->total() }} kết quả
                    </div>
                    {{ $categories->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryModalLabel">
                    <i class="fas fa-plus me-2"></i>Thêm danh mục mới
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="add_name" class="form-label">Tên danh mục <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="add_name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="add_slug" class="form-label">Slug</label>
                        <input type="text" class="form-control" id="add_slug" name="slug"
                               placeholder="Tự động tạo từ tên danh mục">
                    </div>
                    <div class="mb-3">
                        <label for="add_description" class="form-label">Mô tả</label>
                        <textarea class="form-control" id="add_description" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="add_image" class="form-label">Hình ảnh</label>
                        <input type="file" class="form-control" id="add_image" name="image" accept="image/*">
                        <div class="form-text">Định dạng: JPG, PNG, GIF. Kích thước tối đa: 2MB</div>
                    </div>
                    <div class="mb-3">
                        <label for="add_status" class="form-label">Trạng thái</label>
                        <select class="form-select" id="add_status" name="status">
                            <option value="active">Hoạt động</option>
                            <option value="inactive">Tạm dừng</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Lưu danh mục
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCategoryModalLabel">
                    <i class="fas fa-edit me-2"></i>Chỉnh sửa danh mục
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" enctype="multipart/form-data" id="editCategoryForm">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Tên danh mục <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_slug" class="form-label">Slug</label>
                        <input type="text" class="form-control" id="edit_slug" name="slug">
                    </div>
                    <div class="mb-3">
                        <label for="edit_description" class="form-label">Mô tả</label>
                        <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_image" class="form-label">Hình ảnh</label>
                        <input type="file" class="form-control" id="edit_image" name="image" accept="image/*">
                        <div class="form-text">Định dạng: JPG, PNG, GIF. Kích thước tối đa: 2MB</div>
                        <div id="current_image_preview" class="mt-2"></div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_status" class="form-label">Trạng thái</label>
                        <select class="form-select" id="edit_status" name="status">
                            <option value="active">Hoạt động</option>
                            <option value="inactive">Tạm dừng</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Cập nhật
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteCategoryModal" tabindex="-1" aria-labelledby="deleteCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger" id="deleteCategoryModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>Xác nhận xóa
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa danh mục <strong id="delete_category_name"></strong> không?</p>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Lưu ý:</strong> Việc xóa danh mục có thể ảnh hưởng đến các sản phẩm liên quan.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <form action="" method="POST" id="deleteCategoryForm" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-2"></i>Xóa danh mục
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Auto generate slug from name
document.getElementById('add_name').addEventListener('input', function() {
    let name = this.value;
    let slug = name.toLowerCase()
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '')
        .replace(/đ/g, 'd')
        .replace(/Đ/g, 'D')
        .replace(/[^a-z0-9\s-]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-')
        .trim('-');
    document.getElementById('add_slug').value = slug;
});

// Edit category function
function editCategory(id, name, slug, description, status, image) {
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_slug').value = slug;
    document.getElementById('edit_description').value = description;
    document.getElementById('edit_status').value = status;

    // Update form action
    document.getElementById('editCategoryForm').action = `/admin/categories/${id}`;

    // Show current image if exists
    const imagePreview = document.getElementById('current_image_preview');
    if (image) {
        imagePreview.innerHTML = `
            <div class="current-image">
                <label class="form-label">Hình ảnh hiện tại:</label>
                <br>
                <img src="/storage/categories/${image}" alt="${name}" class="img-thumbnail" style="max-width: 100px;">
            </div>
        `;
    } else {
        imagePreview.innerHTML = '';
    }
}

// Confirm delete function
function confirmDelete(id, name) {
    document.getElementById('delete_category_name').textContent = name;
    document.getElementById('deleteCategoryForm').action = `/admin/categories/${id}`;

    const deleteModal = new bootstrap.Modal(document.getElementById('deleteCategoryModal'));
    deleteModal.show();
}

// Auto-hide alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
});
</script>
@endpush
