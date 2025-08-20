document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form');
    if (!form) return;

    const btn = form.querySelector('[type="submit"]');
    const btnText = btn?.querySelector('.btn-text');
    const spinner = btn?.querySelector('.spinner');

    // Reactivar botón al cargar
    if (btn) {
        btn.disabled = false;
        if (btnText) btnText.textContent = 'Enviar';
        if (spinner) spinner.style.display = 'none';


    }

    // -------------------- SITUACIÓN LABORAL --------------------
    const situacionRadios = document.querySelectorAll('input[name="situacion_laboral"]');
    const desempleadoGroup = document.getElementById('situacion_desempleado_group');
    const ocupadoGroup = document.getElementById('situacion_ocupado_group');

    function toggleGroup(group, enable) {
        if (!group) return;
        const inputs = group.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.disabled = !enable;
            if (!enable && input.type === 'checkbox') input.checked = false;
        });
        group.style.display = enable ? 'block' : 'none';
    }

    function initSituacion() {
        const selected = document.querySelector('input[name="situacion_laboral"]:checked');
        if (!selected) {
            toggleGroup(desempleadoGroup, false);
            toggleGroup(ocupadoGroup, false);
        } else if (selected.value === 'desempleado') {
            toggleGroup(desempleadoGroup, true);
            toggleGroup(ocupadoGroup, false);
        } else {
            toggleGroup(ocupadoGroup, true);
            toggleGroup(desempleadoGroup, false);
        }
    }

    situacionRadios.forEach(radio => radio.addEventListener('change', initSituacion));
    initSituacion();

    // -------------------- CHECKBOX ÚNICO --------------------
    const singleSelectCheckbox = (selector) => {
        document.querySelectorAll(selector).forEach(cb => {
            cb.addEventListener('change', () => {
                if (cb.checked) {
                    document.querySelectorAll(selector).forEach(other => {
                        if (other !== cb) other.checked = false;
                    });
                }
            });
        });
    };
    singleSelectCheckbox('.desempleado-checkbox');
    singleSelectCheckbox('.ocupado-checkbox');

    // -------------------- OTRO CURSO --------------------
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
    toggleTextInput();

    // -------------------- VALIDACIÓN --------------------
    const validation = new JustValidate(`#${form.id}`);

    // Datos personales
    document.querySelectorAll('#datosPersonales input, #datosPersonales select').forEach(field => {
        const rules = [];
        if (field.required) rules.push({ rule: 'required', errorMessage: 'Este campo es obligatorio' });
        if (field.type === 'email') rules.push({ rule: 'email', errorMessage: 'Debe ser un correo válido' });
        if (rules.length) {
            const selector = field.id ? `#${field.id}` : `[name="${field.name}"]`;
            if (document.querySelector(selector)) validation.addField(selector, rules);
        }
    });

    const birthdateField = document.getElementById('birthdate');
    if (birthdateField) {
        validation.addField('#birthdate', [
            { rule: 'required', errorMessage: 'La fecha de nacimiento es obligatoria' },
            { rule: 'customRegexp', value: /^\d{4}-\d{2}-\d{2}$/, errorMessage: 'Formato inválido' }
        ]);
    }

    // Carnet
    if (document.getElementById('carnet_tipos')) {
        validation.addField('#carnet_tipos', [{
            validator: (value) => {
                const carnetSi = document.getElementById('carnet_si');
                return carnetSi && carnetSi.checked ? value.trim() !== '' : true;
            },
            errorMessage: 'Debes indicar los tipos de carnet si has marcado Sí'
        }]);
    }

    // Nivel académico
    if (document.querySelector('input[name="nivel_academico"]')) {
        validation.addField('input[name="nivel_academico"]', [{ rule: 'required', errorMessage: 'Debes seleccionar un nivel académico' }]);
    }

    // Situación laboral
    if (document.querySelector('input[name="situacion_laboral"]')) {
        validation.addField('input[name="situacion_laboral"]', [{ rule: 'required', errorMessage: 'Debes seleccionar tu situación laboral' }]);
    }

    // Otro curso
    if (textInput) {
        validation.addField('#otro_curso_text', [{
            validator: (value) => radioSi.checked ? value.trim() !== '' : true,
            errorMessage: 'Debes indicar el curso'
        }]);
    }

    // -------------------- IDIOMAS --------------------
    document.querySelectorAll('.chk-idioma').forEach((checkbox) => {
        const checkboxEl = document.getElementById(checkbox.id);
        const index = Number(checkbox.dataset.index);

        // Radios combinando oficiales + no oficiales
        const niveles = [...['A1', 'A2', 'B1', 'B2', 'C1', 'C2'], ...['Básico', 'Medio', 'Avanzado']];
        const radiosContainer = checkbox.closest('.idioma-group').querySelector('.niveles');
        const radios = radiosContainer ? radiosContainer.querySelectorAll('input[type="radio"]') : [];

        // Inicializar visibilidad y habilitación
        function toggleNiveles() {
            if (checkboxEl.checked) {
                if (radiosContainer) radiosContainer.style.display = 'block';
                radios.forEach(r => r.disabled = false);
                // "Otro idioma"
                if (checkbox.nextElementSibling.textContent.trim() === 'Otro idioma') {
                    const otroInput = document.getElementById('otro_idioma');
                    const otroContainer = document.getElementById('otro_idioma_container');
                    if (otroInput && otroContainer) {
                        otroContainer.style.display = 'block';
                        otroInput.disabled = false;
                    }
                }
            } else {
                if (radiosContainer) radiosContainer.style.display = 'none';
                radios.forEach(r => { r.disabled = true; r.checked = false; });
                if (checkbox.nextElementSibling.textContent.trim() === 'Otro idioma') {
                    const otroInput = document.getElementById('otro_idioma');
                    const otroContainer = document.getElementById('otro_idioma_container');
                    if (otroInput && otroContainer) {
                        otroContainer.style.display = 'none';
                        otroInput.disabled = true;
                        otroInput.value = '';
                    }
                }
            }
        }

        checkboxEl.addEventListener('change', toggleNiveles);
        toggleNiveles();

        // Validación con JustValidate
        if (typeof validation !== 'undefined') {
            const radioSelector = `input[name="IDIOMA_${index}"]`;
            validation.addField(radioSelector, [{
                validator: () => {
                    if (!checkboxEl.checked) return true; // no obligatorio si no se marca idioma
                    return Array.from(document.querySelectorAll(radioSelector)).some(r => r.checked);
                },
                errorMessage: 'Debes seleccionar un nivel si has marcado este idioma'
            }]);

            if (checkbox.nextElementSibling.textContent.trim() === 'Otro idioma') {
                const otroInput = document.getElementById('otro_idioma');
                if (otroInput) {
                    validation.addField(`#${otroInput.id}`, [{
                        validator: value => checkboxEl.checked ? value.trim() !== '' : true,
                        errorMessage: 'Debes especificar el otro idioma'
                    }]);
                }
            }
        }
    });

    // -------------------- MOTIVOS --------------------
    if (document.getElementById('motivo_interes')) {
        validation.addField('#motivo_interes', [{
            validator: () => {
                const motivosMarcados = document.querySelectorAll(
                    '#motivo_interes:checked, #motivo_prestacion:checked, #motivo_cualificacion:checked, #motivo_trabajo:checked, #motivo_sector:checked, #motivo_otros:checked'
                );
                return motivosMarcados.length > 0;
            },
            errorMessage: 'Debes seleccionar al menos un motivo',
            errorFieldCssClass: 'is-invalid'
        }], { errorsContainer: '#motivos_error' });
    }

    // -------------------- FIRMA --------------------
    if (document.querySelector('#signature canvas')) {
        validation.addField('#signature canvas', [{
            validator: () => {
                const canvas = document.querySelector('#signature canvas');
                const blank = document.createElement('canvas');
                blank.width = canvas.width;
                blank.height = canvas.height;
                return canvas.toDataURL() !== blank.toDataURL();
            },
            errorMessage: 'Debes firmar antes de enviar el formulario'
        }]);
    }

    // -------------------- ENVÍO --------------------
    validation.onSuccess(() => {
        if (btn) {
            btn.disabled = true;
            if (btnText) btnText.textContent = 'Enviando...';
            if (spinner) spinner.style.display = 'inline-block';
        }

        const canvas = document.getElementById("signatureCanvas");
        const signatureInput = document.getElementById("signatureInput");
        if (canvas && signatureInput && typeof SignaturePad !== 'undefined') {
            const signaturePad = new SignaturePad(canvas);
            if (!signaturePad.isEmpty()) signatureInput.value = signaturePad.toDataURL();
        }

        // Submit con setTimeout para evitar bloqueo si falla la validación
        setTimeout(() => form.submit(), 50);
    });
});
