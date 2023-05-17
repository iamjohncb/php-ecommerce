@extends('admin.layout.base')
@section('title', 'Dashboard')
@section('data-page-id', 'adminDashboard')

@section('content')
    <div class="dashboard admin_shared">
        <div class="grid-x" data-equalizer data-equalizer-on="medium">
            {{--Order sumamry--}}
            <div class="small-12 medium-3 cell summary" data-equalizer-watch>
                <div class="card">
                    <div class="card-section">
                        <div class="grid-x">
                            <div class="small-3 cell">
                                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                            </div>
                            <div class="small-9 cell">
                                <p>Total Orders</p><h4>{{$orders}}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-divider">
                        <div class="grid-x cell">
                            <a href="#">Order Details</a>
                        </div>
                    </div>
                </div>
            </div>

            {{--Stock sumamry--}}
            <div class="small-12 medium-3 cell summary" data-equalizer-watch>
                <div class="card">
                    <div class="card-section">
                        <div class="grid-x">
                            <div class="small-3 cell">
                                <i class="fa fa-thermometer-empty" aria-hidden="true"></i>
                            </div>
                            <div class="small-9 cell">
                                <p>Stock</p><h4>{{$products}}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-divider">
                        <div class="grid-x cell">
                            <a href="/admin/products">View Products</a>
                        </div>
                    </div>
                </div>
            </div>

            {{--Revenue sumamry--}}
            <div class="small-12 medium-3 cell summary" data-equalizer-watch>
                <div class="card">
                    <div class="card-section">
                        <div class="grid-x">
                            <div class="small-3 cell">
                                <i class="fa fa-money" aria-hidden="true"></i>
                            </div>
                            <div class="small-9 cell">
                                <p>Revenue</p><h4>${{number_format($payments,2)}}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-divider">
                        <div class="grid-x cell">
                            <a href="#">Payment Details</a>
                        </div>
                    </div>
                </div>
            </div>

            {{--Signup sumamry--}}
            <div class="small-12 medium-3 cell summary" data-equalizer-watch>
                <div class="card">
                    <div class="card-section">
                        <div class="grid-x">
                            <div class="small-3 cell">
                                <i class="fa fa-users" aria-hidden="true"></i>
                            </div>
                            <div class="small-9 cell">
                                <p>Signup</p><h4>{{$users}}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-divider">
                        <div class="grid-x cell">
                            <a href="#">Registered Users</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid-x graph">
            <div class="small-12 medium-6 cell monthly-sales">
                <div class="card">
                    <div class="card-section">
                        <h4>Monthly Orders</h4>
                        <canvas id="order"></canvas>
                    </div>
                </div>
            </div>

            <div class="small-12 medium-6 cell monthly-revenue">
                <div class="card">
                    <div class="card-section">
                        <h4>Monthly Revenue</h4>
                        <canvas id="revenue"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection