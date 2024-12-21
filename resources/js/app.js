// app.js
console.log("app.js loaded");

import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

// Vérifiez si les routes globales sont définies
console.log("Message Inbox Route:", window.routes?.messagesInbox);

if (!window.routes || !window.routes.messagesInbox) {
    console.error("Route 'messages.inbox' is not defined.");
}
document.addEventListener("DOMContentLoaded", function() {
    console.log("DOM fully loaded and parsed");

    const notificationContainer = document.getElementById('notifications');
    const notificationCount = document.getElementById('notification-count');

    if (notificationContainer) {
        console.log("Element #notifications found in DOM.");
    } else {
        console.log("Element #notifications NOT found in DOM.");
    }

    if (notificationCount) {
        console.log("Element #notification-count found in DOM.");
    } else {
        console.log("Element #notification-count NOT found in DOM.");
    }

// Vérifiez si l'utilisateur est authentifié
if (window.userIsAuthenticated) {
    window.Pusher = Pusher;
    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: import.meta.env.VITE_PUSHER_APP_KEY,
        cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
        forceTLS: true,
    });

    console.log("Echo instance initialized:", window.Echo);
    console.log("Pusher key:", import.meta.env.VITE_PUSHER_APP_KEY);
    console.log("Pusher cluster:", import.meta.env.VITE_PUSHER_APP_CLUSTER);

    if (window.Echo && typeof window.Echo.private === 'function') {
        console.log("Setting up private Echo listener.");
        window.Echo.private('chat')
            .listen('.message.sent', (e) => {  // Assurez-vous de l'utiliser avec le point
                console.log("Message received in Echo listener:", e.message); // Ajoutez ce log
                displayNotification(e.message);
                const notificationCount = document.getElementById('notification-count');
                notificationCount.innerText = parseInt(notificationCount.innerText) + 1;
            });
    } else {
        console.error("Echo instance or private method is not initialized.");
    }
} else {
    console.log("User is not authenticated, Echo is not initialized.");
}

function displayNotification(message) {
    console.log('Display Notification:', message);


    // Ajout de la notification dans la liste
    const notification = document.createElement('div');
    notification.classList.add('notification');
    
    // Ajout d'un lien pour rediriger vers la messagerie
    notification.innerHTML = `
        <p>Vous avez un nouveau message de => ${message.sender.name}</p>
        <a href="${window.routes.messagesInbox}" class="notification-link">Go to messages</a>
    `;
    notificationContainer.appendChild(notification);
    console.log("Notification added to the DOM.");

    // Mise à jour du compteur de notifications
    const notificationCount = document.getElementById('notification-count');
    if (notificationCount) {
        notificationCount.innerText = parseInt(notificationCount.innerText) + 1;
    } else {
        console.error("Element #notification-count not found in the DOM.");
    }
}

});
function toggleNotificationDropdown() {
    const dropdown = document.getElementById('notification-dropdown');
    dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
}

window.toggleNotificationDropdown = toggleNotificationDropdown;
