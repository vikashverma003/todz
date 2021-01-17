<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProjectRating;
use App\Repositories\Interfaces\ProjectRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use URL,Session;


class ReviewController extends Controller
{
    use \App\Traits\CommonUtil;

    public $permissionName;
    public function __construct(ProjectRepositoryInterface $project, ProjectRating $rating){
        $this->project=$project;
        $this->rating = $rating;
        $this->permissionName = 'rating_management_access';
    }

    public function index(Request $request)
    {
        abort_unless($this->helperCheckPermission($this->permissionName), 403);
        
        $data = $request->all();
        $user=Auth::guard('admin')->user();
        $client_reviews = ProjectRating::where('rating_given_by',config('constants.role.TALENT'))->latest()->paginate(10);
        $talent_reviews = ProjectRating::where('rating_given_by',config('constants.role.CLIENT'))->latest()->paginate(10);
        return view('admin.reviews.index', ['title' => 'Rating & Reviews','user'=>$user,'client_reviews'=>$client_reviews,'talent_reviews'=>$talent_reviews,'data'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function clientReviews()
    {
        abort_unless($this->helperCheckPermission($this->permissionName), 403);

        $user=Auth::guard('admin')->user();
        $client_reviews = ProjectRating::where('rating_given_by',config('constants.role.TALENT'))->latest()->paginate(10);
        return view('admin.reviews.client', ['title' => 'Rating & Reviews','user'=>$user,'client_reviews'=>$client_reviews]);
    }
    public function talentReviews()
    {
        abort_unless($this->helperCheckPermission($this->permissionName), 403);

        $user=Auth::guard('admin')->user();
        $talent_reviews = ProjectRating::where('rating_given_by',config('constants.role.CLIENT'))->latest()->paginate(10);
        return view('admin.reviews.talent', ['title' => 'Rating & Reviews','user'=>$user,'talent_reviews'=>$talent_reviews]);
    }
    public function editReview($id)
    {
        abort_unless($this->helperCheckPermission($this->permissionName), 403);

        $currentURL = URL::current();
        Session::put('url.previousUrl',url()->previous());
        if($currentURL == Session::get('url.previousUrl'))
        {
          Session::put('url.previousUrl',url()->previous());
        }
        $user=Auth::guard('admin')->user();
        $review = $this->rating->getById($id);
        return view('admin.reviews.edit', ['title' => 'Edit Review','user'=>$user,'review'=>$review]);
    }
    public function deleteReview($id)
    {
        abort_unless($this->helperCheckPermission($this->permissionName), 403);

        $delete = $this->rating->deleteReview($id);
        return redirect()->back()->with(['success'=>'Review Deleted successfully']);
        
    }
    public function updateReview(Request $request)
    {
        abort_unless($this->helperCheckPermission($this->permissionName), 403);

        $request->validate([
            'review_id'  =>  'required',
            'rating'   => 'required',
            'feedback' => 'required',
        ]);
        $couponCreated=$this->rating->updateReview([
            'rating'=>$request->rating,
            'feedback'=>$request->feedback,
        ],$request->review_id);
        if($request->session()->get('url.previousUrl')){
            return redirect($request->session()->get('url.previousUrl'))->with(['success'=>'Review updated successfully']);
        }
        return redirect()->route('talent_reviews')->with(['success'=>'Review updated successfully']);
    }
}
