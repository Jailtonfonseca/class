@extends($activeTheme.'layouts.app')
@section('title', ___('Dashboard'))
@section('active_menu', 'dashboard')
@section('content')
    <div class="dashboard-box margin-top-0">
        <div class="content with-padding">
            <div class="row dashboard-profile">
                <div class="col-xl-6 col-md-6 col-sm-12">
                    <div class="user-img"><img src="{{ asset('storage/profile/'.request()->user()->image) }}" alt="user" class="img-responsive"></div>
                    <div>
                        <h2>{{ request()->user()->name }}</h2>
                        <span><i class="icon-feather-gift"></i>
                            {{ ___('Membership') }} : {{ request()->user()->plan()->name }}
                        </span><br>
                        <small>{{ ___('Username') }} : {{ request()->user()->username }}</small>
                    </div>
                </div>
                <div class="col-xl-6 col-md-6 col-sm-12 text-right">
                    <span class="dashboard-badge"><strong>{{ count(request()->user()->favorites) }}</strong><i class="icon-feather-heart"></i> {{ ___('Favorite Listings') }}</span>
                    <span class="dashboard-badge"><strong>{{ count(request()->user()->posts) }}</strong><i class="icon-feather-briefcase"></i> {{ ___('My Listings') }}</span>
                </div>
            </div>
        </div>
    </div>
    <!-- Dashboard Box -->
    <div class="dashboard-box main-box-in-row">
        <div class="headline">
            <h3><i class="icon-feather-bar-chart-2"></i> {{ ___('This Month Views') }}</h3>
        </div>
        <div class="content">
            <!-- Chart -->
            <div class="chart">
                <canvas id="chart" width="100" height="45"></canvas>
            </div>
        </div>
    </div>
    <!-- Dashboard Box / End -->

@endsection

@push('scripts_at_bottom')
    <script src="{{ asset($activeThemeAssets.'assets/js/chart.min.js') }}"></script>
    <script>
        Chart.defaults.global.defaultFontFamily = "Nunito";
        Chart.defaults.global.defaultFontColor = '#888';
        Chart.defaults.global.defaultFontSize = '14';

        var ctx = document.getElementById('chart').getContext('2d');

        var chart = new Chart(ctx, {
            type: 'line',

            // The data for our dataset
            data: {
                labels: @json($days),
                // Information about the dataset
                datasets: [{
                    label: @json(___('Views')),
                    backgroundColor: '{{ $settings->theme_color }}15',
                    borderColor: '{{ $settings->theme_color }}',
                    borderWidth: "3",
                    data: @json($postViews),
                    pointRadius: 5,
                    pointHoverRadius:5,
                    pointHitRadius: 10,
                    pointBackgroundColor: "#fff",
                    pointHoverBackgroundColor: "#fff",
                    pointBorderWidth: "2",
                }]
            },

            // Configuration options
            options: {
                layout: {
                    padding: 10,
                },
                legend: { display: false },
                title:  { display: false },
                scales: {
                    yAxes: [{
                        scaleLabel: {
                            display: false
                        },
                        gridLines: {
                            borderDash: [6, 10],
                            color: "#d8d8d8",
                            lineWidth: 1,
                        },
                        ticks: {
                            beginAtZero:true
                        }
                    }],
                    xAxes: [{
                        scaleLabel: { display: false },
                        gridLines:  { display: false },
                    }],
                },
                tooltips: {
                    backgroundColor: '#333',
                    titleFontSize: 13,
                    titleFontColor: '#fff',
                    bodyFontColor: '#fff',
                    bodyFontSize: 13,
                    displayColors: false,
                    xPadding: 10,
                    yPadding: 10,
                    intersect: false
                }
            },
        });

    </script>
@endpush
