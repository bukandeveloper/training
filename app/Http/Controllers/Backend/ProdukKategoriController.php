<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin;
use App\Models\Kategory;
use Config;
use Carbon\Carbon;

class ProdukKategoriController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.produk-kategori.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        $data = new Kategory();
        $data->page_title = "produk-kategori";
        $data->h1 = "Buat Baru";
        $data->form_action = route('admin.produk-kategori.create');
        // Add page type here to indicate that the form.blade.php is in "add" mode
        $data->page_type = "add";
        $data->button = 'Simpan';

        return view('backend.produk-kategori.form', [
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
        $newData = $request->all();

        try {
            // Create new admin
            $data = Kategory::create($newData);

            if ($data) {
                // Create is successful, back to list
                return redirect()->route('admin.produk-kategori')->with('success', Config::get('const.SUCCESS_CREATE_MESSAGE'));
            } else {
                // Create is failed
                return redirect()->route('admin.produk-kategori')->with('error', Config::get('const.FAILED_CREATE_MESSAGE'));
            }
        } catch (Exception $e) {
            // Create is failed
            return redirect()->route('admin.produk-kategori')->with('error', Config::get('const.FAILED_CREATE_MESSAGE'));
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
        $data = Kategory::find($id);
        $data->page_title = 'produk-kategori Edit';
        $data->h1 = 'Edit';
        $data->form_action = route('admin.produk-kategori.update');
        $data->page_type = 'edit';
        $data->button = 'Simpan';

        return view('backend.produk-kategori.form', [
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
        try {
            $currentData = Kategory::find($request->get('id'));

            if($currentData) {

                // update data
                $currentData->update($newData);

                // update success
                return redirect(route('admin.produk-kategori'))->with('success', Config::get('const.SUCCESS_UPDATE_MESSAGE'));
            } else {
                // update failed
                return redirect(route('admin.produk-kategori'))->with('error', Config::get('const.FAILED_UPDATE_MESSAGE'));
            }

        } catch(\Exception $e) {
            // update failed
            return redirect(route('admin.produk-kategori'))->with('error', Config::get('const.FAILED_UPDATE_MESSAGE'));
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
            $dataId = $request->get('id');
            $current_time = Carbon::now()->format('Ymd-His');
            $data = Kategory::find($dataId);
            $data->delete();
            //delete success
            return redirect(route('admin.produk-kategori'))->with('success', Config::get('const.SUCCESS_DELETE_MESSAGE'));
        } catch(\Exception $e) {
            // delete failed
            return redirect(route('admin.produk-kategori'))->with('error', Config::get('const.FAILED_DELETE_MESSAGE'));
        }
    }
}
