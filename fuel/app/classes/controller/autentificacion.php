<?php
use \Firebase\JWT\JWT;

class Controller_Autentificacion extends Controller_Rest
{
    //Modo de codificar el token
    protected $key = 'klj34234kl2j34k259923j';
    protected $algorithm = array('HS256');
    
    //-------------------------------------------------------------------------------------------
    /**
    * Funcion para hacer debugs
    * Pasamos el valor de la variable que queremos mostrar en el debug
    **/
    protected function Debugear($variable)
    {
        var_dump($variable);
        exit;
    }
    //-------------------------------------------------------------------------------------------

    /**
     *  Funcion para verificar el token
     * @return boolean
     */
    protected function LoginAuthentification()
    {
        
        $tokenHeader = apache_request_headers();

        //isset  Determina si una variable esta definida y no es NULL

        if(isset($tokenHeader['token']))
        {
             
          $token = $tokenHeader['token'];
          $datosUsers = JWT::decode($token, $this->key, $this->algorithm); 
          //var_dump($datosUsers);
          if(isset($datosUsers->nombre) and isset($datosUsers->password))
          { 
              $user = Model_users::find('all', array
                          (
                              'where' => array
                              (
                                array('nombre'=>$datosUsers->nombre),
                                array('password'=>$datosUsers->password)
                              )
                          ));
                if(!empty($user))
                {
                    foreach ($user as $key => $value)
                    {
                          $id = $user[$key]->id;
                          $username = $user[$key]->nombre;
                          $password = $user[$key]->password;
                    }
                }
                else
                {
                  return false;
                }
          }
          else
          {
            return false;
          }

          if($username == $datosUsers->nombre and $password == $datosUsers->password)
          {
            return true;
          }
          else
          {
            return false;
          }
      }
      else
      {
          return false;
      } 
        
    }
/**
     *  Funcion para obtener el id del usuario logueado por el token
     * @return int
     */
    protected function userID ()
    {
      $tokenHeader = apache_request_headers();
      $token = $tokenHeader['token'];
      $datosUsers = JWT::decode($token, $this->key, $this->algorithm);
      //var_dump($datosUsers);
      $user = Model_users::find('all', array
      (
        'where' => array
        (
          array('nombre'=>$datosUsers->nombre),
          array('password'=>$datosUsers->password)
        )
        ));
        if(!empty($user))
        {
          $id=0;
          foreach ($user as $key => $value)
            {
              $id = $user[$key]->id;
              $username = $user[$key]->nombre;
              $password = $user[$key]->password;
            }
          return $id;         
        }                  
    }

    /**
     *  Funcion para saber si el usuario es un adminitrador
     * @return bool
     */
    protected function userIsAdmin ()
    {
      $tokenHeader = apache_request_headers();
      $token = $tokenHeader['token'];
      $datosUsers = JWT::decode($token, $this->key, $this->algorithm);

      if($datosUsers->nombre=="admin")
      {
        return true;
      }
      else
      {
        return false;
      }                 
    }
/**
     *  Funcion para saber el id de una lista introduciendo el nombre
     * @return int
     */
    protected function idNameList($nombreLista)
    {
        $lista = Model_Listas::find('all', array
      (
        'where' => array
        (
          array('titulo'=>$nombreLista) 
        )
        ));
        if(!empty($lista))
        {
          $id=0;
          foreach ($lista as $key => $value)
            {
              $id = $lista[$key]->id;
            }
          return $id;         
        }
    }

    /**
     *  Funcion para saber el id de una cancion introduciendo el nombre
     * @return int
     */
    protected function idNameSong($nombreCancion)
    {
        $lista = Model_Cancion::find('all', array
      (
        'where' => array
        (
          array('nombre'=>$nombreCancion) 
        )
        ));
        if(!empty($lista))
        {
          $id=0;
          foreach ($lista as $key => $value)
            {
              $id = $lista[$key]->id;
            }
          return $id;         
        }
    }

    /**
     *  Funcion para obtener el id del usuario por el email
     * @return int
     */
    protected function userIDEmail ($email)
    {
      
      $user = Model_users::find('all', array
      (
        'where' => array
        (
          array('email'=>$email),
        )
        ));
        if(!empty($user))
        {
          $id=0;
          foreach ($user as $key => $value)
            {
              $id = $user[$key]->id;
            }
          return $id;         
        }                  
    }

    /**
     *  Funcion para obtener el id de una cancion que hay en una lista en la tabla tiene
     * @return int
     */
    protected function IdCancionEnLista ($nombreCancion,$nombreLista)
    {
      $cancionEnLista = Model_tiene::find('all', array
                (
                    'where' => array
                    (
                        array('id_cancion'=>$this->idNameSong($nombreCancion)),
                        array('id_lista'=>$this->idNameList($nombreLista))
                    )
                ));
                if(!empty($cancionEnLista))
                {
                  $id=0;
                  foreach ($cancionEnLista as $key => $value)
                    {
                      $id = $cancionEnLista[$key]->id_cancion;
                    }
                  return $id;         
                }
    }
    /**
     *  Funcion para crear una lista reproducidas por usuario
     */
    protected function ReproducidasPorUsuario ($userID)
    {
      $listas = new Model_Listas();
      $listas->titulo ='reproducidas';
      $listas->id_usuario = $userID;
      $listas->editable=0;
      $listas->save();
    }
    /**
     *  Funcion que que debuelve el id del usuario que tiene la lista reproduccion
     */
protected function IdUserListReproduction ()
    {
      $lista = Model_Listas::find('all', array
                  (
                    'where' => array
                    (
                      array('id_usuario'=>$this->userID()),
                      array('titulo'=>'reproducidas')
                    )
                    ));
                    if(!empty($lista))
                    {
                        $id=0;
                      foreach ($lista as $key => $value)
                        {
                          $id = $lista[$key]->id;
                        } 
                        return $id;        
                    }
    }
}