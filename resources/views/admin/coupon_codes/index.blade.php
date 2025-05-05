@extends('admin.layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        Coupon Codes
                    </h4>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCouponModal">
                            <i class="la la-plus"></i> Add New Coupon Code
                        </button>
                        <div id="alert-container" class="mt-2">
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="couponTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Code</th>
                                    <th>Value</th>
                                    <th>Validity</th>
                                    <th>Utilized</th>
                                    <th>Utilized At</th>
                                    <th>User Id</th>
                                    <th>Active</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="couponTableBody">
                                <!-- Coupons will load here -->



                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Shared Edit Modal -->
    <!-- Shared Edit Modal -->
    <div class="modal fade" id="editCouponModal" tabindex="-1" aria-labelledby="editCouponModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCouponModalLabel">Edit Coupon Code</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editCouponForm">
                        <input type="hidden" id="edit_id">
                        <div class="mb-3">
                            <label for="edit_name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="edit_name" placeholder="Enter coupon name"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_coupon_code" class="form-label">Coupon Code</label>
                            <input type="text" class="form-control" id="edit_coupon_code" placeholder="Enter coupon code"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_coupon_value" class="form-label">Coupon Value</label>
                            <input type="text" class="form-control" id="edit_coupon_value"
                                placeholder="Enter coupon value" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_value_type" class="form-label">Value Type</label>
                            <div class="input-group">
                                <select id="edit_value_type" class="form-select">
                                    <option value="percentage">Percentage</option>
                                    <option value="fixed">Fixed</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_valid_period" class="form-label">Valid Until</label>
                            <input class="form-control" type="date" id="edit_valid_period" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_is_active" class="form-label">Is Active</label>
                            <select class="form-control" id="edit_is_active">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_status" class="form-label">Status</label>
                            <input type="text" class="form-control" id="edit_status" placeholder="Enter coupon status"
                                required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="updateCouponBtn">Update Coupon</button>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="addCouponModal" tabindex="-1" aria-labelledby="addCouponModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCouponModalLabel">Add New Coupon Code</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addCouponForm">
                        <div class="mb-3">
                            <label for="add_name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="add_name" placeholder="Enter coupon name"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="add_coupon_code" class="form-label">Coupon Code</label>
                            <input type="text" class="form-control" id="add_coupon_code"
                                placeholder="Enter coupon code" required>
                        </div>
                        <div class="mb-3">
                            <label for="add_coupon_value" class="form-label">Coupon Value</label>
                            <input type="text" class="form-control" id="add_coupon_value"
                                placeholder="Enter coupon value" required>
                        </div>
                        <div class="mb-3">
                            <label for="add_value_type" class="form-label">Value Type</label>
                            <div class="input-group">
                                <select id="add_value_type" class="form-select">
                                    <option value="percentage">Percentage</option>
                                    <option value="fixed">Fixed</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="add_valid_until" class="form-label">Valid Until</label>
                            <input class="form-control" type="date" id="add_valid_period">
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveCouponBtn">Save Coupon</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('after_scripts')
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>

    <script>
        $(document).ready(function() {
            function showAlert(message, type) {
                const alertContainer = $('#alert-container');
                const alertDiv = $(`<div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>`);
                alertContainer.append(alertDiv);

                // Automatically dismiss after 5 seconds (optional)
                setTimeout(() => {
                    alertDiv.alert('close');
                }, 5000);
            }

            // --- Add New Coupon Functionality ---
            $('#saveCouponBtn').on('click', function() {
                const name = $('#add_name').val();
                const code = $('#add_coupon_code').val();
                const value = $('#add_coupon_value').val();
                const value_type = $('#add_value_type').val();
                const valid_period = $('#add_valid_period').val();

                if (!name || !code || !value || !value_type || !valid_period) {
                    showAlert('Please fill in all required fields.', 'danger');
                    return;
                }

                $.ajax({
                    url: "{{ route('admin.coupons.store') }}",
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        name: name,
                        code: code,
                        value: value,
                        value_type: value_type,
                        valid_period: valid_period
                    },
                    success: function(response) {
                        showAlert('Coupon created successfully!', 'success');
                        loadCoupons();
                        $('#addCouponModal').modal('hide');
                        $('#addCouponForm')[0].reset();
                    },
                    error: function(xhr) {
                        const errors = xhr.responseJSON.errors;
                        if (errors) {
                            let message = '';
                            for (const key in errors) {
                                message += errors[key][0] + '<br>';
                            }
                            showAlert(message, 'danger');
                        } else {
                            showAlert('Something went wrong.', 'danger');
                        }
                    }
                });
            });

            $(document).on('click', '.edit-coupon-btn', function() {
                const id = $(this).data('coupon-id');
                let url = "{{ route('admin.coupons.show', ':id') }}".replace(':id', id);
                $.get(url, function(res) {
                    console.log(res);
                    $('#edit_id').val(res.id);
                    $('#edit_name').val(res.name);
                    $('#edit_coupon_code').val(res.code);
                    $('#edit_coupon_value').val(res.value);
                    $('#edit_value_type').val(res.value_type);
                    $('#edit_valid_period').val(res.created_at ? res.created_at.split('T')[0] : '');
                    $('#edit_is_active').val(res.is_active ? 1 : 0);
                    $('#edit_status').val(res.status);

                    $('#editCouponModal').modal('show');
                });
            });

            // Update Coupon
            $('#updateCouponBtn').on('click', function() {
                const id = $('#edit_id').val();
                const data = {
                    name: $('#edit_name').val(),
                    code: $('#edit_coupon_code').val(),
                    value: $('#edit_coupon_value').val(),
                    value_type: $('#edit_value_type').val(),
                    valid_period: $('#edit_valid_period').val(),
                    is_active: $('#edit_is_active').val(),
                    status: $('#edit_status').val(),
                    _token: $('meta[name="csrf-token"]').attr('content')
                };
                let url = "{{ route('admin.coupons.update', ':id') }}".replace(':id', id);
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: data,
                    success: function(response) {
                        $('#editCouponModal').modal('hide');
                        showAlert(response.message, response.success ? 'success' : 'danger');
                        loadCoupons();
                    },
                    error: function(err) {
                        console.log(err);
                        alert('Failed to update coupon');
                    }
                });
            });

            // Delete Coupon
            $(document).on('click', '.delete-coupon-btn', function() {
                const id = $(this).data('coupon-id');

                if (confirm('Are you sure you want to delete this coupon?')) {
                    let url = "{{ route('admin.coupons.destroy', ':id') }}".replace(':id', id);
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            _method: 'DELETE',
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function() {
                            showAlert('Coupon deleted successfully!', 'success');
                            // loadCoupons();
                            $(`#coupon-row-${id}`).remove();
                        },
                        error: function() {
                            alert('Failed to delete coupon');
                        }
                    });
                }
            });


            function loadCoupons() {
                $.ajax({
                    url: "{{ route('admin.coupons.json') }}",
                    method: 'GET',
                    success: function(response) {
                        let rows = '';
                        response.data.forEach(function(coupon) {
                            const validFrom = coupon.valid_period ? moment(coupon.valid_period)
                                .format('YYYY-MM-DD HH:mm') : '-';
                            const utilizedAt = coupon.utilized_date ? moment(coupon
                                .utilized_date).format('YYYY-MM-DD HH:mm') : '-';
                            const createdAt = coupon.created_at ? moment(coupon.created_at)
                                .format('YYYY-MM-DD HH:mm') : '-';

                            rows += `
                    <tr id="coupon-row-${coupon.id}">
                        <td>${coupon.id}</td>
                        <td class="coupon-name">${coupon.name ?? '-'}</td>
                        <td class="coupon-code">${coupon.code}</td>
                        <td class="coupon-value">${coupon.value ?? '-'}</td>
                        <td>${validFrom}</td>
                        <td class="coupon-utilized">
                            ${coupon.utilized=="Yes" ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-secondary">No</span>'}
                        </td>
                        <td class="coupon-utilized-at">${utilizedAt}</td>
                        <td class="coupon-utilized-by">${coupon.user?.id ?? '-'}</td>
                        <td class="coupon-is-active">
                            ${coupon.is_active ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>'}
                        </td>
                        <td class="coupon-status">${coupon.status ?? '-'}</td>
                        <td class="coupon-created-at">${createdAt}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-warning edit-coupon-btn"
                                data-bs-toggle="modal"
                                data-bs-target="#editCouponModal-${coupon.id}"
                                data-coupon-id="${coupon.id}">
                                <i class="la la-edit"></i> edit
                            </button>
                            <button type="button" class="btn btn-sm btn-danger delete-coupon-btn"
                                data-coupon-id="${coupon.id}" style="margin-top:3px">
                                <i class="la la-trash"></i> delete
                            </button>
                        </td>
                    </tr>
                `;
                        });

                        $('#couponTableBody').html(rows);
                    },
                    error: function(xhr) {
                        console.error('Failed to load coupons', xhr.responseText);
                    }
                });
            }

            loadCoupons();

        });
    </script>
@endsection
