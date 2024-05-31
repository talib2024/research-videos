<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\profileCompletionReminderEmail;

class profileCompletionReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'profileCompletionReminder:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'If user did not complete their profile 100%';

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
            $user = DB::table('users')->select('id','name','email')->where('status',1)->get();
            foreach ($user as $user)
            {
                $progress_count = profile_progress_count($user->id); //in App/Helper.php
                if($progress_count < 100)
                {
                    Mail::to($user->email)->send(new profileCompletionReminderEmail($user,$progress_count));
                }
            }
        }
        catch (Exception $e)
        {
            Log::error($e);
        }
    }
}
