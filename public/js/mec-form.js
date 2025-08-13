document.addEventListener('DOMContentLoaded', () => {
    const situacionRadios = document.querySelectorAll('input[name="situacion_laboral"]');

    const desempleadoGroup = document.getElementById('situacion_desempleado_group');
    const ocupadoGroup = document.getElementById('situacion_ocupado_group');

    function toggleGroup(group, enable) {
        if (!group) return;
        const inputs = group.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.disabled = !enable;
            if (!enable) input.checked = false;
        });
        group.style.display = enable ? 'block' : 'none';
    }

    function init() {
        const selected = document.querySelector('input[name="situacion_laboral"]:checked');
        if (!selected) {
            toggleGroup(desempleadoGroup, false);
            toggleGroup(ocupadoGroup, false);
        } else if (selected.value === 'desempleado') {
            toggleGroup(desempleadoGroup, true);
            toggleGroup(ocupadoGroup, false);
        } else if (selected.value === 'ocupado') {
            toggleGroup(ocupadoGroup, true);
            toggleGroup(desempleadoGroup, false);
        }
    }

    // Solo una checkbox marcada a la vez en desempleado
    const desempleadoCheckboxes = document.querySelectorAll('.desempleado-checkbox');
    desempleadoCheckboxes.forEach(cb => {
        cb.addEventListener('change', () => {
            if (cb.checked) {
                desempleadoCheckboxes.forEach(other => {
                    if (other !== cb) other.checked = false;
                });
            }
        });
    });

    // Solo una checkbox marcada a la vez en ocupado (categorías)
    const ocupadoCheckboxes = document.querySelectorAll('.ocupado-checkbox');
    ocupadoCheckboxes.forEach(cb => {
        cb.addEventListener('change', () => {
            if (cb.checked) {
                ocupadoCheckboxes.forEach(other => {
                    if (other !== cb) other.checked = false;
                });
            }
        });
    });

    situacionRadios.forEach(radio => {
        radio.addEventListener('change', init);
    });

    init();

    const radioSi = document.getElementById('otro_curso_si');
    const radioNo = document.getElementById('otro_curso_no');
    const textContainer = document.getElementById('otro_curso_text_container');
    const textInput = document.getElementById('otro_curso_text');

    function toggleTextInput() {
        if (radioSi.checked) {
            textContainer.style.display = 'block';
            textInput.disabled = false;
        } else {
            textContainer.style.display = 'none';
            textInput.disabled = true;
            textInput.value = '';
        }
    }

    radioSi.addEventListener('change', toggleTextInput);
    radioNo.addEventListener('change', toggleTextInput);

    // Inicializar estado al cargar
    toggleTextInput();

});
