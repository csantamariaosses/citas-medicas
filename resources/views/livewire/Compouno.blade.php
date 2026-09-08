<div>
    <h3>COMPO UNO</H3>
     <!-- Primer Select -->

      <form action="{{ route('agendadoc.showcalendar') }}" method="POST">
                @csrf
                @method('POST')
        <table>
            <tr>
                <td><label>Especialidad:</label></td>
                <td>
                    <select name="state_id" wire:model.live="state_id">
                        <option value="">Seleccione una especialidad</option>
                        @foreach($states as $state)
                            <option value="{{ $state->id }}">{{ $state->name }}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <label>Seleccione un médico:</label>
                </td>
                <td>
                    <select name="city_id" wire:model.live="city_id" @if(empty($state_id)) disabled @endif>
                        <option value="">Seleccione un Médico</option>
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}">{{ $city->id }} -{{ $city->user->name }}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
                <td></td>
                <td> *{{ $state_id}} - {{ $city_id}}*
                    <input type="hidden" id="specialityName" name="specialityName" value="{{ session('specialityName') }}">
                    <button id="miBoton" name="miBoton" type="submit" class="btn btn-primary"  @if(empty($city_id)) disabled @endif>Buscar</button>
                </td>
            </tr>
        </table>    
    </form>
</div>
