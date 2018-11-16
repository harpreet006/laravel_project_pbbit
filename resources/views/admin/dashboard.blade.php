@extends('admin.layouts.main')

@section('style')
    <link rel="stylesheet" href="{{ asset('public/vendor/jquery-ui/jquery-ui.css')}}" />
	<link rel="stylesheet" href="{{ asset('public/vendor/jquery-ui/jquery-ui.theme.css')}}" />
	<link rel="stylesheet" href="{{ asset('public/vendor/bootstrap-multiselect/bootstrap-multiselect.css')}}" />
	<link rel="stylesheet" href="{{ asset('public/vendor/morris/morris.css')}}" />
@endsection

@section('content')
<section role="main" class="content-body">
					<header class="page-header">
						<h2>Dashboard</h2>
					
						<div class="right-wrapper text-right">
							<ol class="breadcrumbs">
								<li>
									<a href="{{url('/admin/dashboard')}}">
										<i class="fa fa-home"></i>
									</a>
								</li>
							</ol>
					
							<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
						</div>
					</header>

					<!-- start: page -->
					<div class="row">
						<div class="col-lg-12">
							<div class="row">
								<div class="col-xl-3">
									<section class="card card-featured-left card-featured-tertiary mb-3">
										<div class="card-body">
											<div class="widget-summary">
												<div class="widget-summary-col widget-summary-col-icon">
													<div class="summary-icon bg-tertiary">
														<i class="fa fa-shopping-cart"></i>
													</div>
												</div>
												<div class="widget-summary-col">
													<div class="summary">
														<h4 class="title">Today's Orders</h4>
														<div class="info">
															<strong class="amount">{{$today_orders}}</strong>
														</div>
													</div>
													<div class="summary-footer">
														<a class="" href="{{url('admin/orders')}}">see all <i class="fa fa-arrow-right" aria-hidden="true"></i>
                                                        </a>
													</div>
												</div>
											</div>
										</div>
									</section>
								</div>
								<div class="col-xl-3">
									<section class="card card-featured-left card-featured-quaternary">
										<div class="card-body">
											<div class="widget-summary">
												<div class="widget-summary-col widget-summary-col-icon">
													<div class="summary-icon bg-quaternary">
														<i class="fa fa-user"></i>
													</div>
												</div>
												<div class="widget-summary-col">
													<div class="summary">
														<h4 class="title">Total Users</h4>
														<div class="info">
															<strong class="amount">{{ $all_users}}</strong>
														</div>
													</div>
													<div class="summary-footer">
														<a class="" href="{{url('admin/users')}}">see all <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
													</div>
												</div>
											</div>
										</div>
									</section>
								</div>
								<div class="col-xl-3">
									<section class="card card-featured-left card-featured-primary mb-3">
										<div class="card-body">
											<div class="widget-summary">
												<div class="widget-summary-col widget-summary-col-icon">
													<div class="summary-icon bg-primary">
														<i class="fa fa-life-ring"></i>
													</div>
												</div>
												<div class="widget-summary-col">
													<div class="summary">
														<h4 class="title">Support Questions</h4>
														<div class="info">
															<strong class="amount">1281</strong>
														</div>
													</div>
													<div class="summary-footer">
														<a class="text-muted text-uppercase" href="#">(view all)</a>
													</div>
												</div>
											</div>
										</div>
									</section>
								</div>
								<div class="col-xl-3">
									<section class="card card-featured-left card-featured-secondary">
										<div class="card-body">
											<div class="widget-summary">
												<div class="widget-summary-col widget-summary-col-icon">
													<div class="summary-icon bg-secondary">
														<i class="fa fa-usd"></i>
													</div>
												</div>
												<div class="widget-summary-col">
													<div class="summary">
														<h4 class="title">Total Profit</h4>
														<div class="info">
															<strong class="amount">$ 14,890.30</strong>
														</div>
													</div>
													<div class="summary-footer">
														<a class="text-muted text-uppercase" href="#">(withdraw)</a>
													</div>
												</div>
											</div>
										</div>
									</section>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6">
							<section class="card">
								<div class="card-body">
									<div class="row">
										<div class="col-xl-12">
											<div class="chart-data-selector" id="salesSelectorWrapper">
												<h2>
													Sales:
													<strong>
														<select class="form-control" id="salesSelector">
															<option value="Porto Admin" selected>Beginner</option>
															<option value="Porto Drupal" >Intermediate</option>
															<option value="Porto Wordpress" >Advance</option>
														</select>
													</strong>
												</h2>
					
												<div id="salesSelectorItems" class="chart-data-selector-items">
													<!-- Flot: Sales Porto Admin -->
													<div class="chart chart-lg" data-sales-rel="Porto Admin" id="flotDashSales1" class="chart-active" style="height: 203px;"></div>
													<script>
					
														var flotDashSales1Data = [{
														    data: [
														        ["Jan", 140],
														        ["Feb", 240],
														        ["Mar", 190],
														        ["Apr", 140],
														        ["May", 180],
														        ["Jun", 320],
														        ["Jul", 270],
														        ["Aug", 180]
														    ],
														    color: "#0088cc"
														}];
					
														// See: js/examples/examples.dashboard.js for more settings.
					
													</script>
					
													<!-- Flot: Sales Porto Drupal -->
													<div class="chart chart-lg" data-sales-rel="Porto Drupal" id="flotDashSales2" class="chart-hidden"></div>
													<script>
					
														var flotDashSales2Data = [{
														    data: [
														        ["Jan", 240],
														        ["Feb", 240],
														        ["Mar", 290],
														        ["Apr", 540],
														        ["May", 480],
														        ["Jun", 220],
														        ["Jul", 170],
														        ["Aug", 190]
														    ],
														    color: "#2baab1"
														}];
					
														// See: js/examples/examples.dashboard.js for more settings.
					
													</script>
					
													<!-- Flot: Sales Porto Wordpress -->
													<div class="chart chart-lg" data-sales-rel="Porto Wordpress" id="flotDashSales3" class="chart-hidden"></div>
													<script>
					
														var flotDashSales3Data = [{
														    data: [
														        ["Jan", 840],
														        ["Feb", 740],
														        ["Mar", 690],
														        ["Apr", 940],
														        ["May", 1180],
														        ["Jun", 820],
														        ["Jul", 570],
														        ["Aug", 780]
														    ],
														    color: "#734ba9"
														}];
					
														// See: js/examples/examples.dashboard.js for more settings.
					
													</script>
												</div>
											</div>
										</div>
									</div>
								</div>
							</section>
						</div>
					</div>
					<!-- end: page -->
