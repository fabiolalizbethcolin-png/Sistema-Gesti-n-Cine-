@extends('layouts.app')

@section('content')
<div class="auth-container" style="max-width: 600px; margin: 0 auto; padding: 20px;">
    <h1 style="margin-bottom: 30px;">🎬 Agregar Nueva Película</h1>

    {{-- Mensajes de error con el formato que ya usas --}}
    @if(session('errors') && count(session('errors')) > 0)
    <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #dc3545;">
        <strong>Por favor corrige los siguientes errores:</strong>
        <ul style="margin-top: 10px; margin-bottom: 0;">
            @foreach(session('errors') as $campo => $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Mensaje de éxito --}}
    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #28a745;">
            {{ session('success') }}
        </div>
    @endif

    {{-- ✅ IMPORTANTE: enctype="multipart/form-data" para poder subir imágenes --}}
    <form action="{{ route('peliculas.store') }}" method="POST" enctype="multipart/form-data" style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        @csrf

        {{-- TÍTULO --}}
        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: bold;">Título:</label>
            <input type="text" name="titulo" value="{{ session('old')['titulo'] ?? '' }}" 
                   style="width: 100%; padding: 10px; border: 2px solid #e0e0e0; border-radius: 5px; font-size: 16px;"
                   placeholder="Ej: Dune: Parte 2" required>
            @if(session('errors')['titulo'] ?? false)
                <small style="color:red; display: block; margin-top: 5px;">⚠️ {{ session('errors')['titulo'] }}</small>
            @endif
        </div>

        {{-- GÉNERO --}}
        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: bold;">Género:</label>
            <select name="genero" style="width: 100%; padding: 10px; border: 2px solid #e0e0e0; border-radius: 5px; font-size: 16px;" required>
                <option value="">-- Selecciona un género --</option>
                <option value="Acción" {{ (session('old')['genero'] ?? '') == 'Acción' ? 'selected' : '' }}>Acción</option>
                <option value="Comedia" {{ (session('old')['genero'] ?? '') == 'Comedia' ? 'selected' : '' }}>Comedia</option>
                <option value="Drama" {{ (session('old')['genero'] ?? '') == 'Drama' ? 'selected' : '' }}>Drama</option>
                <option value="Ciencia Ficción" {{ (session('old')['genero'] ?? '') == 'Ciencia Ficción' ? 'selected' : '' }}>Ciencia Ficción</option>
                <option value="Terror" {{ (session('old')['genero'] ?? '') == 'Terror' ? 'selected' : '' }}>Terror</option>
                <option value="Animación" {{ (session('old')['genero'] ?? '') == 'Animación' ? 'selected' : '' }}>Animación</option>
                <option value="Aventura" {{ (session('old')['genero'] ?? '') == 'Aventura' ? 'selected' : '' }}>Aventura</option>
                <option value="Suspenso" {{ (session('old')['genero'] ?? '') == 'Suspenso' ? 'selected' : '' }}>Suspenso</option>
            </select>
            @if(session('errors')['genero'] ?? false)
                <small style="color:red; display: block; margin-top: 5px;">⚠️ {{ session('errors')['genero'] }}</small>
            @endif
        </div>

        {{-- DURACIÓN --}}
        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: bold;">Duración (minutos):</label>
            <input type="number" name="duracion" value="{{ session('old')['duracion'] ?? '' }}" 
                   style="width: 100%; padding: 10px; border: 2px solid #e0e0e0; border-radius: 5px; font-size: 16px;"
                   placeholder="Ej: 120" min="1" required>
            @if(session('errors')['duracion'] ?? false)
                <small style="color:red; display: block; margin-top: 5px;">⚠️ {{ session('errors')['duracion'] }}</small>
            @endif
        </div>

        {{-- DESCRIPCIÓN --}}
        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: bold;">Descripción:</label>
            <textarea name="descripcion" rows="5" 
                      style="width:100%; padding:10px; font-size:16px; border-radius:5px; border:2px solid #e0e0e0; box-sizing:border-box; resize:vertical;"
                      placeholder="Escribe una breve descripción de la película...">{{ session('old')['descripcion'] ?? '' }}</textarea>
            @if(session('errors')['descripcion'] ?? false)
                <small style="color:red; display: block; margin-top: 5px;">⚠️ {{ session('errors')['descripcion'] }}</small>
            @endif
        </div>

        {{-- CLASIFICACIÓN --}}
        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: bold;">Clasificación:</label>
            <select name="clasificacion" style="width: 100%; padding: 10px; border: 2px solid #e0e0e0; border-radius: 5px; font-size: 16px;" required>
                <option value="">-- Selecciona una clasificación --</option>
                <option value="A" {{ (session('old')['clasificacion'] ?? '') == 'A' ? 'selected' : '' }}>A (Todo público)</option>
                <option value="B" {{ (session('old')['clasificacion'] ?? '') == 'B' ? 'selected' : '' }}>B (Adolescentes y adultos)</option>
                <option value="C" {{ (session('old')['clasificacion'] ?? '') == 'C' ? 'selected' : '' }}>C (Adultos)</option>
                <option value="D" {{ (session('old')['clasificacion'] ?? '') == 'D' ? 'selected' : '' }}>D (Adultos +18)</option>
            </select>
            @if(session('errors')['clasificacion'] ?? false)
                <small style="color:red; display: block; margin-top: 5px;">⚠️ {{ session('errors')['clasificacion'] }}</small>
            @endif
        </div>

        {{-- IDIOMA --}}
        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: bold;">Idioma original:</label>
            <select name="idioma" style="width: 100%; padding: 10px; border: 2px solid #e0e0e0; border-radius: 5px; font-size: 16px;" required>
                <option value="">-- Selecciona un idioma --</option>
                <option value="Español" {{ (session('old')['idioma'] ?? '') == 'Español' ? 'selected' : '' }}>Español</option>
                <option value="Inglés" {{ (session('old')['idioma'] ?? '') == 'Inglés' ? 'selected' : '' }}>Inglés</option>
                <option value="Francés" {{ (session('old')['idioma'] ?? '') == 'Francés' ? 'selected' : '' }}>Francés</option>
                <option value="Japonés" {{ (session('old')['idioma'] ?? '') == 'Japonés' ? 'selected' : '' }}>Japonés</option>
                <option value="Coreano" {{ (session('old')['idioma'] ?? '') == 'Coreano' ? 'selected' : '' }}>Coreano</option>
                <option value="Otro" {{ (session('old')['idioma'] ?? '') == 'Otro' ? 'selected' : '' }}>Otro</option>
            </select>
            @if(session('errors')['idioma'] ?? false)
                <small style="color:red; display: block; margin-top: 5px;">⚠️ {{ session('errors')['idioma'] }}</small>
            @endif
        </div>

        {{-- IMAGEN --}}
        <div style="margin-bottom: 25px;">
            <label style="display: block; margin-bottom: 5px; font-weight: bold;">Imagen de la película:</label>
            <input type="file" name="imagen" accept="image/*" 
                   style="width: 100%; padding: 10px; border: 2px dashed #e0e0e0; border-radius: 5px; background: #f9f9f9; cursor: pointer;">
            <small style="color: #666; display: block; margin-top: 5px;">
                📁 Formatos permitidos: JPG, PNG, GIF. Tamaño máximo: 2MB
            </small>
            @if(session('errors')['imagen'] ?? false)
                <small style="color:red; display: block; margin-top: 5px;">⚠️ {{ session('errors')['imagen'] }}</small>
            @endif
            
            {{-- Vista previa de la imagen (opcional) --}}
            <div id="preview-container" style="margin-top: 10px; display: none;">
                <img id="image-preview" src="#" alt="Vista previa" style="max-width: 200px; max-height: 200px; border: 2px solid #e0e0e0; border-radius: 5px; padding: 5px;">
            </div>
        </div>

        {{-- BOTONES --}}
        <div style="display: flex; gap: 10px; margin-top: 20px;">
            <button type="submit" style="background: #28a745; color: white; padding: 12px 25px; border: none; border-radius: 5px; font-size: 16px; font-weight: bold; cursor: pointer; flex: 1; transition: background 0.3s;"
                    onmouseover="this.style.background='#218838'" 
                    onmouseout="this.style.background='#28a745'">
                ✅ Agregar Película
            </button>
            
            <a href="{{ route('peliculas.index') }}" style="background: #6c757d; color: white; padding: 12px 25px; border-radius: 5px; text-decoration: none; text-align: center; font-size: 16px; transition: background 0.3s;"
               onmouseover="this.style.background='#5a6268'" 
               onmouseout="this.style.background='#6c757d'">
                Cancelar
            </a>
        </div>
    </form>
