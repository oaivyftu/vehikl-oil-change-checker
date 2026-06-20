@extends('layouts.app')

@section('title', 'Oil Change Checker')

@section('content')
    <h1>Oil Change Checker</h1>
    <p class="intro">Enter your vehicle details to check whether an oil change is due.</p>

    @if ($errors->any())
        <div class="error-summary" role="alert">
            <p>Please correct the following:</p>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('status'))
        <div class="status" role="status">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('oil-change-checks.store') }}">
        @csrf

        <div class="field">
            <label for="current_odometer">Current odometer (km)</label>
            <input
                id="current_odometer"
                name="current_odometer"
                type="number"
                min="0"
                step="1"
                value="{{ old('current_odometer') }}"
                aria-invalid="{{ $errors->has('current_odometer') ? 'true' : 'false' }}"
                @error('current_odometer') aria-describedby="current_odometer_error" @enderror
            >
            @error('current_odometer')
                <span class="error" id="current_odometer_error">{{ $message }}</span>
            @enderror
        </div>

        <div class="field">
            <label for="previous_oil_change_date">Previous oil change date</label>
            <input
                id="previous_oil_change_date"
                name="previous_oil_change_date"
                type="date"
                max="{{ today()->subDay()->toDateString() }}"
                value="{{ old('previous_oil_change_date') }}"
                aria-invalid="{{ $errors->has('previous_oil_change_date') ? 'true' : 'false' }}"
                @error('previous_oil_change_date') aria-describedby="previous_oil_change_date_error" @enderror
            >
            @error('previous_oil_change_date')
                <span class="error" id="previous_oil_change_date_error">{{ $message }}</span>
            @enderror
        </div>

        <div class="field">
            <label for="previous_oil_change_odometer">Odometer at previous oil change (km)</label>
            <input
                id="previous_oil_change_odometer"
                name="previous_oil_change_odometer"
                type="number"
                min="0"
                step="1"
                value="{{ old('previous_oil_change_odometer') }}"
                aria-invalid="{{ $errors->has('previous_oil_change_odometer') ? 'true' : 'false' }}"
                @error('previous_oil_change_odometer') aria-describedby="previous_oil_change_odometer_error" @enderror
            >
            @error('previous_oil_change_odometer')
                <span class="error" id="previous_oil_change_odometer_error">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit">Check oil change status</button>
    </form>
@endsection
