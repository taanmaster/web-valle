<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TourismThirdPartyRequest;
use App\Models\TourismThirdPartyObservation;
use App\Models\User;
use Carbon\Carbon;

class TourismThirdPartySeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        if (!$user) {
            return;
        }

        $requests = [
            [
                'full_name' => 'María Elena González Rodríguez',
                'organization_name' => null,
                'applicant_type' => 'persona_fisica',
                'rfc_or_curp' => 'GORM850312MGTNDL08',
                'fiscal_address' => 'Calle Independencia 45, Centro, Valle de Santiago',
                'phone' => '(456) 123-4567',
                'email' => 'maria.gonzalez@ejemplo.com',
                'event_name' => 'Festival Gastronómico del Valle',
                'event_type' => 'Festival',
                'event_objective' => 'Promover la gastronomía local y atraer turismo al municipio mediante la exposición de platillos típicos de la región.',
                'event_description' => 'Festival de tres días con stands de comida típica, demostraciones culinarias, concursos de cocina y música en vivo.',
                'start_date' => Carbon::now()->addDays(30),
                'end_date' => Carbon::now()->addDays(32),
                'start_time' => '10:00',
                'end_time' => '22:00',
                'venue' => 'Plaza Principal de Valle de Santiago',
                'event_access_type' => 'Abierto',
                'expected_impact' => 'Regional',
                'estimated_attendees' => 5000,
                'promotes_identity' => 'El festival promueve las tradiciones culinarias que forman parte de la identidad cultural del Valle de Santiago.',
                'generates_economic_impact' => 'Se estima una derrama económica de $500,000 MXN beneficiando a restauranteros, hoteleros y comerciantes locales.',
                'support_type' => 'Logístico',
                'support_description' => 'Se solicita apoyo con tarimas, sonido, sillas, mesas y difusión en redes sociales oficiales del municipio.',
                'status' => 'Enviada',
                'created_at' => Carbon::now()->subDays(5),
            ],
            [
                'full_name' => 'José Carlos Hernández López',
                'organization_name' => 'Asociación de Artesanos del Valle A.C.',
                'applicant_type' => 'persona_moral',
                'rfc_or_curp' => 'AAV210315AB9',
                'fiscal_address' => 'Av. Juárez 120, Col. Centro, Valle de Santiago',
                'phone' => '(456) 987-6543',
                'email' => 'artesanos.valle@ejemplo.com',
                'event_name' => 'Expo Artesanal Valle de Santiago',
                'event_type' => 'Exposición',
                'event_objective' => 'Exhibir y comercializar artesanías locales, promoviendo el trabajo de artesanos de la región.',
                'event_description' => 'Exposición y venta de artesanías típicas con talleres demostrativos de técnicas ancestrales.',
                'start_date' => Carbon::now()->addDays(45),
                'end_date' => Carbon::now()->addDays(47),
                'start_time' => '09:00',
                'end_time' => '20:00',
                'venue' => 'Casa de la Cultura',
                'event_access_type' => 'Abierto',
                'expected_impact' => 'Local',
                'estimated_attendees' => 2000,
                'promotes_identity' => 'La exposición resalta las técnicas artesanales tradicionales transmitidas de generación en generación.',
                'generates_economic_impact' => 'Beneficia directamente a 30 familias artesanas con ventas estimadas de $200,000 MXN.',
                'support_type' => 'Económico',
                'support_description' => 'Se solicita apoyo económico de $50,000 MXN para montaje de stands y material promocional.',
                'status' => 'En Revisión',
                'created_at' => Carbon::now()->subDays(10),
            ],
            [
                'full_name' => 'Laura Patricia Martínez Sánchez',
                'organization_name' => null,
                'applicant_type' => 'persona_fisica',
                'rfc_or_curp' => 'MASL900520MGTRTL05',
                'fiscal_address' => 'Calle Morelos 78, Col. San Juan, Valle de Santiago',
                'phone' => '(456) 555-1234',
                'email' => 'laura.martinez@ejemplo.com',
                'event_name' => 'Carrera Atlética por el Valle',
                'event_type' => 'Deportivo',
                'event_objective' => 'Fomentar el deporte y turismo deportivo en el municipio a través de una carrera atlética.',
                'event_description' => 'Carrera atlética de 5K y 10K con recorrido por los principales atractivos turísticos del municipio.',
                'start_date' => Carbon::now()->addDays(60),
                'end_date' => Carbon::now()->addDays(60),
                'start_time' => '07:00',
                'end_time' => '14:00',
                'venue' => 'Unidad Deportiva Municipal',
                'event_access_type' => 'Cerrado',
                'expected_impact' => 'Estatal',
                'estimated_attendees' => 1500,
                'promotes_identity' => 'El recorrido de la carrera incluye paradas informativas en sitios históricos y naturales del municipio.',
                'generates_economic_impact' => 'Se estima la llegada de 800 corredores foráneos que generarán derrama económica en hospedaje y alimentación.',
                'support_type' => 'Logístico',
                'support_description' => 'Se requiere apoyo con cierre de calles, seguridad vial, servicio médico y difusión del evento.',
                'status' => 'Aprobada',
                'created_at' => Carbon::now()->subDays(20),
            ],
            [
                'full_name' => 'Roberto Méndez Vargas',
                'organization_name' => 'Cámara de Comercio Valle de Santiago',
                'applicant_type' => 'persona_moral',
                'rfc_or_curp' => 'CCV180901KL2',
                'fiscal_address' => 'Blvd. Guanajuato 200, Valle de Santiago',
                'phone' => '(456) 222-3344',
                'email' => 'camara.comercio@ejemplo.com',
                'event_name' => 'Noche de Estrellas en las Hoyitas',
                'event_type' => 'Cultural',
                'event_objective' => 'Posicionar a Valle de Santiago como destino de astroturismo aprovechando el entorno natural de las Hoyitas.',
                'event_description' => 'Evento nocturno con observación astronómica guiada, conferencias, música ambiental y gastronomía local.',
                'start_date' => Carbon::now()->addDays(15),
                'end_date' => Carbon::now()->addDays(15),
                'start_time' => '18:00',
                'end_time' => '23:00',
                'venue' => 'Las Hoyitas - Zona Turística',
                'event_access_type' => 'Cerrado',
                'expected_impact' => 'Nacional',
                'estimated_attendees' => 800,
                'promotes_identity' => 'Aprovecha el patrimonio natural único de las Hoyitas como atractivo turístico diferenciador.',
                'generates_economic_impact' => 'Evento con potencial de posicionar al municipio como destino de astroturismo, generando turismo recurrente.',
                'support_type' => 'Logístico',
                'support_description' => 'Se solicita apoyo con transporte, iluminación del acceso, seguridad y difusión en medios oficiales.',
                'status' => 'Rechazada',
                'created_at' => Carbon::now()->subDays(30),
            ],
            [
                'full_name' => 'Ana Sofía Ramírez Torres',
                'organization_name' => null,
                'applicant_type' => 'persona_fisica',
                'rfc_or_curp' => 'RATA950815MGTMRN02',
                'fiscal_address' => 'Privada Las Flores 12, Valle de Santiago',
                'phone' => '(456) 777-8899',
                'email' => 'ana.ramirez@ejemplo.com',
                'event_name' => 'Feria del Libro y la Lectura',
                'event_type' => 'Cultural',
                'event_objective' => 'Promover la lectura y la cultura entre los habitantes y visitantes del municipio.',
                'event_description' => 'Feria del libro con presentaciones de autores locales, talleres de escritura creativa, cuentacuentos y venta de libros.',
                'start_date' => Carbon::now()->addDays(75),
                'end_date' => Carbon::now()->addDays(77),
                'start_time' => '10:00',
                'end_time' => '19:00',
                'venue' => 'Biblioteca Municipal',
                'event_access_type' => 'Abierto',
                'expected_impact' => 'Local',
                'estimated_attendees' => 1000,
                'promotes_identity' => 'Rescata y promueve la producción literaria local y las tradiciones orales de la región.',
                'generates_economic_impact' => 'Genera actividad económica para librerías locales y negocios aledaños al recinto.',
                'support_type' => 'Económico',
                'support_description' => 'Se solicita apoyo económico de $30,000 MXN para pago de autores invitados y material de difusión.',
                'status' => 'Enviada',
                'created_at' => Carbon::now()->subDays(2),
            ],
        ];

        foreach ($requests as $requestData) {
            $requestData['user_id'] = $user->id;
            $requestData['folio'] = TourismThirdPartyRequest::generateFolio();

            $request = TourismThirdPartyRequest::create($requestData);

            // Add observations for requests that are not in 'Enviada' status
            if ($request->status !== 'Enviada') {
                TourismThirdPartyObservation::create([
                    'tourism_third_party_request_id' => $request->id,
                    'user_id' => $user->id,
                    'observation' => 'Solicitud recibida y en proceso de revisión por el área de Turismo.',
                    'created_at' => $request->created_at->addDays(1),
                ]);
            }

            if ($request->status === 'Aprobada') {
                TourismThirdPartyObservation::create([
                    'tourism_third_party_request_id' => $request->id,
                    'user_id' => $user->id,
                    'observation' => 'Solicitud aprobada. Se coordinará el apoyo logístico con la Dirección de Turismo.',
                    'created_at' => $request->created_at->addDays(3),
                ]);
            }

            if ($request->status === 'Rechazada') {
                TourismThirdPartyObservation::create([
                    'tourism_third_party_request_id' => $request->id,
                    'user_id' => $user->id,
                    'observation' => 'Solicitud rechazada. El evento no cumple con los requisitos mínimos de impacto turístico establecidos.',
                    'created_at' => $request->created_at->addDays(5),
                ]);
            }
        }
    }
}
