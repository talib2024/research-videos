<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GenerateVideoController extends Controller
{  
    public function __construct()
    { 
        $this->middleware(['auth','userRole','checkUserStatus']);  
    }
    public function concat_video_without_video()
    {
        return view('frontend.generate_videos.concat_video_without_video');
    }
  
    public function generate_video_without_video(Request $request)
    {
        $videoFiles = $request->file('video_files');
        $videoOrder = $request->input('video_order');
        $videoDuration = $request->input('video_duration');

        $audioFiles = $request->file('audio_files');
        $audioOrder = $request->input('audio_order');
        $audioDuration = $request->input('audio_duration');

        $imageFiles = $request->file('image_files');
        $imageOrder = $request->input('image_order');
        $imageDuration = $request->input('image_duration');

        $textFiles = $request->file('text_files');
        $textOrder = $request->input('text_order');
        $textDuration = $request->input('text_duration');

        if(empty($videoFiles) && empty($audioFiles) && empty($textFiles))
        {
            $request->session()->flash('error', 'The form is empty');
            return response()->json([
                'status' => 'notok',
                'message' => 'The form is empty.'
            ]);  
        }

        // Generate a unique ID for the session to avoid conflicts
        $sessionId = Str::uuid()->toString();
        $storagePath = storage_path("app/public/uploads/video_generate/{$sessionId}");
        if (!file_exists($storagePath)) {
            mkdir($storagePath, 0777, true);
        }

        $final_videos_to_concat = "{$storagePath}/final_videos_to_concat";
        if (!file_exists($final_videos_to_concat)) {
            mkdir($final_videos_to_concat, 0777, true);
        }

        // Store files and create an array with file paths, order, and duration
        $files = [
            'video' => [],
            'audio' => [],
            'image' => [],
            'text' => [],
        ];

        if(!empty($videoFiles))
        {
            foreach ($videoFiles as $index => $videoFile) {
                $extension_video = $videoFile->getClientOriginalExtension();
                $uniquen_number_video = rand(10,100).'_'.rand(10,100);
                $newFileName_video = $uniquen_number_video . '.' . $extension_video;
                $videoPath = $videoFile->storeAs("uploads/video_generate/{$sessionId}/video", $newFileName_video, 'public');
                $files['video'][] = [
                    'path' => storage_path('app/public/' . $videoPath),
                    'order' => !empty($videoOrder[$index]) ? $videoOrder[$index] : '1',
                    'duration' => !empty($videoDuration[$index]) ? $videoDuration[$index] : '15',
                    'type' => 'video',
                    'extention' => $extension_video,
                ];
            }
        }        

        if(!empty($audioFiles))
        {
            foreach ($audioFiles as $index => $audioFile) {
                $extension_audio = $audioFile->getClientOriginalExtension();
                $uniquen_number_audio = rand(10,100).'_'.rand(10,100);
                $newFileName_audio = $uniquen_number_audio . '.' . $extension_audio;
                $audioPath = $audioFile->storeAs("uploads/video_generate/{$sessionId}/audio", $newFileName_audio, 'public');
                $files['audio'][] = [
                    'path' => storage_path('app/public/' . $audioPath),
                    'order' => !empty($audioOrder[$index]) ? $audioOrder[$index] : '1',
                    'duration' => !empty($audioDuration[$index]) ? $audioDuration[$index] : '15',
                    'type' => 'audio',
                    'extention' => $extension_audio,
                ];
            }
        }

        if(!empty($imageFiles))
        {
            foreach ($imageFiles as $index => $imageFile) {
                $extension_image = $imageFile->getClientOriginalExtension();
                $uniquen_number_image = rand(10,100).'_'.rand(10,100);
                $newFileName_image = $uniquen_number_image . '.' . $extension_image;
                $imagePath = $imageFile->storeAs("uploads/video_generate/{$sessionId}/images", $newFileName_image, 'public');
                $files['image'][] = [
                    'path' => storage_path('app/public/' . $imagePath),
                    'order' => !empty($imageOrder[$index]) ? $imageOrder[$index] : '1',
                    'duration' => !empty($imageDuration[$index]) ? $imageDuration[$index] : '15',
                    'type' => 'image',
                    'extention' => $extension_image,
                ];
            }
        }

        if(!empty($textFiles))
        {
            foreach ($textFiles as $index => $textFile) {
                $extension_text = $textFile->getClientOriginalExtension();
                $uniquen_number_text = rand(10,100).'_'.rand(10,100);
                $newFileName_text = $uniquen_number_text . '.' . $extension_text;
                $textPath = $textFile->storeAs("uploads/video_generate/{$sessionId}/texts", $newFileName_text, 'public');
                $files['text'][] = [
                    'path' => storage_path('app/public/' . $textPath),
                    'order' => !empty($textOrder[$index]) ? $textOrder[$index] : '1',
                    'duration' => !empty($textDuration[$index]) ? $textOrder[$index] : '15',
                    'type' => 'text',
                    'extention' => $extension_text,
                ];
            }
        }

        // Sort files by order
        foreach ($files as $type => $fileArray) {
            usort($fileArray, function ($a, $b) {
                return $a['order'] <=> $b['order'];
            });
            $files[$type] = $fileArray;
        }


        $with_same_sequence_files = [];
        $standalone_files = [];
        foreach ($files as $type => $fileArray) {
            foreach ($fileArray as $file) {
                $order = $file['order'];
                if (!isset($with_same_sequence_files[$order])) {
                    $with_same_sequence_files[$order] = [];
                }
                $with_same_sequence_files[$order][] = $file;
            }
        }

        foreach ($with_same_sequence_files as $order => $files) {
            if (count($files) === 1) {
                $standalone_files = array_merge($standalone_files, $files);
                unset($with_same_sequence_files[$order]);
            }
        }
       
        // Start for files which have same order number
        $with_same_sequence_files = array_values($with_same_sequence_files);
        $with_same_sequence_generated_videos = [];
        // echo '<pre>';
        // print_r($standalone_files);
        // echo '<br/>';
        // echo '<br/>';
        // print_r($with_same_sequence_files);
        // exit;
        foreach ($with_same_sequence_files as $key=>$with_same_sequence_files_array) 
        {
            $audio_Order = null;
            $image_Order = null;
            $text_Order = null;

            foreach($with_same_sequence_files_array as $with_same_sequence_files_array_value)
            {
                if ($with_same_sequence_files_array_value['type'] == 'video') 
                {
                    $video_Path = $with_same_sequence_files_array_value['path'];
                    $video_Order = $with_same_sequence_files_array_value['order'];
                    $video_Duration = $with_same_sequence_files_array_value['duration'];
                } 
                elseif ($with_same_sequence_files_array_value['type'] == 'audio') 
                {
                    $audio_Path = $with_same_sequence_files_array_value['path'];
                    $audio_Order = $with_same_sequence_files_array_value['order'];
                    $audio_Duration = $with_same_sequence_files_array_value['duration'];
                } 
                elseif ($with_same_sequence_files_array_value['type'] == 'image') 
                {
                    $image_Path = $with_same_sequence_files_array_value['path'];
                    $image_Order = $with_same_sequence_files_array_value['order'];
                    $image_Duration = $with_same_sequence_files_array_value['duration'];
                } 
                elseif ($with_same_sequence_files_array_value['type'] == 'text')
                {
                    $text_Path = $with_same_sequence_files_array_value['path'];
                    $text_Order = $with_same_sequence_files_array_value['order'];
                    $text_Duration = $with_same_sequence_files_array_value['duration'];
                }
            }

            if(!empty($video_Order) && !empty($text_Order) && empty($audio_Order))
            {
                $outputVideo = "{$final_videos_to_concat}/video_and_text_same_sequence_{$key}.mp4";
                $mp4_to_mp4_outputVideoPath = "{$storagePath}/mp4_to_mp4_outputVideoPath1_{$key}.mp4";
                $this->video_crop_and_set_resolution($video_Path,$video_Duration,$mp4_to_mp4_outputVideoPath);

                $this->video_and_text_have_same_sequence_only($text_Path,$mp4_to_mp4_outputVideoPath,$outputVideo,$storagePath,$text_Duration);  
                $with_same_sequence_generated_videos[$video_Order] = $outputVideo;  
                $video_Order = '';    
                $text_Order = '';    
            }
            elseif(!empty($video_Order) && !empty($audio_Order) && empty($text_Order))
            {
                $outputVideo = "{$final_videos_to_concat}/video_and_audio_same_sequence_{$key}.mp4";
                $mp4_to_mp4_outputVideoPath = "{$storagePath}/mp4_to_mp4_outputVideoPath2_{$key}.mp4";
                $this->video_crop_and_set_resolution($video_Path,$video_Duration,$mp4_to_mp4_outputVideoPath);
                $this->merge_video_and_audio($mp4_to_mp4_outputVideoPath,$audio_Path,$outputVideo);
                $with_same_sequence_generated_videos[$video_Order] = $outputVideo;  
                $video_Order = '';    
                $audio_Order = '';    
            }
            elseif(!empty($video_Order) && !empty($audio_Order) && !empty($text_Order))
            {
                $outputVideo = "{$final_videos_to_concat}/video_text_and_audio_same_sequence_{$key}.mp4";

                // first,merge video and text
                $mp4_to_mp4_outputVideoPath = "{$storagePath}/mp4_to_mp4_outputVideoPath3_{$key}.mp4";
                $this->video_crop_and_set_resolution($video_Path,$video_Duration,$mp4_to_mp4_outputVideoPath);
                $output_video_and_text_have_same_sequence_only_path = "{$storagePath}/output_video_and_text_have_same_sequence_only_{$key}.mp4";
                $this->video_and_text_have_same_sequence_only($text_Path,$mp4_to_mp4_outputVideoPath,$output_video_and_text_have_same_sequence_only_path,$storagePath,$text_Duration);  

                // Then, merge video and audio
                $this->merge_video_and_audio($output_video_and_text_have_same_sequence_only_path,$audio_Path,$outputVideo);
                $with_same_sequence_generated_videos[$video_Order] = $outputVideo;  
                $video_Order = '';    
                $audio_Order = '';       
                $text_Order = '';       
            }
            elseif(!empty($audio_Order) && !empty($image_Order) && empty($text_Order))
            {
                // if audio and images have same sequence
                $outputVideo = "{$final_videos_to_concat}/audio_and_images_same_sequence_{$key}.mp4";
                $this->audio_and_images_have_same_sequence($storagePath,$key,$image_Path,$image_Duration,$audio_Path,$outputVideo);  
                $with_same_sequence_generated_videos[$audio_Order] = $outputVideo;      
                $audio_Order = '';             
                $image_Order = '';             
            }
            elseif(!empty($audio_Order) && !empty($text_Order) && empty($image_Order) && empty($video_Order))
            {
                // if audio and text have same sequence
                $outputVideo = "{$final_videos_to_concat}/audio_and_text_same_sequence_{$key}.mp4";
                $audio_and_text_same_sequence__outputImagePath = "{$storagePath}/audio_and_text_same_sequence_text_to_mp4_{$key}.png";
                // first, Convert text file to images
                $this->text_to_image($text_Path,$audio_and_text_same_sequence__outputImagePath,$storagePath);   
                // then
                $this->audio_and_images_have_same_sequence($storagePath,$key,$audio_and_text_same_sequence__outputImagePath,$text_Duration,$audio_Path,$outputVideo);                  
                $with_same_sequence_generated_videos[$audio_Order] = $outputVideo;      
                $audio_Order = '';             
                $text_Order = '';              
            }
            elseif(empty($audio_Order) && !empty($text_Order) && !empty($image_Order))
            {
                // if images and text have same sequence
                $outputVideo = "{$final_videos_to_concat}/images_and_text_same_sequence_{$key}.mp4";
                //$images_and_text_same_sequence__outputImagePath = "{$storagePath}/images_and_text_same_sequence_image_to_mp4_{$key}.mp4";
                // first, convert images into mp4
                //$this->standalone_image_to_mp4($image_Path,$image_Duration,$images_and_text_same_sequence__outputImagePath);
                // then
                //$this->video_and_text_have_same_sequence($text_Path,$images_and_text_same_sequence__outputImagePath,$outputVideo,$storagePath);        
                $this->video_and_text_have_same_sequence($text_Path,$image_Path,$outputVideo,$storagePath,$image_Duration);        
                $with_same_sequence_generated_videos[$text_Order] = $outputVideo;     
                $image_Order = '';             
                $text_Order = '';    
                //exit;             
            }
            elseif(!empty($audio_Order) && !empty($text_Order) && !empty($image_Order))
            {
                // if audio, images and text have same sequence
                $outputVideo = "{$final_videos_to_concat}/audio_images_and_text_same_sequence_{$key}.mp4";
                //$audio_images_and_text_same_sequence__outputImagePath = "{$storagePath}/audio_images_and_text_same_sequence_image_to_mp4_{$key}.mp4";

                // first, merge audio and images, which are in same sequence
                // $this->audio_and_images_have_same_sequence($storagePath,$key,$image_Path,$image_Duration,$audio_Path,$audio_images_and_text_same_sequence__outputImagePath);
                // then
                //$this->video_and_text_have_same_sequence($text_Path,$audio_images_and_text_same_sequence__outputImagePath,$outputVideo,$storagePath); 
                
                // First images and text
                $audio_images_and_text_same_sequence__outputImagePath = "{$storagePath}/audio_images_and_text_same_sequence_image_to_mp4_{$key}.mp4";
                $this->video_and_text_have_same_sequence_with_audio($text_Path,$image_Path,$audio_images_and_text_same_sequence__outputImagePath,$storagePath,$image_Duration); 
                
                // Then, crop the audio file
                $outputAudioCroppedPath = "{$storagePath}/output_audio_cropped_{$key}.mp4";
                $ffmpegCmd_same_sequence222 = "ffmpeg -i {$audio_Path} -af \"atrim=0:{$audio_Duration}\" -c:a aac {$outputAudioCroppedPath}";

                shell_exec($ffmpegCmd_same_sequence222);

                // Then, merge audio and video     
                $ffmpegCmd_same_sequence22 = "ffmpeg -i {$audio_images_and_text_same_sequence__outputImagePath} -i {$outputAudioCroppedPath} -preset ultrafast -c:v copy -c:a aac {$outputVideo}";
                shell_exec($ffmpegCmd_same_sequence22);
                $with_same_sequence_generated_videos[$text_Order] = $outputVideo;    
                $audio_Order = '';             
                $text_Order = '';               
                $image_Order = '';               
            }
        }       

        // Start for files which have same order number

        // Start for stand alone files. Means files which do not have same order number
        $standalone_files = array_values($standalone_files);
        $stand_alone_generated_videos = [];


        // echo '<pre>';
        // print_r($standalone_files);
        // print_r($with_same_sequence_files);exit;

        if (!empty($standalone_files)) 
        {
            $standalone_increment_number = 0;
            foreach($standalone_files as $key=>$standalone_files_values)
            {
                $file_path = $standalone_files_values['path'];
                $file_duration = $standalone_files_values['duration'];
                $file_order = $standalone_files_values['order'];
                $file_extention = $standalone_files_values['extention'];
                if($standalone_files_values['type'] == 'video')
                {
                    if($file_extention == 'mp4')
                    {
                        // convert mp4 to mp4. Add audio and resolution
                        $outputVideo = "{$final_videos_to_concat}/standalone_mp4_to_mp4_{$key}.mp4";
                        $ffmpegCmd_mp4_to_mp4 = "ffmpeg -i {$file_path} -f lavfi -i anullsrc -vf \"crop=in_w:in_h:0:0,trim=start=0:end={$file_duration},setpts=PTS-STARTPTS,scale=1280:720,setdar=16/9,setsar=1\" -c:v libx264 -c:a aac -shortest {$outputVideo}";
                        shell_exec($ffmpegCmd_mp4_to_mp4);
                    }
                    // elseif($file_extention == 'gif')
                    // {
                    //     // convert gif to mp4
                    //     $outputVideo = "{$final_videos_to_concat}/standalone_gif_to_mp4_{$key}.mp4";
                    //     //$ffmpegCmd_gif_to_mp4 = "ffmpeg -stream_loop -1 -i {$file_path} -t {$file_duration} -movflags faststart -pix_fmt yuv420p -vf \"scale=trunc(iw/2)*2:trunc(ih/2)*2\" {$outputVideo}";
                    //     $ffmpegCmd_gif_to_mp4 = "ffmpeg -stream_loop -1 -i {$file_path} -f lavfi -i anullsrc=cl=stereo:r=44100 -t {$file_duration} -movflags faststart -pix_fmt yuv420p -vf \"scale=trunc(iw/2)*2:trunc(ih/2)*2\" -c:a aac -shortest {$outputVideo} 2>&1";
                    //     $output = shell_exec($ffmpegCmd_gif_to_mp4);
                    //     // echo '<pre>';
                    //     // print_r($output);exit;
                    // }
                    $stand_alone_generated_videos[$file_order] = $outputVideo;
                }
                if($standalone_files_values['type'] == 'audio')
                {
                    // convert mp3 to mp4
                    $outputVideo = "{$final_videos_to_concat}/standalone_mp3_to_mp4_{$key}.mp4";
                    $ffmpegCmd1 = "ffmpeg -y -f lavfi -i color=c=black:s=1280x720:r=5 -i {$file_path} -t {$file_duration} -preset ultrafast -crf 0 -c:a copy -shortest {$outputVideo}";
                    shell_exec($ffmpegCmd1);
                    $stand_alone_generated_videos[$file_order] = $outputVideo;
                }
                elseif($standalone_files_values['type'] == 'image')
                {
                    // convert images to mp4
                    $outputVideo = "{$final_videos_to_concat}/standalone_images_to_mp4_{$key}.mp4";
                    $this->standalone_image_to_mp4($file_path,$file_duration,$outputVideo);
                    $stand_alone_generated_videos[$file_order] = $outputVideo;
                    
                }
                elseif($standalone_files_values['type'] == 'text')
                {
                    // convert text to mp4
                    $outputVideo = "{$final_videos_to_concat}/standalone_text_to_mp4_{$key}.mp4";
                    $outputImagePath = "{$storagePath}/standalone_text_to_mp4_{$key}.png";
                    
                    // first convert text file to images
                    $text_to_image = $this->text_to_image($file_path,$outputImagePath, $storagePath);           
                    
                    // then Convert those image to mp4
                    $this->standalone_image_to_mp4($outputImagePath,$file_duration,$outputVideo);    
                    $stand_alone_generated_videos[$file_order] = $outputVideo;                
                }
            }
        }
        // End for stand alone files. Means files which do not have same order number


        // Final concat all the generated videos
        $combinedArray = $with_same_sequence_generated_videos + $stand_alone_generated_videos;
        $all_generated_videos = $combinedArray;
        ksort($all_generated_videos);

        $final_ffmpegCmd1 = "ffmpeg -y ";
        $final_ffmpegCmd2_count = 0;
        $final_ffmpegCmd2 = '';
        $final_ffmpegCmd22 = '';
        // foreach ($all_generated_videos as $order => $filePath) {
        //     $final_ffmpegCmd1 .= " -i {$filePath} ";
        //     $final_ffmpegCmd2 .= "[{$final_ffmpegCmd2_count}:v]fade=in:st=0:d=1[fadein];";
        //     $final_ffmpegCmd22 .= "[fadein][{$final_ffmpegCmd2_count}:a]";
        //     $final_ffmpegCmd2_count++;
        // }
       
        // $final_ffmpegCmd1 .= " -filter_complex \"";
        // $final_ffmpegCmd3 = $final_ffmpegCmd1.$final_ffmpegCmd2.$final_ffmpegCmd22;

        foreach ($all_generated_videos as $order => $filePath) {
            $final_ffmpegCmd1 .= " -i {$filePath} ";
            $final_ffmpegCmd2 .= "[{$final_ffmpegCmd2_count}:v][{$final_ffmpegCmd2_count}:a]";
            //$final_ffmpegCmd22 .= "[fadein][{$final_ffmpegCmd2_count}:a]";
            $final_ffmpegCmd2_count++;
        }
       
        $final_ffmpegCmd1 .= " -filter_complex \"";
        $final_ffmpegCmd3 = $final_ffmpegCmd1.$final_ffmpegCmd2;

        //$final_ffmpegCmd3;
        // echo '</br>';
        // echo '</br>';
        // echo '</br>';
        //echo $final_ffmpegCmd3 .= "concat=n=" . count($all_generated_videos) . ":v=1:a=1[v][a]\" -map \"[v]\" -map \"[a]\" -fps_mode vfr -c:v libx264 -preset ultrafast -c:a aac {$storagePath}/final_output_without_logo.mp4 2>&1";
        $final_ffmpegCmd_output = $final_ffmpegCmd3. "concat=n=" . count($all_generated_videos) . ":v=1:a=1[v][a]\" -map \"[v]\" -map \"[a]\" -fps_mode vfr -c:v libx264 -preset ultrafast -c:a aac {$storagePath}/final_output.mp4";
        //shell_exec($final_ffmpegCmd3);
        $output = shell_exec($final_ffmpegCmd_output);
        // echo '<pre>';
        // print_r($output);exit;
        // Add logo on the generated video
        // $final_ouput_video = "{$storagePath}/final_output_without_logo.mp4";
        // $logo_path = public_path('frontend/img/rv_rotating_logo.gif');
        // $final_ffmpegCmd_with_logo = "ffmpeg -i {$final_ouput_video} -i {$logo_path} -filter_complex \"[1:v]scale=80:70 [logo]; [0:v][logo]overlay=10:10\" {$storagePath}/final_output.mp4 2>&1";
        // $output = shell_exec($final_ffmpegCmd_with_logo);

        // Generate the download URL using route
        $downloadUrl = route('download.generated.video', ['sessionId' => $sessionId]);
        return response()->json([
            'status' => 'ok',
            'session_id' => $sessionId,
            'video_path' => $downloadUrl
        ]);        

    }
    public function audio_and_images_have_same_sequence($storagePath,$key,$image_Path,$imageDuration,$audio_Path,$outputVideo)
    {
        // first convert images into video with time
        $outputImageIntoVideoPath = "{$storagePath}/same_sequence_image_to_video_{$key}.mp4";
        $ffmpegCmd_same_sequence1 = "ffmpeg -loop 1 -i {$image_Path} -c:v libx264 -t {$imageDuration} -preset ultrafast -pix_fmt yuv420p -vf \"scale=1280:720,setdar=16/9,setsar=1\" {$outputImageIntoVideoPath}";
        shell_exec($ffmpegCmd_same_sequence1);

        // then, merge audio and video
        $ffmpegCmd_same_sequence2 = "ffmpeg -i {$outputImageIntoVideoPath} -i {$audio_Path} -preset ultrafast -c:v copy -c:a aac {$outputVideo}";
        shell_exec($ffmpegCmd_same_sequence2);
    }
    public function splitText($text, $charsPerLine) {
        $lines = [];
        $line = '';
        $charCount = 0;
        foreach (str_split($text) as $char) {
            $line .= $char;
            $charCount++;
            if ($charCount >= $charsPerLine) {
                $lines[] = rtrim($line);
                $line = '';
                $charCount = 0;
            }
        }
        if (!empty($line)) {
            $lines[] = rtrim($line);
        }
        return $lines;
    }
    public function video_and_text_have_same_sequence_only($text_Path,$mp4_to_mp4_outputVideoPath,$outputVideo,$storagePath,$text_Duration)
    {
        $textFile = $text_Path;
        $input_text = file_get_contents($textFile);
        $input_text = trim($input_text);

        // Function to split text into lines after every n characters

        // Split text into lines after every n characters
        $charsPerLine = 185; // Change this value according to your requirement
        $lines =  $this->splitText($input_text, $charsPerLine);

        // Prepare text with line breaks
        $textWithNewlines = implode("\n", $lines);
        $rand_no = rand(10,100);

        // Write the prepared text to a new file
        $new_generated_file = "{$storagePath}/text_content_{$rand_no}.txt";
        file_put_contents($new_generated_file, $textWithNewlines);
        $new_generated_file = str_replace('\\', '/', $new_generated_file);
        $new_generated_file2 = str_replace(':/', '\:/', $new_generated_file);


        //$cmd = "ffmpeg -loop 1 -i {$imageFile} -f lavfi -i anullsrc -vf \"drawtext=textfile='{$new_generated_file2}':fontcolor=white:fontsize=13:x=10:y=main_h-25-text_h-10:line_spacing=10:box=1:boxcolor=black@0.5:boxborderw=5,fade=in:st=0:d=1,scale=1280:720,setdar=16/9,setsar=1\" -t {$duration} -c:v libx264 -pix_fmt yuv420p -crf 23 -c:a aac {$outputVideo} 2>&1";
        $cmd = "ffmpeg -i {$mp4_to_mp4_outputVideoPath} -preset ultrafast -vf \"drawtext=textfile='{$new_generated_file2}':fontcolor=white:fontsize=15:x=10:y=h-80-(th-10):line_spacing=14:box=1:boxcolor=black@0.5:boxborderw=5,format=yuv420p\" -t {$text_Duration} -c:v libx264 -crf 23 -c:a copy {$outputVideo}";

        $output = shell_exec($cmd);

        // echo '<pre>';
        // print_r($output);exit;
        if ($output === null) {
            echo false;
        } else {
            echo true;
        }
    }
    public function video_and_text_have_same_sequence($text_Path,$image_Path,$outputVideo,$storagePath,$duration)
    {
        $textFile = $text_Path;
        $input_text = file_get_contents($textFile);
        $input_text = trim($input_text);

        // Function to split text into lines after every n characters

        // Split text into lines after every n characters
        $charsPerLine = 122; // Change this value according to your requirement
        $lines =  $this->splitText($input_text, $charsPerLine);

        // Prepare text with line breaks
        $textWithNewlines = implode("\n", $lines);
        $rand_no = rand(10,100);

        // Write the prepared text to a new file
        $new_generated_file = "{$storagePath}/text_content_{$rand_no}txt";
        file_put_contents($new_generated_file, $textWithNewlines);
        $new_generated_file = str_replace('\\', '/', $new_generated_file);
        $new_generated_file2 = str_replace(':/', '\:/', $new_generated_file);


        // Image and output video file
        $imageFile = $image_Path;
        //$outputVideo = 'text_on_image.mp4';

        //echo $cmd = "ffmpeg -loop 1 -i {$imageFile} -vf \"drawtext=textfile='$new_generated_file':fontcolor=white:fontsize=13:x=10:y=main_h-25-text_h-10:line_spacing=10:box=1:boxcolor=black@0.5:boxborderw=5,fade=in:st=0:d=1\" -c:v libx264 -pix_fmt yuv420p -crf 23 -c:a copy {$outputVideo} 2>&1";

       // $cmd = "ffmpeg -loop 1 -i {$imageFile} -vf \"drawtext=textfile='{$new_generated_file2}':fontcolor=white:fontsize=13:x=10:y=main_h-25-text_h-10:line_spacing=10:box=1:boxcolor=black@0.5:boxborderw=5,fade=in:st=0:d=1\" -t {$duration} -c:v libx264 -pix_fmt yuv420p -crf 23 -c:a copy {$outputVideo}";

        $cmd = "ffmpeg -loop 1 -i {$imageFile} -f lavfi -i anullsrc -vf \"drawtext=textfile='{$new_generated_file2}':fontcolor=white:fontsize=15:x=10:y=main_h-25-text_h-10:line_spacing=10:box=1:boxcolor=black@0.5:boxborderw=5,fade=in:st=0:d=1,scale=1280:720,setdar=16/9,setsar=1\" -t {$duration} -c:v libx264 -pix_fmt yuv420p -crf 23 -c:a aac {$outputVideo}";
       
        $output = shell_exec($cmd);
        // echo '<pre>';
        // print_r($output);exit;
        if ($output === null) {
            echo false;
        } else {
            echo true;
        }
    }
    public function video_and_text_have_same_sequence_with_audio($text_Path,$image_Path,$outputVideo,$storagePath,$duration)
    {
        $textFile = $text_Path;
        $input_text = file_get_contents($textFile);
        $input_text = trim($input_text);

        // Function to split text into lines after every n characters

        // Split text into lines after every n characters
        $charsPerLine = 122; // Change this value according to your requirement
        $lines =  $this->splitText($input_text, $charsPerLine);

        // Prepare text with line breaks
        $textWithNewlines = implode("\n", $lines);
        $rand_no = rand(10,100);

        // Write the prepared text to a new file
        $new_generated_file = "{$storagePath}/text_content_{$rand_no}.txt";
        file_put_contents($new_generated_file, $textWithNewlines);
        $new_generated_file = str_replace('\\', '/', $new_generated_file);
        $new_generated_file2 = str_replace(':/', '\:/', $new_generated_file);


        // Image and output video file
        $imageFile = $image_Path;

        $cmd = "ffmpeg -loop 1 -i {$imageFile} -vf \"drawtext=textfile='{$new_generated_file2}':fontcolor=white:fontsize=15:x=10:y=main_h-25-text_h-10:line_spacing=10:box=1:boxcolor=black@0.5:boxborderw=5,fade=in:st=0:d=1,scale=1280:720,setdar=16/9,setsar=1\" -t {$duration} -c:v libx264 -pix_fmt yuv420p -crf 23 -c:a aac {$outputVideo}";
       
        $output = shell_exec($cmd);
        // echo '<pre>';
        // print_r($output);exit;
        if ($output === null) {
            echo false;
        } else {
            echo true;
        }
    }
    // public function video_and_text_have_same_sequence($text_Path,$images_and_text_same_sequence__outputImagePath,$outputVideo)
    // {
    //     $textFile = $text_Path;
    //     $input_text = file_get_contents($textFile);
    //     $input_text = trim($input_text);

    //     // Replace newline characters with appropriate escape sequences
    //     $input_text = str_replace("\n", "\\n", $input_text);
    //     $input_text = str_replace("\r", "", $input_text);

    //     $cmd = "C:/FFmpeg/bin/ffmpeg -i {$images_and_text_same_sequence__outputImagePath} -preset ultrafast -vf \"drawtext=fontfile=/fa-solid-900.ttf:text='$input_text':fontcolor=white:fontsize=24:x=w-tw-(t*50):y=h-th-10:box=1:boxcolor=black@0.5:boxborderw=5\" -y -codec:a copy {$outputVideo}";

    //     $output = shell_exec($cmd);

    //     if ($output === null) {
    //         echo false;
    //     } else {
    //         echo true;
    //     }
    // }
    public function standalone_image_to_mp4($file_path,$file_duration,$outputVideo)
    {
        $ffmpegCmd2 = "ffmpeg -loop 1 -i {$file_path} -f lavfi -i anullsrc=channel_layout=stereo:sample_rate=44100 -c:v libx264 -t {$file_duration} -preset ultrafast -pix_fmt yuv420p -vf \"scale=1280:720,setdar=16/9,setsar=1\" {$outputVideo}";                    
        shell_exec($ffmpegCmd2);
    }
    public function text_to_image($textFilePath, $outputImagePath, $storagePath)
    {
        $textFile = $textFilePath;
        $input_text = file_get_contents($textFile);
        $width = 800;
        $height = 400;

        // Create a true color image
        $textImage = imagecreatetruecolor($width, $height);

        // Allocate white color for the background
        $white = imagecolorallocate($textImage, 255, 255, 255);
        imagefill($textImage, 0, 0, $white);

        // Allocate black color for the text
        $black = imagecolorallocate($textImage, 0, 0, 0);


        // Split text into lines after every n characters
        $charsPerLine = 85; // Change this value according to your requirement
        $lines =  $this->splitText($input_text, $charsPerLine);
        // Prepare text with line breaks
        $textWithNewlines = implode("\n", $lines);
        $rand_no = rand(10,100);
        $new_generated_file = "{$storagePath}/text_content_{$rand_no}.txt";
        file_put_contents($new_generated_file, $textWithNewlines);
        $input_text = file_get_contents($new_generated_file);



        // Break lines by newline characters
        $input_text_lines = explode("\n", $input_text);

        // If you have multiple lines, you can adjust the y-coordinate for each line
        $y = 5; // Initial y-coordinate
        $line_height = 15; // Adjust line height as needed
        $font_size = 5; // GD font size

        foreach ($input_text_lines as $line) {
            imagestring($textImage, $font_size, 10, $y, trim($line), $black);
            $y += $line_height; // Move down for the next line
        }
        // Save the image as a PNG file in the current directory
        $image_file = $outputImagePath;
        imagepng($textImage, $image_file);

        // Output the image as base64
        ob_start();
        imagepng($textImage);
        $data = base64_encode(ob_get_clean());
        imagedestroy($textImage);
    }
    public function merge_video_and_audio($video_Path,$audio_Path,$outputVideo)
    {
        $ffmpegCmd_video_and_audio = "ffmpeg -i {$video_Path} -i {$audio_Path} -c:v copy -map 0:v:0 -map 1:a:0 -shortest {$outputVideo}";
        shell_exec($ffmpegCmd_video_and_audio);    
    }
    public function video_crop_and_set_resolution($video_Path,$video_Duration,$mp4_to_mp4_outputVideoPath)
    {
        $ffmpegCmd_mp4_to_mp4 = "ffmpeg -i {$video_Path} -f lavfi -i anullsrc -vf \"crop=in_w:in_h:0:0,trim=start=0:end={$video_Duration},setpts=PTS-STARTPTS,scale=1280:720,setdar=16/9,setsar=1\" -c:v libx264 -c:a aac -shortest {$mp4_to_mp4_outputVideoPath}";
        shell_exec($ffmpegCmd_mp4_to_mp4);
    }
    public function download_generated_video($sessionId)
    {
        $videoPath = storage_path("app/public/uploads/video_generate/{$sessionId}/final_output.mp4");
        return response()->download($videoPath);
    }
    public function delete_generated_deletedirectory(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'session_id' => 'required', // Assuming session_id is a string
        ]);

        // Get the session ID from the request
        $sessionId = $request->input('session_id');

        // Construct the directory path
        $directoryPath = "uploads/video_generate/{$sessionId}";
       // $directoryPath = storage_path("app/public/uploads/video_generate/{$sessionId}");

        // Check if the directory exists
        if (Storage::disk('public')->exists($directoryPath)) {
            // Delete the directory and all its contents
            Storage::disk('public')->deleteDirectory($directoryPath);
            return response()->json(['message' => 'Directory deleted successfully']);
        } else {
            return response()->json(['error' => 'Directory not found'], 404);
        }
    }


}
