<div>
    <h3>CONSULTATION COMPONENTE - ADMIN</H3>
    <div class="col-6">
        <table class="table table-striped">
            <tr><td>Cita_id</td><td>{{$appointment->id}}</td></tr>
            <tr><td>Consulta_id</td><td>{{$appointment->consultation->id}}</td></tr>
            <tr><td>Doctor_id</td><td>{{$appointment->doctor->id}}</td></tr>
            <tr><td>Doctor_name</td><td>{{$appointment->doctor->user->name}}</td></tr>
            <tr><td>Paciente_id</td><td>{{$appointment->patient_id}}</td></tr>
            <tr><td>Paciente_name</td><td>{{$appointment->patient->user->name}}</td></tr>                
        </table>
    </div>
    <div class="col-8">
        <div class="card">
            <div class="card-header">
                <h3>Edicion Consulta</h3>
            </div>   
            <div class="card-body">
                <h3>Body</h3>

                <div class="col-8">
                        <div class="mb-3">
                            <label for="diagnostic" class="form-label">Diagnóstico:</label>
                            <textarea class="form-control" id="diagnostic" name="diagnostic" rows="3" wire:model="form.diagnostic"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="treatment" class="form-label">Tratamiento:</label>
                            <textarea class="form-control" id="treatment" name="treatment" rows="3" wire:model="form.treatment"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="notes" class="form-label">Notas:</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3"  wire:model="form.notes"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="prescription" class="form-label">Prescripción:</label><br>
                            <hr>

                            @foreach( $this->form['prescriptions'] as $key => $pres )
                                {{$key}} - {{$pres['medicine']}}
                            @endforeach
                            <hr>
                            @forelse ( $this->form['prescriptions'] as $index => $prescription )

                                
                                <div wire:key="prescription-{{$index}}">      
                                    <table>
                                        <tr>
                                            <td>
                                                <div class="flex-1">          
                                                    <label>Medicamento</label>                        
                                                    <input type="text" wire:model="form.prescriptions.{{$index}}.medicine">
                                                </div>
                                            </td>
                                            <td>                                            
                                                <div class="w-32">      
                                                     <label>Dosis</label>                                
                                                    <input type="text" wire:model="form.prescriptions.{{$index}}.dosage">
                                                </div>
                                            </td>
                                            <td>                                            
                                                <div class="flex-1">        
                                                     <label>Frecuencia</label>                              
                                                    <input type="text" wire:model="form.prescriptions.{{$index}}.frequency">
                                                </div>    
                                            </td>
                                            <td>
                                                <div class="flex-shrink-8">                                  
                                                    <button wire:click="removePrescription({{$index}})">Eliminar</button>
                                                </div> 
                                            </td>
                                        </tr>
                                    </table>                                       
                                </div>
                            @empty

                                <div>
                                    <p>No hay medicamentos agregados a la receta</p>
                                </div>
                            @endforelse
                            <button wire:click="addPrescription">Agregar Medicamento</buttton>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary" wire:click="saveConsultation">Guardar</button>
                        </div>
                </div>
                <div class="col-6">
                    TARJETAS
                    <div class="card">
                        <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Active</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Link</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Link</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                        </li>
                        </ul>
                    </div>
                </div>

            </div>   
        </div>
    </div>
</div>
