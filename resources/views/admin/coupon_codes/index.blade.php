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
                                <th>Id</th>
                                <th>Name</th>
                                <th>Coupon Code</th>
                                <th>Value</th>
                                <th>Validity Period</th>
                                <th>Utilized</th>
                                <th>Utilized Date</th>
                                <th>User Id</th>
                                <th>Is Active</th>
                                <th>Status</th>
                                <th>Created Date</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $couponCodes = [
                                    [
                                        'id' => 1,
                                        'name' => 'Summer Sale',
                                        'coupon_code' => 'SUMMER25',
                                        'coupon_value' => '25%',
                                        'valid_from' => '2025-06-01 00:00:00',
                                        'valid_until' => '2025-06-30 23:59:59',
                                        'is_utilized' => false,
                                        'utilized_at' => null,
                                        'utilized_by_user_id' => null,
                                        'is_active' => true,
                                        'status' => 'Confirmed',
                                        'created_at' => '2025-05-20 10:00:00',
                                    ],
                                    [
                                        'id' => 2,
                                        'name' => 'Welcome Discount',
                                        'coupon_code' => 'WELCOME10',
                                        'coupon_value' => '10',
                                        'valid_from' => '2025-03-20 00:00:00',
                                        'valid_until' => '2025-04-30 23:59:59',
                                        'is_utilized' => true,
                                        'utilized_at' => '2025-03-25 14:30:00',
                                        'utilized_by_user_id' => 5,
                                        'is_active' => false,
                                        'status' => 'Utilized',
                                        'created_at' => '2025-03-15 09:00:00',
                                    ],
                                    [
                                        'id' => 3,
                                        'name' => 'Special Offer',
                                        'coupon_code' => 'SPECIAL50',
                                        'coupon_value' => '50%',
                                        'valid_from' => '2025-03-26 00:00:00',
                                        'valid_until' => '2025-04-05 23:59:59',
                                        'is_utilized' => false,
                                        'utilized_at' => null,
                                        'utilized_by_user_id' => null,
                                        'is_active' => true,
                                        'status' => 'Confirmed',
                                        'created_at' => '2025-03-22 16:00:00',
                                    ],
                                    [
                                        'id' => 4,
                                        'name' => 'Expired Coupon',
                                        'coupon_code' => 'EXPIRED20',
                                        'coupon_value' => '20',
                                        'valid_from' => '2024-12-01 00:00:00',
                                        'valid_until' => '2024-12-31 23:59:59',
                                        'is_utilized' => false,
                                        'utilized_at' => null,
                                        'utilized_by_user_id' => null,
                                        'is_active' => false,
                                        'status' => '0',
                                        'created_at' => '2024-11-15 11:00:00',
                                    ],
                                ];
                            @endphp
                            @foreach ($couponCodes as $coupon)
                                <tr id="coupon-row-{{ $coupon['id'] }}">
                                    <td>{{ $coupon['id'] }}</td>
                                    <td class="coupon-name">{{ $coupon['name'] ?? '-' }}</td>
                                    <td class="coupon-code">{{ $coupon['coupon_code'] }}</td>
                                    <td class="coupon-value">{{ $coupon['coupon_value'] ?? '-' }}</td>
                                    <td>
                                        @if (isset($coupon['valid_from']) && isset($coupon['valid_until']))
                                            {{ \Carbon\Carbon::parse($coupon['valid_from'])->format('Y-m-d H:i') }} - {{ \Carbon\Carbon::parse($coupon['valid_until'])->format('Y-m-d H:i') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="coupon-utilized">
                                        @if ($coupon['is_utilized'])
                                            <span class="badge bg-success">yes</span>
                                        @else
                                            <span class="badge bg-secondary">no</span>
                                        @endif
                                    </td>
                                    <td class="coupon-utilized-at">{{ $coupon['utilized_at'] ? \Carbon\Carbon::parse($coupon['utilized_at'])->format('Y-m-d H:i') : '-' }}</td>
                                    <td class="coupon-utilized-by">{{ $coupon['utilized_by_user_id'] ?? '-' }}</td>
                                    <td class="coupon-is-active">
                                        @if ($coupon['is_active'])
                                            <span class="badge bg-success">active</span>
                                        @else
                                            <span class="badge bg-danger">inactive</span>
                                        @endif
                                    </td>
                                    <td class="coupon-status">{{ $coupon['status'] ?? '-' }}</td>
                                    <td class="coupon-created-at">{{ $coupon['created_at'] ? \Carbon\Carbon::parse($coupon['created_at'])->format('Y-m-d H:i') : '-' }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning edit-coupon-btn" data-bs-toggle="modal" data-bs-target="#editCouponModal-{{ $coupon['id'] }}" data-coupon-id="{{ $coupon['id'] }}">
                                            <i class="la la-edit"></i> edit
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger delete-coupon-btn" data-coupon-id="{{ $coupon['id'] }}" style="margin-top:3px">
                                            <i class="la la-trash"></i> delete
                                        </button>
                                    </td>
                                </tr>

                                <div class="modal fade" id="editCouponModal-{{ $coupon['id'] }}" tabindex="-1" aria-labelledby="editCouponModalLabel-{{ $coupon['id'] }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editCouponModalLabel-{{ $coupon['id'] }}">Edit Coupon Code</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="editCouponForm-{{ $coupon['id'] }}">
                                                    <input type="hidden" id="edit_id_{{ $coupon['id'] }}" value="{{ $coupon['id'] }}">
                                                    <div class="mb-3">
                                                        <label for="edit_name_{{ $coupon['id'] }}" class="form-label">Name</label>
                                                        <input type="text" class="form-control" id="edit_name_{{ $coupon['id'] }}" value="{{ $coupon['name'] ?? '' }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="edit_coupon_code_{{ $coupon['id'] }}" class="form-label">Coupon Code</label>
                                                        <input type="text" class="form-control" id="edit_coupon_code_{{ $coupon['id'] }}" value="{{ $coupon['coupon_code'] }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="edit_coupon_value_{{ $coupon['id'] }}" class="form-label">Coupon Value</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" id="edit_coupon_value_{{ $coupon['id'] }}" value="{{ str_replace('%', '', $coupon['coupon_value'] ?? '') }}">
                                                            <span class="input-group-text">% or Fixed</span>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="edit_valid_from_{{ $coupon['id'] }}" class="form-label">Valid From</label>
                                                        <input type="datetime-local" class="form-control" id="edit_valid_from_{{ $coupon['id'] }}" value="{{ isset($coupon['valid_from']) ? \Carbon\Carbon::parse($coupon['valid_from'])->format('Y-m-d\TH:i') : '' }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="edit_valid_until_{{ $coupon['id'] }}" class="form-label">Valid Until</label>
                                                        <input type="datetime-local" class="form-control" id="edit_valid_until_{{ $coupon['id'] }}" value="{{ isset($coupon['valid_until']) ? \Carbon\Carbon::parse($coupon['valid_until'])->format('Y-m-d\TH:i') : '' }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="edit_is_active_{{ $coupon['id'] }}" class="form-label">Is Active</label>
                                                        <select class="form-control" id="edit_is_active_{{ $coupon['id'] }}">
                                                            <option value="1" {{ $coupon['is_active'] ? 'selected' : '' }}>Active</option>
                                                            <option value="0" {{ !$coupon['is_active'] ? 'selected' : '' }}>Inactive</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="edit_status_{{ $coupon['id'] }}" class="form-label">Status</label>
                                                        <input type="text" class="form-control" id="edit_status_{{ $coupon['id'] }}" value="{{ $coupon['status'] ?? '' }}">
                                                    </div>
                                                    </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="button" class="btn btn-primary update-coupon-submit-btn" data-coupon-id="{{ $coupon['id'] }}">Update Coupon</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
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
                            <input type="text" class="form-control" id="add_name" placeholder="Enter coupon name" required>
                        </div>
                        <div class="mb-3">
                            <label for="add_coupon_code" class="form-label">Coupon Code</label>
                            <input type="text" class="form-control" id="add_coupon_code" placeholder="Enter coupon code" required>
                        </div>
                        <div class="mb-3">
                            <label for="add_coupon_value" class="form-label">Coupon Value</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="add_coupon_value" placeholder="Enter value (e.g., 10 or 25)" required>
                                <span class="input-group-text">% or Fixed</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="add_valid_from" class="form-label">Valid From</label>
                            <input type="datetime-local" class="form-control" id="add_valid_from" required>
                        </div>
                        <div class="mb-3">
                            <label for="add_valid_until" class="form-label">Valid Until</label>
                            <input type="datetime-local" class="form-control" id="add_valid_until" required>
                        </div>
                        <div class="mb-3">
                            <label for="add_is_active" class="form-label">Is Active</label>
                            <select class="form-control" id="add_is_active">
                                <option value="1" selected>Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="add_status" class="form-label">Status</label>
                            <input type="text" class="form-control" id="add_status" placeholder="Enter status">
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
            const coupon_code = $('#add_coupon_code').val();
            const coupon_value = $('#add_coupon_value').val();
            const valid_from = $('#add_valid_from').val();
            const valid_until = $('#add_valid_until').val();
            const is_active = $('#add_is_active').val();
            const status = $('#add_status').val();

            // Basic frontend validation
            if (!name || !coupon_code || !coupon_value || !valid_from || !valid_until) {
                showAlert('Please fill in all required fields.', 'danger');
                return;
            }

            const newCoupon = {
                id: Math.floor(Math.random() * 1000) + 10, // Simulate ID generation
                name: name,
                coupon_code: coupon_code,
                coupon_value: coupon_value,
                valid_from: valid_from,
                valid_until: valid_until,
                is_utilized: false,
                utilized_at: null,
                utilized_by_user_id: null,
                is_active: is_active === '1',
                status: status,
                created_at: new Date().toISOString().slice(0, 19).replace('T', ' '),
            };

            // Simulate adding to the table (in a real scenario, this would be an AJAX call)
            const newRowHtml = `
                <tr id="coupon-row-${newCoupon.id}">
                    <td>${newCoupon.id}</td>
                    <td class="coupon-name">${newCoupon.name}</td>
                    <td class="coupon-code">${newCoupon.coupon_code}</td>
                    <td class="coupon-value">${newCoupon.coupon_value}</td>
                    <td>${new Date(newCoupon.valid_from).toLocaleString()} - ${new Date(newCoupon.valid_until).toLocaleString()}</td>
                    <td class="coupon-utilized"><span class="badge bg-secondary">no</span></td>
                    <td class="coupon-utilized-at">-</td>
                    <td class="coupon-utilized-by">-</td>
                    <td class="coupon-is-active"><span class="badge bg-${newCoupon.is_active ? 'success' : 'danger'}">${newCoupon.is_active ? 'active' : 'inactive'}</span></td>
                    <td class="coupon-status">${newCoupon.status || '-'}</td>
                    <td class="coupon-created-at">${newCoupon.created_at}</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-warning edit-coupon-btn" data-bs-toggle="modal" data-bs-target="#editCouponModal-${newCoupon.id}" data-coupon-id="${newCoupon.id}">
                            <i class="la la-edit"></i> edit
                        </button>
                        <button type="button" class="btn btn-sm btn-danger delete-coupon-btn" data-coupon-id="${newCoupon.id}" style="margin-top:3px">
                            <i class="la la-trash"></i> delete
                        </button>
                    </td>
                </tr>
            `;
            $('#couponTable tbody').prepend(newRowHtml); // Add to the top of the table

            // Close the modal and clear the form
            $('#addCouponModal').modal('hide');
            $('#addCouponForm')[0].reset();

            // Re-bind event listeners for new buttons
            bindDeleteCouponListeners();
            bindEditCouponListeners();

            showAlert('Coupon code added successfully!', 'success');
        });

        // --- Edit Coupon Functionality ---
        $('.update-coupon-submit-btn').on('click', function() {
            const couponId = $(this).data('coupon-id');
            const name = $(`#edit_name_${couponId}`).val();
            const coupon_code = $(`#edit_coupon_code_${couponId}`).val();
            const coupon_value = $(`#edit_coupon_value_${couponId}`).val();
            const valid_from = $(`#edit_valid_from_${couponId}`).val();
            const valid_until = $(`#edit_valid_until_${couponId}`).val();
            const is_active = $(`#edit_is_active_${couponId}`).val();
            const status = $(`#edit_status_${couponId}`).val();

            // Basic frontend validation (you might want more specific validation)
            if (!name || !coupon_code || !coupon_value || !valid_from || !valid_until) {
                showAlert('Please fill in all required fields in the edit form.', 'danger');
                return;
            }

            const updatedCoupon = {
                id: couponId,
                name: name,
                coupon_code: coupon_code,
                coupon_value: coupon_value,
                valid_from: valid_from,
                valid_until: valid_until,
                is_active: is_active === '1',
                status: status,
                // In a real scenario, you might fetch other data from the row as well
            };

            // Simulate updating the table row
            const row = $(`#coupon-row-${couponId}`);
            row.find('.coupon-name').text(name);
            row.find('.coupon-code').text(coupon_code);
            row.find('.coupon-value').text(coupon_value);
            row.find('td:nth-child(5)').text(`${new Date(valid_from).toLocaleString()} - ${new Date(valid_until).toLocaleString()}`);
            row.find('.coupon-is-active').html(`<span class="badge bg-${updatedCoupon.is_active ? 'success' : 'danger'}">${updatedCoupon.is_active ? 'active' : 'inactive'}</span>`);
            row.find('.coupon-status').text(status || '-');

            $(`#editCouponModal-${couponId}`).modal('hide');

            showAlert('Coupon code updated successfully!', 'success');
        });

        // --- Delete Coupon Functionality ---
        function bindDeleteCouponListeners() {
            $(document).off('click', '.delete-coupon-btn');

            $(document).on('click', '.delete-coupon-btn', function() {
                const couponId = $(this).data('coupon-id');
                if (confirm('Are you sure you want to delete this coupon code?')) {
                    // Simulate deleting the row from the table
                    $(`#coupon-row-${couponId}`).remove();
                    showAlert('Coupon code deleted successfully!', 'success');
                }
            });
        }

        // --- Bind initial delete button listeners ---
        bindDeleteCouponListeners();

        // --- Function to bind edit modal listeners (for dynamically added rows) ---
        function bindEditCouponListeners() {
            //$(document).off('click', '.edit-coupon-btn'); // Unbind previous listeners

            $(document).on('click', '.edit-coupon-btn', function() {
                const couponId = $(this).data('coupon-id');
                console.log('Opening edit modal for coupon ID:', couponId);
                const modalId = $(this).data('bs-target');
                const modalElement = document.querySelector(modalId);
                if (modalElement) {
                    // Try adding a slight delay
                    setTimeout(() => {
                        const modal = new bootstrap.Modal(modalElement);
                        modal.show();
                    }, 10); // 10 milliseconds delay
                }
            });
        }

        // --- Bind initial edit button listeners ---
        bindEditCouponListeners();
    });
</script>
@endsection