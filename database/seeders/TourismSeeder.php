<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\TourismBanner;
use App\Models\TourismBlog;

class TourismSeeder extends Seeder
{
    public function run(): void
    {
        // Banners
        $banners = [
            [
                'title' => 'Bienvenido a Valle de Santiago',
                'subtitle' => 'Descubre la magia de nuestras Siete Luminarias y paisajes volcánicos únicos en el mundo.',
                'show_text' => true,
                'image' => 'placeholder.jpg',
                'image_responsive' => 'placeholder.jpg',
                'is_active' => true,
                'priority' => '1',
                'has_button' => false,
            ],
            [
                'title' => 'Ruta de las Siete Luminarias',
                'subtitle' => 'Explora los cráteres volcánicos que guardan lagos milenarios y leyendas ancestrales.',
                'show_text' => true,
                'image' => 'placeholder.jpg',
                'image_responsive' => 'placeholder.jpg',
                'is_active' => true,
                'priority' => '2',
                'has_button' => true,
                'text_button' => 'Conoce más',
                'link' => '#',
                'hex_button' => '#2e7d32',
                'hex_text_button' => '#ffffff',
            ],
            [
                'title' => 'Gastronomía Vallense',
                'subtitle' => 'Sabores que te conquistan: gorditas, enchiladas y dulces tradicionales.',
                'show_text' => true,
                'image' => 'placeholder.jpg',
                'image_responsive' => 'placeholder.jpg',
                'is_active' => true,
                'priority' => '3',
                'has_button' => false,
            ],
        ];

        foreach ($banners as $banner) {
            TourismBanner::create($banner);
        }

        // Blog posts
        $posts = [
            [
                'title' => 'Las Siete Luminarias: Un recorrido por los cráteres volcánicos de Valle de Santiago',
                'description' => 'Conoce la historia y belleza natural de los siete cráteres volcánicos que rodean Valle de Santiago, un fenómeno geológico único en México.',
                'content_1' => '<div><p>Las Siete Luminarias son un conjunto de cráteres volcánicos ubicados en el municipio de Valle de Santiago, Guanajuato. Este fenómeno geológico, único en su tipo en México, ha cautivado a visitantes y científicos durante décadas.</p><p>Los cráteres, formados hace miles de años por actividad volcánica, albergan lagos de diferentes colores y profundidades. Cada uno tiene su propia personalidad: desde la Hoya de Cíntora con sus aguas cristalinas, hasta la Hoya de Álvarez con su imponente profundidad.</p><p>La zona fue declarada Área Natural Protegida, lo que garantiza la preservación de este patrimonio natural para las futuras generaciones.</p></div>',
                'content_2' => '<div><p>Para visitar las Siete Luminarias se recomienda llevar calzado cómodo, protector solar y suficiente agua. Los recorridos guiados están disponibles todos los días y parten desde el centro de Valle de Santiago.</p><p>Los guías locales conocen cada rincón de estos cráteres y comparten leyendas fascinantes que han pasado de generación en generación. Una experiencia que no te puedes perder.</p></div>',
                'hero_img' => 'empty-image.jpg',
                'category' => 'Naturaleza',
                'is_fav' => true,
                'is_active' => true,
                'published_at' => '2026-01-15',
                'writer' => 'Dirección de Turismo',
            ],
            [
                'title' => 'Festival de la Gordita: Tradición y sabor en Valle de Santiago',
                'description' => 'Cada año, Valle de Santiago celebra su emblemático Festival de la Gordita, un evento que reúne a los mejores cocineros de la región.',
                'content_1' => '<div><p>El Festival de la Gordita es uno de los eventos gastronómicos más esperados en el Bajío guanajuatense. Durante tres días, las calles del centro histórico se llenan de aromas, colores y sabores que celebran esta delicia culinaria.</p><p>Las gorditas vallenses son famosas por su masa de maíz quebrado, rellenas de chicharrón, frijoles, papa con chorizo y muchas variedades más. Cada puesto ofrece su receta familiar, transmitida por generaciones.</p><p>El festival también incluye música en vivo, artesanías locales y actividades culturales para toda la familia.</p></div>',
                'content_2' => '<div><p>Este año el festival contó con la participación de más de 50 cocineras tradicionales de Valle de Santiago y municipios vecinos. Los visitantes pudieron degustar más de 30 variedades diferentes de gorditas.</p><p>Si planeas visitarnos para el próximo festival, te recomendamos llegar temprano para disfrutar de todas las actividades programadas.</p></div>',
                'hero_img' => 'empty-image.jpg',
                'category' => 'Gastronomía',
                'is_fav' => true,
                'is_active' => true,
                'published_at' => '2026-01-28',
                'writer' => 'Comunicación Social',
            ],
            [
                'title' => 'Centro Histórico de Valle de Santiago: Arquitectura colonial que enamora',
                'description' => 'Un paseo por las calles empedradas del centro histórico revela joyas arquitectónicas del periodo colonial y tradiciones que siguen vivas.',
                'content_1' => '<div><p>El centro histórico de Valle de Santiago es un testimonio vivo de la riqueza cultural e histórica de la región. Sus edificios coloniales, iglesias centenarias y plazas arboladas invitan a caminar sin prisa.</p><p>La Parroquia de Santiago Apóstol, construida en el siglo XVIII, es el corazón espiritual y arquitectónico de la ciudad. Su fachada barroca y su interior decorado con retablos dorados son una visita obligada.</p><p>El Jardín Principal, rodeado de portales con arcos, es el punto de encuentro de vallenses y visitantes. Aquí se puede disfrutar de un café, una nieve artesanal o simplemente observar la vida cotidiana del municipio.</p></div>',
                'content_2' => '<div><p>Otros puntos de interés incluyen el Mercado Municipal, donde se pueden encontrar productos frescos y artesanías; la Casa de la Cultura, que ofrece exposiciones y talleres; y el Museo Comunitario, que resguarda piezas arqueológicas de la región.</p><p>Te invitamos a recorrer nuestras calles y descubrir por qué Valle de Santiago es conocido como la "Atenas de Guanajuato".</p></div>',
                'hero_img' => 'empty-image.jpg',
                'category' => 'Cultura',
                'is_fav' => true,
                'is_active' => true,
                'published_at' => '2026-02-01',
                'writer' => 'Dirección de Turismo',
            ],
            [
                'title' => 'Ruta del Mezcal Artesanal en Valle de Santiago',
                'description' => 'Descubre las destilerías artesanales donde se produce mezcal con técnicas ancestrales que han sobrevivido al paso del tiempo.',
                'content_1' => '<div><p>Valle de Santiago se ha posicionado como un destino emergente para los amantes del mezcal artesanal. Las tierras volcánicas de la región brindan condiciones ideales para el cultivo de diferentes variedades de agave.</p><p>En los últimos años, varias familias productoras han abierto sus puertas al turismo, ofreciendo recorridos por sus destilerías donde se puede conocer todo el proceso de elaboración: desde la jima del agave hasta la destilación en alambiques de cobre.</p></div>',
                'content_2' => '<div><p>La ruta del mezcal incluye degustaciones guiadas donde los visitantes aprenden a distinguir los diferentes perfiles de sabor según el tipo de agave y el método de cocción utilizado.</p><p>Para más información sobre los recorridos y horarios, puedes comunicarte a la Dirección de Turismo Municipal.</p></div>',
                'hero_img' => 'empty-image.jpg',
                'category' => 'Gastronomía',
                'is_fav' => false,
                'is_active' => true,
                'published_at' => '2026-02-05',
                'writer' => 'Dirección de Turismo',
            ],
            [
                'title' => 'Senderismo en la Hoya de Cíntora: Guía para principiantes',
                'description' => 'Todo lo que necesitas saber para disfrutar de una caminata segura y memorable en uno de los cráteres más accesibles de las Siete Luminarias.',
                'content_1' => '<div><p>La Hoya de Cíntora es uno de los cráteres más visitados de las Siete Luminarias gracias a su accesibilidad y la belleza de su lago interior. Es el punto de inicio perfecto para quienes desean explorar esta maravilla natural.</p><p>El sendero principal tiene una longitud aproximada de 3 kilómetros y un nivel de dificultad bajo a moderado. Se recomienda iniciar el recorrido temprano por la mañana para evitar el calor del mediodía.</p><p>Durante el camino podrás observar vegetación endémica, aves migratorias y formaciones rocosas de origen volcánico que cuentan millones de años de historia geológica.</p></div>',
                'content_2' => '<div><p><strong>Recomendaciones:</strong></p><ul><li>Llevar al menos 2 litros de agua por persona</li><li>Usar bloqueador solar y sombrero</li><li>Calzado cerrado con suela antiderrapante</li><li>No dejar basura en el camino</li><li>Respetar la señalización del área protegida</li></ul><p>Los recorridos guiados tienen un costo accesible y apoyan directamente a la economía local.</p></div>',
                'hero_img' => 'empty-image.jpg',
                'category' => 'Naturaleza',
                'is_fav' => false,
                'is_active' => true,
                'published_at' => '2026-02-08',
                'writer' => 'Guías Comunitarios',
            ],
            [
                'title' => 'Fiestas Patronales de Valle de Santiago: Tradición que une al pueblo',
                'description' => 'Las fiestas en honor a Santiago Apóstol son el evento cultural más importante del municipio, con actividades para toda la familia.',
                'content_1' => '<div><p>Cada 25 de julio, Valle de Santiago se viste de fiesta para celebrar a su santo patrono, Santiago Apóstol. Las festividades comienzan días antes con novenas, procesiones y eventos culturales que llenan de alegría cada rincón del municipio.</p><p>La feria tradicional incluye juegos mecánicos, puestos de antojitos mexicanos, eventos charros y presentaciones artísticas. Es una celebración que reúne a familias enteras y atrae visitantes de toda la región.</p></div>',
                'content_2' => '<div><p>Entre los eventos más destacados se encuentran la cabalgata, el torneo de gallos, las serenatas en el jardín principal y los espectaculares castillos de fuegos pirotécnicos elaborados por artesanos locales.</p><p>Las fiestas patronales son una oportunidad perfecta para conocer las tradiciones más arraigadas de Valle de Santiago y convivir con su gente cálida y hospitalaria.</p></div>',
                'hero_img' => 'empty-image.jpg',
                'category' => 'Cultura',
                'is_fav' => false,
                'is_active' => true,
                'published_at' => '2026-02-10',
                'writer' => 'Comunicación Social',
            ],
        ];

        foreach ($posts as $post) {
            TourismBlog::create(array_merge($post, [
                'slug' => Str::slug($post['title']),
            ]));
        }
    }
}
