<div class="row g-3">
    <div class="col-md-4">
        <label class="form-label" for="number">Número de mesa</label>
        <input id="number" name="number" type="number" min="1" class="form-control" value="{{ old('number', $table->number) }}" required>
    </div>
    <div class="col-md-4">
        <label class="form-label" for="capacity">Capacidad</label>
        <input id="capacity" name="capacity" type="number" min="1" max="30" class="form-control" value="{{ old('capacity', $table->capacity) }}" required>
    </div>
    <div class="col-md-4">
        <label class="form-label" for="status">Estado</label>
        <select id="status" name="status" class="form-select" required>
            @foreach(\App\Models\Table::STATUSES as $status)
                <option value="{{ $status }}" @selected(old('status', $table->status) === $status)>
                    {{ (new \App\Models\Table(['status' => $status]))->statusLabel() }}
                </option>
            @endforeach
        </select>
    </div>
</div>
<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="{{ route('tables.index') }}" class="btn btn-outline-secondary">Cancelar</a>
    <button class="btn btn-danger" type="submit">Guardar</button>
</div>
