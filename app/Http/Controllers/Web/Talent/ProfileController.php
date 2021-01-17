<?php

namespace App\Http\Controllers\Web\Talent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\TalentRepositoryInterface;
use App\Repositories\Interfaces\SkillRepositoryInterface;
use Validator,Hash,Auth;
use App\Repositories\Interfaces\SavedUserCardRepositoryInterface;
use App\Repositories\Interfaces\JobCategoryRepositoryInterface;
use App\Repositories\Interfaces\AppsCountryRepositoryInterface;
use App\Models\ProjectRating;
use App\Models\Project;
use App\User;


class ProfileController extends Controller
{
    use \App\Traits\MangoPayManager;

    private $appsCountry;
    private $user;
    public function __construct(UserRepositoryInterface $user,TalentRepositoryInterface $talent,SkillRepositoryInterface $skill,SavedUserCardRepositoryInterface $saveUserCard, JobCategoryRepositoryInterface $jobCategory,AppsCountryRepositoryInterface $appsCountry){
        $this->user=$user;
        $this->talent=$talent;
        $this->skill=$skill;
        $this->saveUserCard=$saveUserCard;
        $this->jobCategory=$jobCategory;
        $this->appsCountry=$appsCountry;
    }


    public function index(Request $request){
        $currentUser=$this->user->getCurrentUser();
        $Cards=null;
        $walletInfo=null;
        $bankAccounts=null;
        $kycDoc=null;
        if(!is_null($currentUser->mangopayUser)){
            $token=$this->token();
            if(!$token){
                return redirect(route('siteError', ['message'=>'Token not generated. Please try again later.']));
            }
            $bankAccounts=$this->listBankAccount($token->access_token,$currentUser->mangopayUser->mangopay_user_id);

            $walletInfo=$this->veiwWallet( $token->access_token,$currentUser->mangopayUser->mangopay_wallet_id);
            //  dd($token,$currentUser->mangopayUser->mangopay_user_id);
          $Cards=$this->listAllUserCards( $token->access_token,$currentUser->mangopayUser->mangopay_user_id);
          $kycDoc=$this->listKycDoc($token->access_token,$currentUser->mangopayUser->mangopay_user_id);
          $array_docx = json_decode(json_encode($kycDoc), true);
          if(is_array($array_docx))
          {
          $count_docx=count($array_docx);
        }
         
        }
        $defaultCardid=$this->saveUserCard->getDefaultCardId($currentUser->id);
        $jobCategories=$this->jobCategory->all();
        $countries=$this->appsCountry->all();
        $project_rating=ProjectRating::where('rated_user_id','=',$currentUser->id)->get();

        foreach($project_rating as $project_ratings){

            $project_name=Project::where('id','=', $project_ratings->project_id)->first();
            $talent_name=User::where('id','=',$currentUser->id)->first();
            $client_name=User::where('id','=',$project_ratings->given_by_user_id)->first();

            $records[]=[

            'project_name'=>$project_name->title,
            'duration'=>$project_name->duration_month,
            'talent_name'=>$talent_name->first_name,
            'client_name'=>$client_name->first_name,
            'rating'=>$project_ratings->rating,
            'feedback'=>$project_ratings->feedback,

            ];

        }
        return view('web.talents.profile.index',compact('records','count_docx','currentUser','Cards','walletInfo','defaultCardid','bankAccounts','kycDoc','jobCategories','countries'));
    }


