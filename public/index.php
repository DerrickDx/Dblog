<?php



require_once('../app/Bootstrap.php');
//require_once '../app/Controller/BaseController.php';
echo "Hola! <br />";
use App\Controller\UserController;
(new UserController())->index();



//phpinfo();

//spl_autoload_register(function ($className) {
//    echo $className;
//    var_dump('AutoLoader');
////    echo "spl_autoload_register ";
////    require_once 'Config/'. $className . '.php';
//});

