@if($categories->isEmpty())
    <div class="alert alert-warning">
        Primero crea al menos una categoría para poder registrar platos.
    </div>
@endif

<div class="row g-3">
    <div class="col-md-6">
        <label for="name" class="form-label">Nombre</label>
        <input id="name" name="name" class="form-control" value="{{ old('name', $dish->name) }}" maxlength="100" required>
    </div>
    <div class="col-md-3">
        <label for="price" class="form-label">Precio</label>
        <input id="price" name="price" type="number" min="0" step="100" class="form-control" value="{{ old('price', $dish->price) }}" required>
    </div>
    <div class="col-md-3">
        <label for="category_id" class="form-label">Categoría</label>
        <select id="category_id" name="category_id" class="form-select" required>
            <option value="">Selecciona...</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" @selected((int) old('category_id', $dish->category_id) === $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-12">
        <label for="description" class="form-label">Descripción</label>
        <textarea id="description" name="description" class="form-control" rows="3" maxlength="500">{{ old('description', $dish->description) }}</textarea>
    </div>
    <div class="col-md-6">
        <label for="image" class="form-label">Imagen</label>
        <input id="image" name="image" type="file" class="form-control" accept="image/*">
        <div class="form-text">Opcional. Máximo 2 MB.</div>
    </div>
    <div class="col-md-6 d-flex align-items-end">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="available" name="available" value="1" @checked(old('available', $dish->available))>
            <label class="form-check-label" for="available">Disponible en el menú del comensal</label>
        </div>
    </div>
</div>

<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="{{ route('dishes.index') }}" class="btn btn-outline-secondary">Cancelar</a>
    <button class="btn btn-danger" type="submit" @disabled($categories->isEmpty())>Guardar</button>
</div>
