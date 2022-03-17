<?php
class Helper {

    function redirect($page){
        header('location: '.URLROOT.'/'.$page);
    }


}
