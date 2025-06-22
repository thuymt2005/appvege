@extends('layouts.admin')

@section('title', 'Tạo người dùng mới')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}" class="text-decoration-none">
                    <i class="fas fa-home"></i> Dashboard
                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.users.index') }}" class="text-decoration-none">
                    <i class="fas fa-users"></i> Quản lý người dùng
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Tạo người dùng mới</li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-user-plus text-primary me-2"></i>
                Tạo người dùng mới
            </h1>
            <p class="text-muted mb-0">Thêm người dùng mới vào hệ thống</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>

    <!-- Main Content -->
    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user-edit me-2"></i>
                        Thông tin người dùng
                    </h5>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Có lỗi xảy ra!</strong> Vui lòng kiểm tra lại thông tin.
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data" id="createUserForm">
                        @csrf

                        <!-- Contact Information -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary border-bottom pb-2 mb-3">
                                    <i class="fas fa-address-book me-1"></i>
                                    Thông tin liên hệ
                                </h6>
                            </div>
                                <label for="name" class="form-label required">
                                    <i class="fas fa-user text-muted me-1"></i>
                                    Họ và tên
                                </label>
                                <input type="text"
                                       class="form-control @error('name') is-invalid @enderror"
                                       id="name"
                                       name="name"
                                       value="{{ old('name') }}"
                                       placeholder="Nhập họ và tên"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label required">
                                    <i class="fas fa-envelope text-muted me-1"></i>
                                    Email
                                </label>
                                <input type="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       id="email"
                                       name="email"
                                       value="{{ old('email') }}"
                                       placeholder="example@email.com"
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Personal Information -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary border-bottom pb-2 mb-3">
                                    <i class="fas fa-id-card me-1"></i>
                                    Thông tin cá nhân
                                </h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="date_of_birth" class="form-label">
                                    <i class="fas fa-birthday-cake text-muted me-1"></i>
                                    Ngày sinh
                                </label>
                                <input type="date"
                                       class="form-control @error('date_of_birth') is-invalid @enderror"
                                       id="date_of_birth"
                                       name="date_of_birth"
                                       value="{{ old('date_of_birth') }}"
                                       max="{{ date('Y-m-d') }}">
                                @error('date_of_birth')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="gender" class="form-label">
                                    <i class="fas fa-venus-mars text-muted me-1"></i>
                                    Giới tính
                                </label>
                                <select class="form-select @error('gender') is-invalid @enderror"
                                        id="gender"
                                        name="gender">
                                    <option value="">-- Chọn giới tính --</option>
                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>
                                        Nam
                                    </option>
                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>
                                        Nữ
                                    </option>
                                    <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>
                                        Khác
                                    </option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">
                                    <i class="fas fa-phone text-muted me-1"></i>
                                    Số điện thoại
                                </label>
                                <input type="text"
                                       class="form-control @error('phone') is-invalid @enderror"
                                       id="phone"
                                       name="phone"
                                       value="{{ old('phone') }}"
                                       placeholder="0123456789">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="role" class="form-label required">
                                    <i class="fas fa-user-tag text-muted me-1"></i>
                                    Vai trò
                                </label>
                                <select class="form-select @error('role') is-invalid @enderror"
                                        id="role"
                                        name="role"
                                        required>
                                    <option value="">-- Chọn vai trò --</option>
                                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>
                                        Người dùng
                                    </option>
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>
                                        Quản trị viên
                                    </option>
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Address Information -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary border-bottom pb-2 mb-3">
                                    <i class="fas fa-map-marker-alt me-1"></i>
                                    Địa chỉ
                                </h6>
                            </div>

                            <div class="col-12 mb-3">
                                <label for="address" class="form-label">
                                    <i class="fas fa-home text-muted me-1"></i>
                                    Địa chỉ chi tiết
                                </label>
                                <textarea class="form-control @error('address') is-invalid @enderror"
                                          id="address"
                                          name="address"
                                          rows="3"
                                          placeholder="Nhập địa chỉ chi tiết">{{ old('address') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Password Information -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary border-bottom pb-2 mb-3">
                                    <i class="fas fa-lock me-1"></i>
                                    Mật khẩu
                                </h6>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label required">
                                    <i class="fas fa-key text-muted me-1"></i>
                                    Mật khẩu
                                </label>
                                <div class="input-group">
                                    <input type="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           id="password"
                                           name="password"
                                           placeholder="Nhập mật khẩu (tối thiểu 8 ký tự)"
                                           required>
                                    <button class="btn btn-outline-secondary"
                                            type="button"
                                            id="togglePassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    <i class="fas fa-info-circle text-info me-1"></i>
                                    Mật khẩu phải có ít nhất 8 ký tự
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label required">
                                    <i class="fas fa-check-double text-muted me-1"></i>
                                    Xác nhận mật khẩu
                                </label>
                                <div class="input-group">
                                    <input type="password"
                                           class="form-control"
                                           id="password_confirmation"
                                           name="password_confirmation"
                                           placeholder="Nhập lại mật khẩu"
                                           required>
                                    <button class="btn btn-outline-secondary"
                                            type="button"
                                            id="togglePasswordConfirm">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- <!-- Status -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary border-bottom pb-2 mb-3">
                                    <i class="fas fa-cog me-1"></i>
                                    Cài đặt tài khoản
                                </h6>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">
                                    <i class="fas fa-toggle-on text-muted me-1"></i>
                                    Trạng thái
                                </label>
                                <select class="form-select @error('status') is-invalid @enderror"
                                        id="status"
                                        name="status">
                                    <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>
                                        <i class="fas fa-check-circle text-success"></i> Hoạt động
                                    </option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>
                                        <i class="fas fa-times-circle text-danger"></i> Tạm khóa
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-check form-switch mt-4">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           id="send_welcome_email"
                                           name="send_welcome_email"
                                           value="1"
                                           {{ old('send_welcome_email') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="send_welcome_email">
                                        <i class="fas fa-paper-plane text-muted me-1"></i>
                                        Gửi email chào mừng
                                    </label>
                                </div>
                            </div>
                        </div> --}}

                        <!-- Action Buttons -->
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                                    <div class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i>
                                        <span class="required">*</span> Trường bắt buộc
                                    </div>
                                    <div>
                                        <a href="{{ route('admin.users.index') }}"
                                           class="btn btn-outline-secondary me-2">
                                            <i class="fas fa-times"></i> Hủy bỏ
                                        </a>
                                        <button type="reset" class="btn btn-outline-warning me-2">
                                            <i class="fas fa-undo"></i> Đặt lại
                                        </button>
                                        <button type="submit" class="btn btn-primary" id="submitBtn">
                                            <i class="fas fa-save"></i> Tạo người dùng
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .required::after {
        content: " *";
        color: #dc3545;
        font-weight: bold;
    }

    .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }

    .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }

    .card {
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }

    .btn {
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-1px);
    }

    .alert {
        border: none;
        border-radius: 0.5rem;
    }

    .breadcrumb-item + .breadcrumb-item::before {
        content: ">";
        font-weight: bold;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle password visibility
    const togglePassword = document.getElementById('togglePassword');
    const passwordField = document.getElementById('password');
    const togglePasswordConfirm = document.getElementById('togglePasswordConfirm');
    const passwordConfirmField = document.getElementById('password_confirmation');

    function togglePasswordVisibility(toggleBtn, passwordInput) {
        toggleBtn.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            const icon = toggleBtn.querySelector('i');
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        });
    }

    togglePasswordVisibility(togglePassword, passwordField);
    togglePasswordVisibility(togglePasswordConfirm, passwordConfirmField);

    // Form validation
    const form = document.getElementById('createUserForm');
    const submitBtn = document.getElementById('submitBtn');

    form.addEventListener('submit', function(e) {
        const password = passwordField.value;
        const passwordConfirm = passwordConfirmField.value;

        if (password !== passwordConfirm) {
            e.preventDefault();
            passwordConfirmField.classList.add('is-invalid');

            // Remove existing feedback
            const existingFeedback = passwordConfirmField.parentNode.querySelector('.invalid-feedback');
            if (existingFeedback) {
                existingFeedback.remove();
            }

            // Add new feedback
            const feedback = document.createElement('div');
            feedback.className = 'invalid-feedback';
            feedback.textContent = 'Mật khẩu xác nhận không khớp';
            passwordConfirmField.parentNode.appendChild(feedback);

            return false;
        }

        // Show loading state
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang tạo...';
    });

    // Remove invalid class when user types
    passwordConfirmField.addEventListener('input', function() {
        this.classList.remove('is-invalid');
        const feedback = this.parentNode.querySelector('.invalid-feedback');
        if (feedback && feedback.textContent === 'Mật khẩu xác nhận không khớp') {
            feedback.remove();
        }
    });

    // Age calculation from date of birth
    const dobInput = document.getElementById('date_of_birth');
    dobInput.addEventListener('change', function() {
        const dob = new Date(this.value);
        const today = new Date();
        const age = today.getFullYear() - dob.getFullYear();
        const monthDiff = today.getMonth() - dob.getMonth();

        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
            age--;
        }

        // Optional: Display age info
        if (age < 16) {
            alert('Người dùng phải từ 16 tuổi trở lên');
            this.value = '';
        }
    });

    // Phone number formatting
    const phoneInput = document.getElementById('phone');
    phoneInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 10) {
            value = value.slice(0, 10);
        }
        e.target.value = value;
    });

    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            if (alert && alert.classList.contains('show')) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, 5000);
    });
});
</script>
@endpush
