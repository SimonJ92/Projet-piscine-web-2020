$(document).ready(function () {
	var $carrousel = $('#carrousel'); // on cible le bloc du carrousel
	$img= $('#carrousel img'); // on cible les images contenues dans le carrousel
	indexImg = $img.length -1; // on définit l'index du dernier élément
	i = 0; // on initialise un compteur
	$currentImg = $img.eq(i); // enfin, on cible l'image courante, qui possède l'index i (0 pour l'instant)
	
	$img.css('display', 'none'); // on cache les images
	$currentImg.css('display', 'block'); // on affiche seulement l'image courante
	
	//si on clique sur le bouton "Suivant"
	$('.next').click(function () { // image suivante
		i++; // on incrémente le compteur
		if (i <= indexImg) {
			$img.css('display', 'none'); // on cache les images
			$currentImg = $img.eq(i); // on définit la nouvelle image
			$currentImg.css('display', 'block'); // puis on l'affiche
			} else {
				i = indexImg;
			}
		});
		//si on clique sur le bouton "Précédent"
		$('.prev').click(function () { // image précédente
			i--; // on décrémente le compteur, puis on réalise la même chose que pour la fonction "suivante"
			
			if (i >= 0) {
				$img.css('display', 'none');
				$currentImg = $img.eq(i);
				$currentImg.css('display', 'block');
				} else {
					i = 0;
				}
			});
			function slideImg() {
				setTimeout(function () { // on utilise une fonction anonyme
				
				if (i < indexImg) { // si le compteur est inférieur au dernier index
					i++; // on l'incrémente
				} else { // sinon, on le remet à 0 (première image)
					i = 0;
				}
				
				$img.css('display', 'none');
				$currentImg = $img.eq(i);
				$currentImg.css('display', 'block');
				slideImg(); // on oublie pas de relancer la fonction à la fin
				}, 4000); // on définit l'intervalle à 4000 millisecondes (4s)
			}
			slideImg(); // enfin, on lance la fonction une première fois
		});
$(document).ready(function () {
	var $carrousel2 = $('#carrousel2'); // on cible le bloc du carrousel
	$img2= $('#carrousel2 img'); // on cible les images contenues dans le carrousel
	indexImg2 = $img2.length -1; // on définit l'index du dernier élément
	o = 0; // on initialise un compteur
	$currentImg2 = $img2.eq(o); // enfin, on cible l'image courante, qui possède l'index i (0 pour l'instant)
	
	$img2.css('display', 'none'); // on cache les images
	$currentImg2.css('display', 'block'); // on affiche seulement l'image courante
	
	//si on clique sur le bouton "Suivant"
	$('.next').click(function () { // image suivante
		o++; // on incrémente le compteur
		if (o <= indexImg2) {
			$img2.css('display', 'none'); // on cache les images
			$currentImg2 = $img2.eq(o); // on définit la nouvelle image
			$currentImg2.css('display', 'block'); // puis on l'affiche
			} else {
				o = indexImg2;
			}
		});
		//si on clique sur le bouton "Précédent"
		$('.prev').click(function () { // image précédente
			o--; // on décrémente le compteur, puis on réalise la même chose que pour la fonction "suivante"
			
			if (o >= 0) {
				$img2.css('display', 'none');
				$currentImg2 = $img2.eq(o);
				$currentImg2.css('display', 'block');
				} else {
					o = 0;
				}
			});
			function slideImg2() {
				setTimeout(function () { // on utilise une fonction anonyme
				
				if (o < indexImg2) { // si le compteur est inférieur au dernier index
					o++; // on l'incrémente
				} else { // sinon, on le remet à 0 (première image)
					o = 0;
				}
				
				$img2.css('display', 'none');
				$currentImg2 = $img2.eq(o);
				$currentImg2.css('display', 'block');
				slideImg2(); // on oublie pas de relancer la fonction à la fin
				}, 4000); // on définit l'intervalle à 4000 millisecondes (4s)
			}
			slideImg2(); // enfin, on lance la fonction une première fois
		});
		
$(document).ready(function () {
	var $carrousel3 = $('#carrousel3'); // on cible le bloc du carrousel
	$img3= $('#carrousel3 img'); // on cible les images contenues dans le carrousel
	indexImg3 = $img3.length -1; // on définit l'index du dernier élément
	p = 0; // on initialise un compteur
	$currentImg3 = $img3.eq(p); // enfin, on cible l'image courante, qui possède l'index i (0 pour l'instant)
	
	$img3.css('display', 'none'); // on cache les images
	$currentImg3.css('display', 'block'); // on affiche seulement l'image courante
	
	//si on clique sur le bouton "Suivant"
	$('.next').click(function () { // image suivante
		p++; // on incrémente le compteur
		if (p <= indexImg3) {
			$img3.css('display', 'none'); // on cache les images
			$currentImg3 = $img3.eq(p); // on définit la nouvelle image
			$currentImg3.css('display', 'block'); // puis on l'affiche
			} else {
				p = indexImg3;
			}
		});
		//si on clique sur le bouton "Précédent"
		$('.prev').click(function () { // image précédente
			p--; // on décrémente le compteur, puis on réalise la même chose que pour la fonction "suivante"
			
			if (p >= 0) {
				$img3.css('display', 'none');
				$currentImg3 = $img3.eq(p);
				$currentImg3.css('display', 'block');
				} else {
					p = 0;
				}
			});
			function slideImg3() {
				setTimeout(function () { // on utilise une fonction anonyme
				
				if (p < indexImg3) { // si le compteur est inférieur au dernier index
					p++; // on l'incrémente
				} else { // sinon, on le remet à 0 (première image)
					p = 0;
				}
				
				$img3.css('display', 'none');
				$currentImg3 = $img3.eq(p);
				$currentImg3.css('display', 'block');
				slideImg3(); // on oublie pas de relancer la fonction à la fin
				}, 4000); // on définit l'intervalle à 4000 millisecondes (4s)
			}
			slideImg3(); // enfin, on lance la fonction une première fois
		});