<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiteContent;
use Illuminate\Support\Facades\Auth;
class SiteContentController extends Controller
{
    use \App\Traits\CommonUtil;

    public $permissionName;
    public $contentArray= [];
    public function __construct(){
        $this->contentArray = ['aboutus','contactus','adb','privacypolicy','clientterms','todderterms','paymentsafety','whyworkwithtalent','whyworkwithclient'];
        
        $this->permissionName = 'sitecontent_management_access';

    }

    public function getSiteContent($slug){
        abort_unless($this->helperCheckPermission($this->permissionName), 403);

        if(in_array($slug, $this->contentArray)){
            $content = SiteContent::where('type','content')->where('key',$slug)->value('value');
            $user=Auth::guard('admin')->user();
            return view('admin.sitecontent.'.$slug, ['title' => 'Site Content','user'=>$user,'content'=>$content,'slug'=>$slug]);
        }
        return redirect('404');
    }

    public function saveSiteContent(Request $request){
        abort_unless($this->helperCheckPermission($this->permissionName), 403);
        $request->validate([
            'content'=>'bail|required|string|max:50000',
            'slug'=>'bail|required',
        ]);
        if(!in_array($request->slug, $this->contentArray)){
            return redirect()->back()->with(['error'=>'Invalid slug passed.']);
        }

        SiteContent::updateOrCreate(
            [
                'key'=>$request->slug,
                'type'=>'content'
            ],
            [
                'key'=>$request->slug,
                'type'=>'content',
                'value'=>$request->content,
            ]);

        return redirect()->back()->with(['success'=>'Content updated successfully.']);
    }
    
    /**
    * get term page content
    */
    public function getAboutUsContent(Request $request){
        abort_unless($this->helperCheckPermission($this->permissionName), 403);
        $content = SiteContent::where('type','content')->where('key','aboutus')->value('value');
        $user=Auth::guard('admin')->user();
        return view('admin.sitecontent.aboutus', ['title' => 'About Us Content','user'=>$user,'content'=>$content]);
    }
    public function updateAboutUsContent(Request $request){
        abort_unless($this->helperCheckPermission($this->permissionName), 403);
        $request->validate([
            'content'=>'bail|required|string|max:50000',
        ]);

        SiteContent::updateOrCreate(
            [
                'key'=>'aboutus',
                'type'=>'content'
            ],
            [
                'key'=>'aboutus',
                'type'=>'content',
                'value'=>$request->content,
            ]);

        return redirect()->back()->with(['success'=>'Content updated successfully.']);
    }

    public function getContactUsContent(Request $request){
        abort_unless($this->helperCheckPermission($this->permissionName), 403);
        $content = SiteContent::where('type','content')->where('key','contactus')->value('value');
        $user=Auth::guard('admin')->user();
        return view('admin.sitecontent.contactus', ['title' => 'Contact Us Content','user'=>$user,'content'=>$content]);
    }
    public function updateContactUsContent(Request $request){
        abort_unless($this->helperCheckPermission($this->permissionName), 403);
        $request->validate([
            'content'=>'bail|required|string|max:50000',
        ]);

        SiteContent::updateOrCreate(
            [
                'key'=>'contactus',
                'type'=>'content'
            ],
            [
                'key'=>'contactus',
                'type'=>'content',
                'value'=>$request->content,
            ]);

        return redirect()->back()->with(['success'=>'Content updated successfully.']);
    }

    public function getPrivacyPolicyContent(Request $request){
        abort_unless($this->helperCheckPermission($this->permissionName), 403);
        $content = SiteContent::where('type','content')->where('key','privacypolicy')->value('value');
        $user=Auth::guard('admin')->user();
        return view('admin.sitecontent.privacypolicy', ['title' => 'Privacy Policy Content','user'=>$user,'content'=>$content]);
    }
    public function updatePrivacyPolicyContent(Request $request){
        abort_unless($this->helperCheckPermission($this->permissionName), 403);
        $request->validate([
            'content'=>'bail|required|string|max:50000',
        ]);
        SiteContent::updateOrCreate(
            [
                'key'=>'privacypolicy',
                'type'=>'content'
            ],
            [
                'key'=>'privacypolicy',
                'type'=>'content',
                'value'=>$request->content,
            ]);
        return redirect()->back()->with(['success'=>'Content updated successfully.']);
    }
}
