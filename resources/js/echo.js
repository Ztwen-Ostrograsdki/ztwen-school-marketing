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

// USER LISTENED EVENT
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

// ADMIN LISTENED EVENT
e.private("admin").listen(
    "NotificationDispatchedToAdminsSuccessfullyEvent",
    (user) => {
        Livewire.dispatch(
            "LiveNotificationDispatchedToAdminsSuccessfullyEvent",
            user
        );
    }
);

// USERS EMAIL VERIFIED LISTENED EVENT
e.private("confirmeds")
    .listen("UserDataHasBeenUpdatedEvent", (user) => {
        Livewire.dispatch("LiveUserDataHasBeenUpdatedEvent", user);
    })
    .listen("SchoolDataHasBeenUpdatedEvent", (user) => {
        Livewire.dispatch("LiveSchoolDataHasBeenUpdatedEvent", user);
    })
    .listen("NewSchoolCreatedEvent", (user) => {
        Livewire.dispatch("LiveNewSchoolCreatedEvent", user);
    })
    .listen("NewUserCreatedEvent", (user) => {
        Livewire.dispatch("LiveNewUserCreatedEvent", user);
    });

// PUBLIC LISTENED EVENT
e.channel("public")
    .listen("UserDataHasBeenUpdatedEvent", (user) => {
        Livewire.dispatch("LiveUserDataHasBeenUpdatedEvent", user);
    })
    .listen("SchoolDataHasBeenUpdatedEvent", (user) => {
        Livewire.dispatch("LiveSchoolDataHasBeenUpdatedEvent", user);
    })
    .listen("NewSchoolCreatedEvent", (user) => {
        Livewire.dispatch("LiveNewSchoolCreatedEvent", user);
    })
    .listen("NewUserCreatedEvent", (user) => {
        Livewire.dispatch("LiveNewUserCreatedEvent", user);
    });
