<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin;
use App\Models\News;
use Config;
use Carbon\Carbon;

class NewsController extends Controller
{
    public function __construct() {
        $this->middleware(function ($request, $next) {
            if(Auth::guard('admin')->check()) { // Update Admin Last Access when Access Backend Page
                Admin::where('id', Auth::guard('admin')->id())
                    ->update(['last_access' => \DB::raw('now()')]);
            }
            return $next($request);
        });
    }

    /**
     *
     *
     * @return \Illuminate\Http\Response
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'title'=> 'max:100|required',
            'content' => 'required'
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.news.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        $data = new News();
        $data->page_title = "News";
        $data->h1 = "Buat Baru";
        $data->form_action = route('admin.news.create');
        // Add page type here to indicate that the form.blade.php is in "add" mode
        $data->page_type = "add";
        $data->button = 'Simpan';

        return view('backend.news.form', [
            'data' => $data,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request){

        $data = $request->all();

        // Validate input, indicate this is 'create' function
        $this->validator($data, 'create')->validate();

        try {
            // Create new admin
            $savedData = News::create($data);

            if ($savedData) {
                // Create is successful, back to list
                return redirect()->route('admin.news')->with('success', Config::get('const.SUCCESS_CREATE_MESSAGE'));
            } else {
                // Create is failed
                return redirect()->route('admin.news')->with('error', Config::get('const.FAILED_CREATE_MESSAGE'));
            }
        } catch (Exception $e) {
            // Create is failed
            return redirect()->route('admin.news')->with('error', Config::get('const.FAILED_CREATE_MESSAGE'));
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = News::find($id);
        $data->page_title = 'News Edit';
        $data->h1 = 'Edit';
        $data->form_action = route('admin.news.update');
        $data->page_type = 'edit';
        $data->button = 'Simpan';

        return view('backend.news.form', [
            'data' => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $newData = $request->all();
        $this->validator($newData, 'update')->validate();
        try {
            $currentData = News::find($request->get('id'));

            if($currentData) {

                // update user
                $currentData->update($newData);

                // update success
                return redirect(route('admin.news'))->with('success', Config::get('const.SUCCESS_UPDATE_MESSAGE'));
            } else {
                // update failed
                return redirect(route('admin.news'))->with('error', Config::get('const.FAILED_UPDATE_MESSAGE'));
            }

        } catch(\Exception $e) {
            // update failed
            return redirect(route('admin.news'))->with('error', Config::get('const.FAILED_UPDATE_MESSAGE'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        try {
            $id = $request->get('id');
            $current_time = Carbon::now()->format('Ymd-His');
            $data = News::find($id);
            $data->delete();
            //delete success
            return redirect(route('admin.news'))->with('success', Config::get('const.SUCCESS_DELETE_MESSAGE'));
        } catch(\Exception $e) {
            // delete failed
            return redirect(route('admin.news'))->with('error', Config::get('const.FAILED_DELETE_MESSAGE'));
        }
    }
}
