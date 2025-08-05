document.addEventListener('DOMContentLoaded', function () {
    const validator = new JustValidate('#form');
    const otherQualification = document.getElementById('otherQualification');
    const zzContainer = document.getElementById('zzOtherContainer');
    const zzInput = document.getElementById('zzOtherText');
    const professionalCategoryInput = document.getElementById('professionalCategory');
    const professionalCategoryNote = document.getElementById('qualificationNote');
    const participantStatus = document.getElementById('participantStatus');
    const participantStatusNote = document.getElementById('participantStatusNote');
    const employmentRegimeInput = document.getElementById('employmentRegime');
    const companyInput = document.getElementById('company');
    const functionalAreaInput = document.getElementById('functionalArea');
    const businessData = document.getElementById('businessData');
    const canvas = document.getElementById("signatureCanvas");
    const ratio = Math.max(window.devicePixelRatio || 1, 1);
    const filteredFields = [
        document.getElementById('studyLevel'),
        document.getElementById('contributionGroup'),
        document.getElementById('cno'),
        document.getElementById('province'),
        professionalCategoryInput,
        functionalAreaInput,
        employmentRegimeInput,
        participantStatus,
        otherQualification
    ]

    function isPortrait() {
        return window.matchMedia("(orientation: portrait)").matches;
    }

    function resizeCanvas() {
        canvas.width = canvas.offsetWidth * ratio;

        if(isPortrait()) canvas.height = (canvas.offsetWidth * ratio)*.6;
        else canvas.height = (canvas.offsetWidth * ratio)*.4;

        canvas.getContext("2d").scale(ratio, ratio);
    }

    resizeCanvas();

    const signaturePad = new SignaturePad(canvas);

    window.addEventListener("resize", resizeCanvas);

    document.getElementById("clearCanvas").addEventListener("click", () => {
        signaturePad.clear();
    });

    filteredFields.forEach(function(item) {
        new Choices(item, {
            searchEnabled: true,
            itemSelectText: '',
            shouldSort: false,
        });
    });

    otherQualification.addEventListener('change', () => {
        zzContainer.classList.toggle('d-none', otherQualification.value !== 'ZZ');
    });

    professionalCategoryInput.addEventListener('change', () => {
        if (professionalCategoryInput.value === 'baja_cualificacion') professionalCategoryNote.classList.remove('d-none');
        else professionalCategoryNote.classList.add('d-none');
    });

    participantStatus.addEventListener('change', () => {
        if (participantStatus.value === 'dspld') participantStatusNote.classList.remove('d-none');
        else participantStatusNote.classList.add('d-none');

        if (participantStatus.value === 'ocupado') businessData.classList.remove('d-none');
        else businessData.classList.add('d-none');
    });

    validator
        .addField('#name', [
            { rule: 'required', errorMessage: 'Este campo es obligatorio' }
        ])
        .addField('#firstSurname', [
            { rule: 'required', errorMessage: 'Este campo es obligatorio' }
        ])
        .addField('#secondSurname', [
            { rule: 'required', errorMessage: 'Este campo es obligatorio' }
        ])
        .addField('#address', [
            { rule: 'required', errorMessage: 'Este campo es obligatorio' }
        ])
        .addField('#locality', [
            { rule: 'required', errorMessage: 'Este campo es obligatorio' }
        ])
        .addField('#province', [
            {rule: 'required', errorMessage: 'Este campo es obligatorio',}
        ])
        .addField('#postalCode', [
            { rule: 'required', errorMessage: 'Este campo es obligatorio' },
            {
                validator: value =>
                    /^(0[1-9]|[1-4][0-9]|5[0-2])\d{3}$/.test(value),
                errorMessage: 'El formato de este código postal es incorrecto',
            }
        ])
        .addField('#email', [
            { rule: 'required', errorMessage: 'Este campo es obligatorio' },
            { rule: 'email', errorMessage: 'El formato de este email es incorrecto' }
        ])
        .addField('#phone', [
            { rule: 'required', errorMessage: 'Este campo es obligatorio' },
            {
                validator: value =>
                    /^(?:\+34|34)?\s?(6|7|8|9)\d{2}[\s-]?\d{3}[\s-]?\d{3}$/.test(value),
                errorMessage: 'El formato de este teléfono es inválido',
            }
        ])
        .addField('#nif', [
            { rule: 'required', errorMessage: 'Este campo es obligatorio' },
            {
                validator: value => isValidDniNie(value),
                errorMessage: 'El formato de DNI o NIE es inválido',
            }
        ])
        .addField('#ssnumber', [
            { rule: 'required', errorMessage: 'Este campo es obligatorio' },
            {
                validator: value => /^\d{12}$/.test(value),
                errorMessage: 'El formato de este número de afiliación es inválido',
            }
        ])
        .addField('#birthdate', [
            { rule: 'required', errorMessage: 'Este campo es obligatorio',},
            {
                validator: (value) => {
                    const inputDate = new Date(value);
                    const today = new Date();

                    inputDate.setHours(0, 0, 0, 0);
                    today.setHours(0, 0, 0, 0);

                    return inputDate < today;
                },
                errorMessage: 'La fecha debe ser anterior a hoy',
            }
        ])
        .addField('#studyLevel', [
            {
                rule: 'required',
                errorMessage: 'Este campo es obligatorio',
            }
        ])
        .addField('#contributionGroup', [
            {
                rule: 'required',
                errorMessage: 'Este campo es obligatorio',
            }
        ])
        .addField('#zzOtherText', [
            {
                validator: () => {
                    if (otherQualification.value === 'ZZ') {
                        return zzInput.value.trim() !== '';
                    }
                    return true;
                },
                errorMessage: 'Este campo es obligatorio',
            }
        ])
        .addField('#professionalCategory', [
            {
                rule: 'required',
                errorMessage: 'Este campo es obligatorio',
            }
        ])
        .addField('#cno', [
            {
                rule: 'required',
                errorMessage: 'Este campo es obligatorio',
            }
        ])
        .addField('#participantStatus', [
            { rule: 'required', errorMessage: 'Este campo es obligatorio' }
        ])
        .addField('#employmentRegime', [
            {
                validator: () => {
                    if (participantStatus.value === 'ocupado') {
                        return employmentRegimeInput.value.trim() !== '';
                    }
                    return true;
                },
                errorMessage: 'Este campo es obligatorio',
            }
        ])
        .addField('#company', [
            {
                validator: () => {
                    if (participantStatus.value === 'ocupado') {
                        return companyInput.value.trim() !== '';
                    }
                    return true;
                },
                errorMessage: 'Este campo es obligatorio',
            }
        ])
        .addField('#functionalArea', [
            {
                validator: () => {
                    if (participantStatus.value === 'ocupado') {
                        return functionalAreaInput.value.trim() !== '';
                    }
                    return true;
                },
                errorMessage: 'Este campo es obligatorio',
            }
        ])
        .addField('#cif', [
            {
                validator: value => {
                    if (participantStatus.value !== 'ocupado') return true;

                    const input = value.trim().toUpperCase();

                    if (isValidDniNie(input)) return true;

                    const cifRegex = /^[ABCDEFGHJNPQRSUVW][0-9]{7}[0-9A-J]$/;
                    if (!cifRegex.test(input)) return false;

                    const letters = 'JABCDEFGHI';
                    const control = input[input.length - 1];
                    const digits = input.slice(1, -1);

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
                    const firstChar = input[0];

                    if ('ABEH'.includes(firstChar)) {
                        return control === controlDigit.toString();
                    } else if ('KPQS'.includes(firstChar)) {
                        return control === controlLetter;
                    } else {
                        return control === controlDigit.toString() || control === controlLetter;
                    }
                },
                errorMessage: 'El formato de CIF, DNI o NIE es inválido',
            }
        ])
        .addField('#signatureCanvas', [
            {
                validator: value => {
                    return !signaturePad.isEmpty();
                },
                errorMessage: 'Por favor, firma antes de enviar',
            }
        ])
        .addRequiredGroup('#genderGroup', 'Debes seleccionar una opción')
        .addRequiredGroup('#disabilityGroup', 'Debes seleccionar una opción')
        .onSuccess((event) => {
            const btn = document.getElementById('submitBtn');
            btn.disabled = true;
            btn.innerText = 'Enviando...';

            document.getElementById("signatureInput").value = signaturePad.toDataURL();

            event.target.submit();
        });
});

function isValidDniNie(input) {
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
}
