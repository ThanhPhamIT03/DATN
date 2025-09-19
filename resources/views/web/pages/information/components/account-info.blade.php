{{-- Thông tin tài khoản --}}
<div class="card shadow-sm p-3 mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0 ps-2">Thông tin tài khoản</h5>
        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#updateModal">
            <i class="bi bi-pencil-square"></i>
            Cập nhật</button>
    </div>

    {{-- Modal chỉnh sửa thông tin cá nhân --}}
    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <!-- Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Cập nhật thông tin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>

                <!-- Body -->
                <div class="modal-body">
                    <form action="{{ route('web.info.account.update') }}" method="POST" id="updateForm">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Họ tên</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ old('name', $user->name ?? '') }}" required>
                            </div>

                            <!-- Số điện thoại -->
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Số điện thoại</label>
                                <input type="text" class="form-control" id="phone" name="phone"
                                    value="{{ old('phone', $user->phone ?? '') }}" required>
                            </div>

                            <!-- Email -->
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ old('email', $user->email ?? '') }}" required>
                            </div>

                            <!-- Ngày sinh -->
                            <div class="col-md-6">
                                <label for="dob" class="form-label">Ngày sinh</label>
                                <input type="date" class="form-control" id="dob" name="birthday"
                                    value="{{ old('birthday', $user->birthday ?? '') }}" required>
                            </div>

                            <!-- Địa chỉ mặc định -->
                            <div class="col-md-12">
                                <label for="address" class="form-label">Địa chỉ mặc định</label>
                                <input type="text" class="form-control" id="address" name="default_address"
                                    value="{{ old('default_address', $user->default_address ?? '') }}" required>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" id="btn-update">Lưu thay đổi</button>
                </div>

            </div>
        </div>
    </div>

    <div class="row g-3">
        <!-- Họ tên -->
        <div class="col-md-6">
            <label for="name" class="form-label">Họ tên</label>
            <input type="text" class="form-control" id="name" name="name"
                value="{{ old('name', $user->name ?? '') }}" readonly>
        </div>

        <!-- Số điện thoại -->
        <div class="col-md-6">
            <label for="phone" class="form-label">Số điện thoại</label>
            <input type="text" class="form-control" id="phone" name="phone"
                value="{{ old('phone', $user->phone ?? '') }}" readonly>
        </div>

        <!-- Email -->
        <div class="col-md-6">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email"
                value="{{ old('email', $user->email ?? '') }}" readonly>
        </div>

        <!-- Ngày sinh -->
        <div class="col-md-6">
            <label for="dob" class="form-label">Ngày sinh</label>
            <input type="date" class="form-control" id="dob" name="birthday"
                value="{{ old('birthday', $user->birthday ?? '') }}" readonly>
        </div>

        <!-- Địa chỉ mặc định -->
        <div class="col-md-12">
            <label for="address" class="form-label">Địa chỉ mặc định</label>
            <input type="text" class="form-control" id="address" name="default_address"
                value="{{ old('default_address', $user->default_address ?? '') }}" readonly>
        </div>
    </div>
</div>

{{-- Địa chỉ --}}
<div class="card shadow-sm p-3 mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0 ps-2">Địa chỉ</h5>
        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
            data-bs-target="#addAddressModal">
            + Thêm địa chỉ
        </button>
    </div>

    <!-- Modal Thêm Địa Chỉ -->
    <div class="modal fade" id="addAddressModal" tabindex="-1" aria-labelledby="addAddressModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <!-- Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="addAddressModalLabel">Thêm địa chỉ mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>

                <!-- Body -->
                <div class="modal-body">
                    <form id="addAddressForm" action="{{ route('web.info.account.add.address') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="fullAddress" class="form-label">Địa chỉ</label>
                                <textarea class="form-control" id="fullAddress" name="address" rows="3" placeholder="Nhập địa chỉ đầy đủ"></textarea>
                            </div>
                            <div class="col-12">
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" id="isDefault"
                                        name="is_default">
                                    <label class="form-check-label" for="isDefault">
                                        Đặt làm địa chỉ mặc định
                                    </label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-primary" id="btn-add-address">Lưu địa chỉ</button>
                </div>

            </div>
        </div>
    </div>

    <div class="list-group">
        @if($user->default_address)
            <div class="list-group-item d-flex justify-content-between align-items-start">
                <div>
                    <div>{{ $user->default_address }}</div>
                    <span class="badge bg-success mt-1">Mặc định</span>
                </div>
            </div>
        @else
            <div class="list-group-item d-flex justify-content-center align-items-center">
                <div>
                    <div class="text-danger">Chưa cập nhật địa chỉ</div>
                </div>
            </div>  
        @endif
        @forelse($user->address as $key => $address)
            <div class="list-group-item d-flex justify-content-between align-items-start">
                <div>
                    <div>{{ $address }}</div>
                </div>
                <div class="ms-3">
                    <button class="btn btn-sm btn-danger btn-delete ladda-button" data-style="zoom-in" data-key="{{ $key }}" data-url="{{ route('web.info.account.delete.address') }}">Xóa</button>
                </div>
            </div>
        @empty

        @endforelse
    </div>
</div>


{{-- Mật khẩu --}}
<div class="card shadow-sm p-2">
    <div class="d-flex align-items-center">
        <h5 class="pt-2 ps-2">Mật khẩu</h5>
    </div>
</div>
