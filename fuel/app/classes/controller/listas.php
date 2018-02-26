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
                    if ($this->userIsAdmin())
                    {
                        $listas->editable=0;
                    }
                    else
                    {
                        $listas->editable=1;
                    }
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

    	return var_dump($listas);
    }

    public function post_delete()
    {
        if($this->LoginAuthentification())
        {

            if ( ! isset($_POST['titulo'])) 
                    {
                        $json = $this->response(array(
                        'code' => 400,
                        'message' => ' parametro incorrectos'
                        ));

                        return $json;
                    }
            $nombreLista=$_POST['titulo'];
            $lista = Model_listas::find($this->idNameList($nombreLista));
            if(empty($lista))
                    {
                        $response = $this->response(array(
                            'code' => 400,
                            'message' => ' lista no existe',
                        ));
                        return $response;
                    }
            //la lista solo puede ser eliminada por su usuario o el admin
            if($this->userID()==$lista->id_usuario||$this->userIsAdmin())
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

            if ( ! isset($_POST['titulo'],$_POST['nombre'])) 
                    {
                        $json = $this->response(array(
                        'code' => 400,
                        'message' => ' parametro incorrectos'
                        ));

                        return $json;
                    }
                    
            $nombreListaeditada=$_POST['titulo'];
            $lista = Model_listas::find($this->idNameList($nombreListaeditada));
            //la lista solo puede ser editada por su usuario o el admin
            if(empty($lista))
                    {
                        $response = $this->response(array(
                            'code' => 400,
                            'message' => ' lista no existe',
                        ));
                        return $response;
                    }
            if($this->userID()==$lista->id_usuario||$this->userIsAdmin())
            {
                if ($lista->editable==1) 
                {
                    $infoID=$lista->id;
                    $datauser = DB::update('listas');
                    $datauser->where('id', '=', $infoID);
                    $datauser->value('titulo', $_POST['nombre']);
                    $datauser->execute();
                }
                else
                {
                    $response = $this->response(array(
                    'code' => 400,
                    'message' => ' La lista no es editable ',
                    ));
                    return $response;
                }

                $response = $this->response(array(
                    'code' => 200,
                    'message' => ' El nombre a cambiado a ',
                    'data' => $_POST['nombre']
                ));
                return $response;
            }
            else
            {
                $response = $this->response(array(
                    'code' => 400,
                    'message' => ' la lista solo puede ser editada por el usuario que la creo o el admin ',
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

public function post_predefinedLists()
    {
        if($this->LoginAuthentification())
        {
            try {
                    if ($this->userIsAdmin())
                    {
                        $listas = new Model_Listas();
                        $listas->titulo ='Mas Escuchadas';
                        $listas->id_usuario = $this->userID();
                        if ($this->userIsAdmin())
                        {
                            $listas->editable=0;
                        }
                        else
                        {
                            $listas->editable=1;
                        }
                        $listas->save();


                        $json = $this->response(array(
                            'code' => 200,
                            'message' => ' listas creadas '
                        ));

                        return $json;

                    }
                    else
                    {
                        $response = $this->response(array
                            (
                                'code' => 400,
                                'message' => ' El usuario debe ser el admin ',
                                'data' => ''
                            ));
                        return $response;
                    }       
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

}

