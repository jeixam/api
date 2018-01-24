<?php 
use \Firebase\JWT\JWT;

class Controller_Users extends Controller_Autentificacion
{
    public function post_create()
    {
        try {
            if ( ! isset($_POST['type'])) 
                {
                    $json = $this->response(array(
                    'code' => 400,
                    'message' => ' parametro incorrecto, se necesita que el parametro se llame type'
                    ));

                return $json;
                }

                $input = $_POST;
                $user = new Model_Users();
                $user->nombre = $input['type'];
                $user->save();

                $json = $this->response(array(
                    'code' => 200,
                    'message' => ' rol creado ',
                    'name' => $input['type']
                ));

                return $json;
            } 
            catch (Exception $e) 
            {
                $json = $this->response(array(
                    'code' => 500,
                 'message' => $e->getMessage(),
                ));

                return $json;
            }       
    }

    

}