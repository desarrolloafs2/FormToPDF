document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    if (!form) return;

    const btn = form.querySelector('[type="submit"]');
    const btnText = btn?.querySelector('.btn-text');
    const spinner = btn?.querySelector('.spinner');

    // Siempre reactivar botón al cargar
    if (btn) {
        btn.disabled = false;
        if (btnText) btnText.textContent = 'Enviar';
        if (spinner) spinner.style.display = 'none';
    }

    const validator = new JustValidate(`#${form.id}`);

    // Función avanzada de safeAddField
    function safeAddField(field, rules) {
        if (!Array.isArray(rules) || rules.length === 0) {
            rules = [{ rule: 'required', errorMessage: 'Campo obligatorio' }];
        }

        let selector;

        if (field.type === 'radio' || field.type === 'checkbox') {
            selector = `[name="${field.name}"]`;
            if (!rules.some(r => r.validator)) {
                rules.push({
                    validator: () => {
                        const checked = form.querySelectorAll(selector + ':checked');
                        return checked.length > 0;
                    },
                    errorMessage: 'Debes seleccionar al menos una opción'
                });
            }
        } else {
            selector = field.id ? `#${field.id}` : `[name="${field.name}"]`;
        }

        if (document.querySelector(selector)) {
            validator.addField(selector, rules);
        } else {
            console.warn(`⚠ Campo no encontrado: ${selector}`);
        }
    }

    // Recorremos todos los inputs, selects y textareas
    const allFields = form.querySelectorAll('input, select, textarea');
    allFields.forEach(field => {
        let rules = [];

        // Por defecto todos son required, salvo checkboxes/radios que se gestionan aparte
        if (field.type !== 'checkbox' && field.type !== 'radio') {
            rules.push({ rule: 'required', errorMessage: 'Campo obligatorio' });
        }

        // Validaciones específicas por id
        switch (field.id) {
            case 'nif':
                rules.push({
                    validator: (value) => {
                        const tipo = document.getElementById('tipo_documento')?.value;
                        if (tipo === 'DNI' || tipo === 'NIE') return isValidDniNie(value);
                        return true;
                    },
                    errorMessage: 'Documento inválido',
                });
                break;

            case 'telefono':
                rules.push({
                    validator: value => /^(\+34|34)?\s?(6|7|8|9)\d{2}[\s-]?\d{3}[\s-]?\d{3}$/.test(value),
                    errorMessage: 'Formato de teléfono inválido',
                });
                break;

            case 'email':
                rules.push({ rule: 'email', errorMessage: 'Formato de email inválido' });
                break;

            case 'nif_empresa':
                rules.push({
                    validator: value => isValidCif(value),
                    errorMessage: 'CIF inválido',
                });
                break;

            case 'condiciones':
                rules = [{
                    validator: () => field.checked,
                    errorMessage: 'Debes aceptar el condicionado',
                }];
                break;
        }

        safeAddField(field, rules);
    });

    validator.onSuccess(() => {
        if (btn) {
            btn.disabled = true;
            if (btnText) btnText.textContent = 'Enviando...';
            if (spinner) spinner.style.display = 'inline-block';
        }

        // Lógica de firma
        const canvas = document.getElementById("signatureCanvas");
        const signatureInput = document.getElementById("signatureInput");
        if (canvas && signatureInput && typeof SignaturePad !== 'undefined') {
            const signaturePad = new SignaturePad(canvas);
            if (!signaturePad.isEmpty()) {
                signatureInput.value = signaturePad.toDataURL();
            }
        }

        form.submit();
    });
});

// Validadores DNI/NIE y CIF
function isValidDniNie(value) {
    const val = value.trim().toUpperCase();
    const letters = 'TRWAGMYFPDXBNJZSQVHLCKE';

    const dni = /^\d{8}[A-Z]$/;
    if (dni.test(val)) {
        const num = parseInt(val.slice(0, 8), 10);
        return letters[num % 23] === val[8];
    }

    const nie = /^[XYZ]\d{7}[A-Z]$/;
    if (nie.test(val)) {
        const prefix = { X: '0', Y: '1', Z: '2' }[val[0]];
        const num = parseInt(prefix + val.slice(1, 8), 10);
        return letters[num % 23] === val[8];
    }

    return false;
}

function isValidCif(value) {
    const cif = value.trim().toUpperCase();
    if (!/^[ABCDEFGHJNPQRSUVW]\d{7}[0-9A-J]$/.test(cif)) return false;

    const control = cif[cif.length - 1];
    const digits = cif.slice(1, -1);
    const letters = 'JABCDEFGHI';

    let sumA = 0, sumB = 0;
    for (let i = 0; i < digits.length; i++) {
        const n = parseInt(digits[i], 10);
        if (i % 2 === 0) {
            const prod = n * 2;
            sumA += Math.floor(prod / 10) + (prod % 10);
        } else {
            sumB += n;
        }
    }

    const total = sumA + sumB;
    const controlDigit = (10 - (total % 10)) % 10;
    const controlLetter = letters[controlDigit];
    const firstChar = cif[0];

    if ('ABEH'.includes(firstChar)) return control === controlDigit.toString();
    if ('KPQS'.includes(firstChar)) return control === controlLetter;
    return control === controlDigit.toString() || control === controlLetter;
}
