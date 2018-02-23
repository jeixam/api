<?php 
use \Firebase\JWT\JWT;
class Controller_Privacidad extends Controller_Autentificacion
{
    public function post_edit()
    {
        if($this->LoginAuthentification())
        {
            $input = $_POST;
            $infoID=$this->userID();
            $datauser = DB::update('privacidad');
            $datauser->where('id_usuario', '=', $infoID);
            $datauser->value('notificaciones', $input['notificaciones']);
            $datauser->value('amigos', $input['amigos']);
            $datauser->value('perfil', $input['perfil']);
            $datauser->value('listas', $input['listas']);
            $datauser->execute();

            $response = $this->response(array(
                'code' => 200,
                'message' => ' preferencias modificadas ',
            ));
            return $response; 
        }
        else
        {
            $response = $this->response(array
                (
                    'code' => 400,
                    'message' => ' El usuario debe loguearse primero ',
                    'data' => ''
                ));
            return $response;
        }
    }
}