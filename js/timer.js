// var
var heure = 23;
var minute = 59;
var seconde = 5;
var compteurseconde

var baliseseconde = document.getElementById('seconde_compteur_cloe_plugin')
var baliseminute = document.getElementById('minute_compteur_cloe_plugin')
var baliseheure = document.getElementById('heure_compteur_cloe_plugin')
var timestart
var timestart_heure
var timestart_minute
var timestart_seconde = 0
var timenow
var timestamp
var timestart2
var timestart3

compteurseconde = setInterval(function () {
    if (baliseseconde == null) {
        // mise en place des valeurs
        baliseseconde = document.getElementById('seconde_compteur_cloe_plugin')
        baliseminute = document.getElementById('minute_compteur_cloe_plugin')
        baliseheure = document.getElementById('heure_compteur_cloe_plugin')

        timestart = document.getElementById('time_start_event').innerHTML
        timestart2 = timestart.split(' ', 1)
        timestart3 = timestart2[0].split(':')
        timestart_heure = Number(timestart3[0])
        timestart_minute = Number(timestart3[1])

        timestamp = new Date();
        let seconde_jour = timestamp.getSeconds()
        let minute_jour = timestamp.getMinutes()
        let heure_jour = timestamp.getHours()

        if (timestart_heure <= heure_jour) {
            heure = 0
        } else {
            heure = timestart_heure - heure_jour

        }

    }
    seconde--
    if (seconde < 10 && seconde >= 0) {
        seconde = "0" + seconde
    }
    baliseseconde.innerText = seconde

    if (minute == 0 && seconde == 0) {
        minute = 59
        seconde = 60
        heure--
        if (minute < 10 && minute >= 0) {
            minute = "0" + minute
        }
        if (heure < 10 && heure >= 0) {
            heure = "0" + heure
        }
        baliseminute.innerText = minute
        baliseheure.innerText = heure
        baliseseconde.innerText = seconde
    }
    if (seconde == 0) {
        seconde = 60
        minute--;
        if (minute < 10 && minute >= 0) {
            minute = "0" + minute
        }
        baliseseconde.innerText = seconde
        baliseminute.innerText = minute
    }


}, 1000);