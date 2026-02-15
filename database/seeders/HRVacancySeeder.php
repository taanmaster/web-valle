<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HRVacancy;
use Carbon\Carbon;

class HRVacancySeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $vacancies = [
            [
                'position_name' => 'Auxiliar Administrativo',
                'dependency' => 'Presidencia Municipal',
                'employment_type' => 'Tiempo completo',
                'work_schedule' => 'Lunes a Viernes 8:00 - 16:00',
                'location' => 'Palacio Municipal, Valle de Santiago',
                'description' => '<div>Se solicita auxiliar administrativo para apoyo en tareas de gestion documental, atencion ciudadana y seguimiento de tramites internos.</div>',
                'requirements' => '<div><ul><li>Licenciatura en Administracion, Contabilidad o afin</li><li>Experiencia minima de 1 año en puestos similares</li><li>Manejo de paqueteria Office</li><li>Buena actitud de servicio</li></ul></div>',
                'published_at' => $now->copy()->subDays(5),
                'closing_date' => $now->copy()->addDays(25),
            ],
            [
                'position_name' => 'Ingeniero Civil - Obras Publicas',
                'dependency' => 'Direccion de Obras Publicas',
                'employment_type' => 'Tiempo completo',
                'work_schedule' => 'Lunes a Viernes 8:00 - 16:00',
                'location' => 'Direccion de Obras Publicas, Valle de Santiago',
                'description' => '<div>Se requiere ingeniero civil para supervision de obras publicas municipales, elaboracion de presupuestos y seguimiento de proyectos de infraestructura.</div>',
                'requirements' => '<div><ul><li>Titulo de Ingeniero Civil</li><li>Cedula profesional vigente</li><li>Experiencia minima de 2 años en supervision de obra</li><li>Manejo de AutoCAD y software de presupuestos</li><li>Disponibilidad para trabajo en campo</li></ul></div>',
                'published_at' => $now->copy()->subDays(3),
                'closing_date' => $now->copy()->addDays(30),
            ],
            [
                'position_name' => 'Trabajador(a) Social - DIF Municipal',
                'dependency' => 'DIF Municipal',
                'employment_type' => 'Tiempo completo',
                'work_schedule' => 'Lunes a Viernes 8:00 - 15:00',
                'location' => 'DIF Municipal, Valle de Santiago',
                'description' => '<div>Se busca profesional en trabajo social para atencion a poblacion vulnerable, elaboracion de estudios socioeconomicos y seguimiento de programas de asistencia social.</div>',
                'requirements' => '<div><ul><li>Licenciatura en Trabajo Social</li><li>Experiencia en atencion a grupos vulnerables</li><li>Conocimiento en programas de asistencia social</li><li>Habilidades de comunicacion y empatia</li></ul></div>',
                'published_at' => $now->copy()->subDays(1),
                'closing_date' => $now->copy()->addDays(20),
            ],
            [
                'position_name' => 'Analista de Sistemas',
                'dependency' => 'Direccion de Innovacion y Tecnologia',
                'employment_type' => 'Tiempo completo',
                'work_schedule' => 'Lunes a Viernes 9:00 - 17:00',
                'location' => 'Palacio Municipal, Valle de Santiago',
                'description' => '<div>Buscamos analista de sistemas para mantenimiento de plataformas digitales del municipio, soporte tecnico y desarrollo de soluciones tecnologicas.</div>',
                'requirements' => '<div><ul><li>Licenciatura en Sistemas Computacionales, Informatica o afin</li><li>Conocimientos en PHP, Laravel, bases de datos MySQL</li><li>Experiencia en soporte tecnico</li><li>Deseable conocimiento en servidores Linux</li></ul></div>',
                'published_at' => $now->copy()->addDays(5),
                'closing_date' => $now->copy()->addDays(35),
            ],
            [
                'position_name' => 'Contador Publico - Tesoreria',
                'dependency' => 'Tesoreria Municipal',
                'employment_type' => 'Tiempo completo',
                'work_schedule' => 'Lunes a Viernes 8:00 - 16:00',
                'location' => 'Tesoreria Municipal, Valle de Santiago',
                'description' => '<div>Se requiere contador publico para apoyo en la gestion financiera, registro contable y elaboracion de reportes fiscales del municipio.</div>',
                'requirements' => '<div><ul><li>Titulo de Contador Publico</li><li>Cedula profesional</li><li>Experiencia minima de 2 años en contabilidad gubernamental</li><li>Conocimiento de la Ley General de Contabilidad Gubernamental</li><li>Manejo de sistemas contables</li></ul></div>',
                'published_at' => $now->copy()->subDays(40),
                'closing_date' => $now->copy()->subDays(10),
            ],
            [
                'position_name' => 'Promotor de Turismo',
                'dependency' => 'Direccion de Turismo',
                'employment_type' => 'Medio tiempo',
                'work_schedule' => 'Sabado y Domingo 9:00 - 15:00',
                'location' => 'Centro Historico, Valle de Santiago',
                'description' => '<div>Se busca promotor turistico para atencion a visitantes, difusion de atractivos turisticos y apoyo en eventos culturales del municipio.</div>',
                'requirements' => '<div><ul><li>Licenciatura en Turismo, Comunicacion o afin (o estudiante de ultimos semestres)</li><li>Conocimiento de la historia y atractivos de Valle de Santiago</li><li>Facilidad de palabra y trato al publico</li><li>Deseable manejo de ingles basico</li></ul></div>',
                'published_at' => $now->copy()->subDays(2),
                'closing_date' => $now->copy()->addDays(15),
            ],
        ];

        foreach ($vacancies as $vacancy) {
            HRVacancy::create($vacancy);
        }
    }
}
