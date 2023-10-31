<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Ability;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public $modules  = [
        'admins',
        'roles',
        'settings',
        'recycle_bin',
        'reports',
    ];

    public function index()
    {
        $this->authorize('view_roles');

        $roles      = Role::withoutGlobalScopes()->with('abilities:id,category,action','admins:id')->get();
        $abilities  = Ability::select('id','name','category','action')->get();

        return view('dashboard.roles.index',[ 'roles' => $roles , 'abilities' => $abilities , 'modules' => $this->modules]);
    }

    public function show(Role $role,Request $request)
    {
        $this->authorize('show_roles');

        $role->load('abilities','admins:id');
        $abilities  = Ability::select('id','name','category','action')->get();

        if ( ! $request->ajax() )
            return view('dashboard.roles.show',[ 'role' => $role , 'abilities' => $abilities , 'modules' => $this->modules]);
         else
            return response()->json(['name_ar' => $role['name_ar'] , 'name_en' => $role['name_en'] , 'role_abilities' => $role['abilities'] ]);
    }

    public function admins(Role $role,Request $request)
    {
        $role->load('admins:id,name,email,phone,image,created_at');

        $adminsCount = $role->admins->count();

        $page    = $request['page']     ?? 1;
        $perPage = $request['per_page'] ?? 10;


        return response()->json([
            "recordsTotal" => $adminsCount,
            "recordsFiltered" => $role->admins->count(),
            'data' => $role->admins->skip(($page - 1) * $perPage)->take($perPage)
        ]);
    }



    public function store(Request $request)
    {

        $this->authorize('create_roles');

        $data = $request->validate([
            "name_ar"   => ['required', 'string' , 'max:255','unique:roles'],
            "name_en"   => ['required', 'string' , 'max:255','unique:roles'],
            'abilities' => ['required', 'array'  , 'min:1'],
        ]);



        $role = Role::create($data);

        $role->abilities()->attach($request['abilities']);

    }


    public function update(Request $request, Role $role)
    {
        $this->authorize('update_roles');

        $data = $request->validate([
            "name_ar"   => ['required', 'string' , 'max:255','unique:roles,id,' . $role['id']],
            "name_en"   => ['required', 'string' , 'max:255','unique:roles,id,' . $role['id']],
            'abilities' => ['required', 'array'  , 'min:1'],
        ]);

        if ( $role->id == 1 ){
            abort(404);
        }


        $role->update($data);
        $role->abilities()->sync($request['abilities']);


    }

    public function destroy(Request $request , Role $role)
    {
        if ( $request->ajax() && ( $role->id !== 1 && $role->id !== 2 ) )
            $role->delete();
    }


}
