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
                        <th class="px-4 py-3 text-right text-sm font-medium text-zinc-300 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-800">
                    @foreach ($products as $product)
                        <tr>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $loop->iteration }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ Str::limit($product->category->name, 20)}}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ Str::limit($product->supplier->razon_social, 20)}}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $product->name }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $product->description }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $product->sale_price }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-300">{{ $product->purchase_prise }}</td>
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
                                    @click="openModal({{ $product->id }}, '{{ addslashes($product->name) }}', '{{ addslashes($product->description) }}')"
                                    class="text-blue-500 hover:text-blue-400 mr-3">
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
                    class="inline-block align-bottom bg-zinc-900 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full border border-zinc-800">
                    <form :action="'/admin/product/' + currentId" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="px-8 py-8">
                            <h3 class="text-xl font-semibold text-white mb-6">Editar Producto</h3>

                            <!-- Campo Categoria -->
                            <div data-flux-field>
                                <label for="category_id" class="block text-sm font-medium text-zinc-300 mb-1">
                                    Categoría <span class="text-red-500">*</span> <!-- Campo obligatorio 🌟 -->
                                </label>
                                <select id="category_id" name="category_id" class="w-full px-4 py-3 bg-zinc-800" required>
                                    <option value="" disabled selected>Seleccione una categoría</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option> <!-- Muestra el nombre, envía el ID 📚 -->
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p> <!-- Muestra error si es inválido 📛 -->
                                @enderror
                            </div>
                    
                            <!-- Campo Proveedor -->
                            <div data-flux-field>
                                <label for="supplier_id" class="block text-sm font-medium text-zinc-300 mb-1">
                                    Proveedor <span class="text-red-500">*</span> <!-- Campo obligatorio 🌟 -->
                                </label>
                                <select id="supplier_id" name="supplier_id" class="w-full px-4 py-3 bg-zinc-800" required>
                                    <option value="" disabled selected>Seleccione un proveedor</option>
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->company_name }}</option> <!-- Muestra el nombre, envía el ID 📚 -->
                                    @endforeach
                                </select>
                                @error('supplier_id')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p> <!-- Muestra error si es inválido 📛 -->
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
            currentName: '',
            currentDescription: '',

            openModal(id, name, description) {
                this.currentId = id;
                this.currentName = name;
                this.currentDescription = description;
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
