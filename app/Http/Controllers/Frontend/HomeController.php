<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Mail;
use Config;
use GuzzleHttp\Client;
use GuzzleHttp\Stream;
use App\Models\DesignStyle;
use App\Models\Plan;
use App\Models\Inquiry;
use App\Models\Prefecture;
use App\Models\ChannelType;
use App\Jobs\ProcessEstimateConverter;
use App\Models\TagStyle;
use App\Models\TagArchitecture;
use App\Models\TagMood;

/*
|--------------------------------------------------------------------------
| Home Controller
|--------------------------------------------------------------------------
|
| This controller handles Home, 404, 500 pages
|
*/
class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('JapanIp')->only([
          'sendEmailEstimateForm'
        ]);
    }

    // display top page
    public function index()
    {
        return view('frontend.home.index', [
            'prefectures' => Prefecture::orderBy('area_id','asc')->orderBy('id')->pluck('display_name', 'id'),
            'tag_style' => TagStyle::orderBy('id')->get(),
            'tag_architecture' => TagArchitecture::orderBy('id')->get(),
            'tag_mood' => TagMood::orderBy('id')->get(),
        ]);
    }

    // display 404 page
    public function notFound()
    {
        return view('frontend.home.404');
    }

    // display 500 page
    public function serverInternalError()
    {
        return view('frontend.home.500');
    }


    // Lands 360 Page
    public function view360(request $request){

        $designId = $request->internal_id;
        $design = DesignStyle::where('internal_id', $designId)
        ->get();

        return view('frontend.home.360', [
          "design"            => $design
        ]);
    }

    // function send estimate form with pdf
    public function sendEmailEstimateForm(request $request){
        ProcessEstimateConverter::dispatch($request->all())->delay(60);
        return redirect()->route('estimate-thanks');
    }

    //contact thanks
    public function estimateThanks()
    {
        return view('frontend.home.estimate-thanks');
    }

}
