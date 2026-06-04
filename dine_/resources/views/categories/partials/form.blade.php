<div class="mb-3">
    <label for="name" class="form-label">Nombre</label>
    <input id="name" name="name" class="form-control" value="{{ old('name', $category->name) }}" maxlength="50" required>
</div>
<div class="mb-3">
    <label for="description" class="form-label">Descripción</label>
    <textarea id="description" name="description" class="form-control" rows="3" maxlength="255">{{ old('description', $category->description) }}</textarea>
</div>
<div class="d-flex justify-content-end gap-2">
    <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">Cancelar</a>
    <button class="btn btn-danger" type="submit">Guardar</button>
</div>
