<?php 
use \Firebase\JWT\JWT;

class Controller_Roles extends Controller_Autentificacion
{
    public function post_create()
    {
        try {
            if ( ! isset($_POST['type']))

                $rol = new Model_Roles();
                $rol->type = "admin";
                $rol->save();

                $rol2 = new Model_Roles();
                $rol2->type = "user";
                $rol2->save();

                $json = $this->response(array(
                    'code' => 200,
                    'message' => ' roles creados '
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

    // both main and related object already exist
    //$comment = Model_Comment::find(6);
    //$comment->post = Model_Post::find(1);
    //$comment->save();
    //$list = Model_Lists::find($input['id_list']);
                //$list->pieces[] = Model_Pieces::find($input['id_piece']);
                //$list->save();

}