Para crear selects anidados (o dependientes) en Laravel Livewire, 
debes enlazar el primer select con una propiedad usando wire:model.live 
y actualizar dinámicamente los datos del segundo select
 mediante un método de ciclo de vida como updatedPropiedad.1. 
 Código del Componente Livewire (PHP)Crea o edita tu clase de Livewire
 para manejar las propiedades de selección y el filtrado:
 
phpnamespace App\Livewire;

use Livewire\Component;
use App\Models\State;
use App\Models\City;

ptransient public $states;
public $cities = [];

public $state_id = '';
public $city_id = '';

public function mount() {
    $this->states = State::all();
}

public function updatedStateId($value) {
    $this->cities = City::where('state_id', $value)->get();
    $this->city_id = ''; // Limpiar selección anterior
}

public function render() {
    return view('livewire.nested-selects');
}

Usa el código con precaución.2. Vista de Livewire (Blade)En tu archivo de vista, utiliza wire:model.live en el elemento principal para que dispare la petición al servidor inmediatamente al cambiar de opción:html<div>
    <!-- Primer Select -->
    <label>Estado / Provincia:</label>
    <select wire:model.live="state_id">
        <option value="">Seleccione un estado</option>
        @foreach($states as $state)
            <option value="{{ $state->id }}">{{ $state->name }}</option>
        @endforeach
    </select>

    <!-- Segundo Select Anidado -->
    <label>Ciudad:</label>
    <select wire:model="city_id" @if(empty($cities)) disabled @endif>
        <option value="">Seleccione una ciudad</option>
        @foreach($cities as $city)
            <option value="{{ $city->id }}">{{ $city->name }}</option>
        @endforeach
    </select>
</div>
