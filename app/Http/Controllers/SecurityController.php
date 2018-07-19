<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRole;
use App\Http\Requests\UpdateRole;
use App\Permission;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Class SecurityController
 */
class SecurityController extends Controller
{
    private $data;

    /**
     * SecurityController constructor.
     *
     */
    public function __construct()
    {
        $this->middleware('role:superadmin');

        $this->data = [
            'pageTitle' => __('Security'),
            'pageHeader' => __('Security'),
            'pageSubHeader' => __('Manage roles and permissions here')
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = [];
        foreach (Permission::all() as $item) {
            $tempArr = explode('-', $item->name);
            $module = ucfirst($tempArr[1]);
            $permissions[$module][] = $item;
        }

        $this->data['permissions'] = $permissions;
        return view('dashboard.security-management', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRole $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRole $request)
    {
        $data = $request->all();

        try {
            $role = new Role();
            $role->name = str_slug($data['name'], '-');
            $role->display_name = $data['display_name'];
            $role->description = $data['description'];
            $role->save();

            $role->syncPermissions($data['permission']);
        } catch (\Exception $exception) {
            Log::info(print_r($exception->getMessage(), true));
            return response()->json([
                'errors' => [
                    'message' => __('Internal server error')
                ]
            ], 500);
        }

        return response()->json([
            'message' => __('Role :name is successfully saved!', ['name' => $data['name']])
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(404);
    }

    /**
     * Edit role
     *
     * @param string $name
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($name)
    {
        if (!auth()->user()->canUpdateSecurity()) {
            $message = __('You have no authorization to perform this action.');
            abort(403, $message);
        }

        $permissions = [];
        foreach (Permission::all() as $item) {
            $tempArr = explode('-', $item->name);
            $module = ucfirst($tempArr[1]);
            $permissions[$module][] = $item;
        }

        $this->data['permissions'] = $permissions;
        $this->data['role'] = Role::getByName($name);
        return view('dashboard.security-edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRole $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRole $request, $id)
    {
        $data = $request->all();

        try {
            $role = Role::findOrFail($id);
            $role->name = str_slug($data['name'], '-');
            $role->display_name = $data['display_name'];
            $role->description = $data['description'];
            $role->save();

            $role->syncPermissions($data['permission']);
        } catch (\Exception $exception) {
            Log::info(print_r($exception->getMessage(), true));
            return response()->json([
                'errors' => [
                    'message' => __('Internal server error')
                ]
            ], 500);
        }

        return response()->json([
            'message' => __('Role :name is successfully updated!', ['name' => $data['name']])
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!auth()->user()->canDeleteSecurity()) {
            return response()->json([
                'message' => __('You have no authorization to perform this action.')
            ], 403);
        }

        $role = Role::findOrFail($id);
        $role->delete();

        return response()->json([
            'message' => __(':name is successfully deleted!', ['name' => $role->name])
        ]);
    }
}
