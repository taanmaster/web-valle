@extends('front.user_profiles.supplier.formats._layout')

@section('title', 'Formato de Datos Bancarios')

@section('content')
    <p class="subtitle">TRANSCRIBIR HOJA MEMBRETADA DEL PROVEEDOR</p>

    <p>(El beneficiario de la cuenta deberá ser igual al nombre que aparece en la cédula fiscal)</p>

    <div class="fields">
        <p>DOMICILIO:</p>
        <p>CALLE:</p>
        <p>NÚMERO EXTERIOR:</p>
        <p>NÚMERO INTERIOR:</p>
        <p>COLONIA:</p>
        <p>CIUDAD:</p>
        <p>DELEGACIÓN O MUNICIPIO:</p>
        <p>CÓDIGO POSTAL:</p>
    </div>

    <div class="fields" style="margin-top: 16pt;">
        <p>RFC:</p>
        <p>TELÉFONO:</p>
        <p>CORREO ELECTRÓNICO:</p>
        <p>BANCO AL QUE SERÁ TRANSFERIDO EL PAGO:</p>
        <p>NÚMERO DE CUENTA:</p>
        <p>SUCURSAL:</p>
        <p>CLABE BANCARIA (18 POSICIONES):</p>
    </div>

    <p style="margin-top: 18pt;">
        Asimismo, declaramos que es nuestra voluntad que los pagos que se hagan a nuestro favor, se realicen
        a la cuenta señalada con anterioridad y en caso de que cambie algún dato de los señalados, lo
        comunicaremos por escrito con <strong>8 días hábiles de anticipación.</strong>
    </p>

    <p class="center" style="margin-top: 24pt;">ATENTAMENTE</p>

    <div class="signature">
        ______________________________________________<br>
        (NOMBRE Y FIRMA DEL PROPIETARIO O REPRESENTANTE<br>
        LEGAL SEGÚN SEA EL CASO)
    </div>

    <p class="note">
        NOTA: Anexo a la presente copia fotostática simple de la carátula del estado de cuenta bancario a
        efecto de que pueda ser verificada la información.
    </p>
@endsection
