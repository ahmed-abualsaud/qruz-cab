<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    
    <body class="antialiased">
    

		<button onclick="startFCM()"
                    class="btn btn-danger btn-flat">Allow notification
                </button>
  
<!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase.js"></script>

<script>
    var firebaseConfig = {
        apiKey: "AIzaSyCbiCWNbYQ44sdqhrw90PzgoyeTnQIqCMI",
        authDomain: "qruz-5494b.firebaseapp.com",
        databaseURL: "https://qruz-5494b-default-rtdb.firebaseio.com",
        projectId: "qruz-5494b",
        storageBucket: "qruz-5494b.appspot.com",
        messagingSenderId: "185120621349",
        appId: "1:185120621349:web:de35fb0f7f3eadcece50cc",
        measurementId: "G-48VCNHG4ZD"
    };

    firebase.initializeApp(firebaseConfig);
    const messaging = firebase.messaging();

    function startFCM() {
        messaging
            .requestPermission()
            .then(function () {
                return messaging.getToken()
            })
            .then(function (response) {
                console.log(response);

            }).catch(function (error) {
                alert(error);
            });
    }

    messaging.onMessage(function (payload) {
        const title = payload.notification.title;
        const options = {
            body: payload.notification.body,
            icon: payload.notification.icon,
        };
        //console.log(title);
        alert(payload.notification.body);
        //new Notification(title, options);
    });

</script>

    </body>
</html>