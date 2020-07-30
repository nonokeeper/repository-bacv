$('#exampleModal').on('show.bs.modal', function (event) {
    let button = $(event.relatedTarget); // Button that triggered the modal
    let recipient = button.data('whatever'); // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    let modal = $(this);
    modal.find('.modal-title').text('Modifier son mot de passe' + recipient);
    modal.find('.modal-body input').val(recipient);
  });

$('#updateJoueur').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget); // Button that triggered the modal
  var id = button.data('id'); // Extract info from data-* attributes
  var prenom = button.data('prenom');
  var nom = button.data('nom');
  var email = button.data('email');
  var mobile = button.data('mobile');
  var modal = $(this);
  modal.find('.modal-title').text('Modification de '+prenom+' '+nom);
  modal.find('#id').val(id);
  modal.find('#prenom').val(prenom);
  modal.find('#nom').val(nom);
  modal.find('#email').val(email);
  modal.find('#mobile').val(mobile);
});

$(document).ready(function () {
  $('.third-button').on('click', function () {
    $('.animated-icon3').toggleClass('open');
  });
});

/* Submit when presence status is changed */
let formulaire = document.getElementsByName("presence")[0]; // Check at least one form name="presence"
if (formulaire) {
  $("[name='value']").change(function(){
    let form = $(this).closest("form").attr('id'); // Get the form id of the changed input
    formulaire = document.getElementById(form);
    formulaire.submit();
  });
}

/* Hide messages after 3 secs
* Hide formScore when loading the page
 */
jQuery(document).ready(function(){
  $('#tmp').fadeTo(2000, 0);
  $('.formScore').hide();
});

/* Submit cat clicked
*/

/* Submit Catégorie des joueurs en Ajax */
function selectCat(cat)
{
  $("#form"+cat).submit();
  return false;
}

/* Submit Statut par joueur by Ajax */
function joueurStatut(joueur, statut, cat)
{
  $.ajax({
    type: 'post',
    url: '/inscription',
    data: {
      joueur: joueur,
      statut: statut,
      cat: cat
    },
    success: function (rep) {
      //console.log(cat);
      $("#"+cat).html($("#"+cat,rep).html()); // recharge la div de la catégorie pour les comptages
    }
  });
  return false;
}

/* Submit Score by Ajax */
function sendData(interclub)
{
  let score = document.getElementById("inputScore-"+interclub).value;
  $.ajax({
    type: 'post',
    url: '/interclubScore',
    data: {
      score:score,
      interclub:interclub
    },
    success: function () {
      $('#score-'+interclub).html(
      // refresh du Score
        'Score : '+score+'&nbsp;&nbsp;<span id="link-'+interclub+'"><i class="fas fa-edit">&nbsp;</i></span>'
      );
    }
  });
  $('#form-'+interclub).toggle('slow'); // hide form score
  $('#score-'+interclub).toggle('slow'); // show score display
  return false;
}

$('body').delegate('span.int', 'click', function(){
  let linkId = $(this).attr('id');
  if (linkId) {
    var interclub = linkId.substring(5, linkId.length);
    $('#score-'+interclub).toggle('fast'); // hide normal display of score
    $('#form-'+interclub).toggle('fast'); // show form to modify score
  }
});

let url = window.location.href;

$('body').delegate('span.compo', 'click', function(){
  let linkId = $(this).attr('id');
  let idTab = linkId.split('_')[0];
  $('#'+idTab).addClass("droppable");
  $('#'+idTab+'_header').removeClass("text-white bg-success");
  let body = document.getElementById(idTab+'_body');
  body.innerHTML = "";
  let divFooter = document.getElementById(idTab+'_footer');
  divFooter.innerHTML = "";
  $.ajax({
    type: 'post',
    url: url,
    data: {
      tableau:idTab,
      joueurs:[0,0] // permet de vider sans provoquer d'erreur de tableau null
    },
    success: function () {
      // console.log('Effacé avec succès !');
    }
  });
});

// Init du nombre de joueurs pour chaque tableau
let nb = 0;
let joueurs = [];

$('body').delegate('.draggable', 'mouseover', function(){
  $('.draggable').draggable({ containment: ".container", scroll: false });
  $('.droppable').droppable({
    drop: function(event, ui) {
      let idJoueur = $(ui.draggable).attr('id');
      let idTab = $(event.target).attr('id');
      let SouD = idTab.substring(0,1);
      // Si c'est un Simple, le nb est incrémenté pour gérer un tableau
      // rempli comme pour les Doubles
      if (SouD == 'S') {
        nb = nb + 1;
      }
      // Test si le joueur déposé est déja dans la zone
      // Pour incrémenter le nb de joueurs uniquement sinon
      if ($.inArray(idJoueur, joueurs) == -1) {
        nb = nb + 1;
        joueurs.push(idJoueur);
      }
      console.log(joueurs);
      console.log('id element droppé :'+idJoueur+', sur id du parent :'+idTab);
      console.log('in drop nb : '+nb);
      // Cas particulier des doubles
      if (nb == 2) {
        $('#'+idTab+'_header').addClass("text-white bg-success");
        $.ajax({
          type: 'post',
          url: url,
          data: {
            tableau:idTab,
            joueurs:joueurs
          },
          success: function () {
            location.reload();
          }
        });
      }
    },
    out: function(event, ui) {
      let idTab = $(ui.draggable).attr('id');
      // Test si le joueur était bien dans la zone avant
      // Pour décrémenter le nb de joueurs uniquement dans ce cas
      if ($.inArray(idTab, joueurs) !== -1) {
        nb = nb - 1;
      }
      joueurs = joueurs.filter(item => item !== idTab);
      $(this).removeClass("ui-state-highlight");
      console.log('id element enlevé :'+idTab+', sur id du parent :'+$(event.target).attr('id'));
      console.log('in out nb : '+nb);
    },
    over: function(event, ui) {
      $(this).addClass('ui-state-over');
    }
  });
});