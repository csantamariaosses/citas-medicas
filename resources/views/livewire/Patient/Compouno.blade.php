<div>
    <h3>COMPO UNO Patient</H3>
     <!-- Primer Select -->

      <form action="{{ route('agendapatient.showcalendar') }}" method="POST">
                @csrf
                @method('POST')
        <table>
            <tr>
                <td><label>Especialidad:</label></td>
                <td>
                    <select name="speciality_id" wire:model.live="speciality_id">
                        <option value="">Seleccione una especialidad</option>
                        @foreach($specialities as $speciality)
                            <option value="{{ $speciality->id }}">{{ $speciality->name }}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <label>Seleccione un médico:</label>
                </td>
                <td>
                    <select name="doctor_id" wire:model.live="doctor_id" @if(empty($speciality_id)) disabled @endif>
                        <option value="">Seleccione un Médico</option>
                        @foreach($doctors as $doctor)
                            <option value="{{ $doctor->id }}">{{ $doctor->id }} -{{ $doctor->user->name }}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
                <td></td>
                <td> *{{ $speciality_id}} - {{ $doctor_id}}*
                    <input type="hidden" id="specialityName" name="specialityName" value="{{ session('specialityName') }}">
                    <button id="miBoton" name="miBoton" type="submit" class="btn btn-primary"  @if(empty($doctor_id)) disabled @endif>Buscar</button>
                </td>
            </tr>
        </table>    
    </form>
</div>
