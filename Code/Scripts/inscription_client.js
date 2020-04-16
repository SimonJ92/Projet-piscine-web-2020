function creation(){
	alert("Votre compte a bien été créé !")
}

function affichebouton(gridCheck) {
	if (gridCheck.checked)
	{
		document.getElementById("bouton").style.display="block";
		document.getElementById("boutondisabled").style.display="none";
	}
	else{
		document.getElementById("bouton").style.display="none";
		document.getElementById("boutondisabled").style.display="block";
	}
	
}



