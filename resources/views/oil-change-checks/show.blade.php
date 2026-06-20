@extends('layouts.app')

@section('title', 'Oil Change Result')

@section('content')
    <h1>Oil Change Result</h1>
    <p class="intro">Your submitted vehicle information has been checked.</p>

    @if ($oilChangeCheck->isDueForOilChange())
        <section class="result-status due" aria-labelledby="result-heading">
            <h2 id="result-heading">Oil change due</h2>
            <ul>
                @foreach ($oilChangeCheck->dueReasons() as $reason)
                    <li>
                        @if ($reason === 'kilometer_limit')
                            More than 5,000 km have passed since the previous oil change.
                        @elseif ($reason === 'time_limit')
                            More than 6 months have passed since the previous oil change.
                        @endif
                    </li>
                @endforeach
            </ul>
        </section>
    @else
        <section class="result-status not-due" aria-labelledby="result-heading">
            <h2 id="result-heading">Oil change not due</h2>
            <p>Neither the kilometer limit nor the time limit has been exceeded.</p>
        </section>
    @endif

    <dl>
        <dt>Current odometer</dt>
        <dd>{{ $oilChangeCheck->current_odometer }} km</dd>

        <dt>Previous oil change date</dt>
        <dd>{{ $oilChangeCheck->previous_oil_change_date->format('Y-m-d') }}</dd>

        <dt>Previous oil change odometer</dt>
        <dd>{{ $oilChangeCheck->previous_oil_change_odometer }} km</dd>

        <dt>Kilometers since previous oil change</dt>
        <dd>{{ $oilChangeCheck->kilometersSincePreviousOilChange() }} km</dd>
    </dl>

    <a class="button" href="{{ route('oil-change-checks.create') }}">Check another vehicle</a>
@endsection