    public function uploadProfileImage(){
        try{
             /*
            *   !!! THIS IS JUST AN EXAMPLE !!!, PLEASE USE ImageMagick or some other quality image processing libraries
            */
            $imgUrl = $_POST['imgUrl'];
            // original sizes
            $imgInitW = $_POST['imgInitW'];
            $imgInitH = $_POST['imgInitH'];
            // resized sizes
            $imgW = $_POST['imgW'];
            $imgH = $_POST['imgH'];
            // offsets
            $imgY1 = $_POST['imgY1'];
            $imgX1 = $_POST['imgX1'];
            // crop box
            $cropW = $_POST['cropW'];
            $cropH = $_POST['cropH'];
            // rotation angle
            $angle = $_POST['rotation'];

            $jpeg_quality = 100;
            $randdd=rand();
            $output_filename = public_path(config('constants.profile.BASE_URL'))."/croppedImg_".$randdd;

            $output_filename1 = config('constants.profile.BASE_URL')."/croppedImg_".$randdd;
          
            // uncomment line below to save the cropped image in the same location as the original image.
            //$output_filename = dirname($imgUrl). "/croppedImg_".rand();
          
            $what = getimagesize($imgUrl);

            switch(strtolower($what['mime']))
            {
              case 'image/png':
                  $img_r = imagecreatefrompng($imgUrl);
                  $source_image = imagecreatefrompng($imgUrl);
                  $type = '.png';
                  break;
              case 'image/jpeg':
                  $img_r = imagecreatefromjpeg($imgUrl);
                  $source_image = imagecreatefromjpeg($imgUrl);
                  error_log("jpg");
                  $type = '.jpeg';
                  break;
              /*case 'image/gif':
                  $img_r = imagecreatefromgif($imgUrl);
                  $source_image = imagecreatefromgif($imgUrl);
                  $type = '.gif';
                  break; */
              default: die('image type not supported');
            }
            //Check write Access to Directory
      
            if(!is_writable(dirname($output_filename))){
                $response = Array(
                  "status" => 'error',
                  "message" => 'Can`t write cropped File'
                );  
            }else
            {
          
                // resize the original image to size of editor
                $resizedImage = imagecreatetruecolor($imgW, $imgH);
                imagecopyresampled($resizedImage, $source_image, 0, 0, 0, 0, $imgW, $imgH, $imgInitW, $imgInitH);
                // rotate the rezized image
                $rotated_image = imagerotate($resizedImage, -$angle, 0);
                // find new width & height of rotated image
                $rotated_width = imagesx($rotated_image);
                $rotated_height = imagesy($rotated_image);
                // diff between rotated & original sizes
                $dx = $rotated_width - $imgW;
                $dy = $rotated_height - $imgH;
                // crop rotated image to fit into original rezized rectangle
                $cropped_rotated_image = imagecreatetruecolor($imgW, $imgH);
                imagecolortransparent($cropped_rotated_image, imagecolorallocate($cropped_rotated_image, 0, 0, 0));
                imagecopyresampled($cropped_rotated_image, $rotated_image, 0, 0, $dx / 2, $dy / 2, $imgW, $imgH, $imgW, $imgH);
                // crop image into selected area
                $final_image = imagecreatetruecolor($cropW, $cropH);
                imagecolortransparent($final_image, imagecolorallocate($final_image, 0, 0, 0));
                imagecopyresampled($final_image, $cropped_rotated_image, 0, 0, $imgX1, $imgY1, $cropW, $cropH, $cropW, $cropH);
                // finally output png image
                //imagepng($final_image, $output_filename.$type, $png_quality);
                imagejpeg($final_image, $output_filename.$type, $jpeg_quality);
                $response = Array(
                "status" => 'success',
                "url" => $output_filename1.$type
                );
            }
            if(isset($response) && $response['status']=='success'){
                $user=\Auth::user();
                $user->user_image=$output_filename1.$type ?? '';
                $user->save();

                return response()->json($response);
            }

            return response()->json($response);
        }
        catch(\Exception $e){
            return response()->json(Array(
                "status" => 'error',
                "error" =>$e->getMessage()
            ));
        }
    } 

    public function changePassword(Request $request){
        try {
            $validation = Validator::make($request->all(), [
                        'old_password' => 'required',
                        // 'new_password' => 'required|min:6|different:old_password',
                        'new_password' => [
                          'required',
                          'string',

                          'min:6',              // must be at least 6 characters in length
                          'different:old_password'
                        ],
                         'new_con_password'=>'required|same:new_password'
                      ]

            );
            if ($validation->fails())
                return Response(array('success' => 0, 'statuscode' => 400, 'msg' => $validation->getMessageBag()->first()));
            $user               =   Auth::user();
            $data               =   $request->all();
            $data['user_id']    =   $user->id;
            // $request['old_password'] = trim($request['old_password'], '"');
            // $request['new_password'] = trim($request['new_password'], '"');

            if (!Hash::check($request['old_password'], $user->password))
                return Response(array('success' => 0, 'statuscode' => 400, 'msg' =>'Old Password did not match'));

                $user->password = $data['new_password'] = Hash::make($request['new_password']);
            $user->save();

            return response(['success' => 1, 'statuscode' => 200, 'msg' => "Password updated successfully."]);
        } catch (\Exception $e) {
            return response(['success' => 0, 'statuscode' => 500, 'msg' => $e->getMessage()]);
        }
    }

