import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';

document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');

    if (calendarEl) {
        const calendar = new Calendar(calendarEl, {
            plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin],
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            locale: 'fr',
            events: '/api/mentorship-sessions', // Charge les séances depuis l'API
            eventClassNames: function () {
                return ['custom-event']; // Ajoute la classe CSS
            },
            eventClick: function (info) {
                // Redirige directement vers le lien de la réunion
                window.location.href = info.event.url;
            }
        });

        calendar.render();
    }
});
