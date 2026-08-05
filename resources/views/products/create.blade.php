<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Producto</title>
</head>
<body>
    <h1>Crear Nuevo Producto</h1>

    <form action="{{ route('products.store') }}" method="POST">
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

</body>
</html>