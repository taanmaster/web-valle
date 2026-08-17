<?php

use App\Models\EnvironmentRequest;

return [

    /*
    |--------------------------------------------------------------------------
    | Trámites de la Dirección de Medio Ambiente
    |--------------------------------------------------------------------------
    |
    | Contenido de las páginas públicas de cada trámite. Los tres son
    | gratuitos: la "compensación" de Tala es la donación de árboles
    | endémicos, no un cobro, y por eso el módulo no toca el carrito ni el
    | checkout.
    |
    | La clave del arreglo es el slug público. `type` es el valor que se
    | guarda en environment_requests.request_type.
    |
    */

    'procedures' => [

        'poda' => [
            'type' => EnvironmentRequest::TYPE_PODA,
            'title' => 'Proceso para solicitud de poda',
            'short_title' => 'Poda',
            'icon' => 'leaf-outline',
            'form_title' => 'Nueva Solicitud de Permiso de Poda',
            'steps' => [
                ['title' => 'Registra tu solicitud', 'text' => 'Completa el formulario en línea con la información requerida.'],
                ['title' => 'Inspección del árbol', 'text' => 'Personal de la Dirección realiza una visita al sitio para evaluar el estado del árbol y documentarlo mediante fotografías.'],
                ['title' => 'Evaluación', 'text' => 'La solicitud es revisada para determinar si la poda es procedente. El tiempo de respuesta es de hasta 15 días hábiles.'],
                ['title' => 'Autorización', 'text' => 'Si la solicitud es aprobada, se emite el permiso correspondiente con las recomendaciones para realizar una poda adecuada.'],
                ['title' => 'Notificación', 'text' => 'Se informa al solicitante por la plataforma del usuario con el resultado de su trámite.'],
            ],
            'cost' => [
                'label' => 'Sin costo.',
                'note' => 'Importante: la poda debe realizarse siguiendo las indicaciones de la Dirección de Medio Ambiente para evitar daños al árbol.',
            ],
        ],

        'tala' => [
            'type' => EnvironmentRequest::TYPE_TALA,
            'title' => 'Proceso para solicitud de tala',
            'short_title' => 'Tala',
            'icon' => 'hammer-outline',
            'form_title' => 'Nueva Solicitud de Permiso de Tala',
            'steps' => [
                ['title' => 'Registra tu solicitud', 'text' => 'Completa el formulario en línea con la información requerida.'],
                ['title' => 'Inspección del árbol', 'text' => 'Personal de la Dirección realiza una visita al sitio para evaluar el estado del árbol y documentarlo mediante fotografías.'],
                ['title' => 'Evaluación', 'text' => 'La solicitud se analiza para determinar si la tala es viable conforme a la normativa vigente. El tiempo de respuesta es de hasta 15 días hábiles.'],
                ['title' => 'Autorización', 'text' => 'En caso de ser aprobada, se emite el permiso oficial para realizar la tala.'],
                ['title' => 'Cumplimiento de la compensación', 'text' => 'Como requisito, el solicitante deberá realizar la donación de 20 árboles endémicos, de acuerdo con lo establecido en el reglamento aplicable.'],
                ['title' => 'Notificación', 'text' => 'Se informa al solicitante por la plataforma del usuario con el resultado de su trámite.'],
            ],
            'cost' => [
                'label' => 'No tiene costo económico. La compensación se realiza mediante la donación de 20 árboles endémicos, conforme al reglamento vigente.',
                'note' => null,
            ],
        ],

        'donacion-de-arboles' => [
            'type' => EnvironmentRequest::TYPE_DONACION,
            'title' => 'Proceso para solicitud de donación de árboles',
            'short_title' => 'Donación de Árboles',
            'icon' => 'flower-outline',
            'form_title' => 'Nueva Solicitud de Donación',
            'steps' => [
                ['title' => 'Registra tu solicitud', 'text' => 'Completa el formulario en línea indicando la cantidad y especie de árboles solicitados, lugar de plantación y comunidad donde serán destinados.'],
                ['title' => 'Adjunta tus documentos', 'text' => 'Carga una copia de tu identificación oficial (INE) y acepta la carta compromiso para el cuidado y mantenimiento de los árboles.'],
                ['title' => 'Revisión de disponibilidad', 'text' => 'La Dirección de Medio Ambiente verificará la existencia de las especies y cantidades solicitadas en el vivero municipal.'],
                ['title' => 'Evaluación y autorización', 'text' => 'La solicitud será evaluada considerando la disponibilidad, cantidad solicitada y lugar de residencia del solicitante. La Dirección determinará la cantidad y especies que podrán ser otorgadas.'],
                ['title' => 'Recibe tu autorización', 'text' => 'Si la solicitud es aprobada y existe disponibilidad, recibirás tu vale de autorización digital con las indicaciones para recoger los árboles en el vivero municipal.'],
            ],
            'cost' => null,
            'warning' => [
                'title' => '¿Qué pasa si no hay disponibilidad?',
                'text' => 'Tu solicitud permanecerá registrada y recibirás una notificación cuando existan árboles disponibles para continuar con el proceso.',
            ],
            'notice' => 'Importante: la cantidad y especies otorgadas están sujetas a disponibilidad y autorización. Las solicitudes podrán ser rechazadas cuando excedan las cantidades permitidas o no cumplan con los requisitos establecidos.',
            'has_floristic_list' => true,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Listado florístico
    |--------------------------------------------------------------------------
    |
    | Documento que proporciona la Dirección. El botón lo descarga directo.
    |
    */

    'floristic_list_file' => 'front/docs/listado-floristico.pdf',

];
