<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Business;
<<<<<<< Updated upstream
use Caffeinated\Shinobi\Models\Role;
use Image;
=======
use App\Region;
use App\Commune;
>>>>>>> Stashed changes
use Session;
use Redirect;
use DB;

class BusinessController extends Controller
{
    private $business;

    /**
    * { function_description }
    */
    public function __construct(Business $business)
    {
        $this->middleware('auth');
        $this->business     = $business;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
<<<<<<< Updated upstream
        $roles = $this->role->get()->pluck('name', 'slug')->prepend('Seleccione...','');
        $status = UsersStatus::get()->pluck('name', 'id')->prepend('Seleccione...','');
        $positions = Position::get()->pluck('name', 'id')->prepend('Seleccione...','');
        $grupos = Group::get()->pluck('group', 'id')->prepend('Seleccione...','');
        $users = $this->user->all();

        return view('pages.user.index', compact('users','status','roles','positions','grupos'));
=======
        $business = Business::all();
        $regions = Region::get()->sortBy('name')->pluck('name','id')->prepend('Seleccione...','');
        $communes = Commune::get()->sortBy('name')->pluck('name','id')->prepend('Seleccione...','');
        return view('pages.business.index',compact('business','regions','communes'));
>>>>>>> Stashed changes
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(createRequest $request)
    {
        try{
        $data = $request->all();

        $file = $request->file('file');

        if ($file != null) {
            // url file save
            $path = public_path().'/img/avatar/';
            // file extension
            $extension = $file->getClientOriginalExtension();
            // file name
            $fileName = $data['email']. '.' . $extension;
            // file save
            $file->move($path, $fileName);
            // add route avarat
            $data = array_add($data, 'image', $fileName);
        }else{
            $fileName = 'default.png';
            $data = array_add($data, 'image', $fileName);
        }

        // encrypt password
        $data['password'] = bcrypt($data['password']);
        //create user
        $user = $this->user->create($data);
        //assig rol user
        $user->assignRoles($data['rol']);
        $lastUser= User::all()->last();
        DB::insert('insert into users_groups (id_user, id_group) values (?, ?)', [$lastUser->id, $request->id_grupo]);
        toastr()->success('¡Se ha registrado exitosamente!');
        Session::flash('message-success',' User '. $request->fullname.' creado correctamente.');

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
        $user = User::find($id);
        $roles = $this->role->get()->pluck('name', 'slug')->prepend('Seleccione...','');
        $status = UsersStatus::get()->pluck('name', 'id')->prepend('Seleccione...','');
        $positions = Position::get()->pluck('name', 'id')->prepend('Seleccione...','');

        $groupUser = DB::table('groups_users')->where('id_user',$id)->pluck('id_group');
        $grupos = Group::whereNotIn('id',$groupUser)->pluck('group', 'id')->prepend('Seleccione...','');

        return view('pages.user.edit_user', compact('user','status','roles','positions','grupos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $user = $this->user->find($id);
        $data = $request->all();
        $file = $request->file('file');
        if ($file != null) {
            $path = public_path().'/img/avatar/';
            $extension = $file->getClientOriginalExtension();
            $fileName = $data['email']. '.' . $extension;
            $file->move($path, $fileName);
            $data = array_add($data, 'image', $fileName);
        }

        if($data['password'] == $data['password_confirmation']){
             if (isset($data['password'])) {
                $data = array_set($data, 'password', bcrypt($data['password']));
                $user->update($data);
            }else{
                $data = array_except($data, ['password']);
                $user->update($data);
            }
            $user->save();
            toastr()->success('¡Se ha actualizado exitosamente!');
            $user->syncRoles($data['rol']);

            $userGroups = UsersGroups::where('id_user',$id)->first();
            if(isset($userGroups)){
                $userGroups->id_group = $request->id_group;
                $userGroups->save();
            }else{
                DB::insert('insert into users_groups (id_user, id_group) values (?, ?)', [$id, $request->id_group]);
            }

            Session::flash('message-success',' User '. $request->fullname.' editado correctamente.');
            return Redirect::back();

        }else{
            Session::flash('message-error','No coinciden la contraseña y la confirmación.');
            return Redirect::back()->withInput();
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try{
        $user->delete();
        toastr()->success('¡Se ha eliminado exitosamente!');
        Session::flash('message-success','Usuario elminado correctamente');
        return Redirect::to('user');

    }catch (\Exception $e){
        toastr()->success('¡Ocurrió un problema!');
        return redirect()->back();
     }
    }

    /**
     * [formPasswordReset description]
     * @return [type] [description]
     */
    public function formPasswordReset()
    {
        return view('pages.user.passwordReset');
    }

    /**
     * [passwordUpdate description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function passwordUpdate(passwordUpdateRequest $request)
    {
        $user = $this->user->where('email',$request->input('email'))->first();
        $password = bcrypt($request->input('password'));
        $user->update(['password' => $password]);
        $user->save();
        toastr()->success('¡Se ha actualizado exitosamente!');
        Session::flash('message-success',' User '. $user->fullname.' actualizado correctamente.');
    }

       public function getGroup($id)
    {
        $data = DB::table('groups_users')
        ->leftjoin('groups','groups_users.id_group','groups.id')
        ->select('groups.id','groups.group as name')
        ->where('groups_users.id_user','=',$id)
        ->get();
        $result = [];
        foreach ($data as $key => $each) {
        $result[] = [
            'id_group' => $each->id,
            'group' => $each->name
            ];
        }

         return datatables()->of($result)->toJson();

    }

    public function obtenerNombre($id){

        $data = DB::table('buildings')->where('id',$id)->value('name');
        return $data;
    }

    public function addGroupUser(Request $request){

        $user = DB::insert('insert into groups_users(id_user, id_group) values (?, ?)', [$request->id_usuario, $request->id_grupo]);
    }

    public function deleteGroupUser(Request $request){

        $user = DB::table('groups_users')->where('id_user', $request->id_usuario)->where('id_group', $request->id_grupo)->delete();
    }

    public function getGroupUser(Request $request){

        $groupUser = DB::table('groups_users')->where('id_user',$request->id_usuario)->pluck('id_group');
        $groups = Group::whereNotIn('id',$groupUser)->pluck('group', 'id')->prepend('Seleccione...','');

        return response()->json($groups);
    }

     public function obtenerEmpresaUser(Request $request){

        $empresas = DB::table('adm_usuarios_empresas_ext')->where('id_usuario','=',$request->id_usuario)->pluck('id_empresa');
        $empresa = Empresa_Externa::whereNotIn('id',$empresas)->get()->pluck('nombre', 'id');
        return response()->json($empresa);
    }

    public function agregaEmpresaUser(Request $request){

        $user = DB::insert('insert into adm_usuarios_empresas_ext (id_usuario, id_empresa) values (?, ?)', [$request->id_usuario, $request->id_empresa]);
    }

    public function getEmpresa($id)
    {
        $data = DB::table('adm_usuarios_empresas_ext')->where('id_usuario','=',$id)->get();
        //dd($data);
        $result = [];
        foreach ($data as $key => $each) {
        $result[] = [
            'id_empresa' => $each->id_empresa,
            'empresa' => $this->obtenerEmpresa($each->id_empresa)
            ];
        }
        //dd($result);
         return datatables()->of($result)->toJson();

    }

    public function obtenerEmpresa($id){

        $data = DB::table('adm_empresas_externas')->where('id',$id)->value('nombre');
        return $data;
    }

     public function eliminaEmpresaUser(Request $request){

        $user = DB::table('adm_usuarios_empresas_ext')->where('id_usuario', $request->id_usuario)->where('id_empresa', $request->id_empresa)->delete();
    }

    public function obtenerAdministracionUser(Request $request){

        $administraciones = DB::table('adm_usuarios_administraciones')->where('id_usuario','=',$request->id_usuario)->pluck('id_administracion');
        $administracion = Administracion::whereNotIn('id',$administraciones)->get()->pluck('nombre', 'id');
        return response()->json($administracion);
    }

    public function agregaAdministracionUser(Request $request){

        $user = DB::insert('insert into adm_usuarios_administraciones (id_usuario, id_administracion) values (?, ?)', [$request->id_usuario, $request->id_administracion]);
    }

     public function getAdministracion($id)
    {
        $data = DB::table('adm_usuarios_administraciones')->where('id_usuario','=',$id)->get();

        $result = [];
        foreach ($data as $key => $each) {
        $result[] = [
            'id_administracion' => $each->id_administracion,
            'administracion' => $this->obtenerAdministracion($each->id_administracion)
            ];
        }
         return datatables()->of($result)->toJson();

    }

     public function obtenerAdministracion($id){

        $data = Administracion::where('id',$id)->value('nombre');
        return $data;
    }

    public function eliminaAdministracionUser(Request $request){

        $user = DB::table('adm_usuarios_administraciones')->where('id_usuario', $request->id_usuario)->where('id_administracion', $request->id_administracion)->delete();
    }

     public function getCorredor($id)
    {
        $data = DB::table('adm_usuarios_corredores')->where('id_usuario','=',$id)->get();
        $result = [];
        foreach ($data as $key => $each) {
        $result[] = [
            'id_corredor' => $each->id_corredor,
            'corredor' => $this->obtenerCorredor($each->id_corredor)
            ];
        }
         return datatables()->of($result)->toJson();

    }

    public function obtenerCorredor($id){

        $data = DB::table('adm_corredores')->where('id',$id)->value('nombre');
        return $data;
    }

     public function agregaCorredorUser(Request $request){

        $user = DB::insert('insert into adm_usuarios_corredores (id_usuario, id_corredor) values (?, ?)', [$request->id_usuario, $request->id_corredor]);
    }

     public function obtenerCorredorUser(Request $request){

        $corredores = DB::table('adm_usuarios_corredores')->where('id_usuario','=',$request->id_usuario)->pluck('id_corredor');
        $corredor = Corredor::whereNotIn('id',$corredores)->get()->pluck('nombre', 'id');
        return response()->json($corredor);
    }

      public function eliminaCorredorUser(Request $request){

        $user = DB::table('adm_usuarios_corredores')->where('id_usuario', $request->id_usuario)->where('id_corredor', $request->id_corredor)->delete();
    }


}
