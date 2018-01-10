<?php 
use \Firebase\JWT\JWT;
class Controller_Listas extends Controller_Autentificacion
{
    public function post_create()
    {
        if($this->LoginAuthentification())
        {
            try {
                    if ( ! isset($_POST['titulo'])) 
                    {
                        $json = $this->response(array(
                        'code' => 400,
                        'message' => ' parametro incorrecto, se necesita que el parametro se llame titulo'
                        ));

                        return $json;
                    }

                    $input = $_POST;
                    $listas = new Model_Listas();
                    $listas->titulo = $input['titulo'];
                    $listas->id_usuario = $this->userID();
                    $listas->save();

                    $json = $this->response(array(
                        'code' => 200,
                        'message' => ' lista creada ',
                        'titulo' => $input['titulo']
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

    public function get_listas()
    {
    	$listas = Model_Listas::find('all');

    	return $this->response(Arr::reindex($listas));
    }

    public function post_delete()
    {
        if($this->LoginAuthentification())
        {
            $idLista=$_POST['idLista'];
            $lista = Model_listas::find($idLista);
            //la lista solo puede ser eliminada por su usuario
            if($this->userID()==$lista->id_usuario)
            {
                $tituloLista = $lista->titulo;
                $lista->delete();

                $json = $this->response(array(
                    'code' => 200,
                    'message' => ' lista borrada ',
                    'name' => $tituloLista
                    ));
                return $json;
            }
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

    public function post_edit()
    {
        //llamar a la funcion
        if($this->LoginAuthentification())
        {
            //la lista solo puede ser editada por su usuario
            if($this->userID()==$lista->id_usuario)
            {
                $infoID=$lista->id;
                $input = $_POST;
                $datauser = DB::update('listas');
                $datauser->where('id', '=', $infoID);
                $datauser->value('nombre', $input['nombre']);
                $datauser->execute();

                $response = $this->response(array(
                    'code' => 200,
                    'message' => ' El nombre a cambiado a ',
                    'data' => $input['nombre']
                ));
                return $response;
            }   
        }
        else
        {
            $response = $this->response(array(
                'code' => 400,
                'message' => ' El usuario debe loguearse primero ',
                'data' => var_dump($this->LoginAuthentification())
            ));
            return $response;
        }
    }   
}

