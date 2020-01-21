// define vars to hold time values
let seconds = 0;
let minutes = 0;
let hours = 0;

//define vars to hold display value
let displaySeconds = 0;
let displayMinutes = 0;
let displayHours = 0;

//define var to hold setinvervall() function
let intervall = null;

//define var to hold stopwatch status
let status = "stopped";

// stopwatch function
function stopWatch() {

    seconds++;

    if (seconds / 60 === 1) {
        seconds = 0;
        minutes++;

        if (minutes / 60 === 1) {
            minutes = 0;
            hours++;
        }
    }

    //if s/m/h are onlye one digit, add a leading zero
    if (seconds < 10) {
        displaySeconds = "0" + seconds.toString();

    } else {
        displaySeconds = seconds;
    }

    if (minutes < 10) {
        displayMinutes = "0" + minutes.toString();
    } else {
        displayMinutes = minutes;
    }

    if (hours < 10) {
        displayHours = "0" + hours.toString();
    } else {
        displayHours = hours;
    }

    //display updated time values to users
    document.getElementById("display").innerHTML = displayHours + ":" + displayMinutes + ":" + displaySeconds;

}


function startStop() {
    if (status === "stopped") {
        //start th stpowatch (time setIntervall) function
        intervall = window.setInterval(stopWatch, 1000);
        document.getElementById("startStop").innerHTML = "Stop";
        status = "started";

    } else {
        window.clearInterval(intervall);
        document.getElementById("startStop").innerHTML = "Start";
        status = "stopped"
    }
}

function reset() {
    window.clearInterval(intervall);
    seconds = 0;
    minutes = 0;
    hours = 0;

    document.getElementById("display").innerHTML = "00:00:00";
    document.getElementById("startStop").innerHTML = "Start";
}