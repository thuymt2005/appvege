<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hồ sơ cá nhân - VeggieFresh</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
            color: white;
            padding: 30px;
            text-align: center;
            position: relative;
        }

        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="10" cy="10" r="2" fill="rgba(255,255,255,0.1)"/><circle cx="30" cy="30" r="1.5" fill="rgba(255,255,255,0.08)"/><circle cx="70" cy="20" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="90" cy="40" r="2" fill="rgba(255,255,255,0.06)"/></svg>');
            animation: float 20s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            margin: 0 auto 20px;
            background: linear-gradient(45deg, #FF6B6B, #4ECDC4);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
            color: white;
            font-weight: bold;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 1;
            transition: transform 0.3s ease;
        }

        .profile-avatar:hover {
            transform: scale(1.05);
        }

        .profile-name {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
        }

        .profile-email {
            font-size: 16px;
            opacity: 0.9;
            position: relative;
            z-index: 1;
        }

        .nav-tabs {
            display: flex;
            background: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            overflow-x: auto;
        }

        .nav-tab {
            padding: 15px 25px;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            color: #6c757d;
            transition: all 0.3s ease;
            white-space: nowrap;
            position: relative;
        }

        .nav-tab.active {
            color: #4CAF50;
            background: white;
        }

        .nav-tab::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: #4CAF50;
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .nav-tab.active::after {
            transform: scaleX(1);
        }

        .nav-tab:hover {
            color: #4CAF50;
            background: rgba(76, 175, 80, 0.05);
        }

        .tab-content {
            padding: 30px;
        }

        .tab-pane {
            display: none;
            animation: fadeIn 0.5s ease;
        }

        .tab-pane.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: #4CAF50;
            box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
        }

        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(76, 175, 80, 0.3);
        }

        .order-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            border-left: 5px solid #4CAF50;
        }

        .order-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .order-id {
            font-weight: 600;
            color: #4CAF50;
            font-size: 18px;
        }

        .order-status {
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-completed {
            background: #d4edda;
            color: #155724;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-processing {
            background: #cce5ff;
            color: #004085;
        }

        .order-items {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 15px;
        }

        .order-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .item-image {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            background: linear-gradient(45deg, #FF6B6B, #4ECDC4);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .item-details h4 {
            margin: 0;
            font-size: 14px;
            color: #333;
        }

        .item-details p {
            margin: 0;
            font-size: 12px;
            color: #666;
        }

        .order-total {
            text-align: right;
            font-size: 18px;
            font-weight: 600;
            color: #4CAF50;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 25px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-number {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .stat-label {
            font-size: 16px;
            opacity: 0.9;
        }

        .address-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .address-card:hover {
            transform: translateY(-3px);
        }

        .address-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .address-type {
            background: #4CAF50;
            color: white;
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 600;
        }

        .btn-edit, .btn-delete {
            padding: 8px 15px;
            font-size: 14px;
            margin-left: 10px;
        }

        .btn-edit {
            background: #17a2b8;
            color: white;
        }

        .btn-delete {
            background: #dc3545;
            color: white;
        }

        @media (max-width: 768px) {
            .container {
                margin: 10px;
                border-radius: 15px;
            }

            .nav-tabs {
                flex-wrap: nowrap;
            }

            .order-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header Profile -->
        <div class="header">
            <div class="profile-avatar">NH</div>
            <div class="profile-name">Nguyễn Văn Hoàng</div>
            <div class="profile-email">hoang.nguyen@email.com</div>
        </div>

        <!-- Navigation Tabs -->
        <div class="nav-tabs">
            <button class="nav-tab active" onclick="showTab('profile')">
                📋 Thông tin cá nhân
            </button>
            <button class="nav-tab" onclick="showTab('orders')">
                📦 Đơn hàng của tôi
            </button>
            <button class="nav-tab" onclick="showTab('addresses')">
                📍 Địa chỉ giao hàng
            </button>
            <button class="nav-tab" onclick="showTab('stats')">
                📊 Thống kê
            </button>
        </div>

        <!-- Tab Contents -->
        <div class="tab-content">
            <!-- Profile Tab -->
            <div id="profile" class="tab-pane active">
                <h3 style="margin-bottom: 25px; color: #333;">Thông tin cá nhân</h3>
                <form>
                    <div class="form-group">
                        <label class="form-label">Họ và tên</label>
                        <input type="text" class="form-control" value="Nguyễn Văn Hoàng">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" value="hoang.nguyen@email.com">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Số điện thoại</label>
                        <input type="tel" class="form-control" value="0987654321">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Ngày sinh</label>
                        <input type="date" class="form-control" value="1990-05-15">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Giới tính</label>
                        <select class="form-control">
                            <option>Nam</option>
                            <option>Nữ</option>
                            <option>Khác</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">💾 Cập nhật thông tin</button>
                </form>
            </div>

            <!-- Orders Tab -->
            <div id="orders" class="tab-pane">
                <h3 style="margin-bottom: 25px; color: #333;">Đơn hàng của tôi</h3>

                <div class="order-card">
                    <div class="order-header">
                        <div class="order-id">#DH2024001</div>
                        <div class="order-status status-completed">Hoàn thành</div>
                    </div>
                    <div class="order-items">
                        <div class="order-item">
                            <div class="item-image">🥕</div>
                            <div class="item-details">
                                <h4>Cà rốt Đà Lạt</h4>
                                <p>2kg × 25,000đ</p>
                            </div>
                        </div>
                        <div class="order-item">
                            <div class="item-image">🥬</div>
                            <div class="item-details">
                                <h4>Rau cải xanh</h4>
                                <p>1.5kg × 20,000đ</p>
                            </div>
                        </div>
                        <div class="order-item">
                            <div class="item-image">🍎</div>
                            <div class="item-details">
                                <h4>Táo Fuji</h4>
                                <p>3kg × 45,000đ</p>
                            </div>
                        </div>
                    </div>
                    <div class="order-total">Tổng: 215,000đ</div>
                </div>

                <div class="order-card">
                    <div class="order-header">
                        <div class="order-id">#DH2024002</div>
                        <div class="order-status status-processing">Đang xử lý</div>
                    </div>
                    <div class="order-items">
                        <div class="order-item">
                            <div class="item-image">🥒</div>
                            <div class="item-details">
                                <h4>Dưa chuột</h4>
                                <p>2kg × 18,000đ</p>
                            </div>
                        </div>
                        <div class="order-item">
                            <div class="item-image">🍌</div>
                            <div class="item-details">
                                <h4>Chuối tiêu</h4>
                                <p>2 nải × 30,000đ</p>
                            </div>
                        </div>
                    </div>
                    <div class="order-total">Tổng: 96,000đ</div>
                </div>

                <div class="order-card">
                    <div class="order-header">
                        <div class="order-id">#DH2024003</div>
                        <div class="order-status status-pending">Chờ xác nhận</div>
                    </div>
                    <div class="order-items">
                        <div class="order-item">
                            <div class="item-image">🍊</div>
                            <div class="item-details">
                                <h4>Cam sành</h4>
                                <p>5kg × 35,000đ</p>
                            </div>
                        </div>
                    </div>
                    <div class="order-total">Tổng: 175,000đ</div>
                </div>
            </div>

            <!-- Addresses Tab -->
            <div id="addresses" class="tab-pane">
                <h3 style="margin-bottom: 25px; color: #333;">Địa chỉ giao hàng</h3>

                <div class="address-card">
                    <div class="address-header">
                        <div class="address-type">Mặc định</div>
                        <div>
                            <button class="btn btn-edit">✏️ Sửa</button>
                            <button class="btn btn-delete">🗑️ Xóa</button>
                        </div>
                    </div>
                    <h4>Nguyễn Văn Hoàng</h4>
                    <p>📞 0987654321</p>
                    <p>📍 123 Đường Láng, Phường Láng Thượng, Quận Đống Đa, Hà Nội</p>
                </div>

                <div class="address-card">
                    <div class="address-header">
                        <div class="address-type" style="background: #6c757d;">Văn phòng</div>
                        <div>
                            <button class="btn btn-edit">✏️ Sửa</button>
                            <button class="btn btn-delete">🗑️ Xóa</button>
                        </div>
                    </div>
                    <h4>Nguyễn Văn Hoàng</h4>
                    <p>📞 0987654321</p>
                    <p>📍 456 Phố Huế, Phường Phố Huế, Quận Hai Bà Trưng, Hà Nội</p>
                </div>

                <button class="btn btn-primary">➕ Thêm địa chỉ mới</button>
            </div>

            <!-- Stats Tab -->
            <div id="stats" class="tab-pane">
                <h3 style="margin-bottom: 25px; color: #333;">Thống kê mua hàng</h3>

                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-number">24</div>
                        <div class="stat-label">Tổng đơn hàng</div>
                    </div>
                    <div class="stat-card" style="background: linear-gradient(135deg, #4ECDC4 0%, #44A08D 100%);">
                        <div class="stat-number">2,340,000đ</div>
                        <div class="stat-label">Tổng chi tiêu</div>
                    </div>
                    <div class="stat-card" style="background: linear-gradient(135deg, #FF6B6B 0%, #EE5A52 100%);">
                        <div class="stat-number">156kg</div>
                        <div class="stat-label">Tổng trọng lượng</div>
                    </div>
                    <div class="stat-card" style="background: linear-gradient(135deg, #FFA726 0%, #FB8C00 100%);">
                        <div class="stat-number">97,500đ</div>
                        <div class="stat-label">Trung bình/đơn</div>
                    </div>
                </div>

                <h4 style="margin: 30px 0 20px; color: #333;">Sản phẩm yêu thích</h4>
                <div class="order-items">
                    <div class="order-item">
                        <div class="item-image">🥕</div>
                        <div class="item-details">
                            <h4>Cà rốt Đà Lạt</h4>
                            <p>Đã mua 8 lần</p>
                        </div>
                    </div>
                    <div class="order-item">
                        <div class="item-image">🍎</div>
                        <div class="item-details">
                            <h4>Táo Fuji</h4>
                            <p>Đã mua 6 lần</p>
                        </div>
                    </div>
                    <div class="order-item">
                        <div class="item-image">🥬</div>
                        <div class="item-details">
                            <h4>Rau cải xanh</h4>
                            <p>Đã mua 5 lần</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showTab(tabName) {
            // Hide all tabs
            const tabs = document.querySelectorAll('.tab-pane');
            tabs.forEach(tab => tab.classList.remove('active'));

            // Remove active class from all nav tabs
            const navTabs = document.querySelectorAll('.nav-tab');
            navTabs.forEach(tab => tab.classList.remove('active'));

            // Show selected tab
            document.getElementById(tabName).classList.add('active');

            // Add active class to clicked nav tab
            event.target.classList.add('active');
        }

        // Add some interactive animations
        document.addEventListener('DOMContentLoaded', function() {
            // Animate cards on scroll
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            // Observe all cards
            const cards = document.querySelectorAll('.order-card, .address-card, .stat-card');
            cards.forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'all 0.6s ease';
                observer.observe(card);
            });

            // Add form validation
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    // Simple validation feedback
                    const button = form.querySelector('.btn-primary');
                    const originalText = button.textContent;
                    button.textContent = '✅ Đã cập nhật!';
                    button.style.background = '#28a745';

                    setTimeout(() => {
                        button.textContent = originalText;
                        button.style.background = '';
                    }, 2000);
                });
            });
        });
    </script>
</body>
</html>
