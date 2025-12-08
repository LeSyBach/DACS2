@forelse ($orders as $order)
    @php
        $statusMap = [
            'pending' => ['label' => 'Chưa duyệt', 'class' => 'warning'],
            'processing' => ['label' => 'Đang xử lý', 'class' => 'secondary'],
            'shipped' => ['label' => 'Đang giao', 'class' => 'info'],
            'completed' => ['label' => 'Hoàn thành', 'class' => 'success'],
            'cancelled' => ['label' => 'Đã hủy', 'class' => 'danger'],
        ];
        
        $status = $statusMap[$order->status] ?? ['label' => $order->status, 'class' => 'secondary'];
    @endphp

    <tr class="order-row">
        <td data-label="Mã ĐH">#{{ $order->id }}</td>
        <td data-label="Tên KH">{{ $order->customer_name }}</td>
        <td data-label="Ngày đặt">{{ $order->created_at->format('d/m/Y H:i') }}</td>
        <td data-label="Tổng tiền" class="price-col">{{ number_format($order->total_price, 0, ',', '.') }}₫</td>
        <td data-label="Địa chỉ">{{ Str::limit($order->shipping_address, 30) }}</td>
        <td data-label="SĐT">{{ $order->customer_phone }}</td>

        <td data-label="Trạng thái">
            <span class="badge status-{{ $status['class'] }}">
                {{ $status['label'] }}
            </span>
        </td>

        <td data-label="Hành động">
            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-info">
                <i class="fas fa-eye"></i> Xem
            </a>
            <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này?')">
                    <i class="fas fa-trash"></i> Xóa
                </button>
            </form>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="8" style="text-align: center; padding: 40px;">
            <i class="fas fa-shopping-cart" style="font-size: 48px; color: #ccc; margin-bottom: 15px;"></i>
            <p style="color: #999; font-size: 16px;">
                @if(request('search') || request('status'))
                    Không tìm thấy đơn hàng nào phù hợp
                @else
                    Chưa có đơn hàng nào
                @endif
            </p>
        </td>
    </tr>
@endforelse