<div>
    <!-- Primer Select -->
    <div class="mb-4">
        <label>País:</label>
        <select wire:model.live="selectedCountry" class="form-control"> 
            <option value="">Seleccione un país</option>
            @foreach($countries as $country)
                <option value="{{ $country->id }}">{{ $country->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Segundo Select (Dependiente) -->
    <div class="mb-4">
        <label>Ciudad:</label>
        <select wire:model="selectedCity" class="form-control" @if(is_null($selectedCountry)) disabled @endif>
            <option value="">Seleccione una ciudad</option>
            @foreach($cities as $city)
                <option value="{{ $city->id }}">{{ $city->name }}</option>
            @endforeach
        </select>
    </div>
</div>

