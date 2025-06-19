<div class="w-full py-8 px-4 sm:px-6 lg:px-8" x-data="productTable()">
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

    <!-- Tabla de Productos -->
    <div class="w-full bg-zinc-900 rounded-xl shadow-2xl overflow-hidden p-6 border border-zinc-800">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-white" data-flux-component="heading">
                Lista de Productos
            </h1>
            <div class="space-x-2">
                <a href="{{ route('admin.product.export-pdf') }}"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Exportar PDF
                </a>
                <a href="{{ route('admin.product.export-excel') }}"
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
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Categoria</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Proveedor</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Nombre</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Descripción</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Codigo de barra</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Precio venta</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Precio compra</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Stock</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Stock minimo</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-zinc-300 uppercase">Estado</th>
                        <th class="px-4 py-3 text-right text-sm font-medium text-zinc-300 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-800">
                    @foreach ($products as $product)
                        <tr>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $loop->iteration }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ Str::limit($product->category->name, 20)}}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ Str::limit($product->supplier->company_name, 20)}}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $product->name }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $product->description }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $product->bar_code }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $product->sale_price }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $product->purchase_price }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $product->stock }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $product->min_stock }}</td>
                            <td class="px-4 py-4">
                                <span
                                    class="px-2 py-1 text-xs rounded-full {{ $product->status ? 'bg-green-900 text-green-300' : 'bg-red-900 text-red-300' }}">
                                    {{ $product->status ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td class="px-4 py-4 text-sm text-right">
                                <!-- Botón Editar -->
                                <button
                                    class="text-blue-500 hover:text-blue-400 mr-3"
                                    @click="openModal({{ $product->id }}, 
                                    '{{ addslashes($product->category->id) }}', 
                                    '{{ addslashes($product->supplier->id) }}', 
                                    '{{ addslashes($product->name) }}', 
                                    '{{ addslashes($product->description) }}', 
                                    '{{ addslashes($product->bar_code) }}', 
                                    '{{ addslashes($product->sale_price) }}', 
                                    '{{ addslashes($product->purchase_price) }}', 
                                    '{{ addslashes($product->stock) }}', 
                                    '{{ addslashes($product->min_stock) }}')">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path
                                            d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>
                                </button>
                                <!-- Botón Eliminar -->
                                <button onclick="confirmDelete({{ $product->id }})"
                                    class="text-red-500 hover:text-red-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <!-- Formulario Eliminar (oculto) -->
                                <form id="delete-form-{{ $product->id }}"
                                    action="{{ route('admin.product.destroy', $product->id) }}" method="POST"
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
        @if ($products->hasPages())
            <div class="mt-6">
                {{ $products->links() }}
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
                <div
                    class="inline-block align-bottom bg-zinc-900 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full border border-zinc-1000">
                    <form :action="'/admin/product/' + currentId" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="px-8 py-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Campo Categoría -->
                                <div data-flux-field>
                                    <label for="category_id" class="block text-sm font-medium text-zinc-300 mb-1" data-flux-label>
                                        Categoría <span class="text-red-500">*</span>
                                    </label>
                                    <select id="category_id" name="category_id" x-model="currentCategoryId"
                                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-white"
                                        required data-flux-control>
                                        <option value="" disabled >Seleccione una categoria</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <p class="mt-1 text-sm text-red-500 font-medium" data-flux-component="error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <!-- Campo Proveedor -->
                                <div data-flux-field>
                                    <label for="supplier_id" class="block text-sm font-medium text-zinc-300 mb-1" data-flux-label>
                                        Proveedor <span class="text-red-500">*</span>
                                    </label>
                                    <select id="supplier_id" name="supplier_id" x-model="currentSupplierId"
                                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-white"
                                        required data-flux-control>
                                        <option value="" disabled>Seleccione un proveedor</option>
                                        @foreach ($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}">{{ $supplier->company_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('supplier_id')
                                        <p class="mt-1 text-sm text-red-500 font-medium" data-flux-component="error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <!-- Campo Nombre -->
                                <div data-flux-field>
                                    <label for="name" class="block text-sm font-medium text-zinc-300 mb-1" data-flux-label>
                                        Nombre <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="name" name="name" x-model="currentName" maxlength="255"
                                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-white placeholder-zinc-500"
                                        placeholder="Ej: Paracetamol 500mg" required data-flux-control>
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-500 font-medium" data-flux-component="error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <!-- Campo Código de Barra -->
                                <div data-flux-field>
                                    <label for="bar_code" class="block text-sm font-medium text-zinc-300 mb-1" data-flux-label>
                                        Código de Barra <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="bar_code" name="bar_code" x-model="currentBarCode"
                                        pattern="\d{1,50}" maxlength="50"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-white placeholder-zinc-500"
                                        placeholder="Ej: 012345678912" required data-flux-control>
                                    @error('bar_code')
                                        <p class="mt-1 text-sm text-red-500 font-medium" data-flux-component="error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <!-- Campo Precio de Venta -->
                                <div data-flux-field>
                                    <label for="sale_price" class="block text-sm font-medium text-zinc-300 mb-1" data-flux-label>
                                        Precio de Venta <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="sale_price" name="sale_price" x-model="currentSalePrice"
                                        pattern="^\d{1,8}(\.\d{0,2})?$"
                                        maxlength="11"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1').replace(/^0+/, '0');
                                                if (this.value.startsWith('.')) this.value = '0.';
                                                if (this.value.split('.').length > 2) this.value = this.value.slice(0, -1);
                                                if (this.value.split('.')[0].length > 8) this.value = this.value.slice(0, this.value.indexOf('.') > -1 ? this.value.indexOf('.') : 8);"
                                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-white placeholder-zinc-500"
                                        placeholder="Ej: 12.50" required data-flux-control>
                                    @error('sale_price')
                                        <p class="mt-1 text-sm text-red-500 font-medium" data-flux-component="error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <!-- Campo Precio de Compra -->
                                <div data-flux-field>
                                    <label for="purchase_price" class="block text-sm font-medium text-zinc-300 mb-1" data-flux-label>
                                        Precio de Compra <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="purchase_price" name="purchase_price" x-model="currentPurchasePrice"
                                        pattern="^\d{1,8}(\.\d{0,2})?$"
                                        maxlength="11"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1').replace(/^0+/, '0');
                                                if (this.value.startsWith('.')) this.value = '0.';
                                                if (this.value.split('.').length > 2) this.value = this.value.slice(0, -1);
                                                if (this.value.split('.')[0].length > 8) this.value = this.value.slice(0, this.value.indexOf('.') > -1 ? this.value.indexOf('.') : 8);"
                                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-white placeholder-zinc-500"
                                        placeholder="Ej: 10.00" required data-flux-control>
                                    @error('purchase_price')
                                        <p class="mt-1 text-sm text-red-500 font-medium" data-flux-component="error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <!-- Campo Stock -->
                                <div data-flux-field>
                                    <label for="stock" class="block text-sm font-medium text-zinc-300 mb-1" data-flux-label>
                                        Stock <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="stock" name="stock" x-model="currentStock"
                                        pattern="\d{1,10}" maxlength="10"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-white placeholder-zinc-500"
                                        placeholder="Ej: 100" required data-flux-control>
                                    @error('stock')
                                        <p class="mt-1 text-sm text-red-500 font-medium" data-flux-component="error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <!-- Campo Stock Mínimo -->
                                <div data-flux-field>
                                    <label for="min_stock" class="block text-sm font-medium text-zinc-300 mb-1" data-flux-label>
                                        Stock Mínimo <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="min_stock" name="min_stock" x-model="currentMinStock"
                                        pattern="\d{1,10}" maxlength="10"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                        class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-white placeholder-zinc-500"
                                        placeholder="Ej: 10" required data-flux-control>
                                    @error('min_stock')
                                        <p class="mt-1 text-sm text-red-500 font-medium" data-flux-component="error">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <!-- Campo Descripción -->
                            <div data-flux-field>
                                <label for="description" class="block text-sm font-medium text-zinc-300 mb-1" data-flux-label>
                                    Descripción
                                </label>
                                <textarea id="description" name="description" rows="4" x-model="currentDescription"
                                    class="w-full px-4 py-3 bg-zinc-800 border border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-white placeholder-zinc-500"
                                    placeholder="Ej: Tabletas para el dolor de cabeza" data-flux-control></textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-500 font-medium" data-flux-component="error">{{ $message }}</p>
                                @enderror
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
            title: '¿Eliminar producto?',
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
    function productTable() {
        return {
            isOpen: false,
            currentId: null,
            currentCategoryId: null,
            currentSupplierId: null,
            currentName: null,
            currentDescription: null,
            currentBarCode: null,
            currentSalePrice: null,
            currentPurchasePrice: null,
            currentStock: null,
            currentMinStock: null,

            openModal(id, currentCategoryId, currentSupplierId, name, description, barCode, salePrice, purchasePrice, stock, minStock) {
                this.currentId = id;
                this.currentCategoryId = currentCategoryId;
                this.currentSupplierId = currentSupplierId;
                this.currentName = name;
                this.currentDescription = description;
                this.currentBarCode = barCode;
                this.currentSalePrice = salePrice;
                this.currentPurchasePrice = purchasePrice;
                this.currentStock = stock;
                this.currentMinStock = minStock;
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