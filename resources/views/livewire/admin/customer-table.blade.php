<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<div class="w-full py-8 px-4 sm:px-6 lg:px-8" x-data="customerTable()">
    <!-- Notificaciones -->
    @if (session('success'))
        <script>
            Swal.fire({
                icon: "success",
                title: "¡Éxito!",
                text: "{{ session('success') }}",
                background: '#18181b',
                color: '#f4f4f5',
                iconColor: '#22c55e',
                confirmButtonColor: '#3b82f6',
                customClass: {
                    popup: 'rounded-lg shadow-lg'
                }
            });
        </script>
    @endif

    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                html: '<ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
                background: '#18181b',
                color: '#f4f4f5',
                iconColor: '#ef4444',
                confirmButtonColor: '#3b82f6',
                customClass: {
                    popup: 'rounded-lg shadow-lg text-left'
                }
            });
        </script>
    @endif

    <!-- Tabla de Detalles de Compra -->
    <div class="w-full bg-zinc-900 rounded-xl shadow-2xl overflow-hidden p-6 border border-zinc-800">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-white" data-flux-component="heading">
                Lista de Clientes
            </h1>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-zinc-800">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">#</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Tipo de documento</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">n° documento</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Nombres</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Apellidos</th>
                        <th class="px-4 py-3 text-right text-sm font-medium text-zinc-300 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-800">
                    @foreach ($customers as $customer)
                        <tr>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $loop->iteration }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $customer->tipo_documento }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $customer->numero_documento }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $customer->nombres }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $customer->apellidos }}</td>
                            <td class="px-4 py-4 text-sm text-right">
                                <!-- Botón Editar -->
                                <button
                                    @click="openModal({{ $customer->id }}, {{ $customer->tipo_documento }}, {{ $customer->numero_documento }}, {{ $customer->nombres }}, {{ $customer->apellidos }})"
                                    class="text-blue-500 hover:text-blue-400 mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path
                                            d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>
                                </button>

                                <!-- Botón Eliminar -->
                                <button onclick="confirmDelete({{ $customer->id }})"
                                    class="text-red-500 hover:text-red-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>

                                <!-- Formulario Eliminar (oculto) -->
                                <form id="delete-form-{{ $customer->id }}"
                                    action="{{ route('admin.customer.destroy', $customer->id) }}" method="POST"
                                    class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        @if ($customers->hasPages())
            <div class="mt-6">
                {{ $customers->links() }}
            </div>
        @endif
    </div>

    <!-- Modal de Edición -->
    <template x-teleport="body">
        <div x-show="isOpen" x-cloak x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Fondo oscuro -->
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-black opacity-75" @click="closeModal"></div>
                </div>

                <!-- Contenido del Modal -->
                <div
                    class="inline-block align-bottom bg-zinc-900 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full border border-zinc-800">
                    <form :action="'/admin/customer/' + currentId" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="px-8 py-8">
                            <h3 class="text-xl font-semibold text-white mb-6">Editar Detalle de Compra</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Campo Compra -->
                                <div data-flux-field>
                                    <label for="tipo_documento" class="block text-sm font-medium text-zinc-300 mb-1" data-flux-label>
                                        Tipo de documento <span class="text-red-500">*</span>
                                    </label>
                                    <select id="tipo_documento" name="tipo_documento" x-model="currentDocumentType"
                                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-white"
                                        required data-flux-control>
                                        <option value="" disabled selected>Seleccione una compra</option>
                                        <option value="dni">DNI</option>
                                        <option value="ruc">RUC</option>
                                    </select>
                                    @error('tipo_documento')
                                        <p class="mt-1 text-sm text-red-500 font-medium" data-flux-component="error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <!-- Campo Producto -->
                                <div data-flux-field>
                                    <label for="numero_documento" class="block text-sm font-medium text-zinc-300 mb-1" data-flux-label>
                                        Numero de documento <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" id="numero_documento" name="numero_documento" x-model="currentDocumentNumber"
                                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-white placeholder-zinc-500"
                                        placeholder="Ej: 1234567" required min="1" value="{{ old('numero_documento') }}"
                                        data-flux-control>
                                    @error('numero_documento')
                                        <p class="mt-1 text-sm text-red-500 font-medium" data-flux-component="error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <!-- Campo Cantidad -->
                                <div data-flux-field>
                                    <label for="nombres" class="block text-sm font-medium text-zinc-300 mb-1" data-flux-label>
                                        Nombres <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="nombres" name="nombres" x-model="currentNames"
                                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-white placeholder-zinc-500"
                                        placeholder="Ej: Pedro" required min="1" value="{{ old('nombres') }}"
                                        data-flux-control>
                                    @error('nombres')
                                        <p class="mt-1 text-sm text-red-500 font-medium" data-flux-component="error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div data-flux-field>
                                    <label for="apellidos" class="block text-sm font-medium text-zinc-300 mb-1" data-flux-label>
                                        Apellidos <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="apellidos" name="apellidos" x-model="currentLastNames"
                                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-white placeholder-zinc-500"
                                        placeholder="Ej: Perez" required min="1" value="{{ old('apellidos') }}"
                                        data-flux-control>
                                    @error('apellidos')
                                        <p class="mt-1 text-sm text-red-500 font-medium" data-flux-component="error">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="px-8 py-4 bg-zinc-800 flex justify-end space-x-4">
                            <button type="button" @click="closeModal" class="px-6 py-3 text-zinc-300 hover:text-white">
                                Cancelar
                            </button>
                            <button type="submit"
                                class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </template>
</div>

<script>
    // Función para confirmar eliminación
    function confirmDelete(id) {
        Swal.fire({
            title: '¿Eliminar detalle de compra?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            background: '#18181b',
            color: '#f4f4f5',
            iconColor: '#ef4444',
            confirmButtonColor: '#3b82f6',
            cancelButtonColor: '#6b7280',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            customClass: {
                popup: 'rounded-lg shadow-lg'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }

    // Componente Alpine.js para la tabla de detalles
    function customerTable() {
        return {
            isOpen: false,
            currentId: null,
            currentDocumentType: null,
            currentDocumentNumber: null,
            currentNames: null,
            currentLastNames: null,

            openModal(id, tipo_documento, numero_documento, nombres, apellidos) {
                this.currentId = id;
                this.currentDocumentType = tipo_documento;
                this.currentDocumentNumber = numero_documento;
                this.currentNames = nombres;
                this.currentLastNames = apellidos;
                this.isOpen = true;
                document.body.classList.add('overflow-hidden');
            },

            closeModal() {
                this.isOpen = false;
                document.body.classList.remove('overflow-hidden');
            }
        }
    }
</script>