setInterval(function() {
  $("#cardUID").load("../../showID.php");

  recherche = $("#cardUID").val();
console.log("salut");
if (recherche != null) {
    $.ajax({
      url: "show_data.php",
      type: 'POST',
      data : 'cardID=' + recherche,
      success : function(data){
        if (data == 1) {
          msg = "<span class='bi bi-x-octagon-fill text-danger'>Ce numéro de carte est déjà attribué à un autre étudiant.<span>";
        }else if(data == 2){
          msg = "<span class='bi bi-x-circle-fill text-danger'>Ce numéro de carte est déjà attribué à un surveillant.</span>";
        }else if(data == 0){
          msg = "<span class='bi bi-check-fill text-success'>UID non encore enregistré.</span>";
        }

        $("#cardUID").next("#msg").fadeIn().html(msg);
      }
  });
}

}, 100);