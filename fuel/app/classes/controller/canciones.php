<?php 
use \Firebase\JWT\JWT;
class Controller_Canciones extends Controller_Autentificacion
{
    public function post_create()
    {
        if($this->LoginAuthentification()&& $this->userIsAdmin ())
        {
            try {
                    if ( ! isset($_POST['nombre'])) 
                    {
                        $json = $this->response(array(
                        'code' => 400,
                        'message' => ' parametro incorrecto, se necesita que el parametro se llame nombre'
                        ));

                        return $json;
                    }

                    $input = $_POST;
                    $canciones = new Model_cancion();
                    $canciones->nombre = $input['nombre'];
                    $canciones->artista = $input['artista'];
                    $canciones->url = $input['url'];
                    $canciones->reproducciones=0;
                    $canciones->save();

                    $json = $this->response(array(
                        'code' => 200,
                        'message' => ' cancion creada ',
                        'nombre' => $input['nombre']
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
                    'message' => ' El usuario debe loguearse primero y ser el admin ',
                    'data' => ''
                ));
            return $response;
        }       
    }

    public function get_canciones()
    {
    	$canciones = Model_cancion::find('all');

    	return $this->response(Arr::reindex($canciones));
    }

    public function post_delete()
    {
        if($this->LoginAuthentification())
        {
            $nombreCancion=$_POST['nombre'];
            $canciones = Model_cancion::find($this->idNameSong($nombreCancion));
            //solo el admin puede eliminar canciones 
            if($this->userIsAdmin ())
            {
                $nombreCancion = $canciones->nombre;
                $canciones->delete();
                
                $json = $this->response(array(
                    'code' => 200,
                    'message' => ' cancione borrada ',
                    'name' => $nombreCancion
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

    public function post_add()
    {

        if($this->LoginAuthentification())
        {
            try {
                    if ( ! isset($_POST['id_lista'],$_POST['id_cancion'])) 
                    {
                        $json = $this->response(array(
                        'code' => 400,
                        'message' => ' parametros incorrectos'
                        ));

                        return $json;
                    }

                    $input = $_POST;
                    $lista = Model_Listas::find($input['id_lista']);

                    if(empty($lista))
                    {
                        $response = $this->response(array(
                            'code' => 400,
                            'message' => 'lista no existe',
                        ));
                        return $response;
                    }

                    $cancion = Model_cancion::find($input['id_cancion']);

                    if(empty($cancion))
                    {
                        $response = $this->response(array(
                            'code' => 400,
                            'message' => ' no existe la cancion',
                        ));
                        return $response;
                    }
                    //guardar canciones en una lista
                    $lista = Model_Listas::find($input['id_lista']);
                    $lista->cancion[] = Model_cancion::find($input['id_cancion']);
                    $lista->save();

                    $json = $this->response(array(
                        'code' => 200,
                        'message' => ' cancion añadida ',
                        //'data'=>var_dump(Model_cancion::find('all'))
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

    public function post_reproduction()
    { 
        if($this->LoginAuthentification())
        {
            $nombreCancion=$_POST['nombreCancion'];
            //$cancion = Model_cancion::find($this->idNameCancion($nombreCancion));
            //en tiene
            $cancionEnLista = Model_listas::find('all', array
                          (
                              'where' => array
                              (
                                array('id_cancion'=>$this->idNameSong($nombreCancion))
                              )
                          ));
            var_dump($cancionEnLista);
            exit();

            $infoID=$cancion->id;
            $datacancion = DB::update('cancion');
            $datacancion->where('id', '=', $infoID);
            $datacancion->value('reproducciones', $cancion->reproduciones+1);
            $datacancion->execute();

            $response = $this->response(array(
                        'code' => 400,
                        'message' => ' cancion reproducida ',
                        ));
                        return $response;
        }
        else
        {
            $response = $this->response(array
                (
                    'code' => 400,
                    'message' => ' El usuario debe loguearse primero '
                ));
            return $response;
        }     
    }  

}