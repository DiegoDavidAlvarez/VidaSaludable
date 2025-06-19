<div class="w-full py-8 px-4 sm:px-6 lg:px-8" x-data="supplierTable()">
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

    <!-- Tabla de Proveedores -->
    <div class="w-full bg-zinc-900 rounded-xl shadow-2xl overflow-hidden p-6 border border-zinc-800">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-white" data-flux-component="heading">
                Lista de Proveedores
            </h1>
            <div class="space-x-2">
                <a href="{{ route('admin.supplier.export-pdf') }}"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Exportar PDF
                </a>
    
                <a href="{{ route('admin.supplier.export-excel') }}"
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    Exportar Excel
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-zinc-800">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">#</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">RUC</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Razon social</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Dirección</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Teléfono</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Email</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Estado</th>
                        <th class="px-4 py-3 text-right text-sm font-medium text-zinc-300 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-800">
                    @foreach ($suppliers as $supplier)
                        <tr>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $loop->iteration }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $supplier->ruc }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $supplier->company_name }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $supplier->address }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $supplier->phone_number }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $supplier->email }}</td>
                            </td>
                            <td class="px-4 py-4">
                                <span
                                    class="px-2 py-1 text-xs rounded-full {{ $supplier->status ? 'bg-green-900 text-green-300' : 'bg-red-900 text-red-300' }}">
                                    {{ $supplier->status ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td class="px-4 py-4 text-sm text-right">
                                <!-- Botón Editar -->
                                <button 
                                    class="text-blue-500 hover:text-blue-400 mr-3"
                                    @click="openModal({{ $supplier->id }}, 
                                    '{{ addslashes($supplier->ruc) }}', 
                                    '{{ addslashes($supplier->company_name) }}', 
                                    '{{ addslashes($supplier->address) }}', 
                                    '{{ addslashes($supplier->phone_number) }}', 
                                    '{{ addslashes($supplier->email) }}')"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>
                                </button>

                                <!-- Botón Eliminar -->
                                <button onclick="confirmDelete({{ $supplier->id }})"
                                    class="text-red-500 hover:text-red-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>

                                <!-- Formulario Eliminar (oculto) -->
                                <form id="delete-form-{{ $supplier->id }}"
                                    action="{{ route('admin.supplier.destroy', $supplier->id) }}" method="POST"
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
        @if ($suppliers->hasPages())
            <div class="mt-6">
                {{ $suppliers->links() }}
            </div>
        @endif
    </div>

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
                <div class="inline-block align-bottom bg-zinc-900 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full border border-zinc-800">
                    <form :action="'/admin/supplier/' + currentId" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="px-8 py-8">
                            <h3 class="text-xl font-semibold text-white mb-6">Editar Proveedor</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Campo RUC -->
                                <div data-flux-field>
                                    <label for="ruc" class="block text-sm font-medium text-zinc-300 mb-1">
                                        RUC de la empresa <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="ruc" name="ruc"
                                        x-model="currentRuc" class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-white placeholder-zinc-500"
                                        placeholder="Ej: 12345678910" required pattern="\d{11}" maxlength="11" oninput="this.value = this.value.replace(/[^0-9]/g, '')" data-flux-control>
                                    @error('ruc')
                                        <p class="mt-1 text-sm text-red-500 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Campo Razon Social -->
                                <div data-flux-field>
                                    <label for="company_name" class="block text-sm font-medium text-zinc-300 mb-1">
                                        Razon social <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="company_name" name="company_name"
                                        x-model="currentCompanyName" maxlength="255"
                                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-white placeholder-zinc-500"
                                        placeholder="Ej: Ferreteria Pedro" required data-flux-control>
                                    @error('company_name')
                                        <p class="mt-1 text-sm text-red-500 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Campo Dirección -->
                                <div data-flux-field>
                                    <label for="address" class="block text-sm font-medium text-zinc-300 mb-1">
                                        Dirección <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="address" name="address"
                                        x-model="currentAddress" maxlength="255"
                                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-white placeholder-zinc-500"
                                        placeholder="Ej: Calle 123 Cusco" required data-flux-control>
                                    @error('address')
                                        <p class="mt-1 text-sm text-red-500 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Campo Teléfono -->
                                <div data-flux-field>
                                    <label for="phone_number" class="block text-sm font-medium text-zinc-300 mb-1">
                                        N° Teléfono <span class="text-red-500">*</span>
                                    </label>
                                    <div class="flex items-center">
                                        <span class="px-4 py-3 inline-flex items-center bg-zinc-700 text-white border border-r-0 border-zinc-600 rounded-l-lg text-sm">
                                            +51
                                        </span>
                                        <input type="tel" id="phone_number" name="phone_number"
                                            pattern="\d{9}" maxlength="9"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                            x-model="currentPhoneNumber"
                                            class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-r-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-white placeholder-zinc-500"
                                            placeholder="Ej: 987654321" required data-flux-control>
                                    </div>
                                    @error('phone_number')
                                        <p class="mt-1 text-sm text-red-500 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Campo Email -->
                                <div class="md:col-span-2" data-flux-field>
                                    <label for="email" class="block text-sm font-medium text-zinc-300 mb-1">
                                        Email <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" id="email" name="email"
                                        x-model="currentEmail" maxlength="255"
                                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-white placeholder-zinc-500"
                                        placeholder="Ej: ejemplo@gmail.com" required data-flux-control>
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-500 font-medium">{{ $message }}</p>
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
            title: '¿Eliminar Proveedor?',
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

    // Componente Alpine.js para la tabla
    function supplierTable() {
        return {
            isOpen: false,
            currentId: null,
            currentRuc: '',
            currentCompanyName: '',
            currentAddress: '',
            currentPhoneNumber: '',
            currentEmail: '',

            openModal(id, ruc, company_name, address, phone_number, email) {
                this.currentId = id;
                this.currentRuc = ruc;
                this.currentCompanyName = company_name;
                this.currentAddress = address;
                this.currentPhoneNumber = phone_number;
                this.currentEmail = email;
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
