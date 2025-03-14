<div class="col-md-3 mb-5">
    <div class="card">
        <div class="absolute top-0 left-0 p-2">
            <div class="franja-card">
                <span class="franjaazul"></span>
                <span class="franjaroja"></span>
            </div>
        </div>
        <div class="card-header">{{ $title }}</div>
        <div class="card-body">
            <p>{{ $client }}</p>
            <a href="{{ $url }}" class="btn btn-primary" target="_blank">Ir a {{ $title }}</a>
        </div>
    </div>
</div>