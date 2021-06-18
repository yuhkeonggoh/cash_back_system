@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        
        <div class="col-md-10">
            <h2 class="text-center">Thomas Sabo Cash Back System</h2>
            <form method="POST" action="{{ route('cashback.calculate') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="channel">Channel</label>
                    <select name="channel" class="form-control" id="channel">
                        <option value="offline" {{ isset($cashback_result['channel']) && $cashback_result['channel'] == 'offline' ? 'selected' : '' }}>Offline</option>
                        <option value="online" {{ isset($cashback_result['channel']) && $cashback_result['channel'] == 'online' ? 'selected' : '' }}>Online</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="transaction_date">Transaction Date</label>
                    <input type="date" name="transaction_date" class="form-control datepicker @error('transaction_date') is-invalid @enderror" id="transaction_date" placeholder="Enter transaction date" value="{{ isset($cashback_result['transaction_date']) ? $cashback_result['transaction_date'] : '' }}">
                    @error('transaction_date')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="min_spend">Min Spend</label>
                    <input type="text" name="min_spend" class="form-control @error('min_spend') is-invalid @enderror" id="min_spend" placeholder="Enter min spend" value="{{ isset($cashback_result['min_spend']) ? $cashback_result['min_spend'] : '' }}">
                    @error('min_spend')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>

        <div class="col-md-10 mt-4">
            <h4>Result:</h4>
            <div class="form-group">
                <label for="cash_back_percentage">Cash Back Percentage</label>
                <input readonly type="text" name="cash_back_percentage" class="form-control" id="cash_back_percentage" value="{{ isset($cashback_result['cash_back_percentage']) ? $cashback_result['cash_back_percentage'] : '' }}%">
            </div>
            <div class="form-group">
                <label for="cash_back_amount">Cash Back Amount</label>
                <input readonly type="text" name="cash_back_amount" class="form-control" id="cash_back_amount" value="RM {{ isset($cashback_result['cash_back_amount']) ? $cashback_result['cash_back_amount'] : '' }}">
            </div>
            <div class="form-group">
                <label for="coins_earned">Coins Earned</label>
                <input readonly type="text" name="coins_earned" class="form-control" id="coins_earned"  value="{{ isset($cashback_result['coins_earned']) ? $cashback_result['coins_earned'] : '' }}">
            </div>
        </div>
    </div>
</div>
@endsection