</section>
@endsection

@section('script')

 <!-- Specific Page Vendor -->
        <script src="{{ asset('public/vendor/jquery-ui/jquery-ui.js')}}"></script>
        <script src="{{ asset('public/vendor/jqueryui-touch-punch/jqueryui-touch-punch.js')}}"></script>
        <script src="{{ asset('public/vendor/jquery-appear/jquery-appear.js')}}"></script>
        <script src="{{ asset('public/vendor/bootstrap-multiselect/bootstrap-multiselect.js')}}"></script>
        <script src="{{ asset('public/vendor/jquery.easy-pie-chart/jquery.easy-pie-chart.js')}}"></script>
        <script src="{{ asset('public/vendor/flot/jquery.flot.js')}}"></script>
        <script src="{{ asset('public/vendor/flot.tooltip/flot.tooltip.js')}}"></script>
        <script src="{{ asset('public/vendor/flot/jquery.flot.pie.js')}}"></script>
        <script src="{{ asset('public/vendor/flot/jquery.flot.categories.js')}}"></script>
        <script src="{{ asset('public/vendor/flot/jquery.flot.resize.js')}}"></script>
        <script src="{{ asset('public/vendor/jquery-sparkline/jquery-sparkline.js')}}"></script>
        <script src="{{ asset('public/vendor/raphael/raphael.js')}}"></script>
        <script src="{{ asset('public/vendor/morris/morris.js')}}"></script>
        <script src="{{ asset('public/vendor/gauge/gauge.js')}}"></script>
        <script src="{{ asset('public/vendor/snap.svg/snap.svg.js')}}"></script>
        <script src="{{ asset('public/vendor/liquid-meter/liquid.meter.js')}}"></script>
        <script src="{{ asset('public/vendor/jqvmap/jquery.vmap.js')}}"></script>
        <script src="{{ asset('public/vendor/jqvmap/data/jquery.vmap.sampledata.js')}}"></script>
        <script src="{{ asset('public/vendor/jqvmap/maps/jquery.vmap.world.js')}}"></script>
        <script src="{{ asset('public/vendor/jqvmap/maps/continents/jquery.vmap.africa.js')}}"></script>
        <script src="{{ asset('public/vendor/jqvmap/maps/continents/jquery.vmap.asia.js')}}"></script>
        <script src="{{ asset('public/vendor/jqvmap/maps/continents/jquery.vmap.australia.js')}}"></script>
        <script src="{{ asset('public/vendor/jqvmap/maps/continents/jquery.vmap.europe.js')}}"></script>
        <script src="{{ asset('public/vendor/jqvmap/maps/continents/jquery.vmap.north-america.js')}}"></script>
        <script src="{{ asset('public/vendor/jqvmap/maps/continents/jquery.vmap.south-america.js')}}"></script>
        
        <!-- Theme Base, Components and Settings -->
        <script src="{{ asset('public/js/theme.js')}}"></script>
        
        <!-- Theme Initialization Files -->
        <script src="{{ asset('public/js/theme.init.js')}}"></script>
        <!-- Examples -->
        <script src="{{ asset('public/js/examples/examples.dashboard.js')}}"></script>

        <script type="text/javascript">
        $(document).ready(function(){
           active_nav_links(0);
        });
        </script>
@endsection