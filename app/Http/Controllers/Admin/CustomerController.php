<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Container\Attributes\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CustomerController extends Controller
{
    public function index()
    {
        return view("admin.customer.index");
    }

    public function consultarDni(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'dni' => 'required|digits:8',
            'tipo_documento' => 'required|in:DNI,CE',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->first()
            ], 422);
        }

        $dni = $request->input('dni');
        $tipoDocumento = $request->input('tipo_documento');
        $url = "https://api.apis.net.pe/v2/reniec/dni?numero={$dni}";

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('APIS_NET_PE_TOKEN'),
                'Accept' => 'application/json',
            ])->withOptions([
                'verify' => false, // Solo para pruebas locales
            ])->get($url);

            if ($response->successful()) {
                $data = $response->json();
                // Registrar la respuesta completa para depuración
                /**@disregard Undefined method 'info'*/
                Log::info('Respuesta de la API para DNI/CE', [
                    'dni' => $dni,
                    'tipo_documento' => $tipoDocumento,
                    'response' => $data
                ]);

                // Normalizar la respuesta
                $normalizedData = [
                    'numero' => $data['numeroDocumento'] ?? $dni,
                    'nombres' => $data['nombres'] ?? '',
                    'apellidos' => $this->normalizeApellidos($data),
                    'tipo_documento_api' => $data['tipoDocumento'] ?? '',
                    'digito_verificador' => $data['digitoVerificador'] ?? '',
                ];

                return response()->json($normalizedData);
            } else {
                $error = $response->json()['error'] ?? 'Respuesta no válida';
                /**@disregard Undefined method 'error'*/
                Log::error('Error en la consulta a la API', [
                    'dni' => $dni,
                    'status' => $response->status(),
                    'error' => $error
                ]);
                return response()->json([
                    'error' => 'No se pudo consultar el documento: ' . $error
                ], 400);
            }
        } catch (\Exception $e) {
            /**@disregard Undefined method 'error'*/
            Log::error('Excepción al consultar la API', [
                'dni' => $dni,
                'error' => $e->getMessage()
            ]);
            return response()->json([
                'error' => 'Error al consultar el documento: ' . $e->getMessage()
            ], 500);
        }
    }

    private function normalizeApellidos(array $data): string
    {
        // Manejar diferentes estructuras de la respuesta
        if (isset($data['apellidos']) && !empty($data['apellidos'])) {
            return $data['apellidos'];
        }

        // Ajustar para camelCase como devuelve la API
        $apellidoPaterno = $data['apellidoPaterno'] ?? '';
        $apellidoMaterno = $data['apellidoMaterno'] ?? '';
        $apellidos = trim("{$apellidoPaterno} {$apellidoMaterno}");

        if (empty($apellidos)) {
            // Intentar con otros posibles campos
            $apellidos = $data['nombreCompleto'] ?? $data['apellido'] ?? $data['apellidos_completos'] ?? '';
            // Si nombreCompleto está presente, extraer solo los apellidos
            if (!empty($apellidos) && isset($data['nombres'])) {
                $apellidos = str_replace($data['nombres'], '', $apellidos);
                $apellidos = trim($apellidos);
            }
        }

        return $apellidos;
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'tipo_documento' => 'required|in:dni,ruc',
            'numero_documento' => 'required|string|max:15',
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
        ]);

        try {
            $validator->validate();

            $customer = Customer::findOrFail($id);
            $customer->update([
                'tipo_documento' => $request->tipo_documento,
                'numero_documento' => $request->numero_documento,
                'nombres' => $request->nombres,
                'apellidos' => $request->apellidos,
            ]);

            return redirect()->route('admin.customer.index')
                ->with('success', 'El cliente fue actualizado correctamente.');

        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors())->withInput();
        }
    }

    public function destroy(string $id)
    {
        $customer = Customer::find($id)->delete();
        return redirect()->route('admin.customer.index')
            ->with('success', 'El cliente fue eliminado correctamente.');
    }
}
