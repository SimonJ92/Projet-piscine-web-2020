// https://www.w3schools.com/howto/tryit.asp?filename=tryhow_js_countdown



// Set the date we're counting down to
	var countDownDate = new Date("Jan 5, 2021 15:37:25").getTime();
	

// Update the count down every 1 second
var x = setInterval(function() {

  // Get today's date and time
  var now = new Date().getTime();
    
  // Find the distance between now and the count down date
  var distance = countDownDate - now;
    
  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
  var prixmax = "100"
  var nombreoffre = "6"
    
  // Output the result in an element with id="datenchere"
  document.getElementById("dateenchere").innerHTML = days + " jours " + hours + " heures "
  + minutes + " minutes " + seconds + " secondes ";
  document.getElementById("DateE").innerHTML = "Jan 5, 2021 15:37:25";
  document.getElementById("prix").innerHTML = prixmax+"€";
  document.getElementById("offre").innerHTML = nombreoffre+" offres";
    
  // If the count down is over, write some text 
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("dateenchere").innerHTML = "EXPIRED";
  }
}, 1000);


function afficheenchere(gridCheck) {
	if (gridCheck.checked)
	{
		document.getElementById("divenchere").style.display="block";
		document.getElementById("divencheredisabled").style.display="none";
	}
	else{
		document.getElementById("divenchere").style.display="none";
		document.getElementById("divencheredisabled").style.display="block";
	}
	
}