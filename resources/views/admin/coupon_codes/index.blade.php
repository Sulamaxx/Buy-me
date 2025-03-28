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
                        <a href="#" class="btn btn-primary">
                            <i class="la la-plus"></i> add_a_new_coupon_code
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th>id</th>
                                <th>name</th>
                                <th>coupon_code</th>
                                <th>coupon_value</th>
                                <th>validity_period</th>
                                <th>utilized</th>
                                <th>utilized_date</th>
                                <th>utilized_by_user_id</th>
                                <th>is_active</th>
                                <th>status</th>
                                <th>created_date</th>
                                <th>actions</th>
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
                                    <tr>
                                        <td>{{ $coupon['id'] }}</td>
                                        <td>{{ $coupon['name'] ?? '-' }}</td>
                                        <td>{{ $coupon['coupon_code'] }}</td>
                                        <td>{{ $coupon['coupon_value'] ?? '-' }}</td>
                                        <td>
                                            @if (isset($coupon['valid_from']) && isset($coupon['valid_until']))
                                                {{ \Carbon\Carbon::parse($coupon['valid_from'])->format('Y-m-d H:i') }} - {{ \Carbon\Carbon::parse($coupon['valid_until'])->format('Y-m-d H:i') }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if ($coupon['is_utilized'])
                                                <span class="badge bg-success">yes</span>
                                            @else
                                                <span class="badge bg-secondary">no</span>
                                            @endif
                                        </td>
                                        <td>{{ $coupon['utilized_at'] ? \Carbon\Carbon::parse($coupon['utilized_at'])->format('Y-m-d H:i') : '-' }}</td>
                                        <td>{{ $coupon['utilized_by_user_id'] ?? '-' }}</td>
                                        <td>
                                            @if ($coupon['is_active'])
                                                <span class="badge bg-success">active</span>
                                            @else
                                                <span class="badge bg-danger">inactive</span>
                                            @endif
                                        </td>
                                        <td>{{ $coupon['status'] ?? '-' }}</td>
                                        <td>{{ $coupon['created_at'] ? \Carbon\Carbon::parse($coupon['created_at'])->format('Y-m-d H:i') : '-' }}</td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-warning">
                                                <i class="la la-edit"></i> edit
                                            </a>
                                            <a href="#" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                                <i class="la la-trash"></i> delete
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('after_scripts')
    <script>
        
    </script>
@endpush