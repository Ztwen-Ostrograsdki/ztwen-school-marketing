import Echo from "laravel-echo";

import Pusher from "pusher-js";
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: "reverb",
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? "https") === "https",
    enabledTransports: ["ws", "wss"],
});

var e = window.Echo;

window.ClientUser = {
    id: 0,
};

if (window.User) {
    window.ClientUser = window.User;
}

// USER CHANNELS
e.private("App.Models.User." + window.ClientUser.id)

    .notification((notification) => {
        Livewire.dispatch("LiveNewLiveNotificationEvent");

        if (notification.type == "new.notification") {
        }
    })

    .listen("LogoutUserEvent", (ev) => {
        Livewire.dispatch("LiveLogoutUserEvent", ev);
    })

    .listen("IHaveNewNotificationEvent", (data) => {
        Livewire.dispatch("LiveIHaveNewNotificationEvent", ev);
    })

    .listen("NotificationsDeletedSuccessfullyEvent", (data) => {
        Livewire.dispatch("LiveNotificationsDeletedSuccessfullyEvent");
    });

// ADMIN CHANNELS
e.private("admin")
    .listen("NotificationDispatchedToAdminsSuccessfullyEvent", (user) => {
        Livewire.dispatch(
            "LiveNotificationDispatchedToAdminsSuccessfullyEvent",
            user
        );
    })
    .listen("NewLyceeCreatedSuccessfullyEvent", (data) => {
        Livewire.dispatch("LiveNewLyceeCreatedSuccessfullyEvent", data);
    })
    .listen("UpdateUsersListToComponentsEvent", (data) => {
        Livewire.dispatch("LiveUpdateUsersListToComponentsEvent");
    });

e.private("confirmeds").listen("UserDataHasBeenUpdatedEvent", (user) => {
    Livewire.dispatch("LiveUserDataHasBeenUpdatedEvent", user);
});

e.channel("public").listen("UserDataHasBeenUpdatedEvent", (user) => {
    Livewire.dispatch("LiveUserDataHasBeenUpdatedEvent", user);
});
