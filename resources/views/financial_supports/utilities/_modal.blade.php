<div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="modalCreate" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h6 class="modal-title m-0 text-white" id="modalCreate">Nuevo Apoyo Económico</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div><!--end modal-header-->

            <form method="POST" action="{{ route('financial_supports.store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-body pd-25">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="int_num" class="form-label">Folio</label>
                            <input type="text" class="form-control" id="int_num" name="int_num" value="{{ $nextFolio }}" readonly>
                        </div>

                        <div class="col-md-8 mb-3">
                            <label for="citizen_id" class="form-label">Beneficiario</label>
                            <select class="form-control" id="citizen_id" name="citizen_id" required>
                                <option value="">Selecciona una opción</option>
                                @foreach($citizens as $citizen)
                                    <option value="{{ $citizen->id }}">{{ $citizen->name }} {{ $citizen->first_name }} {{ $citizen->last_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{--  
                        <div class="col-md-12 mb-3">
                            <label for="name" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="first_name" class="form-label">Primer Apellido</label>
                            <input type="text" class="form-control" id="first_name" name="first_name">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="last_name" class="form-label">Segundo Apellido</label>
                            <input type="text" class="form-control" id="last_name" name="last_name">
                        </div>
                        
                        <script>
                            document.getElementById('citizen_id').addEventListener('change', function() {
                                var citizenId = this.value;
                                fetch(`/citizens/${citizenId}`)
                                    .then(response => response.json())
                                    .then(data => {
                                        document.getElementById('name').value = data.name;
                                        document.getElementById('first_name').value = data.first_name;
                                        document.getElementById('last_name').value = data.last_name;
                                    });
                            });
                        </script>
                        --}}

                        <div class="col-md-6 mb-3">
                            <label for="qty" class="form-label">Monto del Apoyo</label>
                            <input type="number" class="form-control" id="qty" name="qty" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="receipt_num" class="form-label">Número de Recibo</label>
                            <input type="text" class="form-control" id="receipt_num" name="receipt_num">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="type_id" class="form-label">Tipo de Apoyo</label>
                            <select class="form-control" id="type_id" name="type_id" required>
                                <option value="">Selecciona una opción</option>
                                @foreach($support_types as $support_type)
                                    <option value="{{ $support_type->id }}">{{ $support_type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-de-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-de-dark btn-sm">Guardar datos</button>
                </div>
            </form>
        </div><!--end modal-content-->
    </div><!--end modal-dialog-->
</div><!--end modal-->