// event listner and function call
const form = document.querySelector("#form");
const button = document.querySelector("#form button");
const input = document.querySelector("#form input");
form.addEventListener("submit", (event) => {
  event.preventDefault();
  checkweather(input.value);
});
// api call
const apikey = "ebe7f9cc36589ce002502387aa6948f2";
// function call
async function checkweather(cityname) {
  try {
    let data;
    if (navigator.onLine) {
      const url = `2510333_AadityaAcharya_WeatherApplication.php?q=${cityname}`;
      const response = await fetch(url);
      data = await response.json();
      localStorage.setItem(cityname, JSON.stringify(data));
    } else {
      data = JSON.parse(localStorage.getItem(cityname));
    }
    console.log(data);
    //    dom city
    document.querySelector("#city").innerHTML =
      data[0].city + ", " + data[0].country;
    //   dom temperature
    document.querySelector("#temp").innerHTML =
      Math.round(data[0].temperature) + "°c";
    // //   dom humidity
    document.querySelector("#humidity").innerHTML = data[0].humidity + "%";
    // //  dom wind
    document.querySelector("#sped").innerHTML = data[0].wind_speed + "m/s";
    document.querySelector("#wind").innerHTML = data[0].wind_direction + "deg";
    // //  dom weather condition
    document.querySelector("#weather").innerHTML =
      data[0].main_weather_condition;
    document.querySelector("#WeatherCondition").innerHTML =
      data[0].weather_condition;
    // //  dom pressure
    document.querySelector("#pressure").innerHTML = data[0].pressure + "hpa";
    // //  dom time
    let date = data[0].date_time;
    let DateDay = new Date(date * 1000);
    document.querySelector("#dateAndDay").innerHTML = DateDay.toDateString();
    // //  dom icon
    let numericIcon = data[0].icon;
    let icon = `https://openweathermap.org/img/wn/${numericIcon}@2x.png`;
    document.querySelector("#wIcon").src = icon;
  } catch {
    document.querySelector(".card").innerHTML =
      "Error, please refresh page to continue";
  }
}
checkweather("swansea");
