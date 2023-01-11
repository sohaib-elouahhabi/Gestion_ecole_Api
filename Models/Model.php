<?php
abstract class Model
{

    public $id=0;
    private static $pdo=null;

    public function __Construct()
    {
        $path=substr($_SERVER['SCRIPT_FILENAME'],0,-9);
        $path =".env";
        $infos=file(ROOT.$path);
        $DB_Server=trim(explode("=",$infos[1])[1]);
        $DB_Name=trim(explode("=",$infos[3])[1]);
        $DB_user=trim(explode("=",$infos[4])[1]);
        $DB_Password=trim(explode("=",$infos[5])[1]);

        self::$pdo=new PDO('mysql:host='.$DB_Server.';
        dbname='.$DB_Name,$DB_user,$DB_Password);
    }

    public function delete()
    {
        $Model=get_class($this);
        $req="delete  from ".$Model." where id=".$this->id;
        echo $req;
        self::$pdo->exec($req);
    }
    
    public static function All()
    {
        $class= get_called_class();
        $cls=new $class();
        $req="select * from ".$class."";
        $self=self::$pdo->query($req);
        return $self->fetchAll(PDO::FETCH_OBJ);
    }

    public static function find($id)
    {
        $class= get_called_class();

        $cls=new $class();

        $req="select * from ".$class." where id= '$id'";
        $self=self::$pdo->query($req);
        $res=$self->fetch(PDO::FETCH_ASSOC);
        foreach($res as $key=>$value)
        {
            $cls->$key=$value;
        }
        return $cls;
    }

    public function save()
    {
        $data=(array)$this;
        // var_dump($data);
        $class=get_called_class();
        $fileds=$values="";

        //  echo $class;
        if($this->id==0){

            foreach($data as $key=>$value){
                if($key!="id"){
                    $fileds.=$key.",";
                    $values.="'".$value."',";
                }}
            $fildFinal=substr($fileds,0,-1);
            $valuesFinal=substr($values,0,-1);

            $req="insert into {$class}($fildFinal) values($valuesFinal);";
            echo $req;

        }
        else{
            $req="update $class set ";
            foreach($data as $key=>$value)
            {
                if($key!="id")
                {
                if($value!=null)
                    {
                    $req.=$key."='".$value."',";

                    }
                }
                
            }
            $req=substr($req,0,-1);
            $req.=" where id=".$this->id;
            
        }
        self::$pdo->exec($req);

    }
}

?>