    // update talent profile
    public function updateProfile(Request $request){
        $currentUser=$this->user->getCurrentUser();
        $this->validate($request,
            [
                'first_name'=>'required',
                'last_name'=>'required',
                'phone_code'=>'required',
                'phone_number'=>'required|unique:users,phone_number,'.$currentUser->id,
            ]);
        $currentUser->first_name = $request->first_name;
        $currentUser->last_name = $request->last_name;
        $currentUser->phone_code = $request->phone_code;
        $currentUser->phone_number = $request->phone_number;
        if($currentUser->save()){
            return response()->json(['status'=>true,'message'=>'Profile updated successfully.'], 200);
        }
        return response()->json(['status'=>false,'message'=>'Profile not updated. Please try again later.'], 200);
    }

    // update work experience details
    public function updateWorkExperience(Request $request){
        $currentUser=$this->user->getCurrentUser();
        $this->validate($request,
            [
                'job_field'=>'required',
                'job_title'=>'bail|required|string|max:200',
                'work_experience'=>'required',
                'working_type'=>'required',
                'hours'=>'required',
                'available_start_date'=>'required',
                'available_end_date'=>'required',
                'skills'=>'bail|required|array'
            ]);
        $talent = $this->talent->details($currentUser->id);
        $talent->job_field = $request->job_field;
        $talent->job_title = $request->job_title;
        $talent->work_experience = $request->work_experience;
        $talent->working_type = $request->working_type;
        $talent->hours = $request->hours;
        $talent->available_start_date = $request->available_start_date;
        $talent->available_end_date = $request->available_end_date;
        if($talent->save()){
            $skills = array_unique($request->skills);
            $talent->skills()->sync($skills);
            
            return response()->json(['status'=>true,'message'=>'The work experience updated successfully.'], 200);
        }
        return response()->json(['status'=>false,'message'=>'The work experience not updated. Please try again later.'], 200);
    }

    public function addGstVatDetails(Request $request){
        $currentUser=$this->user->getCurrentUser();
        $countries=$this->appsCountry->all();
        return view('web.talents.profile.gst', compact('countries','currentUser'));
    }

    public function saveGstVatDetails(Request $request){
        $currentUser=$this->user->getCurrentUser();
        $this->validate($request,[
            'invoice_country_code'=>'required',
            'country_of_operation'=>'required',
            'country_of_origin'=>'required',
            'gst_vat_applicable'=>'bail|required|in:yes,no',
            'vat_gst_number'=>'bail|required_if:gst_vat_applicable,yes',
            'vat_gst_rate'=>'bail|required_if:gst_vat_applicable,yes|max:100|numeric',
        ]);

        $currentUser->invoice_country_code = $request->input('invoice_country_code');
        $currentUser->country_of_operation = $request->input('country_of_operation');
        $currentUser->country_of_origin = $request->input('country_of_origin');
        $currentUser->gst_vat_applicable = $request->input('gst_vat_applicable');
        if($request->input('gst_vat_applicable')=='yes'){
            $currentUser->vat_gst_number = $request->input('vat_gst_number');
            $currentUser->vat_gst_rate = $request->input('vat_gst_rate');
        }else{
            $currentUser->vat_gst_number = null;
            $currentUser->vat_gst_rate = null;
        }

        if($currentUser->save()){
            return response()->json(['status'=>true,'message'=>'Details updated successfully.'], 200);
        }
        return response()->json(['status'=>false,'message'=>'Details not updated. Please try again later.'], 200);
    }
}
