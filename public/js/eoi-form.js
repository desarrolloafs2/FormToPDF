document.addEventListener('DOMContentLoaded', function () {
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

    const validator = new JustValidate(`#${form.id}`);

    const fieldsRules = {
        // Datos personales
        firstSurname: [{ rule: 'required', errorMessage: 'El primer apellido es obligatorio' }],
        apellido2: [{ rule: 'required', errorMessage: 'El segundo apellido es obligatorio' }],
        name: [{ rule: 'required', errorMessage: 'El nombre es obligatorio' }],
        tipo_documento: [{ rule: 'required', errorMessage: 'Selecciona un tipo de documento' }],
        nif: [
            { rule: 'required', errorMessage: 'El NIF es obligatorio' },
            {
                validator: value => {
                    const tipo = document.getElementById('tipo_documento')?.value;
                    return (tipo === 'NIF' || tipo === 'NIE' || tipo === 'PASS') ? isValidDniNie(value) : true;
                },
                errorMessage: 'Documento inválido'
            }
        ],
        sexo: [{ rule: 'required', errorMessage: 'Selecciona tu sexo' }],
        fecha_nacimiento: [
            { rule: 'required', errorMessage: 'Fecha de nacimiento obligatoria' },
            {
                validator: value => {
                    const inputDate = new Date(value);
                    const today = new Date();
                    inputDate.setHours(0, 0, 0, 0);
                    today.setHours(0, 0, 0, 0);
                    return inputDate <= today;
                },
                errorMessage: 'La fecha no puede ser posterior al día de hoy'
            }
        ],

        fecha: [
            { rule: 'required', errorMessage: 'Fecha obligatoria' },
            {
                validator: value => {
                    const inputDate = new Date(value);
                    const today = new Date();
                    inputDate.setHours(0, 0, 0, 0);
                    today.setHours(0, 0, 0, 0);
                    return inputDate <= today;
                },
                errorMessage: 'La fecha no puede ser posterior al día de hoy'
            }
        ],
        direccion: [{ rule: 'required', errorMessage: 'Dirección obligatoria' }],
        ciudad: [{ rule: 'required', errorMessage: 'Ciudad obligatoria' }],
        codigo_postal: [
            { rule: 'required', errorMessage: 'Código postal obligatorio' },
            { validator: value => /^(0[1-9]|[1-4][0-9]|5[0-2])\d{3}$/.test(value), errorMessage: 'Código postal inválido' }
        ],
        provincia: [{ rule: 'required', errorMessage: 'Provincia obligatoria' }],
        ccaa: [{ rule: 'required', errorMessage: 'Comunidad autónoma obligatoria' }],
        telefono: [
            { rule: 'required', errorMessage: 'Teléfono obligatorio' },
            {
                validator: value => /^(\+34|34)?\s?(6|7|8|9)\d{2}[\s-]?\d{3}[\s-]?\d{3}$/.test(value),
                errorMessage: 'Formato de teléfono inválido'
            }
        ],
        email: [
            { rule: 'required', errorMessage: 'Correo obligatorio' },
            { rule: 'email', errorMessage: 'Correo inválido' }
        ],

        // Empresa
        empresa: [{ rule: 'required', errorMessage: 'Nombre de empresa obligatorio' }],
        nif_empresa: [
            { rule: 'required', errorMessage: 'NIF de empresa obligatorio' },
            { validator: value => isValidCif(value), errorMessage: 'CIF inválido' }
        ],
        actividad_empresa: [{ rule: 'required', errorMessage: 'Actividad de la empresa obligatoria' }],
        tamano_empresa: [{ rule: 'required', errorMessage: 'Selecciona tamaño de empresa' }],
        province: [{ rule: 'required', errorMessage: 'Provincia obligatoria' }],
        ccaa_empresa: [{ rule: 'required', errorMessage: 'CCAA obligatoria' }],
        antiguedad_empresa: [{ rule: 'required', errorMessage: 'Selecciona antigüedad de empresa' }],
        facturacion: [{ rule: 'required', errorMessage: 'Facturación obligatoria' }],
        ambito_rural: [{ rule: 'required', errorMessage: 'Debes indicar ámbito rural' }],
        politicas_sostenibilidad: [{ rule: 'required', errorMessage: 'Debes indicar políticas de sostenibilidad' }],
        transformacion_digital: [{ rule: 'required', errorMessage: 'Debes indicar transformación digital' }],
        mujer_responsable: [{ rule: 'required', errorMessage: 'Debes indicar responsable mujer' }],
        porcentaje_mujeres: [{ rule: 'required', errorMessage: 'Porcentaje de mujeres obligatorio' }],

        // Consentimientos (checkboxes)
        trabaja_en_pyme: [{ rule: 'required', errorMessage: 'Debes aceptar esta declaración' }],
        info_veraz: [{ rule: 'required', errorMessage: 'Debes aceptar esta declaración' }],
        no_duplicado: [{ rule: 'required', errorMessage: 'Debes aceptar esta declaración' }],
        sin_conflicto: [{ rule: 'required', errorMessage: 'Debes aceptar esta declaración' }],
        autorizo_datos: [{ rule: 'required', errorMessage: 'Debes aceptar el tratamiento de datos' }],
        autorizo_discapacidad: [{ rule: 'required', errorMessage: 'Debes indicar aceptación' }],
        condiciones: [{ rule: 'required', errorMessage: 'Debes aceptar el condicionado' }],

        // Firma y lugar
        lugar: [{ rule: 'required', errorMessage: 'Lugar obligatorio' }],
        signature: [{ rule: 'required', errorMessage: 'Debes firmar el formulario' }]
    };

    function safeAddField(field, rules) {
        let selector;
        if (field.type === 'checkbox') {
            selector = `[name="${field.name}"]`;

            // Solo si hay reglas definidas explícitamente
            if (rules.length > 0) {
                // Si no tiene validador propio, añadimos uno genérico (mínimo 1 check)
                if (!rules.some(r => r.validator)) {
                    rules.push({
                        validator: () => {
                            const checked = form.querySelectorAll(selector + ':checked');
                            return checked.length > 0;
                        },
                        errorMessage: `Debes seleccionar al menos una opción para ${field.name}`
                    });
                }

                validator.addField(selector, rules);
            }
        } else {
            selector = field.id ? `#${field.id}` : `[name="${field.name}"]`;

            if (rules.length > 0) {
                validator.addField(selector, rules);
            }
        }
    }

    // Iteramos todos los inputs, selects, textareas
    const allFields = form.querySelectorAll('input, select, textarea');
    allFields.forEach(field => {
        const rules = fieldsRules[field.id] || fieldsRules[field.name] || [];
        safeAddField(field, rules);
    });

    // On success
    validator.onSuccess(() => {
        if (btn) {
            btn.disabled = true;
            if (btnText) btnText.textContent = 'Enviando...';
            if (spinner) spinner.style.display = 'inline-block';
        }

        // Firma digital
        const canvas = document.getElementById("signatureCanvas");
        const signatureInput = document.getElementById("signatureInput");
        if (canvas && signatureInput && typeof SignaturePad !== 'undefined') {
            const signaturePad = new SignaturePad(canvas);
            if (!signaturePad.isEmpty()) signatureInput.value = signaturePad.toDataURL();
        }

        form.submit();
    });
});

