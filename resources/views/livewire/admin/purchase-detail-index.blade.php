<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<div class="w-full py-8 px-4 sm:px-6 lg:px-8">
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
            Registrar Detalle de Compra
        </h1>
        <form action="{{ route('admin.purchase_detail.store') }}" method="POST" class="space-y-6" data-flux-component="form">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Campo Compra -->
                <div data-flux-field>
                    <label for="purchase_id" class="block text-sm font-medium text-zinc-300 mb-1" data-flux-label>
                        Compra <span class="text-red-500">*</span>
                    </label>
                    <select id="purchase_id" name="purchase_id"
                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-white"
                        required data-flux-control>
                        <option value="" disabled selected>Seleccione una compra</option>
                        @foreach ($purchases as $purchase)
                            <option value="{{ $purchase->id }}">{{ $purchase->date }} - {{ $purchase->total }} - ({{ $purchase->receipt_type }})</option>
                        @endforeach
                    </select>
                    @error('purchase_id')
                        <p class="mt-1 text-sm text-red-500 font-medium" data-flux-component="error">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Campo Producto -->
                <div data-flux-field>
                    <label for="product_id" class="block text-sm font-medium text-zinc-300 mb-1" data-flux-label>
                        Producto <span class="text-red-500">*</span>
                    </label>
                    <select id="product_id" name="product_id"
                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-white"
                        required data-flux-control>
                        <option value="" disabled selected>Seleccione un producto</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                    @error('product_id')
                        <p class="mt-1 text-sm text-red-500 font-medium" data-flux-component="error">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Campo Cantidad -->
                <div data-flux-field>
                    <label for="quantity" class="block text-sm font-medium text-zinc-300 mb-1" data-flux-label>
                        Cantidad <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="quantity" name="quantity"
                        pattern="\d{1,10}" maxlength="10"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-white placeholder-zinc-500"
                        placeholder="Ej: 5" required value="{{ old('quantity') }}"
                        data-flux-control>
                    @error('quantity')
                        <p class="mt-1 text-sm text-red-500 font-medium" data-flux-component="error">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Campo Precio Unitario -->
                <div data-flux-field>
                    <label for="unitary_cost" class="block text-sm font-medium text-zinc-300 mb-1" data-flux-label>
                        Precio Unitario <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="unitary_cost" name="unitary_cost"
                        pattern="^\d{1,8}(\.\d{0,2})?$"
                        maxlength="11"
                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1').replace(/^0+/, '0');
                                    if (this.value.startsWith('.')) this.value = '0.';
                                    if (this.value.split('.').length > 2) this.value = this.value.slice(0, -1);
                                    if (this.value.split('.')[0].length > 8) this.value = this.value.slice(0, this.value.indexOf('.') > -1 ? this.value.indexOf('.') : 8);"
                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-white placeholder-zinc-500"
                        placeholder="Ej: 50.00" required value="{{ old('unitary_cost') }}"
                        data-flux-control>
                    @error('unitary_cost')
                        <p class="mt-1 text-sm text-red-500 font-medium" data-flux-component="error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
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
                    Registrar Detalle
                </button>
            </div>
        </form>
    </div>
</div>