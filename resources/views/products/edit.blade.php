<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>
</head>
<body>
    <h1>Editar Producto: {{ $product->name }}</h1>

    
    <form id="formEditarProducto" action="{{ route('products.update', $product->id) }}" method="POST">
        @csrf
        @method('PUT') 

        <label>Nombre del producto:</label>
        <br>
        <input type="text" name="name" value="{{ $product->name }}" required>
        <br><br>
        
        <label>Precio (S/):</label>
        <br>
        <input type="number" step="0.01" name="price" value="{{ $product->price }}" required>
        <br><br>

        <label>Categoría:</label>
        <br>
        <select name="category_id" required>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        <br><br>

        <button type="submit">Actualizar Producto</button>
    </form>

    <br><br>
    <a href="{{ route('products.index') }}">Volver a la lista</a>

   
    <script>
        document.getElementById('formEditarProducto').addEventListener('submit', function(e) {
            
            e.preventDefault(); 
            
            
            let formData = new FormData(this);

            
            fetch(`/api/products/{{ $product->id }}`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json' 
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('¡Producto actualizado con éxito!');
                    
                    
                    const canalProductos = new BroadcastChannel('canal_productos');
                    canalProductos.postMessage('actualizar_tabla');
                    // --------------------------------------------------------------------

                    
                    window.location.href = '/products'; 
                } else {
                    console.error(data);
                    alert('Ocurrió un error al actualizar el producto.');
                }
            })
            .catch(error => {
                console.error('Error al actualizar:', error);
                alert('Hubo un problema de conexión con el servidor.');
            });
        });
    </script>
</body>
</html>