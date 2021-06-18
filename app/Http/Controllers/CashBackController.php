<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CashBack;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class CashBackController extends Controller
{
    public function calculate(Request $request) {
        $validator = Validator::make($request->all(), [
            'channel' => [
                'required'
            ],
            'transaction_date' => [
                'bail',
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    $campaignCountByDate = CashBack::where('channel', request('channel'))
                                            ->where('start_date', '<=', Carbon::create($value))
                                            ->where(function($campaignCountByDate){
                                                $campaignCountByDate->whereNull('end_date')
                                                    ->orWhere('end_date', '>=', Carbon::create(request('transaction_date')));
                                                })
                                            ->count();
                    if ($campaignCountByDate < 1) {
                        $fail('The transaction date is not within any campaign period.');
                    }
                },
            ],
            'min_spend' => [
                'bail',
                'required',
                'numeric',
                function ($attribute, $value, $fail) {
                    $campaignCountBySpend = CashBack::where('channel', request('channel'))
                                            ->where('start_date', '<=', Carbon::create(request('transaction_date')))
                                            ->where(function($campaignCountBySpend){
                                                $campaignCountBySpend->whereNull('end_date')
                                                    ->orWhere('end_date', '>=', Carbon::create(request('transaction_date')));
                                                })
                                            ->where('min_spend', '<=', $value)
                                            ->where(function($campaignCountBySpend){
                                                $campaignCountBySpend->whereNull('max_spend')
                                                    ->orWhere('max_spend', '>=', floor(request('min_spend')));
                                                })
                                            ->count();
                    if ($campaignCountBySpend < 1) {
                        $fail('The amount did not meet the minimum spend.');
                    }
                },
            ]
        ]);

        // $validator->stopOnFirstFailure();
        $validator->validate();

        $cashback = CashBack::where('channel', request('channel'))
                            ->where('start_date', '<=', Carbon::create(request('transaction_date')))
                            ->where(function($cashback){
                                $cashback->whereNull('end_date')
                                    ->orWhere('end_date', '>=', Carbon::create(request('transaction_date')));
                                })
                            ->where('min_spend', '<=', request('min_spend'))
                            ->where(function($cashback){
                                $cashback->whereNull('max_spend')
                                    ->orWhere('max_spend', '>=', floor(request('min_spend')));
                                })
                            ->orderBy('priority')
                            ->first();

        $cashback_result = [
            'channel' => $request->channel,
            'transaction_date' => $request->transaction_date,
            'min_spend' => $request->min_spend,
            'cash_back_percentage' => $cashback->cash_back_percentage,
            'cash_back_amount' => number_format((float)($request->min_spend * $cashback->cash_back_percentage / 100), 2, '.', '') > $cashback->cap_cash_back && $cashback->cap_cash_back != null ? $cashback->cap_cash_back : number_format((float)($request->min_spend * $cashback->cash_back_percentage / 100), 2, '.', ''),
            'coins_earned' => floor($request->min_spend * $cashback->coin)
        ];

        return view('home', ['cashback_result' => $cashback_result]);
    }
}
