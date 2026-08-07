<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de productos</title>
</head>
<body>
    <h1>Gestión de productos</h1>
    <a href="{{ route('products.create')}}">
        <button>+ Crear un nuevo producto</button>
    </a>
    <br><br>

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Categorías</th>
                <th>Acciones</th>
            </tr>    
        </thead>
    
        <tbody id="tbody-productos">
        </tbody>
    </table>
    
    <script>
        document.addEventListener('DOMContentLoaded', cargarProductos);

        
        function cargarProductos() {
            fetch('/api/products')
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        let tbody = document.getElementById('tbody-productos');
                        tbody.innerHTML = ''; 
                        
                        result.data.forEach(product => {
                            tbody.insertAdjacentHTML('beforeend', generarFilaHTML(product));
                        });
                    }
                })
                .catch(error => console.error('Error al cargar la tabla:', error));
        }

        
        function generarFilaHTML(product) {
            let categoria = product.category ? product.category.name : 'Sin categoría';
            
            
            return `
                <tr id="fila-${product.id}">
                    <td>${product.id}</td>        
                    <td>${product.name}</td>
                    <td><strong>${product.formatted_price}</strong></td>
                    <td>${categoria}</td>
                    <td>
                        <a href="/products/${product.id}/edit"> Editar </a>
                        
                        <!-- Transformamos el formulario de eliminar en un simple botón que llama a una función JS -->
                        <button onclick="eliminarProducto(${product.id})" style="background-color: #dc3545; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer; margin-left: 5px;">
                            X
                        </button>
                    </td>
                </tr>
            `;
        }

        
        function eliminarProducto(id) {
            if (!confirm('¿Estás seguro de eliminar este producto?')) return;

            
            fetch(`/api/products/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}', 
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                   
                    document.getElementById(`fila-${id}`).remove();
                }
            })
            .catch(error => console.error('Error al eliminar:', error));
        }

        const canalProductos = new BroadcastChannel('canal_productos');
        canalProductos.onmessage = function(evento){
            if (evento.data == 'actualizar_tabla'){
                console.log("¡Otra pestaña hizo un cambio! Recargando tabla...");
                cargarProductos();
            }
        };
    </script>
</body>
</html>