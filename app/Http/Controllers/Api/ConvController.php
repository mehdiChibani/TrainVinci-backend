<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Conventions;
use Validator;
use DB;
class ConvController extends BaseController
{
    //
    public function index(){
        $convs=Conventions::all();
        return $this->sendResponse($convs->toArray(),'Books readed succefully');
    }
    public function store(Request $req){
        $input=$req->all();
        $validator=Validator::make($input,[
            'stage_concerne'=>'required',
            'chemeinConv'=>'required'
        ]);
        if($validator->fails()){
            return  $this->sendEroor('error validation',$validator->errors());
        }
        $conv=Conventions::create($input);
        return $this->sendResponse($conv->toArray(),'conv craeted succefully');
    }
    public function show($id){
        $conv=Conventions::find($id);

        if(is_null($conv)){
            return $this->sendEroor('404 conv not found');
        }
        return $this->sendResponse($conv->toArray(),'conv found succefully');
    }
    public function update(Request $req,Conventions $conv){
        $input=$req->all();
        $validator=Validator::make($input,[
            'stage_concerne'=>'required',
            'chemeinConv'=>'required'
        ]);
        if($validator->fails()){
            return  $this->sendEroor('error validation',$validator->errors());
        }
        $conv->stage_concerne=$input['stage_concerne'];
        $conv->chemeinConv=$input['chemeinConv'];
        $conv->save();
        return $this->sendResponse($conv->toArray(),'conv updated succefully');
    }
    public function destroy(Conventions $conv){
        $conv->delete();
        return $this->sendResponse($conv->toArray(),'conv destroyed succefully');
    }
    public function getNotValideOne(){
        $false='non';
        $convs = Conventions::where('valide', $false)->get();
        //$convs = Conventions::where(['valide','=','non'])->get();
        if(is_null($convs)){
            return $this->sendEroor('404 conv not found');
        }
        return $this->sendResponse($convs->toArray(),'conv found succefully');
    }
    public function getConvInfo(){
        $convs =DB::table('stages')
        ->join('conventions', 'stages.id', '=', 'conventions.idStage')
        ->join('stages_etudiants','stages.id', '=', 'stages_etudiants.idStages')
        ->join('etudiants','stages_etudiants.idEtudaint', '=', 'etudiants.id')
        ->get();
        if(is_null($convs)){
            return $this->sendEroor('erreur');
        }
        return $this->sendResponse($convs->toArray(),'convs found succefully');
    }
}
