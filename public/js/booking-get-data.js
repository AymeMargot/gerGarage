$(document).ready(function(){    
        $('#Vehicle').change(function(){
             var id = $(this).val();
            $.ajax({
                url: 'bookings/create/'+id,
                type: 'get',
                dataType: 'json',           
                success: function(response){
                    var content = response['data'];
                    if(content !=null)
                        $("#DescriptionVehicle").val()=response['data'];  
                    else    
                    $("#DescriptionVehicle").val()='';             
                }
            });
      });
});
