//jQuery('#e_deliverydate').val('');
jQuery(document).ready(function($) {

    function getPosition(moth_name)
    {
        var months=[
            {
                
                 'srt':'Jan',
                 'full':'January',
                 'postition':1
            },
            {
                
                'srt':'Feb',
                 'full':'February',
                 'postition':2
            },
            {
                
                'srt':'Mar',
                 'full':'March',
                 'postition':3
            },
            {
                 
                 'srt':'Apr',
                 'full':'April',
                 'postition':4 
            },{
                
                 'srt':'Jun',
                 'full':'June',
                 'postition':6
            },{
                  
                  'srt':'May',
                 'full':'May',
                 'postition':5
            },{
                  
                  'srt':'Jul',
                 'full':'July',
                 'postition':7  
            },{
                  
                  'srt':'Aug',
                 'full':'August',
                 'postition':8  
            },{
                  
                  'srt':'Sep',
                 'full':'September',
                 'position':9  
            },{
                  
                  'srt':'Oct',
                 'full':'October',
                 'position':10
            },{
                  
                  'srt':'Nov',
                 'full':'November',
                 'position':11
            },{
                  
                  'srt':'Dec',
                 'full':'December',
                 'postition':12
            }
        ];

        var month_name=$(months).filter(function (i,n){
            return n.srt===moth_name;
        });
        // var month_name=JSON.parse(months).filter(function (entry) {
        //     return entry.srt === 'Feb';
        // });
        return month_name[0].postition;
    }





    // Your custom Datepicker initialization
    $('#datepicker').datepicker({
        minDate: 0,  // Disallow past dates
        //maxDate: '+30d',  // Allow selection up to 6 days from today
        beforeShowDay: function(date) {
            var day = date.getDay();
            // Disable selection on Saturdays and Sundays
            return [day !== 0 && day !== 6, ''];
        },
    });
    $('#datepicker').on('change',function(){
       
        var selectedDate = $("#datepicker").datepicker("getDate");
        localStorage.setItem( "date_picker_date_forrmat",$(this).val());
      
    // Check if a date is selected
        if (selectedDate !== null) {
        //alert(selectedDate);
      // Convert the selected date to a timestamp in milliseconds
        var selectedDateParsed=selectedDate.toString().split(" ");
        var h_deliverydate_lite_session=selectedDateParsed[2]+'-'+getPosition(selectedDateParsed[1])+'-'+selectedDateParsed[3];
        var timestampInMilliseconds = selectedDate.getTime();
        localStorage.setItem( "orddd_lite_storage_next_time",timestampInMilliseconds);
        localStorage.setItem("h_deliverydate_lite_session",h_deliverydate_lite_session);
        //localStorage.setItem("orddd_deliverydate_lite_session","8 February, 2024");
        }
            // let orddd_lite_storage_next_time=orddd_lite_storage_next_time($(this).val());
             // localStorage.setItem( "orddd_lite_storage_next_time" );
			 // localStorage.setItem( "orddd_deliverydate_lite_session" );
			 // localStorage.setItem( "h_deliverydate_lite_session" );
    });
    localStorage.getItem("customer_note") ? $('#customer_note').val(localStorage.getItem("customer_note") ) : $('#customer_note').val("")
    
    $('#datepicker').val(localStorage.getItem("date_picker_date_forrmat") ? localStorage.getItem("date_picker_date_forrmat") : "");

    $('#customer_note').on('input',function(){
		
        localStorage.setItem( "customer_note",$(this).val());
    })

    $('#customer_note').on('change',function(){
        localStorage.setItem( "customer_note",$(this).val());
    })
    
    $('#roder_review_dalivary_date').html(localStorage.getItem("date_picker_date_forrmat"))
    $('#order_review_customer_note').html(localStorage.getItem("customer_note"))
    $('#new_order_notes').val(localStorage.getItem("customer_note"))

    $('#delivary_date_hidden_field').val(localStorage.getItem("date_picker_date_forrmat"));
    $('#customer_note_hidden_field').val(localStorage.getItem("customer_note"));
    $('#delivary_date_timestm_hidden_field').val(localStorage.getItem("orddd_lite_storage_next_time"));
    
});

jQuery('#datepicker').attr("required", "true");

jQuery('.woocommerce-MyAccount-navigation .woocommerce-MyAccount-navigation-link--orders a').text("Orderhistorik");

//jQuery('.fixed__nav_bar .woocommerce-MyAccount-navigation .woocommerce-MyAccount-navigation-link--contest a').text("tavling");



// window.onload = function () {
//     var child = document.querySelector(".fixed__nav_bar .woocommerce-MyAccount-navigation .woocommerce-MyAccount-navigation-link--contest a");
//     child.innerHTML = "Tävling";
// };

jQuery('.recreate_p  .qunatity').on('input',function(){
    jQuery('.recreate_p .btn').css({
                'padding': '10px 80px'
                // Add more properties as needed
            });
 });
 jQuery('.qunatity').on('change',function(){
  
  jQuery('.recreate_p .btn').css({
    
    'padding': '10px 80px'
                // Add more properties as needed
            });
});
jQuery('.qunatity').on('keyup',function(){
  jQuery('.recreate_p .btn').css({
    'padding': '10px 80px'
                // Add more properties as needed
            });
});