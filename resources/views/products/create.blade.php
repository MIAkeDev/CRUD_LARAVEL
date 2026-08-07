<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Producto</title>
</head>
<body>
    <h1>Crear Nuevo Producto</h1>

    
    <form id="formCrearProducto" action="{{ route('products.store') }}" method="POST">
        @csrf 

        <label>Nombre del producto:</label>
        <br>
        <input type="text" name="name" required>
        <br><br>

        <label>Precio:</label>
        <br>
        <input type="number" step="0.01" name="price" required>
        <br><br>

        <label>Categoría:</label>
        <br>
        <select name="category_id" required>
            <option value="">Seleccione una categoría...</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
            
        </select>
        <br><br>
        
        <label>Moneda:</label>
        <br>
        <select name="currency_id" required>
            <option value="">Seleccione una moneda...</option>
            @foreach($currencies as $currency)
                <option value="{{ $currency->id}}">{{$currency->name }}({{ $currency->symbol }})</option>
            @endforeach
        </select>
        <br><br>
        
        <button type="submit">Guardar Producto</button>
    </form>

    <br><br>
    <a href="{{ route('products.index') }}">Volver a la lista</a>

    
    <script>
        document.getElementById('formCrearProducto').addEventListener('submit', function(e) {
            
            e.preventDefault(); 

            let formData = new FormData(this); 

            
            fetch('/api/products', {
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
                    alert('¡Producto creado con éxito!');
                    
                    
                    const canalProductos = new BroadcastChannel('canal_productos');
                    canalProductos.postMessage('actualizar_tabla');
                    
                    window.location.href = '/products'; 
                } else {
                    console.error(data);
                    alert('Ocurrió un error guardando el producto.');
                }
            })
            .catch(error => {
                console.error('Error al guardar:', error);
                alert('Hubo un error de conexión con el servidor.');
            });
        });
    </script>
</body>
</html>