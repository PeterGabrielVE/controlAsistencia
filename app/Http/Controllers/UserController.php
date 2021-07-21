<?php

namespace App\Http\Controllers;

use App\User;
use App\Position;
use App\Building;
use App\Corredor;
use App\Empresa_Externa;
use App\UsersStatus;
use Illuminate\Http\Request;
use App\Http\Requests\User\createRequest;
use App\Http\Requests\User\updateRequest;
use App\Http\Requests\User\passwordUpdateRequest;
use Caffeinated\Shinobi\Models\Role;
use Image;
use Session;
use Redirect;
use DB;

class UserController extends Controller
{
    private $user;
    private $role;

    /**
    * { function_description }
    */
    public function __construct(User $user, Role $role)
    {
        $this->middleware('auth');
        $this->user     = $user;
        $this->role     = $role;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = $this->role->get()->pluck('name', 'slug')->prepend('Seleccione...','');
        $status = UsersStatus::get()->pluck('name', 'id')->prepend('Seleccione...','');
        $positions = Position::get()->pluck('name', 'id')->prepend('Seleccione...','');
        $users = $this->user->all();

        return view('pages.user.index', compact('users','status','roles','positions'));  
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
        $data = $request->all();

        // encrypt password
        $data['password'] = bcrypt($data['password']);
        //create user
        $user = $this->user->create($data);
        //assig rol user
        $user->assignRoles($data['rol']);
        Session::flash('message-success',' User '. $request->fullname.' creado correctamente.');
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
        return view('pages.user.edit_user', compact('user','status','roles','positions'));  
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
    public function update(updateRequest $request,$id)
    {
        $user = $this->user->find($id);
        $data = $request->all();
        $file = $request->file('file');
       
        if($data['password'] == $data['password_confirmation']){
             if (isset($data['password'])) {
                $data = array_set($data, 'password', bcrypt($data['password']));
                $user->update($data);
            }else{
                $data = array_except($data, ['password']);
                $user->update($data);
            }   
            $user->save();
            $user->syncRoles($data['rol']);
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
        $user->delete();
        Session::flash('message-success','Usuario elminado correctamente');
        return Redirect::to('user');
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
        Session::flash('message-success',' User '. $user->fullname.' actualizado correctamente.');
    }

       public function getEdificio($id)
    {
        $data = DB::table('adm_usuarios_edificios')->where('id_usuario','=',$id)->get();
        //dd($data);
        $result = [];
        foreach ($data as $key => $each) {
        $result[] = [
            'id_edificio' => $each->id_edificio,
            'edificio' => $this->obtenerNombre($each->id_edificio)
            ];
        }
        //dd($result);
         return datatables()->of($result)->toJson();

    }

    public function obtenerNombre($id){

        $data = DB::table('buildings')->where('id',$id)->value('name');
        return $data;
    }

    public function agregaEdificioUser(Request $request){

        $user = DB::insert('insert into adm_usuarios_edificios (id_usuario, id_edificio) values (?, ?)', [$request->id_usuario, $request->id_edificio]);
    }

    public function eliminaEdificioUser(Request $request){

        $user = DB::table('adm_usuarios_edificios')->where('id_usuario', $request->id_usuario)->where('id_edificio', $request->id_edificio)->delete();
    }

    public function obtenerEdificioUser(Request $request){
       
        $edificios = DB::table('adm_usuarios_edificios')->where('id_usuario','=',$request->id_usuario)->pluck('id_edificio');
        $building = Building::whereNotIn('id',$edificios)->get()->pluck('name', 'id');
        return response()->json($building);  
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
