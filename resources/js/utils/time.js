export const convertEstimation = (value, showEstimation = false) => {
    const sec = parseInt(value, 10); // convert value to number if it's string
    let hours = Math.floor(sec / 3600); // get hours
    let minutes = Math.floor((sec - hours * 3600) / 60); // get minutes
    let seconds = sec - hours * 3600 - minutes * 60; //  get seconds

    if (showEstimation) {
        if (minutes > 0) {
            return `${hours}:${minutes}h`;
        }

        return `${hours}h`;
    }

    // add 0 if value < 10; Example: 2 => 02
    if (hours < 10) {
        hours = '0' + hours;
    }
    if (minutes < 10) {
        minutes = '0' + minutes;
    }
    if (seconds < 10) {
        seconds = '0' + seconds;
    }

    return {
        hours,
        minutes,
        seconds,
    };
};

export const parseSecondsToFullTime = (duration) => {
    let h = Math.floor(duration / 3600);
    h = h < 10 ? `0${h}` : h;
    let m = Math.floor((duration / 60) % 60);
    m = m < 10 ? `0${m}` : m;
    let s = duration % 60;
    s = s < 10 ? `0${s}` : s;

    return `${h}:${m}:${s}`;
};

export const parseFromHHMMTOSeconds = (value) => {
    const a = value.split(':');

    const seconds = +a[0] * 60 * 60 + +a[1] * 60;

    return seconds;
};
