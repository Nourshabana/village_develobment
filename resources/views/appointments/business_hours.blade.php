@extends('layouts.home')

@section('content')
<div class="container">
    <h1 class="center">
        Business Hours
    </h1>

    <div class="row center">

        <form action="{{ route('bessnishours.update') }}" method="post">
            @csrf
            @foreach($busnisshours as $busnisshour)
                        <div class="col s3">
                <h4>
                    {{$busnisshour->day}}
                </h4>
            </div>
            <input type="hidden" name="data[{{$busnisshour->day}}][day]" value="{{$busnisshour->day}}">
            <div class="input-field col s3">
                <input type="text" class="timepicker" value="{{$busnisshour->from}}" name="data[{{$busnisshour->day}}][from]" placeholder="From">
            </div>

            <div class="input-field col s2">
                <input type="text" class="timepicker" value="{{$busnisshour->to}}" name="data[{{$busnisshour->day}}][to]" placeholder="To">
            </div>
            <div class="input-field col s1">
                <input type="number" name="data[{{$busnisshour->day}}][step]" value="{{$busnisshour->step}}" placeholder="Step">
            </div>

            <div class="input-field col s3">
                <p>
                    <label>
                        <input value="true" name="data[{{$busnisshour->day}}][off]" class="filled-in" type="checkbox" @checked($busnisshour->off) />
                        <span>OFF</span>
                    </label>
                </p>
            </div>

            @endforeach



            <div class="col s12">

                <button class="waves-effect waves-light btn info darken-2" type="submit">
                    save
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var elems = document.querySelectorAll('.timepicker');
        var instances = M.Timepicker.init(elems, {
            twelveHour:false
            showSecond: true,
        });
    });
</script>
@endsection
