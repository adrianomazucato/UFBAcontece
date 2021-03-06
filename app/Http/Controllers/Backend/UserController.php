<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Image;

use App\User;

use Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //dd($request->input('termoPesquisa'));
        if(!empty($request->input('termoPesquisa')))
        {
            $usuarios = User::where('nome', 'LIKE', '%'.$request->input('termoPesquisa').'%')->orderBy('nome')->paginate(10);
        }else{
            $usuarios = User::orderBy('nome')->paginate(10);
        }
        return view('backend.usuarios.index', compact('usuarios'));
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
        //
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
        $usuario = User::findOrFail(Auth::user()->id);

        $usuario->nome = $request->get('nome');
        $usuario->curso_id = $request->get('curso_id');
        $usuario->unidade_id = $request->get('unidade_id');
        $usuario->apresentacao = $request->get('apresentacao');

        //Trata e salva a imagem nova
        if ($request->hasFile('foto')) {

          //Deleta a imagem antiga se houver
          if(!empty($usuario->foto)){
              unlink('uploadsDoUsuario/perfil'.DIRECTORY_SEPARATOR.$usuario->foto);
          }

          $file = $request->file('foto');
          $filename  = time() . $usuario->id .'.' . $file->getClientOriginalExtension();
          $path = public_path('uploadsDoUsuario/perfil/' . $filename);
          Image::make($file->getRealPath())->resize('200','200')->save($path);
          $usuario->foto = $filename;
        }

        if($usuario->save()){
          //return redirect()->to(app('url')->previous(). '#settings');
          return redirect()->action('BackendController@index')
          ->with('statusPerfil', 'Perfil atualizado.')
          ->with('aba', 'settings');
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
        //
    }

    public function show($id){
        $usuario = User::findOrFail($id);
        return view('backend.perfil.index', compact('usuario'));
    }
}
