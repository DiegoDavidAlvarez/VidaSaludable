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
            Registrar Nuevo Producto
        </h1>
        <form action="{{ route('admin.product.store') }}" method="POST" class="space-y-6" data-flux-component="form">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Campo Categoria -->
                <div data-flux-field>
                    <label for="category_id" class="block text-sm font-medium text-zinc-300 mb-1" data-flux-label>
                        Categoría <span class="text-red-500">*</span> <!-- Campo obligatorio 🌟 -->
                    </label>
                    <select id="category_id" name="category_id" class="w-full px-4 py-3 bg-zinc-800" required data-flux-control>
                        <option value="" disabled selected>Seleccione una categoría</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option> <!-- Muestra el nombre, envía el ID 📚 -->
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-sm text-red-500" data-flux-component="error">{{ $message }}</p> <!-- Muestra error si es inválido 📛 -->
                    @enderror
                </div>
        
                <!-- Campo Proveedor -->
                <div data-flux-field>
                    <label for="supplier_id" class="block text-sm font-medium text-zinc-300 mb-1" data-flux-label>
                        Proveedor <span class="text-red-500">*</span> <!-- Campo obligatorio 🌟 -->
                    </label>
                    <select id="supplier_id" name="supplier_id" class="w-full px-4 py-3 bg-zinc-800" required data-flux-control>
                        <option value="" disabled selected>Seleccione un proveedor</option>
                        @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->company_name }}</option> <!-- Muestra el nombre, envía el ID 📚 -->
                        @endforeach
                    </select>
                    @error('supplier_id')
                        <p class="mt-1 text-sm text-red-500" data-flux-component="error">{{ $message }}</p> <!-- Muestra error si es inválido 📛 -->
                    @enderror
                </div>
                
                {{-- Campo Nombre --}}
                <div data-flux-field>
                    <label for="name" class="block text-sm font-medium text-zinc-300 mb-1" data-flux-label>
                        Nombre del producto <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="name" name="name"
                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-white placeholder-zinc-500"
                        placeholder="Ej: Paracetamol" required data-flux-control>
                    @error('name')
                        <p class="mt-1 text-sm text-red-500 font-medium" data-flux-component="error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Campo Precio de venta --}}
                <div data-flux-field>
                    <label for="sale_price" class="block text-sm font-medium text-zinc-300 mb-1" data-flux-label>
                        Precio de venta <span class="text-red-500">*</span>
                    </label>
                    <input type="number" step="0.01" id="sale_price" name="sale_price"
                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-white placeholder-zinc-500"
                        placeholder="Ej: 0.50" required data-flux-control>
                    @error('sale_price')
                        <p class="mt-1 text-sm text-red-500 font-medium" data-flux-component="error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Campo Precio de compra --}}
                <div data-flux-field>
                    <label for="purchase_prise" class="block text-sm font-medium text-zinc-300 mb-1" data-flux-label>
                        Precio de compra <span class="text-red-500">*</span>
                    </label>
                    <input type="number" step="0.01" id="purchase_prise" name="purchase_prise"
                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-white placeholder-zinc-500"
                        placeholder="Ej: 0.50" required data-flux-control>
                    @error('purchase_prise')
                        <p class="mt-1 text-sm text-red-500 font-medium" data-flux-component="error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Campo Stock--}}
                <div data-flux-field>
                    <label for="stock" class="block text-sm font-medium text-zinc-300 mb-1" data-flux-label>
                        Stock <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="stock" name="stock"
                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-white placeholder-zinc-500"
                        placeholder="Ej: 20" required data-flux-control>
                    @error('stock')
                        <p class="mt-1 text-sm text-red-500 font-medium" data-flux-component="error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Campo Stock minimo--}}
                <div data-flux-field>
                    <label for="min_stock" class="block text-sm font-medium text-zinc-300 mb-1" data-flux-label>
                        Stock minimo <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="min_stock" name="min_stock"
                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-white placeholder-zinc-500"
                        placeholder="Ej: 5" required data-flux-control>
                    @error('min_stock')
                        <p class="mt-1 text-sm text-red-500 font-medium" data-flux-component="error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Campo Descripcion--}}
            <div data-flux-field>
                <label for="description" class="block text-sm font-medium text-zinc-300 mb-1" data-flux-label>
                    Descripción <span class="text-red-500">*</span>
                </label>
                <textarea id="description" name="description" rows="3"
                    class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-white placeholder-zinc-500"
                    placeholder="Describe el producto (opcional)" data-flux-control></textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-500 font-medium" data-flux-component="error">{{ $message }}</p>
                @enderror
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
                    Registrar Producto
                </button>
        </form>
        
    </div>
</div>
