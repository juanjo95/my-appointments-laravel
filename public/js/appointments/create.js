let doctor, date, specialty, hours, iRadio;
const noHoursAlert = `<div class="alert alert-danger" role="alert"><strong>Lo sentimos!</strong> No se encontraron horas disponibles para el medico en el dia seleccionado</div>`;

$(function() {

    doctor = $("#doctor");
    date = $("#date");
    specialty = $("#specialty");
    hours = $("#hours");

    specialty.change(() => {
        let specialty_id = specialty.val();
        const URL = `/specialties/${specialty_id}/doctors`;
        $.getJSON(URL, onDoctorsLoaded);
    });

    $("#doctor").change(loadHours);
    $("#date").change(loadHours);
});

function onDoctorsLoaded(doctors) {
    let htmlOptions = "";
    doctors.forEach(doctor => {
        htmlOptions += `<option value="${doctor.id}">${doctor.name}</option>`;
    });
    $("#doctor").html(htmlOptions);
    loadHours();
}

function loadHours() {
    const selectDate = date.val();
    const doctorId = doctor.val();
    const URL = `/schedule/hours?date=${selectDate}&doctor_id=${doctorId}`;
    $.getJSON(URL, displayHours);
}

function displayHours(response) {
    if (!response.morning && !response.afternoon) {
        hours.html(noHoursAlert);
        return;
    }

    let htmlHours = "";
    iRadio = 0;

    if (response.morning) {
        const morning_intervals = response.morning;
        morning_intervals.forEach(interval => {
            htmlHours += getRadioIntervalHtml(interval);
        });
    }

    if (response.afternoon) {
        const afternoon_intervals = response.afternoon;
        afternoon_intervals.forEach(interval => {
            htmlHours += getRadioIntervalHtml(interval);
        });
    }

    hours.html(htmlHours);
}

function getRadioIntervalHtml(interval) {
    const text = `${interval.start} - ${interval.end}`;
    return `<div class="custom-control custom-radio mb-3">
                <input type="radio" id="interval${iRadio}" name="interval" class="custom-control-input" value="${text}">
                <label class="custom-control-label" for="interval${iRadio++}">${text}</label>
            </div>`;
}