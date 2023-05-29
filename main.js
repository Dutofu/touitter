const menubtn = document.querySelector(".menu-btn");
const navLinks = document.querySelector(".nav-links");

menubtn.addEventListener('click',()=>{
  navLinks.classList.toggle('mobile-menu')
})
// ajoute une classe .menu-btn quand on clique sur le bouton contenant la classe .nav-links


const plus = document.querySelector(".plus")
const ajout = document.querySelector(".ajout")

plus.addEventListener('click',()=>{
  plus.classList.toggle('plusplus');
  ajout.classList.toggle('grossis');
})



document.getElementById('color-filter').addEventListener('change', function() {
  var selectedColor = this.value;
  var tweetBoxes = document.getElementsByClassName('tweet-p');

  // Parcourir tous les tweet boxes
  for (var i = 0; i < tweetBoxes.length; i++) {
      var tweetBox = tweetBoxes[i];
      var tweetColor = tweetBox.dataset.color;

      // Afficher ou masquer le tweet box en fonction de la couleur sélectionnée
      if (selectedColor === '' || tweetColor === selectedColor) {
          tweetBox.style.display = 'block';
      } else {
          tweetBox.style.display = 'none';
      }
  }
});



var popupdisplay = false;

window.addEventListener('scroll', function() {
  // Vérifier si l'utilisateur n'est pas connecté
  if (!connection && !popupdisplay) {
    console.log(connection);
    // Ajouter un effet de flou à l'écran
    var mainflou = document.querySelector('main');
    mainflou.classList.add('blur-effect');

    // Afficher une popup demandant de s'inscrire ou de se connecter
    var popup = document.createElement('div');
    popup.className = 'popup';
    popup.innerHTML = 'Veuillez vous inscrire ou vous connecter pour continuer.';
    document.body.appendChild(popup);
  };

  popupdisplay = true;
});