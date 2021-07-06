document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        selectable: true,
        initialView: 'dayGridMonth',
        initialDate: '2021-06-07',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        eventSources: [
            {
                url: '/appointments/background',
                color: 'yellow',
                textColor: 'black'
            },
            {
                url: '/appointments',
                color: 'green',
                textColor: 'black'
            }
        ],
        select: function (info) {
            launchModal(info)
        }
    });

    calendar.render();

    function launchModal(info) {
        $("#error-messages").hide();
        $('#appointmentModal').modal()
        $("#patientName").val("");
        $("#dateStart").val(info.startStr);
        $("#timeStart").val((new Date(info.startStr).getHoursFixed()));
        $("#timeEnd").val((new Date(info.startStr).addHours(2).getHoursFixed()));
        $("#repeat").val('none');
        $('#repeat-date-end-container').hide();
    }

    document.getElementById('appointment-form').addEventListener('submit', function () {
        event.preventDefault();

        fetch('/appointments/create', {
            method: 'POST',
            body: JSON.stringify({
                'patientName': $("#patientName").val(),
                'dateStart': $("#dateStart").val(),
                'dateEnd': $("#dateEnd").val(),
                'timeStart': $("#timeStart").val(),
                'timeEnd': $("#timeEnd").val(),
                'repeat': $("#repeat").val()
            }),
            headers: {
                'Content-type': 'application/json; charset=UTF-8'
            }
        }).then(function (response) {
            $("#error-messages").hide();
            if (response.ok) {
                return response.json();
            }
            return Promise.reject(response);
        }).then(function (data) {
            if (data.error === false) {
                $('#appointmentModal').modal('hide');
                calendar.refetchEvents()
            } else {
                var errorMessages = $("#error-messages");
                errorMessages.show();
                errorMessages.html(data.error);
            }
        }).catch(function (error) {
            console.log('Something went wrong.', error.body);
        });
    })
    $("#repeat").change(function () {
        const repeatContainer = $("#repeat-date-end-container");
        if (this.value !== "none") {
            repeatContainer.show();
        } else {
            repeatContainer.hide();
        }
    });
    Date.prototype.addHours = function (h) {
        this.setHours(this.getHours() + h);
        return this;
    }
    Date.prototype.getHoursFixed = function () {
        return this.getHours().toString().padStart(2, 0) + ":00";
    }
});
