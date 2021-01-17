<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\TalentRepositoryInterface;
use App\Repositories\Interfaces\SkillRepositoryInterface;
use Validator,Hash,Auth;
class ProfileController extends Controller
{
    private $user;
    public function __construct(UserRepositoryInterface $user,TalentRepositoryInterface $talent,SkillRepositoryInterface $skill){
        $this->user=$user;
        $this->talent=$talent;
        $this->skill=$skill;
    }


    public function uploadProfileImage(){
 
        /*
      *	!!! THIS IS JUST AN EXAMPLE !!!, PLEASE USE ImageMagick or some other quality image processing libraries
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
          case 'image/gif':
              $img_r = imagecreatefromgif($imgUrl);
              $source_image = imagecreatefromgif($imgUrl);
              $type = '.gif';
              break;
          default: die('image type not supported');
      }
      
      
      //Check write Access to Directory
      
      if(!is_writable(dirname($output_filename))){
          $response = Array(
              "status" => 'error',
              "message" => 'Can`t write cropped File'
          );	
      }else{
      
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
      // echo $output_filename.$type;
      try{
      $user=\Auth::user();
      $user->user_image=$output_filename1.$type;
      $user->save();
      print json_encode($response);
      }catch(\Exception $e){
        print json_encode( Array(
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

}
