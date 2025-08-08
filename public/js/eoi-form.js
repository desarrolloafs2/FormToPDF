
document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    if (!form) return;

    const validator = new JustValidate(`#${form.id}`);

    validator
        .addField('#firstSurname', [{ rule: 'required', errorMessage: 'Campo obligatorio' }])
        .addField('#name', [{ rule: 'required', errorMessage: 'Campo obligatorio' }])
        .addField('#tipo_documento', [{ rule: 'required', errorMessage: 'Campo obligatorio' }])
        .addField('#nif', [
            { rule: 'required', errorMessage: 'Campo obligatorio' },
            {
                validator: (value, fields) => {
                    const tipo = document.getElementById('tipo_documento').value;
                    if (tipo === 'DNI' || tipo === 'NIE') return isValidDniNie(value);
                    return true; // Pasaporte no se valida
                },
                errorMessage: 'Documento inválido',
            }
        ])
        .addField('#telefono', [
            { rule: 'required', errorMessage: 'Campo obligatorio' },
            {
                validator: value =>
                    /^(\+34|34)?\s?(6|7|8|9)\d{2}[\s-]?\d{3}[\s-]?\d{3}$/.test(value),
                errorMessage: 'Formato de teléfono inválido',
            }
        ])
        .addField('#email', [
            { rule: 'required', errorMessage: 'Campo obligatorio' },
            { rule: 'email', errorMessage: 'Formato de email inválido' }
        ])
        .addField('#empresa', [{ rule: 'required', errorMessage: 'Campo obligatorio' }])
        .addField('#nif_empresa', [
            { rule: 'required', errorMessage: 'Campo obligatorio' },
            {
                validator: value => isValidCif(value),
                errorMessage: 'CIF inválido',
            }
        ])
        .addField('#actividad_empresa', [{ rule: 'required', errorMessage: 'Campo obligatorio' }])
        .addField('#tamano_empresa', [{ rule: 'required', errorMessage: 'Campo obligatorio' }])
        .addField('#dni_file', [{ rule: 'required', errorMessage: 'Campo obligatorio' }])
        .addField('#condiciones', [
            {
                validator: () => document.getElementById('condiciones').checked,
                errorMessage: 'Debes aceptar el condicionado',
            }
        ])
        .onSuccess((event) => {
            const btn = form.querySelector('[type="submit"]');
            if (btn) {
                btn.disabled = true;
                btn.innerText = 'Enviando...';
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