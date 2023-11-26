<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Http\Request;

class AdminController extends Controller
{


    public function index(Request $request)
    {
        //$this->authorize('view_admins');

        if ($request->ajax()){
            $data = getModelData( model: new Admin(), andsFilters: [['email', '!=', 'support@test.com']], relations: ['roles' => ['id', 'name_ar', 'name_en']]);
            return response()->json($data);
        }
        $roles = Role::get();

        return view('dashboard.admins.index', compact('roles'));
    }

    public function show(Admin $admin)
    {

        //$this->authorize('show_admins');

        $roles = Role::select('id','name_' . getLocale() )->get();

        return view('dashboard.admins.show',compact('admin','roles'));
    }

    public function edit(Admin $admin)
    {
        //$this->authorize('update_admins');

        $roles = Role::select('id','name_' . getLocale() )->get();

        return view('dashboard.admins.edit',compact('admin','roles'));
    }

    public function store(StoreAdminRequest $request)
    {
        $data           = $request->validated();
        $data['status'] = ( bool ) request('status');
        $admin       = Admin::sharedLock()->create($data);

        //$rolesAndDefaultOne = array_merge( $request['roles'] , [ "2" ] );

        //$admin->roles()->attach( $rolesAndDefaultOne );

    }

    public function update(UpdateAdminRequest $request , Admin $admin)
    {
        $data = $request->validated();

        $data['status']               = ( bool ) request('status');
        $data['needs_to_clear_cache'] = true; // update the cache to this admin

        $admin->update($data);

        //$rolesAndDefaultOne = array_merge( $request['roles'] , [ "2" ] );

        //$admin->roles()->sync( $rolesAndDefaultOne );
    }


    public function destroy(Request $request, Admin $admin)
    {
        //$this->authorize('delete_admins');

        if($request->ajax())
        {
            $admin->delete();
        }
    }

    public function updateProfile(Request $request){

        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'phone'    => ['required','string','max:255','unique:admins,id,' . auth()->id() ,'regex:/(^(009665|9665|\+9665|966|05|5)(5|0|3|6|4|9|1|8|7)([0-9]{7})$)/u'],
            'email'    => ['required','string','email','unique:admins,id,' . auth()->id() ],
            'image'    => ['nullable','mimes:jpeg,jpg,png,gif,svg' , 'max:10000'] ,
        ]);

        if ( $request->has('image') )
            $data['image'] = uploadImage( $request->file('image') , 'Admins' );
        else
            $data['image'] = auth()->user()->image;

        auth()->user()->update($data);

    }
    public function updatePassword(Request $request){

        $data = $request->validate([
            'password'              => ['required','string','min:6','max:255','confirmed'],
            'password_confirmation' => ['required','same:password'],
        ]);

        auth()->user()->update($data);

    }

    public function selectAjaxRoles()
    {
        $roles = Role::select('id','name_' . getLocale() )->get();
        return $roles;
    }

    public function deleteSelected(Request $request)
    {
        //$this->authorize('delete_admins');
        abort_if(in_array(1, $request->selected_items_ids), '404', "!لا يمكن حذف الحساب الرئيسى");

        Admin::whereIn('id', $request->selected_items_ids)->delete();
        return response(["selected admins deleted successfully"]);
    }

    public function restoreSelected(Request $request)
    {
        //$this->authorize('delete_admins');
        Admin::withTrashed()->whereIn('id', $request->selected_items_ids)->restore();
        return response(["selected admins restored successfully"]);
    }

}
