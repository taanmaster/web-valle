<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Spatie\Permission\Models\Role;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        // Determinar el tipo de usuario (por defecto 'citizen')
        $userType = $input['user_type'] ?? 'citizen';

        // Validación base para todos los usuarios
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
            'captcha' => ['required', 'captcha'],
            'user_type' => ['sometimes', 'string', 'in:citizen,supplier,economist'],
        ];

        // Validación adicional para proveedores
        if ($userType === 'supplier') {
            $rules['person_type'] = ['required', 'string', 'in:fisica,moral'];
            $rules['company_name'] = ['required_if:person_type,moral', 'nullable', 'string', 'max:255'];
            $rules['padron_status'] = ['required', 'string', 'in:con_padron,sin_padron'];
        }

        Validator::make($input, $rules)->validate();

        // Crear el usuario
        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        // Asignar rol según el tipo de usuario (por defecto 'citizen')
        // Para agregar más roles, solo es necesario actualizar la función getRoleNameByUserType de este archivo
        $roleName = $this->getRoleNameByUserType($userType);
        $role = Role::firstOrCreate(['name' => $roleName]);
        $user->assignRole($role);

        // Preparar datos adicionales según el tipo de usuario
        // Para agregar más tipos de datos, solo es necesario actualizar la función prepareAdditionalData de este archivo
        $additionalData = $this->prepareAdditionalData($input, $userType);

        // Crear registro en user_infos
        UserInfo::create([
            'user_id' => $user->id,
            'model_type' => $this->getModelType($userType), // Permite relación polimórfica en UserInfo
            'model_id' => null, // Se puede asignar más tarde si es necesario
            'additional_data' => $additionalData,
        ]);

        return $user;
    }

    /**
     * Obtener el nombre del rol según el tipo de usuario
     * Se pueden agregar más tipos de roles en el arreglo $roleMap
     * de esta forma el sistema es escalable a cualquier tipo de rol posible que requiera autenticación
     * Siempre debe existir un rol por defecto (citizen)
     */
    private function getRoleNameByUserType(string $userType): string
    {
        $roleMap = [
            'citizen' => 'citizen',
            'supplier' => 'supplier',
        ];

        return $roleMap[$userType] ?? 'citizen';
    }

    /**
     * Obtener el tipo de modelo según el tipo de usuario
     * Esto permite una relación polimórfica en UserInfo con la columna model_type
     * Al igual que la función de roles, se puede expandir para más tipos de usuarios y modelos
     */
    private function getModelType(string $userType): ?string
    {
        $modelMap = [
            'citizen' => 'App\Models\Citizen',
            'supplier' => 'App\Models\Supplier'
        ];

        return $modelMap[$userType] ?? null;
    }

    /**
     * Preparar datos adicionales para guardar en JSON
     * Este swtitch permite agregar campos específicos según el tipo de usuario
     * Siguiendo la logica de los roles y modelos, se puede expandir para más tipos de usuarios
     */
    private function prepareAdditionalData(array $input, string $userType): ?array
    {
        $data = [];

        switch ($userType) {
            case 'supplier':
                $data = [
                    'person_type' => $input['person_type'] ?? null,
                    'company_name' => $input['company_name'] ?? null,
                    'padron_status' => $input['padron_status'] ?? null,
                    'registration_date' => now()->toDateString(),
                ];
                break;
            case 'citizen':
            default:
                $data = [
                    'registration_date' => now()->toDateString(),
                ];
                break;
        }

        return !empty($data) ? $data : null;
    }
}
