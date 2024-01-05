  setInterval(function() {
    $("#cardUID").load("../../showID.php");
    $("#cardUID1").load("../../showID.php");
    $("#cardUID2").load("../../showID.php");

    recherche = $("#cardUID").val();
    recherche1 = $("#cardUID1").val();
    recherche2 = $("#cardUID2").val();

  if (recherche != null) {
      $.ajax({
        url: "../../get-info.php",
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

  
  if (recherche1 != null) {
    id = $("#id").val();

    $.ajax({
      url: "../../get-info.php",
      type: 'POST',
      data : {cardID1:recherche1, id:id},
      success : function(data){
        if (data == 1) {
          msg = "<span class='bi bi-x-octagon-fill text-danger'>Ce numéro de carte est déjà attribué à un autre étudiant.<span>";
        }else if(data == 2){
          msg = "<span class='bi bi-x-circle-fill text-danger'>Ce numéro de carte est déjà attribué à un surveillant.</span>";
        }else if(data == 0){
          msg = "<span class='bi bi-check-fill text-success'>UID valide.</span>";
        }
        $("#cardUID1").next("#msg1").fadeIn().html(msg);

      }
  });
}


if (recherche2 != null) {
  id = $("#id2").val();

  $.ajax({
    url: "../../get-info.php",
    type: 'POST',
    data : {cardID2:recherche2, id:id},
    success : function(data){
      if (data == 1) {
        msg = "<span class='bi bi-x-octagon-fill text-danger'>Ce numéro de carte est déjà attribué à un autre étudiant.<span>";
      }else if(data == 2){
        msg = "<span class='bi bi-x-circle-fill text-danger'>Ce numéro de carte est déjà attribué à un surveillant.</span>";
      }else if(data == 0){
        msg = "<span class='bi bi-check-fill text-success'>UID valide.</span>";
      }
      $("#cardUID2").next("#msg1").fadeIn().html(msg);

    }
});
}

}, 100);