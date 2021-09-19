<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Group;
use Session;

class GrupoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $count_user = User::count();
        $count_jefes = User::leftjoin('role_user','users.id','role_user.user_id')
                        ->leftjoin('roles','role_user.role_id','roles.id')
                        ->where('roles.id',3)
                        ->count();
        $users = User::all();
        $groups = Group::get()->sortBy('group')->pluck('group','id')->prepend('Seleccione...','');
        $subgroups = Group::all();
        $jefes = User::leftjoin('role_user','users.id','role_user.user_id')
        ->leftjoin('roles','role_user.role_id','roles.id')
        ->where('roles.id',3)
        ->get();
        return view('pages.group.index',compact('count_user','count_jefes','jefes','users','groups','subgroups'));
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
        try{
        $data = $request->all();         
        Group::create($data);
        toastr()->success('¡Se ha registrado exitosamente!');
        return response()->json(['message'=>'Grupo registrado correctamente']);

    }catch (\Exception $e){
        toastr()->success('¡Ocurrió un problema!');
        return redirect()->back();
     }
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
        $group = Group::find($id);
        return response()->json($group);
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
        try{
        $group = Group::find($id);
        $group->update($request->all());
        $group->save();
        toastr()->success('¡Se ha actualizado exitosamente!');
        Session::flash('message-success',' Grupo '. $request->group.' editada correctamente.');
        
    }catch (\Exception $e){
        toastr()->success('¡Ocurrió un problema!');
        return redirect()->back();
     }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $parent = Group::where('id_group_parent',$id)->get()->count();
        if($parent > 0){
            return response()->json($parent);
        }else{
            $group = Group::find($id);
            $group->delete();
            toastr()->success('¡Se ha eliminado exitosamente!');
            return response()->json($parent);
        }
        
    }

    public function searchJefes($id)
    {
        $jefes = User::leftjoin('role_user','users.id','role_user.user_id')
        ->leftjoin('roles','role_user.role_id','roles.id')
        ->leftjoin('users_groups','users.id','users_groups.id_user')
        ->leftjoin('groups','users_groups.id','groups.id')
        ->where('roles.id',3)
        ->where('groups.id',$id)
        ->get();
        return response()->json($jefes);
    }

    public function searchUsers($id)
    {
        $users = User::leftjoin('users_groups','users.id','users_groups.id_user')
        ->leftjoin('groups','users_groups.id','groups.id')
        ->where('groups.id',$id)
        ->get();
        return response()->json($users);
    }

    public function getAllGroups()
    {
        $groups = Group::all();
        return response()->json($groups);
    }

    public function getAllJefes()
    {
        $jefes = User::leftjoin('role_user','users.id','role_user.user_id')
        ->leftjoin('roles','role_user.role_id','roles.id')
        ->leftjoin('users_groups','users.id','users_groups.id_user')
        ->leftjoin('groups','users_groups.id','groups.id')
        ->select('users.fullname','users.last_name','users.phone1','users.image','groups.group')
        ->where('roles.id',3)
        ->get();
        return response()->json($jefes);
    }

    public function getAllUsers()
    {
        $jefes = User::leftjoin('role_user','users.id','role_user.user_id')
        ->leftjoin('roles','role_user.role_id','roles.id')
        ->leftjoin('users_groups','users.id','users_groups.id_user')
        ->leftjoin('groups','users_groups.id','groups.id')
        ->select('users.fullname','users.last_name','users.phone1','users.image','groups.group')
        ->where('roles.id',3)
        ->get();
        return response()->json($jefes);
    }

}
