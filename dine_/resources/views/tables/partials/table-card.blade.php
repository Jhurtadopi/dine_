<div class="col-sm-6 col-xl-3" data-table-id="{{ $table->id }}">
    <div class="card table-card {{ $table->statusClass() }}">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-muted small">Mesa</div>
                    <div class="display-6 fw-bold">{{ $table->number }}</div>
                </div>
                <span class="badge bg-dark-subtle text-dark">{{ $table->capacity }} puestos</span>
            </div>
            <div class="mt-3 fw-semibold">{{ $table->statusLabel() }}</div>
            @if($table->status === \App\Models\Table::STATUS_READY_FOR_SERVICE)
                <div class="small text-danger fw-semibold mt-1">El cliente finalizó la sesión del menú digital.</div>
            @endif
            <div class="d-flex gap-2 mt-3">
                @if(auth()->user()->isAdmin())
                    <a class="btn btn-sm btn-outline-dark" href="{{ route('tables.edit', $table) }}">Editar</a>
                @endif
                <a class="btn btn-sm btn-outline-primary" href="{{ route('tables.show', $table) }}">QR</a>
            </div>
        </div>
    </div>
</div>
