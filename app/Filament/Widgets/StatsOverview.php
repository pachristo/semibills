<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\User;
use App\Models\APITransaction as Trans;
use App\Models\Support;
// use \Carbon\Carbon;
use App\Models\Referral;
use Carbon\Carbon;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        $user = User::all();
        $user1 = User::where('email_verified','1')->get();
        $trans=\DB::table('a_p_i_transactions')->get();
      
        // Today
        $todayDebitAmount = Trans::whereDate('created_at', Carbon::today())
            ->where('trans_type', 'debit')
            ->sum('amount');
        
        $todayCreditAmount = Trans::whereDate('created_at', Carbon::today())
            ->where('trans_type', 'credit')
            ->sum('amount');
        
        // This Week
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        
        $weeklyDebitAmount = Trans::whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->where('trans_type', 'debit')
            ->sum('amount');
        
        $weeklyCreditAmount = Trans::whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->where('trans_type', 'credit')
            ->sum('amount');
        
        // This Month
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        
        $monthlyDebitAmount = Trans::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->where('trans_type', 'debit')
            ->sum('amount');
        
        $monthlyCreditAmount = Trans::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->where('trans_type', 'credit')
            ->sum('amount');
        
             // This Year
    $startOfYear = Carbon::now()->startOfYear();
    $endOfYear = Carbon::now()->endOfYear();
    
    $yearlyDebitAmount = Trans::whereBetween('created_at', [$startOfYear, $endOfYear])
        ->where('trans_type', 'debit')
        ->sum('amount');
    
    $yearlyCreditAmount = Trans::whereBetween('created_at', [$startOfYear, $endOfYear])
        ->where('trans_type', 'credit')
        ->sum('amount');

        $support = Support::all();
        $referral=Referral::all();
        $a = [];

        if (auth()->guard('admins')->user()->type == 0) {
            $a[] = Stat::make('Total Users', count($user));
            $a[] = Card::make('Verified Account', count($user1));
            $a[] = Card::make('Total Referals', count($referral));
            $a[] = Card::make('Total Transactions', count($trans));
            $a[] = Stat::make('Total Support', count($support));
            $a[] = Card::make('Today\'s Debit Trans.', 'NGN ' . number_format($todayDebitAmount, 2, '.', ','));
            $a[] = Card::make('Today\'s Credit Trans.', 'NGN ' . number_format($todayCreditAmount, 2, '.', ','));

            $a[] = Card::make('Weekly Debit Trans.', 'NGN ' . number_format($weeklyDebitAmount, 2, '.', ','));
            $a[] = Card::make('Weekly Credit Trans.', 'NGN ' . number_format($weeklyCreditAmount, 2, '.', ','));


            $a[] = Card::make('Monthly Debit Trans.', 'NGN ' . number_format($monthlyDebitAmount, 2, '.', ','));
            $a[] = Card::make('Monthly Credit Trans.', 'NGN ' . number_format($monthlyCreditAmount, 2, '.', ','));


            $a[] = Card::make('Yearly Debit Trans.', 'NGN ' . number_format($yearlyDebitAmount, 2, '.', ','));
            $a[] = Card::make('Yearly Credit Trans.', 'NGN ' . number_format($yearlyCreditAmount, 2, '.', ','));
        }
        
     
        
        return $a;
    }
    protected int | string | array $columnSpan = [
        'md' => 2,
        'xl' => 3,
    ];
}