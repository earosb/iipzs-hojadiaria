<?php

use Cartalyst\Sentry\Users\LoginRequiredException;
use Cartalyst\Sentry\Users\PasswordRequiredException;
use Cartalyst\Sentry\Users\WrongPasswordException;
use Cartalyst\Sentry\Users\UserNotFoundException;
use Cartalyst\Sentry\Users\UserNotActivatedException;
use Cartalyst\Sentry\Throttling\UserSuspendedException;
use Cartalyst\Sentry\Throttling\UserBannedException;

class APIv2Controller extends \BaseController
{
    /**
     * GET /api/v2/trabajos
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function trabajos()
    {
        try {
            $trabajos = Trabajo::join('tipo_mantenimiento', 'trabajo.tipo_mantenimiento_id', '=', 'tipo_mantenimiento.id')
                ->where('tipo_mantenimiento.cod', '=', 'menor')
                ->orWhere('tipo_mantenimiento.cod', '=', 'mayor')
                ->orderBy('trabajo.nombre')
                ->get([ 'trabajo.id as remote_id', 'trabajo.nombre', 'trabajo.unidad' ]);

            return Response::json([
                'error' => false,
                'msg' => $trabajos
            ]);
        } catch ( Exception $e ) {
            Log::error('APIv2Controller::trabajos', [ $e->getMessage() ]);
            return Response::json([
                'error' => true,
                'msg' => 'Se produjo un error en la base de datos',
                'e' => $e->getMessage()
            ]);
        }
    }

    /**
     * POST /api/v2/auth
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function auth()
    {
        $username = Input::get('username');
        $password = Input::get('password');

        // Credenciales
        $cmredenciales = array(
            'username' => $username,
            'password' => $password
        );
        try {
            $usuario = Sentry::authenticate($cmredenciales, false);

            if ( $usuario ) {
                Log::info('APIv1Controller::login', [ $username ]);
                $token = bin2hex(openssl_random_pseudo_bytes(16));

                $user = Sentry::getUser();
                $user->token_api = $token;
                $user->save();

                return Response::json([ 'error' => 'false',
                    'user' => $user ]);
            }
        } catch ( Cartalyst\Sentry\Users\LoginRequiredException $e ) {
            return Response::json([ 'error' => 'true', 'msg' => 'Nombre de usuario requerido.' ]);
        } catch ( Cartalyst\Sentry\Users\PasswordRequiredException $e ) {
            return Response::json([ 'error' => 'true', 'msg' => 'La Contraseña es requerida.' ]);
        } catch ( Cartalyst\Sentry\Users\WrongPasswordException $e ) {
            return Response::json([ 'error' => 'true', 'msg' => 'Contraseña incorrecta.' ]);
        } catch ( Cartalyst\Sentry\Users\UserNotFoundException $e ) {
            return Response::json([ 'error' => 'true', 'msg' => 'Usuario no encontrado.' ]);
        } catch ( Cartalyst\Sentry\Users\UserNotActivatedException $e ) {
            return Response::json([ 'error' => 'true', 'msg' => 'Usuario no activado.' ]);
        } // The following is only required if the throttling is enabled
        catch ( Cartalyst\Sentry\Throttling\UserSuspendedException $e ) {
            return Response::json([ 'error' => 'true', 'msg' => 'Usuario suspendido.' ]);
        } catch ( Cartalyst\Sentry\Throttling\UserBannedException $e ) {
            return Response::json([ 'error' => 'true', 'msg' => 'Usuario Baneado.' ]);
        }
    }

    /**
     * POST /api/v2/programar
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        Log::info('APIv2Controller::store', [ 'input' => Input::all() ]);

        $username = Input::get('username');
        $password = Input::get('password');

        $auth = $this->checkCredentials([ $username, $password ]);
        if ( $auth[ 'error' ] )
            return Response::json([ 'error' => 'true', 'msg' => $auth[ 'msg' ] ]);

        $user = $auth[ 'user' ];
        $programs = [];
        $errors = [];
        try {
            $inspections = json_decode(Input::get('trabajos'));
            foreach ( $inspections as $inspection ) {
                $program = [];
                $program[ 'causa' ] = $inspection->causa;
                $program[ 'trabajo_id' ] = $inspection->trabajo_id;
                $program[ 'km_inicio' ] = $inspection->km_inicio;
                $program[ 'km_termino' ] = $inspection->km_termino;
                $program[ 'cantidad' ] = $inspection->cantidad;
                $program[ 'obs_ce' ] = $inspection->obs_ce;
                $program[ 'observaciones' ] = $inspection->obs;

                $validator = Validator::make($program, Programa::$rules);

                if ( $validator->fails() ) {
                    $trabajo = Trabajo::findOrFail($program[ 'trabajo_id' ]);
                    $errors[] = [
                        'trabajo' => $trabajo->nombre,
                        'km_inicio' => $program[ 'km_inicio' ],
                        'km_termino' => $program[ 'km_termino' ],
                        'msg' => $validator->messages()
                    ];
                }
            }

            if ( count($errors) > 0 ) {
                Mail::send('emails.api.errors', [ 'user' => $user, '$errors' => $errors ], function ($message) use ($user) {
                    $message
                        ->to($user[ 'email' ], $user[ 'username' ])
                        ->subject('Errores en nueva inspección ingresada desde iipzs-android');
                });
                return Response::json([ 'error' => true, 'msg' => $errors ]);
            }

            foreach ( $programs as $program ) {
                $programs[] = Programa::create($program);
            }

            Mail::send('emails.api.success', [ 'user' => $user, 'programs' => $programs ], function ($message) use ($user) {
                $message
                    ->to($user[ 'email' ], $user[ 'username' ])
                    ->subject('Nueva inspección ingresada desde iipzs-android');
            });

            return Response::json([ 'error' => false ]);
        } catch ( Exception $e ) {
            return Response::json([ 'error' => true, 'msg' => 'Se produjo un error en la base de datos' ]);
        }
    }

    /**
     * Check user's credentials
     *
     * @param $credentials
     * @return array
     */
    private function checkCredentials($credentials)
    {
        try {
            $user = Sentry::authenticate($credentials, false);
            if ( $user ) return [
                'error' => false,
                'user' => $user
            ];
        } catch ( LoginRequiredException $e ) {
            return [ 'error' => 'true', 'msg' => 'Nombre de usuario requerido.' ];
        } catch ( PasswordRequiredException $e ) {
            return [ 'error' => 'true', 'msg' => 'La Contraseña es requerida.' ];
        } catch ( WrongPasswordException $e ) {
            return [ 'error' => 'true', 'msg' => 'Contraseña incorrecta.' ];
        } catch ( UserNotFoundException $e ) {
            return [ 'error' => 'true', 'msg' => 'Usuario no encontrado.' ];
        } catch ( UserNotActivatedException $e ) {
            return [ 'error' => 'true', 'msg' => 'Usuario no activado.' ];
        } catch ( UserSuspendedException $e ) {
            return [ 'error' => 'true', 'msg' => 'Usuario suspendido.' ];
        } catch ( UserBannedException $e ) {
            return [ 'error' => 'true', 'msg' => 'Usuario Baneado.' ];
        }

        return [ 'error' => 'true', 'msg' => 'Error interno del servidor.' ];
    }
}
