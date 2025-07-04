<div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="modalCreate" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h6 class="modal-title m-0 text-white" id="modalCreate">Nuevo Doctor</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div><!--end modal-header-->

            <form method="POST" action="{{ route('dif.doctors.store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-body pd-25">
                    <div class="row">
                        
                        <div class="col-md-12 mb-3">
                            <label for="name" class="form-label">Nombre Completo <span class="text-danger tx-12">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="specialty_id" class="form-label">Especialidad <span class="text-danger tx-12">*</span></label>
                            <select class="form-control" id="specialty_id" name="specialty_id" required>
                                <option value="">Seleccionar especialidad...</option>
                                @foreach(\App\Models\DIFSpecialty::all() as $specialty)
                                    <option value="{{ $specialty->id }}">{{ $specialty->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Teléfono <span class="text-danger tx-12">*</span></label>
                            <input type="text" class="form-control" id="phone" name="phone">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="full_address" class="form-label">Dirección Completa <span class="text-info tx-12">(Opcional)</span></label>
                            <textarea class="form-control" id="full_address" name="full_address" rows="3"></textarea>
                        </div>

                        <hr>

                        <h3>Accesos</h3>
                        <p>El doctor podrá entrar a su perfil de empleado usando su correo electrónico y la siguiente contraseña:</p>
                        
                        <div class="col-md-12 mb-3">
                            <label for="email" class="form-label">Correo Electrónico <span class="text-danger tx-12">*</span></label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">Contraseña <span class="text-danger tx-12">*</span></label>
                            <input type="text" class="form-control" id="password" name="password" value="{{ Str::random(8) }}" required>
                            <small class="form-text text-muted">Se generó una contraseña automáticamente. Puedes modificarla si lo deseas.</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation" class="form-label">Confirmar Contraseña <span class="text-danger tx-12">*</span></label>
                            <input type="text" class="form-control" id="password_confirmation" name="password_confirmation" required>
                        </div>

                        <hr>
                        
                        <div class="col-md-12 mb-3">
                            <label for="employee_num" class="form-label">Número de Empleado <span class="text-info tx-12">(Generado automáticamente)</span></label>
                            <input type="text" class="form-control" id="employee_num" name="employee_num" value="{{ Str::random(8) }}" readonly>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-dark btn-sm">Guardar datos</button>
                </div>
            </form>
        </div><!--end modal-content-->
    </div><!--end modal-dialog-->
</div><!--end modal-->

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Función para generar contraseña aleatoria
    function generatePassword(length = 8) {
        const charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        let password = '';
        for (let i = 0; i < length; i++) {
            password += charset.charAt(Math.floor(Math.random() * charset.length));
        }
        return password;
    }

    // Sincronizar contraseña cuando se cambie
    const passwordField = document.getElementById('password');
    const confirmPasswordField = document.getElementById('password_confirmation');
    
    if (passwordField && confirmPasswordField) {
        // Establecer la contraseña de confirmación inicial
        confirmPasswordField.value = passwordField.value;
        
        // Botón para generar nueva contraseña
        const generateBtn = document.createElement('button');
        generateBtn.type = 'button';
        generateBtn.className = 'btn btn-outline-secondary btn-sm mt-1';
        generateBtn.innerHTML = 'Generar nueva';
        generateBtn.onclick = function() {
            const newPassword = generatePassword();
            passwordField.value = newPassword;
            confirmPasswordField.value = newPassword;
        };
        
        // Agregar el botón después del campo de contraseña
        passwordField.parentNode.appendChild(generateBtn);
    }
});
</script>
