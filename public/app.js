$('#exampleModal').on('show.bs.modal', function (event) {
    let button = $(event.relatedTarget); // Button that triggered the modal
    let recipient = button.data('whatever'); // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    let modal = $(this);
    modal.find('.modal-title').text('Modifier son mot de passe' + recipient);
    modal.find('.modal-body input').val(recipient);
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

$('body').delegate('span', 'click', function(){
  let linkId = $(this).attr('id');
  if (linkId) {
    var interclub = linkId.substring(5, linkId.length);
    $('#score-'+interclub).toggle('fast'); // hide normal display of score
    $('#form-'+interclub).toggle('fast'); // show form to modify score
  }
});

// Init du nombre de joueurs avant déplacements
let nb = 0;
let joueurs = [];
console.log('init nb : '+nb);

$('body').delegate('.draggable', 'mouseover', function(){
  $('.draggable').draggable();
  $('.droppable').droppable({
    drop: function(event, ui) {
      // Test si le joueur n'est pas encore dans la zone
      // Pour incrémenter le nb de joueurs uniquement dans ce cas
      if ($.inArray($(ui.draggable).attr('id'), joueurs) == -1) {
        nb = nb + 1;
        joueurs.push($(ui.draggable).attr('id'));
      }
      // Cas particulier des doubles
      if (nb == 2) {
        $(this).addClass('ui-state-highlight').find('p')
        .html('Double Homme <i class="far fa-check-circle">&nbsp;</i>');
      }
//      console.log('id element droppé :'+$(ui.draggable).attr('id')+', sur id du parent :'+$(event.target).attr('id'));
      console.log('in drop nb : '+nb);
      console.log(joueurs);
    },
    out: function(event, ui) {
      // Test si le joueur était bien dans la zone avant
      // Pour décrémenter le nb de joueurs uniquement dans ce cas
      if ($.inArray($(ui.draggable).attr('id'), joueurs) !== -1) {
        nb = nb - 1;
      }
      joueurs = joueurs.filter(item => item !== $(ui.draggable).attr('id'));
      $(this)
        .removeClass("ui-state-highlight").find("p")
          .html("Double Homme");
//      console.log('id element enlevé :'+$(ui.draggable).attr('id')+', sur id du parent :'+$(event.target).attr('id'));
      console.log('in out nb : '+nb);
    },
    over: function(event, ui) {
      $(this).addClass('ui-state-over');
    }
  });
});