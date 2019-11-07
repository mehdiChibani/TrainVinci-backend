<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Stages;
use App\Stages_etudiants;
use DB;
use Validator;
class StageController extends BaseController
{
    //
    public function index(){
        $stages=Stages::all();
        return $this->sendResponse($stages->toArray(),'stages readed succefully');
    }
    public function store(Request $req){
        $input=$req->all();
        $validator=Validator::make($input,[
            'entreprise_concernee'=>'required',
            'periode'=>'required',
            'sujet'=>'required'
        ]);
        $idetud=5;
        $ids=7;
        if($validator->fails()){
            return  $this->sendEroor('error validation',$validator->errors());
        }
        $stages=Stages::create($input);
        
        return $this->sendResponse($stages->toArray(),'Book craeted succefully');
    }
    public function show($id){
        $stage=Stages::find($id);

        if(is_null($stage)){
            return $this->sendEroor('404 stage not found');
        }
        return $this->sendResponse($stage->toArray(),'stage found succefully');
    }
    public function update(Request $req,Stages $stage){
        $input=$req->all();
        $validator=Validator::make($input,[
            'entreprise_concernee'=>'required',
            'periode'=>'required',
            'sujet'=>'required',
            'date_debut'=>'required',
            'idEtudiant'=>'required',
        ]);
        if($validator->fails()){
            return  $this->sendEroor('error validation',$validator->errors());
        }
        $stage->entreprise_concernee=$input['entreprise_concernee'];
        $stage->periode=$input['periode'];
        $stage->sujet=$input['sujet'];
        $stage->date_debut=$input['date_debut'];
        $stage->save();
        DB::table('stages_etudiants')
            ->where('idStages', $stages->id)
            ->update(['idEtudiant' => $input['idEtudiant']]);
        return $this->sendResponse($stage->toArray(),'stage craeted succefully');
    }
    public function destroy(Stages $book){
        $stage->delete();
        return $this->sendResponse($stage->toArray(),'stage craeted succefully');
    }
    public function getStageInfo($id){
        $stages =DB::table('stages')
        ->join('stages_etudiants', 'stages.id', '=', 'stages_etudiants.idStages')
        //->join('encadrants','encadrants.id', '=','stages.idEncadrant')
        ->join('etudiants','stages_etudiants.idEtudaint', '=', 'etudiants.id')
        ->where('stages.id',$id)
        ->get();
        if(is_null($stages)){
            return $this->sendEroor('erreur');
        }
        return $this->sendResponse($stages->toArray(),'stages found succefully');
    }
}
   