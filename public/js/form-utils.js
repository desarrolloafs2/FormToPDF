/**
 * Valida si un DNI o NIE es correcto
 */
window.isValidDniNie = function(input) {
    const value = input.trim().toUpperCase();
    const validLetters = 'TRWAGMYFPDXBNJZSQVHLCKE';

    const dniPattern = /^\d{8}[A-Z]$/;
    if (dniPattern.test(value)) {
        const number = parseInt(value.slice(0, 8), 10);
        return validLetters[number % 23] === value.slice(-1);
    }

    const niePattern = /^[XYZ]\d{7}[A-Z]$/;
    if (niePattern.test(value)) {
        const prefixNumber = { X: '0', Y: '1', Z: '2' }[value[0]];
        const number = parseInt(prefixNumber + value.slice(1, 8), 10);
        return validLetters[number % 23] === value.slice(-1);
    }

    return false;
};

/**
 * Valida si un CIF es correcto (según normativa AEAT)
 */
window.isValidCif = function(input) {
    const value = input.trim().toUpperCase();
    const cifRegex = /^[ABCDEFGHJNPQRSUVW][0-9]{7}[0-9A-J]$/;

    if (!cifRegex.test(value)) return false;

    const letters = 'JABCDEFGHI';
    const control = value[value.length - 1];
    const digits = value.slice(1, -1);
    const firstChar = value[0];

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

    if ('ABEH'.includes(firstChar)) {
        return control === controlDigit.toString();
    } else if ('KPQS'.includes(firstChar)) {
        return control === controlLetter;
    } else {
        return control === controlDigit.toString() || control === controlLetter;
    }
};

/**
 * Verifica si una fecha es anterior a hoy
 */
window.isDateBeforeToday = function(value) {
    const inputDate = new Date(value);
    const today = new Date();

    inputDate.setHours(0, 0, 0, 0);
    today.setHours(0, 0, 0, 0);

    return inputDate < today;
};

/**
 * Inicializa Choices.js sobre múltiples elementos
 */
window.enableChoices = function(fields) {
    fields.forEach(function(item) {
        new Choices(item, {
            searchEnabled: true,
            itemSelectText: '',
            shouldSort: false,
        });
    });
};

/**
 * Verifica si un SignaturePad no está vacío
 */
window.isSignatureValid = function(signaturePad) {
    return signaturePad && !signaturePad.isEmpty();
};

/**
 * Establece el valor del input oculto con la firma
 */
window.setSignatureValue = function(signaturePad, hiddenInputId = 'signatureInput') {
    const input = document.getElementById(hiddenInputId);
    if (input && signaturePad && !signaturePad.isEmpty()) {
        input.value = signaturePad.toDataURL();
    }
};
