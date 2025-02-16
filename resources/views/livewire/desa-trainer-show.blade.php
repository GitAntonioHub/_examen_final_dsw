<div class="container-fluid py-4">
    <!-- Tarjeta principal con diseño moderno -->
    <div class="card mb-4 mt-4 border-0 shadow-lg">
        <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center py-3">
            <div class="d-flex align-items-center">
                <i class="fas fa-first-aid fa-2x me-3"></i>
                <h3 class="card-title mb-0 fw-bold ml-2">Detalles del Entrenador DESA</h3>
            </div>
            <a href="{{ route('desa-trainers.index') }}" 
               class="btn btn-outline-light btn-sm hover-bg-primary float-end">
               <i class="fas fa-chevron-left me-2"></i> Volver
            </a>
        </div>
        
        <div class="card-body bg-light">
            <div class="row g-4">
                <!-- Columna izquierda con detalles principales -->
                <div class="col-md-6">
                    <div class="detail-item bg-white p-3 rounded shadow-sm mb-3">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-tag text-primary me-2"></i>
                            <h5 class="mb-0 fw-semibold ml-1">Identificación</h5>
                        </div>
                        <div class="ms-4">
                            <p class="mb-1"><span class="text-muted">Nombre:</span> {{ $desaTrainer->name }}</p>
                            <p class="mb-0"><span class="text-muted">Modelo:</span> {{ $desaTrainer->model }}</p>
                        </div>
                    </div>

                    <div class="detail-item bg-white p-3 rounded shadow-sm">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-align-left text-info me-2"></i>
                            <h5 class="mb-0 fw-semibold ml-1">Descripción</h5>
                        </div>
                        <div class="ms-4">
                            {!! $desaTrainer->description ?: '<em class="text-muted">Sin descripción disponible</em>' !!}
                        </div>
                    </div>
                </div>

                <!-- Columna derecha con metadatos -->
                <div class="col-md-6">
                    <div class="detail-item bg-white p-3 rounded shadow-sm mb-3">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-history text-secondary me-2"></i>
                            <h5 class="mb-0 fw-semibold ml-1">Historial</h5>
                        </div>
                        <div class="ms-4">
                            <p class="mb-1"><span class="text-muted">Creado:</span> {{ $desaTrainer->created_at->format('d/m/Y H:i') }}</p>
                            <p class="mb-0"><span class="text-muted">Actualizado:</span> {{ $desaTrainer->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>

                    <div class="detail-item bg-white p-3 rounded shadow-sm">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-sliders-h text-success me-2"></i>
                            <h5 class="mb-0 fw-semibold ml-1">Configuración</h5>
                        </div>
                        <div class="ms-4">
                            <div class="d-flex align-items-center">
                                <span class="text-muted me-2">Botones activos:</span>
                                <span class="badge bg-primary rounded-pill fs-6">
                                    {{ $desaTrainer->buttons->count() }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de alertas rediseñada -->
    <div class="row">
        <div class="col-md-12">
            @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            
            @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
        </div>
    </div>

    <!-- Contenido interactivo reorganizado -->
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow">
                <div class="card-header bg-white border-bottom py-3">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-drafting-compass me-2 text-primary mr-1"></i>Zona de Configuración
                    </h3>
                </div>
                <div class="card-body">
                    <div class="alert alert-info border-0 shadow-sm" style="background-color: rgb(27, 137, 255)" wire:loading.remove>
                        <i class="fas fa-paint-brush me-2"></i>
                        Haz clic en "Nuevo Botón" y dibuja el área interactiva sobre la imagen.
                        <span class="d-block mt-2 small"  style="color: rgb(0, 0, 0)">
                            <i class="fas fa-lightbulb me-1"></i> Doble clic para finalizar el trazado
                        </span>
                    </div>
                    
                    <div wire:loading>
                        <div class="alert alert-warning bg-soft-warning border-0 shadow-sm">
                            <i class="fas fa-sync fa-spin me-2"></i>Procesando tu solicitud...
                        </div>
                    </div>

                    <div class="image-frame position-relative overflow-hidden rounded-3 shadow" wire:ignore>
                        <img id="desaImage" src="{{ asset('storage/' . $desaTrainer->image) }}" 
                             class="img-fluid interactive-image" alt="{{ $desaTrainer->name }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- Panel de botones rediseñado -->
        <div class="col-lg-4">
            <div class="card border-0 shadow h-100">
                <div class="card-header bg-white border-bottom py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">
                            <i class="fas fa-shapes me-2 text-success mr-1"></i>Controles
                        </h3>
                        <button type="button" class="btn btn-primary btn-sm px-3 py-2" wire:click="startNewButton">
                            <i class="fas fa-plus me-2 mr-1"></i>Nuevo
                        </button>
                    </div>
                </div>
                
                <div class="card-body">
                    @if($showButtonForm)
                    <div class="config-panel bg-soft-light p-3 rounded shadow-sm mb-4">
                        <h5 class="mb-3 fw-semibold border-bottom pb-2">
                            <i class="fas fa-cog me-2"></i>
                            {{ $editingButton ? 'Editar Control' : 'Nuevo Control' }}
                        </h5>
                        
                        <form wire:submit.prevent="saveButton">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control @error('buttonLabel') is-invalid @enderror" 
                                       id="buttonLabel" wire:model.live="buttonLabel" placeholder="Nombre del botón">
                                <label for="buttonLabel" class="mt-1">
                                    <i class="fas fa-tag me-1 mr-1"></i>Etiqueta
                                </label>
                                @error('buttonLabel')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="color-picker mb-4">
                                <label class="form-label small text-muted mb-2">
                                    <i class="fas fa-palette me-1 mr-1"></i>Color destacado
                                </label>
                                <div class="d-flex gap-2 align-items-center">
                                    <input type="color" 
                                           class="form-control form-control-color rounded-3 @error('buttonColor') is-invalid @enderror"
                                           id="buttonColor" wire:model.live="buttonColor">
                                    <div class="color-presets d-flex gap-1">
                                        @foreach(\App\Models\DesaButton::AVAILABLE_COLORS as $colorCode => $colorName)
                                        <button type="button" class="color-dot rounded-circle shadow-sm" 
                                                style="background-color: {{ $colorCode }}"
                                                wire:click="$set('buttonColor', '{{ $colorCode }}')"></button>
                                        @endforeach
                                    </div>
                                </div>
                                @error('buttonColor')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-check form-switch mb-4">
                                <input class="form-check-input" type="checkbox" id="isBlinking" wire:model.live="isBlinking">
                                <label class="form-check-label small" for="isBlinking">
                                    <i class="fas fa-lightbulb me-1 mr-1"></i>Efecto de parpadeo
                                </label>
                            </div>

                            <div class="status-indicator mb-4">
                                <span class="badge bg-{{ empty($buttonArea) ? 'warning' : 'success' }} rounded-pill">
                                    <i class="fas fa-{{ empty($buttonArea) ? 'exclamation-triangle' : 'check-circle' }} me-1"></i>
                                    {{ empty($buttonArea) ? 'Área pendiente' : 'Área definida' }}
                                </span>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary" @if(empty($buttonArea)) disabled @endif>
                                    <i class="fas fa-save me-2 mr-1"></i>{{ $editingButton ? 'Actualizar' : 'Guardar' }}
                                </button>
                                <button type="button" class="btn btn-outline-secondary" wire:click="cancelButton">
                                    <i class="fas fa-times me-2 mr-1"></i>Cancelar
                                </button>
                            </div>
                        </form>
                    </div>
                    @endif

                    <!-- Lista de controles -->
                    <div class="controls-list">
                        <h5 class="mb-3 fw-semibold">
                            <i class="fas fa-list-ul me-2 mr-1"></i>Controles existentes
                        </h5>
                        @forelse($desaTrainer->buttons as $button)
                        <div class="control-item bg-white p-3 rounded shadow-sm mb-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <div class="color-indicator me-3" 
                                        style="background-color: {{ $button->color }}">
                                    </div>
                                    <div class="ml-2">
                                        <span class="d-block fw-semibold">{{ $button->label }}</span>
                                        <small class="text-muted">
                                            {{ $button->is_blinking ? 'Parpadeante' : 'Estático' }}
                                        </small>
                                    </div>
                                </div>
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-outline-warning" 
                                            wire:click="editButton({{ $button->id }})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    {{-- TODO: Implementar SweetAlert de eliminación --}}
                                    <button class="btn btn-sm btn-outline-danger" 
                                            wire:click="deleteButton({{ $button->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="empty-state text-center py-4">
                            <i class="fas fa-plug fa-2x text-muted mb-3"></i>
                            <p class="text-muted mb-0">No hay controles configurados</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('css')
        <style>
            /* Contenedor principal de la imagen y el canvas */
            .image-container {
                position: relative;
                width: 100%;               /* Se asegura de ocupar todo el ancho posible */
                max-width: 800px;          /* Limita el ancho máximo para dispositivos grandes */
                margin: 0 auto;            /* Centra el contenedor */
            }

            /* Canvas sobre la imagen */
            .canvas-container {
                position: absolute !important;
                top: 0;
                left: 0;
                z-index: 100;
            }

            /* Imagen principal */
            #desaImage {
                max-width: 100%;           /* Asegura que la imagen se redimensione */
                height: auto;              /* Mantiene la proporción de la imagen */
                display: block;
            }

            /* Marco de la imagen */
            .image-frame {
                border: 3px solid #e9ecef;
                border-radius: 0.5rem;
                background: #f8f9fa;
            }

            /* Efecto hover en la imagen */
            .interactive-image {
                cursor: crosshair;
                transition: transform 0.3s ease;
            }

            .interactive-image:hover {
                transform: scale(1.02);
            }

            /* Puntos de color */
            .color-dot {
                width: 25px;
                height: 25px;
                border: none;
                transition: transform 0.2s;
            }

            .color-dot:hover {
                transform: scale(1.1);
                cursor: pointer;
            }

            .color-indicator {
                width: 20px;
                height: 20px;
                border-radius: 50%;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            }

            /* Items de control */
            .control-item {
                transition: all 0.3s ease;
                border-left: 3px solid transparent;
            }

            .control-item:hover {
                transform: translateX(5px);
                border-left-color: var(--bs-primary);
            }

            /* Fondos suaves */
            .bg-soft-info {
                background-color: rgba(23, 162, 184, 0.1) !important;
            }

            .bg-soft-warning {
                background-color: rgba(255, 193, 7, 0.1) !important;
            }

            .hover-bg-primary {
                color: #fff; /* Color inicial */
            }
            .hover-bg-primary:hover {
                /* Cambiar aquí al color del fondo (bg-gradient-primary) o el que se necesite */
                color: rgb(27, 137, 255) !important;
            }

            /* Panel de configuración */
            .config-panel {
                background: rgba(248, 249, 250, 0.8);
                backdrop-filter: blur(5px);
            }

            /* Media queries para pantallas pequeñas */
            @media (max-width: 768px) {
                .image-container {
                    width: 90%;        /* Ajusta el ancho para evitar desbordamientos horizontales */
                    max-width: none;   /* Permite que se adapte por completo en pantallas más pequeñas */
                    margin: 0 auto;
                }

                .canvas-container {
                    /* Ajustes adicionales si lo deseas,
                       por ejemplo para reubicar el canvas en pantallas chicas */
                    top: 0;
                    left: 0;
                }
            }
        </style>
    @endpush

    @push('js')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.3.1/fabric.min.js"></script>
        <script>
        let canvas; 
        let isDrawing = false; 
        let points = []; 
        let activeShape; 
        let blinkingIntervals = new Map();

        // Helper para convertir hex a rgba
        function hexToRgba(hex, alpha = 1) {
            const r = parseInt(hex.slice(1, 3), 16);
            const g = parseInt(hex.slice(3, 5), 16);
            const b = parseInt(hex.slice(5, 7), 16);
            return `rgba(${r}, ${g}, ${b}, ${alpha})`;
        }

        // Espera a que la imagen cargue antes de inicializar el lienzo
        window.addEventListener('load', function() {
            const img = document.getElementById('desaImage');
            if (img.complete) {
                initCanvas(); 
            } else {
                img.onload = initCanvas;
            }
        });

        function initCanvas() {
            const img = document.getElementById('desaImage');
            const container = img.parentElement;
            
            const canvasEl = document.createElement('canvas');
            canvasEl.id = 'drawingCanvas';
            container.appendChild(canvasEl);
            
            canvas = new fabric.Canvas('drawingCanvas', {
                width: img.naturalWidth,
                height: img.naturalHeight
            });
            
            const scale = img.clientWidth / img.naturalWidth;
            canvas.setZoom(scale);
            canvas.setDimensions({
                width: img.clientWidth,
                height: img.clientHeight
            });
            
            setupCanvasEvents();
            loadExistingButtons();
            
            canvas.setBackgroundImage(img.src, canvas.renderAll.bind(canvas));
        }

        function setupCanvasEvents() {
            let lastClickTime = 0;
            const doubleClickDelay = 300;

            canvas.on('mouse:down', function(options) {
                if (!isDrawing) return;
                
                const currentTime = new Date().getTime();
                const timeDiff = currentTime - lastClickTime;
                
                if (timeDiff < doubleClickDelay) {
                    if (points.length >= 3) {
                        completeDrawing();
                    }
                } else {
                    const pointer = canvas.getPointer(options.e);
                    points.push({ x: pointer.x, y: pointer.y });
                    
                    const circle = new fabric.Circle({
                        radius: 3,
                        fill: @this.buttonColor,
                        left: pointer.x,
                        top: pointer.y,
                        selectable: false,
                        originX: 'center',
                        originY: 'center'
                    });
                    
                    canvas.add(circle);
                    if (points.length > 1) {
                        drawPolygon();
                    }
                }
                
                lastClickTime = currentTime;
            });

            canvas.on('mouse:move', function(options) {
                if (!isDrawing || points.length === 0) return;
                
                if (activeShape) {
                    canvas.remove(activeShape);
                }
                
                const pointer = canvas.getPointer(options.e);
                const tempPoints = [...points, { x: pointer.x, y: pointer.y }];
                
                activeShape = new fabric.Polygon(tempPoints, {
                    fill: hexToRgba(@this.buttonColor, 0.2),
                    stroke: @this.buttonColor,
                    strokeWidth: 2,
                    selectable: false
                });
                
                canvas.add(activeShape);
                canvas.renderAll();
            });
        }

        function completeDrawing() {
            if (!isDrawing || points.length < 3) return;
            isDrawing = false;
            
            if (activeShape) {
                canvas.remove(activeShape);
            }
            
            canvas.getObjects('circle').forEach(obj => canvas.remove(obj));
            
            const finalPolygon = new fabric.Polygon(points, {
                fill: hexToRgba(@this.buttonColor, 0.2),
                stroke: @this.buttonColor,
                strokeWidth: 2,
                selectable: false
            });
            
            canvas.add(finalPolygon);
            canvas.renderAll();
            
            @this.dispatch('areaSelected', { points: points });
            
            points = [];
            activeShape = null;
        }

        function drawPolygon() {
            if (activeShape) {
                canvas.remove(activeShape);
            }
            activeShape = new fabric.Polygon(points, {
                fill: hexToRgba(@this.buttonColor, 0.2),
                stroke: @this.buttonColor,
                strokeWidth: 2,
                selectable: false
            });
            canvas.add(activeShape);
            canvas.renderAll();
        }

        function startBlinking(polygon, polygonId) {
            if (blinkingIntervals.has(polygonId)) {
                clearInterval(blinkingIntervals.get(polygonId));
            }
            
            const originalFill = polygon.fill;
            const originalStroke = polygon.stroke;
            let isHighlighted = false;
            
            const interval = setInterval(() => {
                isHighlighted = !isHighlighted;
                const opacity = isHighlighted ? 0.6 : 0.2;
                polygon.set({ 
                    fill: hexToRgba(originalStroke, opacity)
                });
                canvas.renderAll();
            }, 1000);
            
            blinkingIntervals.set(polygonId, interval);
        }

        function loadExistingButtons() {
            const buttons = @json($desaTrainer->buttons);
            clearCanvas();
            
            buttons.forEach(button => {
                const polygon = new fabric.Polygon(button.area, {
                    id: button.id,
                    fill: hexToRgba(button.color, 0.2),
                    stroke: button.color,
                    strokeWidth: 2,
                    selectable: false,
                });
                canvas.add(polygon);
                if (button.is_blinking) {
                    startBlinking(polygon, button.id);
                }
            });
            canvas.renderAll();
        }

        function clearCanvas(excludeIds = []) {
            blinkingIntervals.forEach((interval) => clearInterval(interval));
            blinkingIntervals.clear();
            
            const objectsToRemove = canvas.getObjects().filter(obj => {
                return !(obj.id && excludeIds.includes(obj.id));
            });
            
            objectsToRemove.forEach(obj => canvas.remove(obj));
            canvas.renderAll();
        }

        document.addEventListener('livewire:initialized', () => {
            Livewire.on('startDrawing', () => {
                clearCanvas();
                isDrawing = true;
                points = [];
            });

            Livewire.on('resetCanvas', () => {
                const existingButtons = canvas.getObjects().filter(obj => obj.id);
                canvas.clear();
                existingButtons.forEach(button => {
                    canvas.add(button);
                });
                isDrawing = false;
                points = [];
                canvas.renderAll();
            });

            Livewire.on('buttonSaved', (data) => {
                clearCanvas();
                data[0].buttons.forEach(button => {
                    const polygon = new fabric.Polygon(button.area, {
                        id: button.id,
                        fill: hexToRgba(button.color, 0.2),
                        stroke: button.color,
                        strokeWidth: 2,
                        selectable: false,
                    });
                    canvas.add(polygon);
                    if (button.is_blinking) {
                        startBlinking(polygon, button.id);
                    }
                });
                canvas.renderAll();
            });

            Livewire.on('buttonDeleted', (data) => {
                clearCanvas();
                data[0].buttons.forEach(button => {
                    const polygon = new fabric.Polygon(button.area, {
                        id: button.id,
                        fill: hexToRgba(button.color, 0.2),
                        stroke: button.color,
                        strokeWidth: 2,
                        selectable: false,
                    });
                    canvas.add(polygon);
                    if (button.is_blinking) {
                        startBlinking(polygon, button.id);
                    }
                });
                canvas.renderAll();
            });

            Livewire.on('loadArea', (data) => {
                const existingPolygons = canvas.getObjects().filter(obj => obj.id !== data.buttonId);
                canvas.clear();
                existingPolygons.forEach(polygon => {
                    canvas.add(polygon);
                });
                
                isDrawing = true;
                points = data.area.map(p => ({ x: p.x, y: p.y }));
                
                const btnRedibujar = document.createElement('button');
                btnRedibujar.className = 'btn btn-warning btn-sm mb-3';
                btnRedibujar.innerHTML = '<i class="fas fa-pencil-alt"></i> Redibujar área';
                btnRedibujar.onclick = function() {
                    const otherPolygons = canvas.getObjects().filter(obj => obj.id && obj.id !== data.buttonId);
                    canvas.clear();
                    otherPolygons.forEach(polygon => canvas.add(polygon));
                    
                    isDrawing = true;
                    points = [];
                    this.remove();
                };
                
                document.querySelector('.image-container').insertBefore(btnRedibujar, canvas.wrapperEl);
                
                const editingPolygon = new fabric.Polygon(data.area, {
                    id: data.buttonId,
                    fill: hexToRgba(data.color, 0.2),
                    stroke: data.color,
                    strokeWidth: 2,
                    selectable: false
                });
                
                canvas.add(editingPolygon);
                if (data.isBlinking) {
                    startBlinking(editingPolygon, data.buttonId);
                }
                
                canvas.renderAll();
            });
        });

        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
        </script>
    @endpush
</div>