// Validadores auxiliares
function isValidDniNie(value) {
    const val = value.trim().toUpperCase();
    const letters = 'TRWAGMYFPDXBNJZSQVHLCKE';
    const dni = /^\d{8}[A-Z]$/;
    const nie = /^[XYZ]\d{7}[A-Z]$/;

    if (dni.test(val)) return letters[parseInt(val.slice(0, 8), 10) % 23] === val[8];
    if (nie.test(val)) {
        const prefix = { X: '0', Y: '1', Z: '2' }[val[0]];
        return letters[parseInt(prefix + val.slice(1, 8), 10) % 23] === val[8];
    }
    return false;
}

function isValidDocumento(value) {
    const val = value.trim().toUpperCase();
    const letters = 'TRWAGMYFPDXBNJZSQVHLCKE';

    // --- DNI ---
    const dniRegex = /^\d{8}[A-Z]$/;
    if (dniRegex.test(val)) {
        const num = parseInt(val.slice(0, 8), 10);
        return letters[num % 23] === val[8];
    }

    // --- NIE ---
    const nieRegex = /^[XYZ]\d{7}[A-Z]$/;
    if (nieRegex.test(val)) {
        const prefix = { X: '0', Y: '1', Z: '2' }[val[0]];
        const num = parseInt(prefix + val.slice(1, 8), 10);
        return letters[num % 23] === val[8];
    }

    // --- CIF ---
    const cifRegex = /^[ABCDEFGHJNPQRSUVW]\d{7}[0-9A-J]$/;
    if (cifRegex.test(val)) {
        const control = val[val.length - 1];
        const digits = val.slice(1, -1);
        const lettersCif = 'JABCDEFGHI';
        let sumA = 0, sumB = 0;

        for (let i = 0; i < digits.length; i++) {
            const n = parseInt(digits[i], 10);
            if (i % 2 === 0) {
                const prod = n * 2;
                sumA += Math.floor(prod / 10) + (prod % 10);
            } else sumB += n;
        }

        const total = sumA + sumB;
        const controlDigit = (10 - (total % 10)) % 10;
        const controlLetter = lettersCif[controlDigit];
        const firstChar = val[0];

        if ('ABEH'.includes(firstChar)) return control === controlDigit.toString();
        if ('KPQS'.includes(firstChar)) return control === controlLetter;
        return control === controlDigit.toString() || control === controlLetter;
    }

    // Ningún formato válido
    return false;
}

