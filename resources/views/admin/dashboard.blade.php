@extends('layouts.app')

@section('css')
  <link href="https://cdn.datatables.net/plug-ins/505bef35b56/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/responsive/1.0.7/css/responsive.bootstrap.min.css" rel="stylesheet">
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <style>
  a:link{
  color:black;
}
a:visited{
  color:black;
}
a:hover{
  color:black;
}
a:focus{
  color:black;
}
a:active{
  color:black;
}
  </style>
@endsection

@section('content')
    @if($tickets_count)
        <div class="row">
            <div class="col-lg-3 col-md-5 col-lg-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                          <a href="{{ url('admin/tickets') }}">
                            <div class="col-xs-3" style="font-size: 5em;">
                                <i class="fa fa-ticket"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <h1>{{ $tickets_count }}</h1>
                                <div>Tickets</div>
                            </div>
                          </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <div class="row">
                          <a href="{{ url('admin/tickets/open') }}">
                            <div class="col-xs-3" style="font-size: 5em;">
                                <i class="fa fa-times-circle"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <h1>{{ $open_tickets_count }}</h1>
                                <div>Open tickets</div>
                            </div>
                          </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="row">
                          <a href="{{ url('admin/tickets/closed') }}">
                            <div class="col-xs-3" style="font-size: 5em;">
                                <i class="fa fa-check"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <h1>{{ $closed_tickets_count }}</h1>
                                <span>Closed tickets</span>
                            </div>
                          </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                    {{-- <div class="col-md-6"> --}}
                        <div class="panel panel-default">
                            <div class="panel-heading text-center">
                                Tickets per category
                            </div>
                            <div class="panel-body">
                                <div id="catpiechart" style="width: auto; height: 350;"></div>
                            </div>
                        </div>
                    {{-- </div> --}}
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
                {{--<h4><i class="glyphicon glyphicon-info-sign"></i> Tickets Activities</h4>--}}
                {{--<hr />--}}
                <ul class="nav nav-tabs nav-justified">
                    <li class="{{$active_tab == "cat" ? "active" : "" }}">
                        <a data-toggle="pill" href="#information-panel-categories">
                            <i class="fa fa-folder-o"></i>
                            <small>Categories</small>
                        </a>
                    </li>
                    <li class="{{$active_tab == "users" ? "active" : ""}}">
                        <a data-toggle="pill" href="#information-panel-users">
                            <i class="fa fa-user-o"></i>
                            <small>Users</small>
                        </a>
                    </li>
                </ul>
                <br>
                <div class="tab-content">
                    <div id="information-panel-categories" class="list-group tab-pane fade {{$active_tab == "cat" ? "in active" : ""}}">
                        <a href="#" class="list-group-item disabled">
                            <span>Categories
                                <span class="badge">Total</span>
                            </span>
                            <span class="pull-right text-muted small">
                                <em>
                                    Open /
                                     Closed
                                </em>
                            </span>
                        </a>
                        @foreach($categories as $category)
                            <a href="#" class="list-group-item">
                        <span style="color: {{ $category->color }}">
                            {{ $category->name }} <span class="badge">{{ $category->tickets()->count() }}</span>
                        </span>
                        <span class="pull-right text-muted small">
                            <em>
                                {{ $category->tickets->where('status', 'Open')->count() }} /
                                 {{ $category->tickets->where('status', 'Closed')->count() }}
                            </em>
                        </span>
                            </a>
                        @endforeach
                        {!! $categories->render() !!}
                    </div>
                    <div id="information-panel-users" class="list-group tab-pane fade {{$active_tab == "users" ? "in active" : ""}}">
                        <a href="#" class="list-group-item disabled">
                            <span>Users
                                <span class="badge">Total</span>
                            </span>
                            <span class="pull-right text-muted small">
                                <em>
                                    Open /
                                    Closed
                                </em>
                            </span>
                        </a>
                        @foreach($users as $user)
                            <a href="#" class="list-group-item">
                                <span>
                                    {{ $user->name }}
                                    <span class="badge">
                                        {{ $user->tickets->where('status', 'Open')->count()  +
                                         $user->tickets->where('status', 'Closed')->count() }}
                                    </span>
                                </span>
                                <span class="pull-right text-muted small">
                                    <em>
                                        {{ $user->tickets->where('status', 'Open')->count() }} /
                                        {{ $user->tickets->where('status', 'Closed')->count() }}
                                    </em>
                                </span>
                            </a>
                        @endforeach
                        {!! $users->render() !!}
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="well text-center">
            Nothing here!
        </div>
    @endif
    @if($tickets_count)
    <script type="text/javascript" src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1','packages':['corechart']}]}"></script>

    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
            // Categories Pie Chart
            var cat_data = google.visualization.arrayToDataTable([
              ['Categories', '{!! addslashes('Tickets') !!}'],
              @foreach($categories_share as $cat_name => $cat_tickets)
                    ['{!! addslashes($cat_name) !!}', {{ $cat_tickets }}],
              @endforeach
            ]);
            var cat_options = {
              legend: {position: 'bottom'}
            };
            var cat_chart = new google.visualization.PieChart(document.getElementById('catpiechart'));
            cat_chart.draw(cat_data, cat_options);
            }
    </script>
    @endif
@endsection
