<!doctype html>
<html>
<head>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<h1>This is example from Anton Chernets for Groups-AutoGroups</h1>
</body>
</html>
<br>
<h3>Block for Groups</h3>
<table class="table">
    <thead>
    <tr>
        <th scope="col">ID</th>
        <th scope="col">Label</th>
        <th scope="col">Created at</th>
        <th scope="col">Updated at</th>
    </tr>
    </thead>
    <tbody>
    @foreach($groups as $group)
        <tr @if($group->is_auto) style="background-color: grey" @endif>
            <td>{{$group->id}}</td>
            <td>{{$group->label}}</td>
            <td>{{$group->created_at}}</td>
            <td>{{$group->updated_at}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
<br>
<h3>Block for Auto Group States</h3>
<table class="table">
    <thead>
    <tr>
        <th scope="col">Group</th>
        <th scope="col">Weight</th>
        <th scope="col">%</th>
        <th scope="col">Players</th>
        <th scope="col">Players %</th>
    </tr>
    </thead>
    <tbody>
    @foreach($autoGroups as $autoGroup)
        <tr>
            <td>{{$autoGroup->label}}</td>
            <td>{{$autoGroup->weight}}</td>
            <td>{{$autoGroup->percent_total_weight}}%</td>
            <td>{{$autoGroup->total_players}}</td>
            <td>{{$autoGroup->percent_total_players}}%</td>
        </tr>
    @endforeach
        @php
            $signUpService = app()->make(\App\Services\SignUpService::class);
        @endphp
        <tr>
            <td>Total</td>
            <td>{{$weightSum}}</td>
            <td></td>
            <td>{{$playersCount}}</td>
            <td>{{PERCENT_TOTAL}}%</td>
        </tr>
    </tbody>
</table>

<a class="btn btn-danger" href="{{route('counters.reset')}}" role="button">Reset Counters</a>