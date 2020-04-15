// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
			function save(){
					alert("Sauvegarde effectué");
					modal.style.display = "none";
			 }
			// Get the modal
function closeForm() {
  document.getElementById("myForm").style.display = "none";
}

			function changement_prenom(){
				var prenom = prompt("Entrez votre prénom","Saisir votre Prénom");
				if(prenom == null || prenom =="" || prenom =="Saisir votre Prénom") {
					alert("Vous n'avez pas changer de prénom.");
				}else {
					document.getElementById("old_prenom").innerHTML = prenom;
					document.getElementById("prenom").value = prenom;
					alert("Votre changement a été effectué, voici votre nouveau prénom : "+prenom);
				}
			 }
			 function changement_nom(){
				var nom = prompt("Entrez votre Nom","Saisir votre Nom");
				if(nom == null || nom =="" || nom =="Saisir votre Nom") {
					alert("Vous n'avez pas changer de Nom.");
				}else {
					document.getElementById("old_nom").innerHTML = nom;
					document.getElementById("nom").value = nom;
					alert("Votre changement a été effectué, voici votre nouveau nom : "+nom);
				}
			 }
			 function changement_mail(){
				var mail = prompt("Entrez votre mail","Saisir votre Adresse Mail");
				if(mail == null || mail =="" || mail =="Saisir votre Adresse Mail") {
					alert("Vous n'avez pas changer de mail.");
				}else {
					document.getElementById("old_mail").innerHTML = mail;
					document.getElementById("mail").value = mail;
					alert("Votre changement a été effectué, voici votre nouveau mail : "+mail);
				}
			 }
			 function changement_adresse1(){
				var adresse1 = prompt("Entrez votre adresse","Saisir votre Adresse");
				if(adresse1 == null || adresse1 =="" || adresse1 =="Saisir votre Adresse") {
					alert("Vous n'avez pas changer d'adresse.");
				}else {
					document.getElementById("old_adresse1").innerHTML = adresse1;
					document.getElementById("adresse1").value = adresse1;
					alert("Votre changement a été effectué, voici votre nouvelle adresse : "+adresse1);
				}
			 }
			 function changement_adresse2(){
				var adresse2 = prompt("Entrez votre adresse","Saisir votre Adresse");
				if(adresse2 == null || adresse2 =="" || adresse2 =="Saisir votre Adresse") {
					alert("Vous n'avez pas changer d'adresse.");
				}else {
					document.getElementById("old_adresse2").innerHTML = adresse2;
					document.getElementById("adresse2").value = adresse2;
					alert("Votre changement a été effectué, voici votre nouvelle adresse : "+adresse2);
				}
			 }
			 function changement_ville(){
				var ville = prompt("Entrez votre ville","Saisir votre Ville");
				if(ville == null || ville =="" || ville =="Saisir votre Ville") {
					alert("Vous n'avez pas changer de ville.");
				}else {
					document.getElementById("old_ville").innerHTML = ville;
					document.getElementById("ville").value = ville;
					alert("Votre changement a été effectué, voici votre nouvelle ville : "+ville);
				}
			 }
			 function changement_zip(){
				var zip = prompt("Entrez votre code postal","Saisir votre Code Postal");
				if(zip == null || zip =="" || zip =="Saisir votre Prénom") {
					alert("Vous n'avez pas changer de code postal.");
				}else {
					document.getElementById("old_zip").innerHTML = zip;
					document.getElementById("zip").value = zip;
					alert("Votre changement a été effectué, voici votre nouveau code postal : "+zip);
				}
			 }
			 function changement_pays(){
				var pays = prompt("Entrez votre pays","Saisir votre Pays");
				if(pays == null || pays =="" || pays =="Saisir votre Pays") {
					alert("Vous n'avez pas changer de pays.");
				}else {
					document.getElementById("old_pays").innerHTML = pays;
					document.getElementById("pays").value = pays;
					alert("Votre changement a été effectué, voici votre nouveau pays : "+pays);
				}
			 }
			 function changement_phone(){
				var phone = prompt("Entrez votre téléphone","Saisir votre Numéro de Téléphone");
				if(phone == null || phone =="" || phone =="Saisir votre Numéro de Téléphone") {
					alert("Vous n'avez pas changer de numéro de téléphone.");
				}else {
					document.getElementById("old_phone").innerHTML = phone;
					document.getElementById("phone").value = phone;
					alert("Votre changement a été effectué, voici votre nouveau phone : "+phone);
				}
			 }