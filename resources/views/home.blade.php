@extends('layouts.app')

@section('content')
{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div> --}}
<div class="row">
    <!-- [ sample-page ] start -->
    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <h6 class="mb-2 f-w-400 text-muted">Total Users</h6>
                <h4 class="mb-3">{{ $total_users }}</h4>
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <h6 class="mb-2 f-w-400 text-muted">Total Subscription</h6>
                <h4 class="mb-3">{{ $total_user_plan }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <h6 class="mb-2 f-w-400 text-muted">Trial Users</h6>
                <h4 class="mb-3">{{ $total_trial }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <h6 class="mb-2 f-w-400 text-muted">Subscription Price</h6>
                <h4 class="mb-3">&#8377; {{ $subscription->amount }}</h4>
                </p>
            </div>
        </div>
    </div>

    <div class="col-md-12 col-xl-12">
        <h5 class="mb-3">Recent Users</h5>
        <div class="card tbl-card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-borderless mb-0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile No.</th>
                                <th>Status</th>
                                <th>Register Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recent_users as $key => $user)
                                @if ($key <= 9)
                                    <tr>
                                        <td> {{ $user->full_name ? $user->full_name : '-' }} </td>
                                        <td> {{ $user->email ? $user->email : '-' }} </td>
                                        <td> {{ $user->mobile_number }} </td>
                                        <td>
                                            <span class="d-flex align-items-center gap-2">
                                                <i class="fas fa-circle text-{{ $user->status == 'active' ? "success" : "success" }} f-10 m-r-5"></i>
                                                {{ $user->status }}
                                            </span>
                                        </td>
                                        <td>{{ date('d-m-Y H:i:s', strtotime($user->created_at)) }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection