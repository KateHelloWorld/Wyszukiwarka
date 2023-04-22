let time = document.getElementById('time').textContent;
const countdownEl = document.getElementById('time');

setInterval(updateCountdown, 1000);

function updateCountdown(){
    let minutes = Math.floor(time/60);
    if(minutes<10) minutes = '0'+ minutes;
    let seconds = time%60;
    if(seconds<10) seconds = '0' + seconds;
    countdownEl.innerHTML = `${minutes}:${seconds}`;
    time ++;
}