<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin;
use App\Models\User;
use App\Http\Controllers\Controller;
use Config;
use ConstHelper;

class AdminController extends Controller
{
    public function __construct() {
        $this->middleware(function ($request, $next) {
            if(Auth::guard('admin')->check()) { // Update Admin Last Access when Access Backend Page
                Admin::where('id', Auth::guard('admin')->id())
                       ->update(['last_access' => \DB::raw('now()')]);
            }
            if(Auth::guard('admin')->user()->is_super){
                return $next($request);
            }else{
                Auth::logout();
                return redirect('login');
            }
        });
    }

    protected function validator(array $data, $type) {
        return Validator::make($data, [
//            'display_name'  => 'required|string|max:100',
            'email'         => 'required|string|max:255|unique:admins,email,' . $data['id'],
            'password'      => $type == 'create' ? 'required|string|min:8|max:255' : 'string|min:8|max:255',
        ]);
    }

    public function index() {
	    $data['page_title'] = 'List Admin';
        return view('backend.admins.index', $data);
    }

    public function create() {
        $data['item'] = new Admin();
        $data['page_title']     = 'Create new Admin';
        $data['h1']             = 'New Admin';
        $data['button_text']    = 'Save';

	    $data['form_action']    = route('admin.admins.store');
	    $data['page_type']      = 'create';

        return view('backend.admins.form', $data);
    }

	public function edit($id) {
		$data['item']           = Admin::find($id);
		$data['page_title']     = 'Edit Admin';
		$data['h1']             = 'Edit';
        $data['button_text']    = 'Edit';

		$data['form_action']    = route('admin.admins.update', $id);
		$data['page_type']      = 'edit';

		return view('backend.admins.form', $data);
	}

    public function store(Request $request) {
        $data = $request->all();
        $this->validator($data, 'create')->validate();

        Admin::create([
                'email'         => $data['email'],
                'password'      => bcrypt($data['password'])
//                'display_name'  => $data['display_name']
        ]);

	    return redirect()->route('admin.admins.index')->with('success', config('const.SUCCESS_CREATE_MESSAGE'));
    }

    public function update(Request $request, $id) {
	    $data = $request->all();
        $currentAdmin = Admin::find($id);
	    $data['password'] = !empty($data['password']) ? $data['password'] : $currentAdmin['password'];

        $this->validator($data, 'update')->validate();

        if (Hash::needsRehash($data['password'])) {
	        $data['password'] = bcrypt($data['password']);
        }

        $currentAdmin->update($data);

	    return redirect()->route('admin.admins.index')->with('success', config('const.SUCCESS_UPDATE_MESSAGE'));
    }

    public function destroy(Request $request) {
        if(count(Admin::all()) === 1) {
            return redirect()->route('admin.admins.index')->with('error', config('const.FAILED_ADMIN_ONLY_1'));
        }
        Admin::find($request->get('id'))->delete();
        return redirect()->route('admin.admins.index')->with('success', config('const.SUCCESS_DELETE_MESSAGE'));
    }
}
