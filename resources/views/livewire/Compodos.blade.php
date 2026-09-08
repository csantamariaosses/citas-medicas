<div>
    <h3>COMPO DOS</H3>
    <select id="doctor" name="doctor" class="form-control">
        <option value="">Seleccione un Doctor</option>
        @foreach($doctors as $doctor)
            <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
        @endforeach
    </select>
</div>
