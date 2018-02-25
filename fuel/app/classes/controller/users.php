<?php 
use \Firebase\JWT\JWT;

class Controller_Users extends Controller_Autentificacion
{
    public function post_createAdmin()
    {
        //si ya existe admin
        
        if($this->userExistAdmin()==true)
        {
            try 
            {
                $user = new Model_Users();
                $user->nombre = "admin";
                $user->password = "1234";
                $user->email = "admin@admin.es";
                $user->id_divice = "A0000000A";
                $user->image = "https://SoyUnaImagenDeUnSitio";
                $user->birtdate = "hoy/mes/año";
                $user->x = 0;
                $user->y = 0;
                $user->ciudad = "mundo digital";
                $user->descripcion = "usuarios administrador";
                $rol = Model_roles::find('all', array
                          (
                              'where' => array
                              (
                                array('type'=>"admin")
                              )
                          ));
                    foreach ($rol as $key => $value)
                    {
                        $id = $rol[$key]->id;
                    }
                
                $user->id_rol=$id;
                $user->save();
                //crea la privacidad del usuario
                $privacity=new Model_privacidad();
                $privacity->notificaciones=0;
                $privacity->listas=0;
                $privacity->amigos=0;
                $privacity->notificaciones=0;
                $privacity->perfil=0;
                $privacity->id_usuario=$user->id;
                $privacity->save();

                $json = $this->response(array(
                    'code' => 200,
                    'message' => ' usuario creado ',
                    'name' => $user->nombre
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
            $json = $this->response(array
                (
                    'code' => 400,
                    'message' => ' usuario admin ya creado ',
                ));

                return $json;
        }       
}

    public function post_create()
    {
        try 
        {
            if ( ! isset($_POST['nombre'],$_POST['password'],$_POST['email'],$_POST['id_divice'],$_POST['x'],$_POST['y'],$_POST['descripcion'],$_POST['birtdate'],$_POST['image'],$_POST['ciudad'])) 
                {
                    $json = $this->response(array(
                    'code' => 400,
                    'message' => ' parametros enviados incorrectos'
                    ));

                    return $json;
                }
            $input = $_POST;
            $user = new Model_Users();
            $user->nombre = $input['nombre'];
            $user->password = $input['password'];
            $user->email = $input['email'];
            $user->id_divice = $input['id_divice'];
            $user->image = $input['image'];
            $user->birtdate = $input['birtdate'];
            $user->x = $input['x'];
            $user->y = $input['y'];
            $user->ciudad = $input['ciudad'];
            $user->descripcion = $input['descripcion'];
            $rol = Model_roles::find('all', array
                          (
                              'where' => array
                              (
                                array('type'=>"user")
                              )
                          ));
                    foreach ($rol as $key => $value)
                    {
                        $id = $rol[$key]->id;
                    }
            $user->id_rol=$id;
            $user->save();
            //crea la privacidad del usuario
                $privacity=new Model_privacidad();
                $privacity->notificaciones=0;
                $privacity->listas=0;
                $privacity->amigos=0;
                $privacity->notificaciones=0;
                $privacity->perfil=0;
                $privacity->id_usuario=$user->id;
                $privacity->save();
            //crea la lista del usuario para las canciones reproducidas
                $this->ReproducidasPorUsuario($user->id);
            //respuesta
            $json = $this->response(array(
                'code' => 200,
                'message' => ' usuario creado ',
                'name' => $user->nombre
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
    	if($this->userIsAdmin())
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
                	'message' => ' El usuario debe loguearse primero y ser admin ',
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
        if ( ! isset($_POST['nombre'],$_POST['password'])) 
            {
                $json = $this->response(array(
                'code' => 400,
                'message' => ' parametros incorrectos'
                ));

                return $json;
            }

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
        if ( ! isset($_POST['email'],$_POST['password'])) 
                    {
                        $json = $this->response(array(
                        'code' => 400,
                        'message' => ' parametro incorrectos'
                        ));

                        return $json;
                    }
            $input = $_POST;
        	$infoID=$this->userIDEmail($input['email']);
            if(empty($infoID))
            {
                $json = $this->response(array(
                        'code' => 400,
                        'message' => ' el email no existe'
                        ));

                        return $json;
            }
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

/**
     *  Funcion para obtener si el usuario admin existe
     * @return bool
     */

protected function userExistAdmin ()
    {
      $user = Model_users::find('all', array
      (
        'where' => array
        (
          array('nombre'=>"admin")
        )
        ));
        if(isset($user))
        {
            if(!empty($user))
            {
                $username;
              foreach ($user as $key => $value)
                {
                  $username = $user[$key]->nombre;
                } 
                if($username=="admin")
                {
                    return false;
                }
                else
                {
                    return true;
                }         
            }
            else
            {
                return true;
            }
        }
        else 
        {
            return true;
        }                  
    }
}

