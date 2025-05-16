<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<div class="w-full py-8 px-4 sm:px-6 lg:px-8">
    {{-- Alerta --}}
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

    <div class="w-full bg-zinc-900 rounded-xl shadow-2xl overflow-hidden p-6 border border-zinc-800">
        <h1 class="text-2xl font-bold text-white mb-6" data-flux-component="heading">
            Registrar Nuevo Proveedor
        </h1>
        <form action="{{ route('admin.supplier.store') }}" method="POST" class="space-y-6" data-flux-component="form">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Campo RUC -->
                <div data-flux-field>
                    <label for="ruc" class="block text-sm font-medium text-zinc-300 mb-1">
                        RUC de la empresa <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="ruc" name="ruc" pattern="[0-9]{11}" maxlength="11" inputmode="numeric"
                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-white placeholder-zinc-500"
                        placeholder="Ej: 12345678910" required data-flux-control>
                    @error('ruc')
                        <p class="mt-1 text-sm text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>
        
                <!-- Campo Razon Social -->
                <div data-flux-field>
                    <label for="company_name" class="block text-sm font-medium text-zinc-300 mb-1">
                        Razon social <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="company_name" name="company_name" maxlength="255"
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
                    <input type="text" id="address" name="address" maxlength="255"
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
                        <input type="tel" id="phone_number" name="phone_number" pattern="[0-9]{9}" maxlength="9" inputmode="numeric"
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
                    <input type="email" id="email" name="email" maxlength="255"
                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-white placeholder-zinc-500"
                        placeholder="Ej: ejemplo@gmail.com" required data-flux-control>
                    @error('email')
                        <p class="mt-1 text-sm text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        
            <!-- Separador -->
            <div class="relative my-8">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-zinc-800"></div>
                </div>
            </div>
        
            <!-- Nota de campos obligatorios -->
            <div class="text-sm text-zinc-500 mb-6">
                Campos marcados con <span class="text-red-500 font-bold">*</span> son obligatorios
            </div>
        
            <!-- Botón de acción principal -->
            <div class="flex justify-end">
                <button type="submit"
                    class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-zinc-900 transition-all duration-200 shadow-lg hover:shadow-xl"
                    data-flux-component="button">
                    Registrar Proveedor
                </button>
            </div>
        </form>
        
    </div>
</div>
<script>
    document.getElementById('phone_number').addEventListener('input', function (e) {
        e.target.value = e.target.value.replace(/[^0-9]/g, '');
    });
    document.getElementById('ruc').addEventListener('input', function (e) {
        e.target.value = e.target.value.replace(/[^0-9]/g, '');
    });
</script>