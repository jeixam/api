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
}