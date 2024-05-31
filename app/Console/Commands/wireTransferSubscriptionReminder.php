<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\sendWireTransferEndSubscriptionReminder;

class wireTransferSubscriptionReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wireTransferSubscriptionReminder:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'wire Transfer Subscription Reminder';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //return Command::SUCCESS;
        try
        {
            $startDate = Carbon::now()->format('Y-m-d');
            $endDate = Carbon::now()->addDay(30)->format('Y-m-d');
            $payment_details = DB::table('transcations')
                                ->leftJoin('users','users.id','=','transcations.user_id')
                                ->where('is_payment_done',1)
                                ->whereBetween('transcations.subscription_end_date', [$startDate, $endDate])
                                ->get();
            foreach ($payment_details as $payment_details)
            {  
                if($payment_details->item_type == 'subscription' && $payment_details->transaction_type == 'wire_transfer')
                {
                    Mail::to($payment_details->email)->send(new sendWireTransferEndSubscriptionReminder($payment_details));
                }
            }
        }
        catch (Exception $e)
        {
            Log::error($e);
        }
    }
}
