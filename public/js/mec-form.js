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
        validation.addField('input[name="nivel_academico"]', [
            { rule: 'required', errorMessage: 'Debes seleccionar un nivel académico' }
        ]);
    }

    // Situación laboral
    if (document.querySelector('input[name="situacion_laboral"]')) {
        validation.addField('input[name="situacion_laboral"]', [
            { rule: 'required', errorMessage: 'Debes seleccionar tu situación laboral' }
        ]);
    }

    // -------------------- IDIOMAS --------------------
    const idiomas = document.querySelectorAll('.chk-idioma');

    idiomas.forEach((checkbox) => {
        const grupo = checkbox.closest('.idioma-group');
        const nivelesContainer = grupo.querySelector('.niveles');
        const radios = nivelesContainer.querySelectorAll('input[type="radio"]');
        const otroContainer = grupo.querySelector('#otro_idioma_container');
        const otroInput = otroContainer ? otroContainer.querySelector('input') : null;

        const idiomaName = checkbox.nextElementSibling.textContent.trim();
        const sufijo = idiomaName === 'FRANCÉS' ? '_2' : (idiomaName === 'OTRO' ? '_3' : '');

        function toggleIdioma() {
            if (checkbox.checked) {
                nivelesContainer.style.display = 'block';
                radios.forEach(r => r.disabled = false);

                if (idiomaName === 'OTRO' && otroInput) {
                    otroInput.disabled = false;
                    otroContainer.style.display = 'block';
                }
            } else {
                nivelesContainer.style.display = 'none';
                radios.forEach(r => { r.disabled = true; r.checked = false; });

                if (idiomaName === 'OTRO' && otroInput) {
                    otroInput.disabled = true;
                    otroInput.value = '';
                    otroContainer.style.display = 'none';
                }
            }
        }

        // Solo un nivel por idioma
        radios.forEach(radio => {
            radio.addEventListener('change', () => {
                radios.forEach(r => { if (r !== radio) r.checked = false; });
            });
        });

        checkbox.addEventListener('change', () => {
            checkbox.value = checkbox.checked ? '1' : '0';
            toggleIdioma();
        });

        toggleIdioma();
        checkbox.value = checkbox.checked ? '1' : '0';

        // Antes de enviar, formatea el valor final
        form.addEventListener('submit', () => {
            const carnet = document.querySelector('input[name="carnet"]:checked');
            if (carnet) {
                carnet.value = carnet.value === '1' ? 'sí' : 'no';
            }


            let nivel = '';
            radios.forEach(r => { if (r.checked) nivel = r.value + sufijo; });

            if (checkbox.checked && nivel) {
                if (idiomaName === 'OTRO' && otroInput && otroInput.value.trim() !== '') {
                    checkbox.value = `OTRO=${nivel}:${otroInput.value.trim()}`;
                } else {
                    checkbox.value = `${idiomaName}=${nivel}`;
                }
            } else {
                checkbox.value = '';
            }
        });
    });

    // -------------------- FIRMA --------------------
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

        setTimeout(() => form.submit(), 50);
    });
});
