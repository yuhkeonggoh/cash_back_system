<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CashBack;
use Carbon\Carbon;

class CashBacksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cash_backs = [
            [
                'name' => 'Thomas Sabo Instore',
                'channel' => 'offline',
                'min_spend' => '200',
                'max_spend' => '499',
                'cash_back_percentage' => '5',
                'cap_cash_back' => null,
                'coin' => 1,
                'priority' => 2,
                'start_date' => Carbon::create(2021, 6, 1, 0),
                'end_date' => Carbon::create(2021, 6, 30, 23, 59, 59)
            ],
            [
                'name' => 'Thomas Sabo Instore',
                'channel' => 'offline',
                'min_spend' => '500',
                'max_spend' => null,
                'cash_back_percentage' => '10',
                'cap_cash_back' => '70',
                'coin' => 1,
                'priority' => 2,
                'start_date' => Carbon::create(2021, 6, 1, 0),
                'end_date' => Carbon::create(2021, 6, 30, 23, 59, 59)
            ],
            [
                'name' => 'Thomas Sabo Online',
                'channel' => 'online',
                'min_spend' => '200',
                'max_spend' => null,
                'cash_back_percentage' => '3',
                'cap_cash_back' => '30',
                'coin' => 1,
                'priority' => 2,
                'start_date' => Carbon::create(2021, 6, 1, 0),
                'end_date' => Carbon::create(2021, 6, 30, 23, 59, 59)
            ],
            [
                'name' => 'Thomas Sabo Online get upsized cash back and coins on 15 June 2021',
                'channel' => 'online',
                'min_spend' => '200',
                'max_spend' =>  null,
                'cash_back_percentage' => '5',
                'cap_cash_back' => '50',
                'coin' => 2,
                'priority' => 1,
                'start_date' => Carbon::create(2021, 6, 15, 0),
                'end_date' => Carbon::create(2021, 6, 15, 23, 59, 59)
            ]
        ];
        foreach($cash_backs as $cash_back) {
            CashBack::create($cash_back);
        }
    }
}
