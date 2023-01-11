<?php
class Profs extends Controller
{

    public function __Construct()
    {
        parent::__Construct('prof');
    }
    public function index()
    {
        $prof=prof::All();
        echo json_encode($prof,JSON_PRETTY_PRINT);
        return json_encode($prof);
    }
    public function destroy($id)
    {
        $prof=prof::find($id);
        $prof->delete();
        echo json_encode($prof);
        return json_encode($prof);
    }
    public function store($request)
    {
        $request=json_decode(file_get_contents("php://input"));
        $prof=new prof();
        $prof->nom=$request->nom;
        $prof->prenom=$request->prenom;
        $prof->specialite=$request->specialite;
        $prof->save();
        echo json_encode($p->save());
    }
    public function update($id,$request)
    {
        $request=json_decode(file_get_contents("php://input"));
        $prof=prof::find($id);
        $prof->nom=$request->nom;
        $prof->prenom=$request->prenom;
        $prof->specialite=$request->specialite;
        $prof->save();
        echo json_encode($p->save());
    }
}
?>
