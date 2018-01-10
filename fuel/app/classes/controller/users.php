<?php 
use \Firebase\JWT\JWT;

class Controller_Users extends Controller_Autentificacion
{
    public function post_create()
    {
        try {
            if ( ! isset($_POST['name'])) 
            {
                $json = $this->response(array(
                    'code' => 400,
                    'message' => ' parametro incorrecto, se necesita que el parametro se llame name'
                ));

                return $json;
            }

            $input = $_POST;
            $user = new Model_Users();
            $user->nombre = $input['name'];
            $user->password = $input['password'];
            $user->save();

            $json = $this->response(array(
                'code' => 200,
                'message' => 'usuario creado',
                'name' => $input['name']
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

    public function get_users()
    {
    	if($this->LoginAuthentification())
        {
        	$users = Model_Users::find('all');

        	foreach ($users as $key => $user)
            {
                $users[] = $user->nombre;
            }
            $response = $this->response(array(
                'code' => 200,
                'message' => 'Usuarios mostrados',
                'data' => $users
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
//borra el usuario del token
    public function post_delete()
    {
    	if($this->LoginAuthentification())
        {
        	$user = Model_Users::find($this->userID());
        	$userName = $user->nombre;
        	$user->delete();

        	$json = $this->response(array(
            	'code' => 200,
            	'message' => ' usuario borrado ',
            	'name' => $userName
        	));
        	return $json;
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

    public function Post_login()
    {
    	$input= $_POST;
        $input['nombre'];
        $entry = Model_Users::find('all', 
            array('where'=>array
            	(
            		array('nombre', $input['nombre']),
            		array('password', $input['password']),
        		),
            ));
        //usuario buscado
        //si esto es nulo
        if($entry==null)
        {
            $json = $this->response(array(
                    'code' => 400,
                    'message' => 'no existe el usuario o la contraseña'
                ));

                return $json;
        }
        else
        {
            $nombreArray=$input['nombre'];
            $passArray=$input['password'];
            $key = 'klj34234kl2j34k259923j';
            $token = array(
                "nombre" => $nombreArray,
                "password" => $passArray,
            );
            $jwt = JWT::encode($token, $key);
            $json = $this->response(array(
                    'code' => ' 200 ',
                    'data'=>$jwt,
                    'message' => ' usuario encontrado, logeado'
                ));

                return $json;
        }
    }

public function post_edit()
    {
    	//llamar a la funcion
        if($this->LoginAuthentification())
        {
        	$infoID=$this->userID();
            $input = $_POST;
            $datauser = DB::update('usuarios');
            $datauser->where('id', '=', $infoID);
            $datauser->value('password', $input['password']);
            $datauser->execute();

            $response = $this->response(array(
                'code' => 200,
                'message' => ' contraseña cambiada a ',
                'data' => $input['password']
            ));
            return $response;
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

//$datosUsers =JWT::decode($jwt, $key, array('HS256'));;
