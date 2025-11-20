<div class="mt-3">

    @push('stylesheets')
        <style>
            .pending-upload {
                border-color: #FFC943 !important;
            }

            .overdue-upload {
                border-color: red !important;
            }

            .completed-upload {
                border-color: #66D575 !important;
            }
        </style>
    @endpush

    <div class="d-flex align-items-center justify-content-between">
        <h4>Lista de Verificación de Documentos</h4>

        <h5><span class="badge text-bg-secondary">Acciones administrativas</span></h5>
    </div>

    <div class="row">
        @if ($bidding->checklists->count() != null)
            @foreach ($contracts as $index => $contract)
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ $contract->type }} - {{ $contract->bidding->title }}</h4>
                        </div>
                        <div class="card-body p-3">
                            @if ($contract->checklists->count() != null)
                                <div class="row">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4 text-center">
                                        <p><strong>FECHA LÍMITE DE ENTREGA</strong></p>
                                    </div>
                                    <div class="col-md-4"></div>
                                </div>
                                @foreach ($contract->checklists as $item)
                                    <div class="row my-2">
                                        @php
                                            $hasFile = !empty($item->file);
                                            $due = \Carbon\Carbon::parse($item->due_date);
                                            $isOverdue =
                                                !$hasFile && ($due->isPast() || $due->diffInDays(today()) <= 2);

                                            if ($hasFile) {
                                                $status = 'completed-upload';
                                            } elseif ($isOverdue) {
                                                $status = 'overdue-upload';
                                            } else {
                                                $status = 'pending-upload';
                                            }
                                        @endphp

                                        <div class="col-md-4 {{ $status }} p-2"
                                            style="border:1px solid; display:flex; align-items:center; gap:16px;">

                                            {{-- OVERDUE --}}
                                            @if ($status === 'overdue-upload')
                                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40"
                                                    fill="#d9534f" viewBox="0 0 256 256">
                                                    <path
                                                        d="M225.86,102.82c-3.77-3.94-7.67-8-9.14-11.57-1.36-3.27-1.44-8.69-1.52-13.94-.15-9.76-.31-20.82-8-28.51s-18.75-7.85-28.51-8c-5.25-.08-10.67-.16-13.94-1.52-3.56-1.47-7.63-5.37-11.57-9.14C146.28,23.51,138.44,16,128,16s-18.27,7.51-25.18,14.14c-3.94,3.77-8,7.67-11.57,9.14C88,40.64,82.56,40.72,77.31,40.8c-9.76.15-20.82.31-28.51,8S41,67.55,40.8,77.31c-.08,5.25-.16,10.67-1.52,13.94-1.47,3.56-5.37,7.63-9.14,11.57C23.51,109.72,16,117.56,16,128s7.51,18.27,14.14,25.18c3.77,3.94,7.67,8,9.14,11.57,1.36,3.27,1.44,8.69,1.52,13.94.15,9.76.31,20.82,8,28.51s18.75,7.85,28.51,8c5.25.08,10.67.16,13.94,1.52,3.56,1.47,7.63,5.37,11.57,9.14C109.72,232.49,117.56,240,128,240s18.27-7.51,25.18-14.14c3.94-3.77,8-7.67,11.57-9.14,3.27-1.36,8.69-1.44,13.94-1.52,9.76-.15,20.82-.31,28.51-8s7.85-18.75,8-28.51c.08-5.25.16-10.67,1.52-13.94,1.47-3.56,5.37-7.63,9.14-11.57C232.49,146.28,240,138.44,240,128S232.49,109.73,225.86,102.82Zm-11.55,39.29c-4.79,5-9.75,10.17-12.38,16.52-2.52,6.1-2.63,13.07-2.73,19.82-.1,7-.21,14.33-3.32,17.43s-10.39,3.22-17.43,3.32c-6.75.1-13.72.21-19.82,2.73-6.35,2.63-11.52,7.59-16.52,12.38S132,224,128,224s-9.15-4.92-14.11-9.69-10.17-9.75-16.52-12.38c-6.1-2.52-13.07-2.63-19.82-2.73-7-.1-14.33-.21-17.43-3.32s-3.22-10.39-3.32-17.43c-.1-6.75-.21-13.72-2.73-19.82-2.63-6.35-7.59-11.52-12.38-16.52S32,132,32,128s4.92-9.15,9.69-14.11,9.75-10.17,12.38-16.52c2.52-6.1,2.63-13.07,2.73-19.82.1-7,.21-14.33,3.32-17.43S70.51,56.9,77.55,56.8c6.75-.1,13.72-.21,19.82-2.73,6.35-2.63,11.52-7.59,16.52-12.38S124,32,128,32s9.15,4.92,14.11,9.69,10.17,9.75,16.52,12.38c6.1,2.52,13.07,2.63,19.82,2.73,7,.1,14.33.21,17.43,3.32s3.22,10.39,3.32,17.43c.1,6.75.21,13.72,2.73,19.82,2.63,6.35,7.59,11.52,12.38,16.52S224,124,224,128,219.08,137.15,214.31,142.11ZM120,136V80a8,8,0,0,1,16,0v56a8,8,0,0,1-16,0Zm20,36a12,12,0,1,1-12-12A12,12,0,0,1,140,172Z" />
                                                </svg>
                                            @endif

                                            {{-- PENDING --}}
                                            @if ($status === 'pending-upload')
                                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40"
                                                    fill="#f0ad4e" viewBox="0 0 256 256">
                                                    <path
                                                        d="M96.26,37.05A8,8,0,0,1,102,27.29a104.11,104.11,0,0,1,52,0,8,8,0,0,1-2,15.75,8.15,8.15,0,0,1-2-.26,88.09,88.09,0,0,0-44,0A8,8,0,0,1,96.26,37.05ZM53.79,55.14a104.05,104.05,0,0,0-26,45,8,8,0,0,0,15.42,4.27,88,88,0,0,1,22-38.09A8,8,0,0,0,53.79,55.14ZM43.21,151.55a8,8,0,1,0-15.42,4.28,104.12,104.12,0,0,0,26,45,8,8,0,0,0,11.41-11.22A88.14,88.14,0,0,1,43.21,151.55ZM150,213.22a88,88,0,0,1-44,0,8,8,0,1,0-4,15.49,104.11,104.11,0,0,0,52,0,8,8,0,0,0-4-15.49ZM222.65,146a8,8,0,0,0-9.85,5.58,87.91,87.91,0,0,1-22,38.08,8,8,0,1,0,11.42,11.21,104,104,0,0,0,26-45A8,8,0,0,0,222.65,146Zm-9.86-41.54a8,8,0,0,0,15.42-4.28,104,104,0,0,0-26-45,8,8,0,1,0-11.41,11.22A88,88,0,0,1,212.79,104.45Z" />
                                                </svg>
                                            @endif

                                            {{-- COMPLETED --}}
                                            @if ($status === 'completed-upload')
                                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40"
                                                    fill="#5cb85c" viewBox="0 0 256 256">
                                                    <path
                                                        d="M173.66,98.34a8,8,0,0,1,0,11.32l-56,56a8,8,0,0,1-11.32,0l-24-24a8,8,0,0,1,11.32-11.32L112,148.69l50.34-50.35A8,8,0,0,1,173.66,98.34ZM232,128A104,104,0,1,1,128,24,104.11,104.11,0,0,1,232,128Zm-16,0a88,88,0,1,0-88,88A88.1,88.1,0,0,0,216,128Z" />
                                                </svg>
                                            @endif

                                            <div>
                                                <h5>{{ $item->file_name }}</h5>

                                                <p>
                                                    @switch($status)
                                                        @case('overdue-upload')
                                                            Archivo en límite de entrega
                                                        @break

                                                        @case('pending-upload')
                                                            Pendiente de subir
                                                        @break

                                                        @case('completed-upload')
                                                            Documentos subidos exitosamente
                                                        @break
                                                    @endswitch
                                                </p>
                                            </div>

                                        </div>
                                        <div class="col-md-4">
                                            <div style="border: 1.5px solid #757575;"
                                                class="h-100 text-center d-flex flex-column justify-content-center align-items-center">
                                                <h5>{{ $item->due_date }}</h5>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div style="border: 1.5px solid #6F71A9; gap:12px"
                                                class="h-100 d-flex align-items-center p-2">
                                                @if ($item->file != null)
                                                    <h6>
                                                        <span class="badge text-bg-secondary">
                                                            {{ $item->upload_date }}
                                                        </span>
                                                    </h6>
                                                    <a href="{{ $item->file }}" class="btn btn-sm btn-light"
                                                        style="max-width: fit-content; max-height:fit-content"
                                                        target="_blank">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" fill="#000000" viewBox="0 0 256 256">
                                                            <path
                                                                d="M213.66,82.34l-56-56A8,8,0,0,0,152,24H56A16,16,0,0,0,40,40V216a16,16,0,0,0,16,16H200a16,16,0,0,0,16-16V88A8,8,0,0,0,213.66,82.34ZM160,51.31,188.69,80H160ZM200,216H56V40h88V88a8,8,0,0,0,8,8h48V216Z">
                                                            </path>
                                                        </svg>
                                                        {{ $item->file }}
                                                    </a>
                                                @else
                                                    <form method="POST" wire:submit="save({{ $item->id }})"
                                                        enctype="multipart/form-data" class="w-100">
                                                        {{ csrf_field() }}
                                                        <label class="form-label">Entregable</label>
                                                        <input type="file" class="form-control w-100"
                                                            wire:model="files.{{ $item->id }}"
                                                            id="file{{ $item->id }}">

                                                        <button type="submit"
                                                            class="btn btn-sm btn-primary mt-2">Guardar</button>

                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p>Contrato/Modificatorio sin elementos para entregar</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

</div>
