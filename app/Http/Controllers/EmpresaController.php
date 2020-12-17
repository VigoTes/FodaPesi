<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empresa;

class EmpresaController extends Controller
{
    const PAGINATION = 10; // PARA QUE PAGINEE DE 10 EN 10

    public function index(Request $Request)
    {
        $buscarpor = $Request->buscarpor;
        $empresa = Empresa::where('estadoAct','=','1')
            ->where('nombreEmpresa','like','%'.$buscarpor.'%')
            ->paginate($this::PAGINATION);

        //cuando vaya al index me retorne a la vista
        return view    ('tablas.empresas.index',compact('empresa','buscarpor')); 
        //el compact es para pasar los datos , para meter mas variables meterle mas comas dentro del compact


        // otra forma sería hacer ['categoria'] => $categoria
    }

    public function create()
    {
        $empresa = new Empresa();
        print($empresa->mision);

        return view('tablas.empresas.create',compact('empresa'));
    }

    public function store(Request $request)
    {
        
        $empresa = request()->validate(
            [
                'nombreEmpresa'=>'required|max:100',
                'mision'=>'required|max:1000',
                'vision'=>'required|max:1000',
                'factorDif'=>'required|max:1000',
                'propuestaV'=>'required|max:100',
                'direccion'=>'required|max:200',
                'RUC'=>'required|size:13'
                
            ],[
                'nombreEmpresa.required'=>'Ingrese nombre de la Empresa',
                'nombreEmpresa.max' => 'Maximo 100 caracteres la descripcion',
                 
                'mision.required'=>'Ingrese la mision de la Empresa',
                'mision.max' => 'Maximo 1000 caracteres la descripcion',
                 
                'vision.required'=>'Ingrese la mision de la Empresa',
                'vision.max' => 'Maximo 1000 caracteres la descripcion',
                 
                'factorDif.required'=>'Ingrese el factor diferenciador',
                'factorDif.max' => 'Maximo 1000 caracteres la descripcion',
                 
                'propuestaV.required'=>'Ingrese la propuesta de valor',
                'propuestaV.max' => 'Maximo 100 caracteres la descripcion',
                 
                'direccion.required'=>'Ingrese la direccion de la empresa',
                'direccion.max' => 'Maximo 200 caracteres la descripcion',

                'RUC.required'=>'Ingrese el ruc de la empresa',
                'RUC.size' => 'Debe tener 13 caracteres'

            ]

            );

            

            $empresa = new Empresa();
            $empresa->nombreEmpresa=$request->nombreEmpresa;
            $empresa->mision=$request->mision;
            $empresa->vision=$request->vision;
            $empresa->factorDif=$request->factorDif;
            $empresa->propuestaV=$request->propuestaV;
            $empresa->direccion=$request->direccion;
            $empresa->RUC=$request->RUC;
            $empresa->estadoAct='1';
            
            
                          
            $empresa->save(); /* Guardamos el nuevo registro en la BD */
                
            /* Regresamos al index con el mensaje de nuevo registro */
            return redirect()->route('empresa.index')->with('msjLlegada','Registro nuevo guardado');
                
        }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        
        $empresa=Empresa::findOrFail($id);


        return view('tablas.empresas.edit',compact('empresa'));


    }

    public function update(Request $request, $id)
    {
        $empresa = request()->validate(
            [
                'nombreEmpresa'=>'required|max:100',
                'mision'=>'required|max:1000',
                'vision'=>'required|max:1000',
                'factorDif'=>'required|max:1000',
                'propuestaV'=>'required|max:100',
                'direccion'=>'required|max:200',
                'RUC'=>'required|size:13'
                
            ],[
                'nombreEmpresa.required'=>'Ingrese nombre de la Empresa',
                'nombreEmpresa.max' => 'Maximo 100 caracteres la descripcion',
                 
                'mision.required'=>'Ingrese la mision de la Empresa',
                'mision.max' => 'Maximo 1000 caracteres la descripcion',
                 
                'vision.required'=>'Ingrese la mision de la Empresa',
                'vision.max' => 'Maximo 1000 caracteres la descripcion',
                 
                'factorDif.required'=>'Ingrese el factor diferenciador',
                'factorDif.max' => 'Maximo 1000 caracteres la descripcion',
                 
                'propuestaV.required'=>'Ingrese la propuesta de valor',
                'propuestaV.max' => 'Maximo 100 caracteres la descripcion',
                 
                'direccion.required'=>'Ingrese la direccion de la empresa',
                'direccion.max' => 'Maximo 200 caracteres la descripcion',

                'RUC.required'=>'Ingrese el ruc de la empresa',
                'RUC.size' => 'El Ruc Debe tener 13 caracteres'
            ]

            );

            $empresa=Empresa::findOrFail($id);
            $empresa->nombreEmpresa=$request->nombreEmpresa;
            $empresa->mision=$request->mision;
            $empresa->vision=$request->vision;
            $empresa->factorDif=$request->factorDif;
            $empresa->propuestaV=$request->propuestaV;
            $empresa->direccion=$request->direccion;
            $empresa->RUC=$request->RUC;
                          
            $empresa->save(); /* Guardamos el nuevo registro en la BD */
                
            /* Regresamos al index con el mensaje de nuevo registro */
            return redirect()->route('empresa.index')->with('msjLlegada','Registro editado Exitosamente');
             
    }

    public function destroy($id)
    {
        $empresa = Empresa::findOrFail($id);
        $empresa->estadoAct = '0';
        $empresa->save ();
        return redirect() -> route('empresa.index')->with('msjLlegada','Registro eliminado!!');

    }

    public function confirmar($id){
        $empresa = Empresa::findOrFail($id); 
        return view('tablas.empresas.confirmar',compact('empresa'));
    }

}