</div>

{{-- Script para vista previa de la imagen --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const inputImagen = document.querySelector('input[name="imagen"]');
    const previewContainer = document.getElementById('preview-container');
    const imagePreview = document.getElementById('image-preview');
    
    inputImagen.addEventListener('change', function() {
        const file = this.files[0];
        
        if (file) {
            // Validar tipo de archivo
            const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
            if (!validTypes.includes(file.type)) {
                alert('❌ Solo se permiten imágenes JPG, PNG o GIF');
                this.value = '';
                previewContainer.style.display = 'none';
                return;
            }
            
            // Validar tamaño (2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('❌ La imagen no debe superar los 2MB');
                this.value = '';
                previewContainer.style.display = 'none';
                return;
            }
            
            // Mostrar vista previa
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                previewContainer.style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            previewContainer.style.display = 'none';
        }
    });
});
</script>

<style>
/* Animación para el formulario */
.auth-container {
    animation: fadeIn 0.5s ease-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Estilo para inputs en focus */
input:focus, select:focus, textarea:focus {
    outline: none;
    border-color: #28a745 !important;
    box-shadow: 0 0 5px rgba(40, 167, 69, 0.3);
}

/* Estilo para el input file */
input[type="file"] {
    padding: 8px !important;
}

input[type="file"]:hover {
    background: #f0f0f0 !important;
}
</style>
@endsection