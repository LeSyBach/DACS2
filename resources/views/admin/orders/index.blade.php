@extends('admin.layouts.guest')

@section('title', 'Quản lý Đơn hàng')

@section('content')
    <div class="row">
        <div class="l-12">
            <h1 class="admin-page-heading">Danh sách Đơn hàng</h1>
            
            @if (session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            <div class="admin-table-card">
                
                {{-- FORM FILTER VÀ SEARCH --}}
                <div class="table-controls">
                    <div class="filter-buttons">
                        <button type="button" class="btn-filter {{ request('status') == '' ? 'active' : '' }}" data-status="">
                            Tất cả
                        </button>
                        <button type="button" class="btn-filter {{ request('status') == 'pending' ? 'active' : '' }}" data-status="pending">
                            Chưa duyệt
                        </button>
                        <button type="button" class="btn-filter {{ request('status') == 'processing' ? 'active' : '' }}" data-status="processing">
                            Đang xử lý
                        </button>
                        <button type="button" class="btn-filter {{ request('status') == 'completed' ? 'active' : '' }}" data-status="completed">
                            Đã hoàn thành
                        </button>
                        <button type="button" class="btn-filter {{ request('status') == 'cancelled' ? 'active' : '' }}" data-status="cancelled">
                            Đã hủy
                        </button>
                    </div>
                    
                    <div class="search-box">
                        <input type="text" 
                               name="search" 
                               id="searchInput" 
                               value="{{ request('search') }}"
                               placeholder="Tìm kiếm theo tên, SĐT, email..." 
                               class="form-control-sm">
                        <span id="currentFilter" style="font-size: 12px; color: #666; margin-left: 10px;"></span>
                    </div>
                </div>

                {{-- BẢNG DANH SÁCH ĐƠN HÀNG --}}
                <div class="order-list-table">
                    <table class="table order-table">
                        <thead>
                            <tr>
                                <th>Mã ĐH</th>
                                <th>Tên Khách hàng</th>
                                <th>Ngày đặt hàng</th>
                                <th>Tổng tiền</th>
                                <th>Địa chỉ</th>
                                <th>SĐT</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody id="orderTableBody">
                            @include('admin.orders.partials.table_rows', ['orders' => $orders])
                        </tbody>
                    </table>
                </div>
                
                {{-- Phân trang --}}
                <div id="paginationContainer">
                    @if($orders->hasPages())
                        <div class="pagination-links mt-4">
                            {{ $orders->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- JavaScript cho Filter và Search --}}
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterButtons = document.querySelectorAll('.btn-filter');
        const searchInput = document.getElementById('searchInput');
        const currentFilter = document.getElementById('currentFilter');
        let currentStatus = '{{ request("status") }}';

        function updateFilterText() {
            const activeBtn = document.querySelector('.btn-filter.active');
            const filterName = activeBtn ? activeBtn.textContent.trim() : 'Tất cả';
            
            if (searchInput.value) {
                currentFilter.textContent = `(Đang tìm trong: ${filterName})`;
            } else {
                currentFilter.textContent = '';
            }
        }

        function fetchOrders() {
            const params = new URLSearchParams({
                search: searchInput.value,
                status: currentStatus
            });

            fetch("{{ route('admin.orders.ajaxSearch') }}?" + params.toString())
            .then(res => res.json())
            .then(data => {
                document.getElementById('orderTableBody').innerHTML = data.html;
                document.getElementById('paginationContainer').innerHTML = data.pagination || '';
                updateFilterText();
            })
            .catch(err => console.error('Error:', err));
        }

        // Filter buttons
        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                filterButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                currentStatus = this.getAttribute('data-status');
                fetchOrders();
            });
        });

        // Search với debounce
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                fetchOrders();
            }, 500);
        });

        // Clear search on ESC
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                this.value = '';
                fetchOrders();
            }
        });

        // Update text khi load trang
        updateFilterText();
    });
    </script>
@endsection