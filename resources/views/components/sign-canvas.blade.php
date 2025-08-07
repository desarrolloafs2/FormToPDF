<div class="alert alert-info rounded py-4">
    <h2 class="text-center mb-3">Firme aquí</h2>
    
    <canvas id="signatureCanvas"
            class="w-100 bg-white rounded border border-black border-2 mb-2"
            style="height: 200px;"></canvas>

    <div class="text-center">
        <button id="clearCanvas" type="button" class="btn btn-danger px-3 py-1">
            <strong>Borrar</strong>
        </button>
    </div>

    <input type="hidden" id="signatureInput" name="signature">
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const canvas = document.getElementById('signatureCanvas');
        const clearButton = document.getElementById('clearCanvas');
        const input = document.getElementById('signatureInput');

        if (!canvas || typeof SignaturePad === 'undefined') return;

        const signaturePad = new SignaturePad(canvas);

        // Resize canvas to handle DPI
        function resizeCanvas() {
            const ratio = Math.max(window.devicePixelRatio || 1, 1);
            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            canvas.getContext("2d").scale(ratio, ratio);
            signaturePad.clear();
        }

        resizeCanvas();
        window.addEventListener('resize', resizeCanvas);

        clearButton.addEventListener('click', function () {
            signaturePad.clear();
            input.value = '';
        });

        const form = canvas.closest('form');
        if (form) {
            form.addEventListener('submit', function () {
                if (!signaturePad.isEmpty()) {
                    input.value = signaturePad.toDataURL();
                }
            });
        }
    });
</script>
@endpush
