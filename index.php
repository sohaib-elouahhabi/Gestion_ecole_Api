
<?php
$chemin = substr($_SERVER['SCRIPT_FILENAME'], 0, -9);
define("ROOT", $chemin);
include_once ROOT . 'Models/Model.php';
include_once ROOT . 'Controllers/Controller.php';
include_once ROOT . './Controllers/Profs.php';
//include_once ROOT . 'views/public/header.php';

header('Access-Control-Allow-Origin: *'); //header that specify what urls have access to this api
header('Content-Type: application/json'); //header that define what kind of body that will receive
header('Access-Control-Allow-Methods: *'); //header that define what kind of methods allowed in this api
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods');   //header that allows all the headers above




$url = isset($_GET['url'])? $_GET['url'] : "";
$id = 0;
$infos_url = explode("/", $url);
if ($infos_url[0] != "")
    if (file_exists(ROOT . 'Controllers/' . $infos_url[0] . ".php")) {
        // $action = "index";
        include_once ROOT . 'Controllers/' . $infos_url[0] . ".php";
        $controller = new $infos_url[0];
        $action = "index";
        if (isset($infos_url[1])) {
            $action = $infos_url[1];
            if (method_exists($controller, $action) || $action="") {

                $request = null;
                if (isset($infos_url[2]))
                    $id = $infos_url[2];
                if (!empty(json_decode(file_get_contents("php://input")))) {
                    $request = new stdclass();
                    foreach ($_POST as $key => $value)
                        $request->$key = $value;
                }
                if ($request != null)
                    if ($id != 0)
                        $controller->$action($id, $request);
                    else
                        $controller->$action($request);
                else
            if ($id == 0)
                    $controller->$action();
                else
                    $controller->$action($id);
            } else
                echo "url introuvable";
        } else
        $controller->$action();
    }
else
echo "URL introuvable 2";
else{
    echo json_encode("API By sohaib");
}

?>

