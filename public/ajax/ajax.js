// party page

/* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
function myFunction() {
  document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}



// delete party
    
$(".deleteRecord").click(function(){

    var id = $(this).data("id");
    var token = $("meta[name='csrf-token']").attr("content");
    var parent = $(this).parent();

      swal({
                      title: "Wait..!",
                      text: "Are You sure, You want to delete Party?",
                      icon: "warning",
                      buttons: true,
                      dangerMode: true,
                    }).then((willDelete) => {

                        if (willDelete) {
    $.ajax({
        url: "delete_party/"+id,
        type: 'DELETE',
        data: {
            "id": id,
            "_token": token,
        },
        success: function (){

                 swal({
                      title: "Good job!",
                      text: "Party Deleted Successfully!",
                      icon: "success",
                      button: "Ok",
                    });

               
               parent.slideUp(300, function () {
                    parent.closest("tr").remove();
                });
        },
        error: function() {

            alert('error, Please Refresh the page');
        },
    });
      
       } else {

             swal("Your Party is safe");
       }
});
   
});

//end 