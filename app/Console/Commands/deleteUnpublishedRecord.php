<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Illuminate\Support\Facades\File;
use App\Models\Videoupload;

class deleteUnpublishedRecord extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deleteUnpublishedRecord:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This Command will delete the unpublished record by publisher.';

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
            $lastVideoHistories = DB::table('videohistories')
                                ->leftJoin('videouploads','videouploads.id','=','videohistories.videoupload_id')
                                ->select('videouploads.id as videouploads_id','videouploads.uploaded_video','videouploads.main_folder_name','videouploads.category_folder_name','videohistories.id as videohistories_id', 'videohistories.videohistorystatus_id')
                                ->whereIn('videohistories.id', function ($query) {
                                    $query->select(DB::raw('MAX(id)'))
                                        ->from('videohistories')
                                        ->groupBy('videoupload_id');
                                })
                                ->where('videohistorystatus_id','19')
                                ->get();
            foreach($lastVideoHistories as $lastVideoHistories)
            {
                $imagePath = storage_path('app/public/uploads/'.$lastVideoHistories->main_folder_name.'/' . $lastVideoHistories->category_folder_name.'/' . $lastVideoHistories->uploaded_video);
                
                if (File::exists($imagePath)) 
                {
                    File::delete($imagePath);
                }

                if(preg_match('/^(.+)\.(\w+)$/', $lastVideoHistories->uploaded_video, $matches))
                {
                    // $matches[1] contains the filename without the extension
                    // $matches[2] contains the file extension            
                    // Concatenate extra numbers to the filename
                    $filename_croppedvideo = $matches[1] . '_cropped' . '.' . $matches[2];
                }
                $sourcePath_croppedvideo = storage_path('app/public/uploads/'.$lastVideoHistories->main_folder_name.'/' . $lastVideoHistories->category_folder_name.'/' . $filename_croppedvideo);
            
                if (File::exists($sourcePath_croppedvideo)) 
                {
                    File::delete($sourcePath_croppedvideo);
                }
            }
            
        }
        catch (Exception $e)
        {
            Log::error($e);
        }
    }
}
