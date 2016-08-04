<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Http\Requests;
use App\church;
use JWTAuth;
use API;
use Tymon\JWTAuth\Exceptions\JWTException;
use Validator;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthenticateController extends Controller
{

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    public function authenticate(Request $request) {

        // Get credentials from the request
        $credentials = ['email'=>$request->input('email'),'password'=> $request->input('password')];
        //dd($credentials);

        try {
            // Attempt to verify the credentials and create a token for the user.
            if (! $token = JWTAuth::attempt($credentials)) {
                return API::response()->array(['error' => 'invalid_credentials'])->statusCode(401);
            }
        } catch (JWTException $e) {
            // Something went wrong - let the app know.
            return API::response()->array(['error' => 'could_not_create_token'])->statusCode(500);
        }

        // Return success.
        return compact('token');
    }

    public function validateToken(){
        return API::response()->array(['status' => 'success'])->statusCode(200);
    }

    public function regForm(){
        $churches = church::lists('name', 'id');
        return compact('churches');
    }
    protected function create(array $data)
    {
        return User::create([
            'username' => $data['email'],
            'email' => $data['email'],
            'church_id' => $data['church_id'],
            'password' => bcrypt($data['password']),
        ]);
    }
    public function regCreate(Request $request){

        if($request->input('church') > 0){
            $request->request->set('church_id', $request->input('church'));
        }else {
            $theChurch_id = $this->syncChurches($request->all());
            $request->request->set('church_id', $theChurch_id);
        }
        $all_requests = $request->all();
        Auth::guard($this->getGuard())->login($this->create($request->all()));
        return compact('all_requests');
    }


    private function syncChurches($churchinfo)
    {

        $theChurchId = '';

            $newChurch = church::create(
                [
                    'name' => $churchinfo['church_name'],
                    'address' => $churchinfo['church_address'],
                    'city' => $churchinfo['church_city'],
                    'country' => $churchinfo['church_country'],
                    'district' => $churchinfo['church_district']

                ]);
            $theChurchId = $newChurch->id;
            $church_id = $theChurchId;
            DB::table('services')->insert(
                [
                    [ 'church_id' => $church_id, 'type' => '1', 'name' => 'madrugada', 'displayOrder' => 1],
                    [ 'church_id' => $church_id, 'type' => '2', 'name' => 'Servicio de ayuno', 'displayOrder' => 2],
                    [ 'church_id' => $church_id, 'type' => '3', 'name' => 'Primer servicio', 'displayOrder' => 3],
                    [ 'church_id' => $church_id, 'type' => '4', 'name' => 'Segundo Servicio', 'displayOrder' => 4],
                    [ 'church_id' => $church_id, 'type' => '5', 'name' => 'Servicio de joven', 'displayOrder' => 5],
                ]
            );

            DB::table('trainings')->insert(
                [
                    ['displayOrder' => 1, 'name' => 'Encuentro', 'short_name' => 'Encuentro', 'category' => 'Encuentro', 'church_id' => $church_id, 'payment' => 1],
                    ['displayOrder' => 2, 'name' => '0-1 - Familia de Dios', 'short_name' => 'Discipulado - Tema 1', 'category' => 'Discipulado Transformador', 'church_id' => $church_id, 'payment' => 1],
                    ['displayOrder' => 3, 'name' => '0-2 - La Oracion', 'short_name' => 'Discipulado - Tema 2', 'category' => 'Discipulado Transformador', 'church_id' => $church_id, 'payment' => 0],
                    ['displayOrder' => 4, 'name' => '0-3 - El Estudio de la Biblia', 'short_name' => 'Discipulado - Tema 3', 'category' => 'Discipulado Transformador', 'church_id' => $church_id, 'payment' => 0],
                    ['displayOrder' => 5, 'name' => '0-4 - Congregandome en la Iglesia', 'short_name' => 'Discipulado - Tema 4', 'category' => 'Discipulado Transformador', 'church_id' => $church_id, 'payment' => 0],
                    ['displayOrder' => 6, 'name' => '0-5 - ¿Por qué debo ganar a otros?', 'short_name' => 'Discipulado - Tema 5', 'category' => 'Discipulado Transformador', 'church_id' => $church_id, 'payment' => 0],
                    ['displayOrder' => 7, 'name' => 'Clase bautismo', 'short_name' => 'Clase bautismo', 'category' => 'Bautismo', 'church_id' => $church_id, 'payment' => 0],
                    ['displayOrder' => 8, 'name' => '1-1 - La Naturaleza de Dios y sus Atributos', 'short_name' => 'Nivel 1 - Tema 1', 'category' => 'Los Fundamentos de nuestra fe', 'church_id' => $church_id, 'payment' => 1],
                    ['displayOrder' => 9, 'name' => '1-2 - El Hombre, su Grandeza y su', 'short_name' => 'Nivel 1 - Tema 2', 'category' => 'Los Fundamentos de nuestra fe', 'church_id' => $church_id, 'payment' => 0],
                    ['displayOrder' => 10, 'name' => '1-3 - Jesucristo, la Provisión de Dios para el Pecado del Hombre', 'short_name' => 'Nivel 1 - Tema 3', 'category' => 'Los Fundamentos de nuestra fe', 'church_id' => $church_id, 'payment' => 0],
                    ['displayOrder' => 11, 'name' => '1-4 - Los Beneficios del Sacrificio de Cristo', 'short_name' => 'Nivel 1 - Tema 4', 'category' => 'Los Fundamentos de nuestra fe', 'church_id' => $church_id, 'payment' => 0],
                    ['displayOrder' => 12, 'name' => '1-5 - ¿Cómo disfrutar los Beneficios del Sacrificio de Cristo?', 'short_name' => 'Nivel 1 - Tema 5', 'category' => 'Los Fundamentos de nuestra fe', 'church_id' => $church_id, 'payment' => 0],
                    ['displayOrder' => 13, 'name' => '1-6 - El Cristiano Verdadero', 'short_name' => 'Nivel 1 - Tema 6', 'category' => 'Los Fundamentos de nuestra fe', 'church_id' => $church_id, 'payment' => 0],
                    ['displayOrder' => 14, 'name' => '1-7 - La Palabra de Dios: Mi VIda Dveocional', 'short_name' => 'Nivel 1 - Tema 7', 'category' => 'Los Fundamentos de nuestra fe', 'church_id' => $church_id, 'payment' => 0],
                    ['displayOrder' => 15, 'name' => '1-8 - El Tiempo a Solas con Dios: Mi Vida Devocional', 'short_name' => 'Nivel 1 - Tema 8', 'category' => 'Los Fundamentos de nuestra fe', 'church_id' => $church_id, 'payment' => 0],
                    ['displayOrder' => 16, 'name' => '1-9 - Un Modelo de Oración: El Padre Nuestro', 'short_name' => 'Nivel 1 - Tema 9', 'category' => 'Los Fundamentos de nuestra fe', 'church_id' => $church_id, 'payment' => 0],
                    ['displayOrder' => 17, 'name' => '1-10 - La Guerra Espiritual', 'short_name' => 'Nivel 1 - Tema 10', 'category' => 'Los Fundamentos de nuestra fe', 'church_id' => $church_id, 'payment' => 0],
                    ['displayOrder' => 18, 'name' => '1-11 - La Presencia de Dios en medio de la ALabanza y la Adoración', 'short_name' => 'Nivel 1 - Tema 11', 'category' => 'Los Fundamentos de nuestra fe', 'church_id' => $church_id, 'payment' => 0],
                    ['displayOrder' => 19, 'name' => '1-12 - La Iglesia, Comunidad de Crecimiento', 'short_name' => 'Nivel 1 - Tema 12', 'category' => 'Los Fundamentos de nuestra fe', 'church_id' => $church_id, 'payment' => 0],
                    ['displayOrder' => 20, 'name' => '2-1 - El Espíritu Santo y su Obra en Nosotros', 'short_name' => 'Nivel 2 - Tema 1', 'category' => 'La vida cristiana guiada por el Espíritu Santo', 'church_id' => $church_id, 'payment' => 1],
                    ['displayOrder' => 21, 'name' => '2-2 - Llenos del Espíritu Santo y enteramente santificados', 'short_name' => 'Nivel 2 - Tema 2', 'category' => 'La vida cristiana guiada por el Espíritu Santo', 'church_id' => $church_id, 'payment' => 0],
                    ['displayOrder' => 22, 'name' => '2-3 - Los Dones del Espíritu Santo - Parte 1', 'short_name' => 'Nivel 2 - Tema 3', 'category' => 'La vida cristiana guiada por el Espíritu Santo', 'church_id' => $church_id, 'payment' => 0],
                    ['displayOrder' => 23, 'name' => '2-4 - Los Dones del Espíritu Santo - Parte 2', 'short_name' => 'Nivel 2 - Tema 4', 'category' => 'La vida cristiana guiada por el Espíritu Santo', 'church_id' => $church_id, 'payment' => 0],
                    ['displayOrder' => 24, 'name' => '2-5 - La Sanidad Divina', 'short_name' => 'Nivel 2 - Tema 5', 'category' => 'La vida cristiana guiada por el Espíritu Santo', 'church_id' => $church_id, 'payment' => 0],
                    ['displayOrder' => 25, 'name' => '2-6 - La Sanidad de las Emociones', 'short_name' => 'Nivel 2 - Tema 6', 'category' => 'La vida cristiana guiada por el Espíritu Santo', 'church_id' => $church_id, 'payment' => 0],
                    ['displayOrder' => 26, 'name' => '2-7 - Aceptación y Autoestima: Empezamos a crecer como personas', 'short_name' => 'Nivel 2 - Tema 7', 'category' => 'La vida cristiana guiada por el Espíritu Santo', 'church_id' => $church_id, 'payment' => 0],
                    ['displayOrder' => 27, 'name' => '2-8 - La voluntad diaria de Dios para mi vida', 'short_name' => 'Nivel 2 - Tema 8', 'category' => 'La vida cristiana guiada por el Espíritu Santo', 'church_id' => $church_id, 'payment' => 0],
                    ['displayOrder' => 28, 'name' => '2-9 - La obediencia, fundamento de bendición', 'short_name' => 'Nivel 2 - Tema 9', 'category' => 'La vida cristiana guiada por el Espíritu Santo', 'church_id' => $church_id, 'payment' => 0],
                    ['displayOrder' => 29, 'name' => '2-10 - Familias conforme al Plan de Dios', 'short_name' => 'Nivel 2 - Tema 10', 'category' => 'La vida cristiana guiada por el Espíritu Santo', 'church_id' => $church_id, 'payment' => 0],
                    ['displayOrder' => 30, 'name' => '2-11 - ¿Pueden los cristianos sufrir? La experiencia del desierto.', 'short_name' => 'Nivel 2 - Tema 11', 'category' => 'La vida cristiana guiada por el Espíritu Santo', 'church_id' => $church_id, 'payment' => 0],
                    ['displayOrder' => 31, 'name' => '2-12 - Las Finanzas y las Escrituras', 'short_name' => 'Nivel 2 - Tema 12', 'category' => 'La vida cristiana guiada por el Espíritu Santo', 'church_id' => $church_id, 'payment' => 0],
                    ['displayOrder' => 32, 'name' => '3-1 - El Desafío de Convertirnos en Discípulos', 'short_name' => 'Nivel 3 - Tema 1', 'category' => 'La visión de la iglesia y el liderazgo cristiano', 'church_id' => $church_id, 'payment' => 1],
                    ['displayOrder' => 33, 'name' => '3-2 - La Gran Comisión y el Previlegio de Hacer Discípulos', 'short_name' => 'Nivel 3 - Tema 2', 'category' => 'La visión de la iglesia y el liderazgo cristiano', 'church_id' => $church_id, 'payment' => 0],
                    ['displayOrder' => 34, 'name' => '3-3 - Discípulos que Hacen Discípulos', 'short_name' => 'Nivel 3 - Tema 3', 'category' => 'La visión de la iglesia y el liderazgo cristiano', 'church_id' => $church_id, 'payment' => 0],
                    ['displayOrder' => 35, 'name' => '3-4 - Siguiendo el Estilo de Discípulado de Jesús', 'short_name' => 'Nivel 3 - Tema 4', 'category' => 'La visión de la iglesia y el liderazgo cristiano', 'church_id' => $church_id, 'payment' => 0],
                    ['displayOrder' => 36, 'name' => '3-5 - Evangelizar, Una Manera Práctica de cumplir la Gran Comisión', 'short_name' => 'Nivel 3 - Tema 5', 'category' => 'La visión de la iglesia y el liderazgo cristiano', 'church_id' => $church_id, 'payment' => 0],
                    ['displayOrder' => 37, 'name' => '3-6 - Aprendiendo a Comunicar de Manera Efectiva el Evangelio', 'short_name' => 'Nivel 3 - Tema 6', 'category' => 'La visión de la iglesia y el liderazgo cristiano', 'church_id' => $church_id, 'payment' => 0],
                    ['displayOrder' => 38, 'name' => '3-7 - La  Consolidación del Nuevo Creyente', 'short_name' => 'Nivel 3 - Tema 7', 'category' => 'La visión de la iglesia y el liderazgo cristiano', 'church_id' => $church_id, 'payment' => 0],
                    ['displayOrder' => 39, 'name' => '3-8 - La Casa de Oración. ¿Qué es? y ¿Cómo desarrollarla con éxito?', 'short_name' => 'Nivel 3 - Tema 8', 'category' => 'La visión de la iglesia y el liderazgo cristiano', 'church_id' => $church_id, 'payment' => 0],
                    ['displayOrder' => 40, 'name' => '3-9 - Ministrando a las necesidades de las personas', 'short_name' => 'Nivel 3 - Tema 9', 'category' => 'La visión de la iglesia y el liderazgo cristiano', 'church_id' => $church_id, 'payment' => 0],
                    ['displayOrder' => 41, 'name' => '3-10 - El Modelo Pastoral de Dios: la ruta de acción para las Casas de Oración', 'short_name' => 'Nivel 3 - Tema 10', 'category' => 'La visión de la iglesia y el liderazgo cristiano', 'church_id' => $church_id, 'payment' => 0],
                    ['displayOrder' => 42, 'name' => '3-11 - Trabajndo en equipo: La fuerza compartida', 'short_name' => 'Nivel 3 - Tema 11', 'category' => 'La visión de la iglesia y el liderazgo cristiano', 'church_id' => $church_id, 'payment' => 0],
                    ['displayOrder' => 43, 'name' => '3-12 - Lo que la Biblia dice acerca del Ministerio', 'short_name' => 'Nivel 3 - Tema 12', 'category' => 'La visión de la iglesia y el liderazgo cristiano', 'church_id' => $church_id, 'payment' => 0],
                    ['displayOrder' => 44, 'name' => 'Graduación', 'short_name' => 'Graduación', 'category' => 'Graduación', 'church_id' => $church_id, 'payment' => 0],
                    ['displayOrder' => 45, 'name' => 'Post Encuentro', 'short_name' => 'Post Encuentro', 'category' => 'Post Encuentro', 'church_id' => $church_id, 'payment' => 1],
                ]
            );

        return ($theChurchId);
    }
}
