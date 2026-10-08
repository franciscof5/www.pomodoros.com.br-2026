jQuery(document).ready(function()
{
    //console.log("escondend");
       /* jQuery(".calendar-container").each(function(i) {
            console.log(";"+i);
            if(i>0)
                jQuery(this).css("display", "none");
        })*/
    var counter = 0;

    jQuery('.calendar-container').each(function(index)
    {
        jQuery(this).attr('id', 'calendar-' + index);

        var caption = '';

        if (0 < index)
        {
            caption += '<a href="#" onclick="jQuery(\'#calendar-' + index + '\').hide(); jQuery(\'#calendar-' + (index - 1) + '\').show(); return false;">&lt;</a> ';
        }

        caption += jQuery('.month-year-caption', this).html();

        jQuery('.month-year-caption', this).html(caption);

        if (0 < index)
        {
            jQuery(this).hide();
        }

        counter = index;
    });

    for (var i = 0; i < counter; i++)
    {
        var caption = jQuery('#calendar-' + i + ' .month-year-caption', this).html();

        caption += ' <a href="#" onclick="jQuery(\'#calendar-' + i + '\').hide(); jQuery(\'#calendar-' + (i + 1) + '\').show(); return false;">&gt;</a>';

        jQuery('#calendar-' + i + ' .month-year-caption').html(caption);
    }

            
           /*jQuery("ul.calendar li.day").find('.day-caption').mouseenter(function(){
                //jQuery(this).find('.author-ranking').show();
                //if(jQuery(this).find('.author-ranking').css('display') == 'none') {
                    
                    jQuery(this).parent().find('.author-ranking').css('display', "block");
                //}
                //console.log("mouseenter day caption");
            })
            jQuery("ul.calendar li.day").find('.author-ranking').mouseleave(function(){
                //jQuery(this).hide();
                jQuery(this).css('display', "none");
                //console.log("saiu author ranking");
            })
            jQuery("ul.calendar li.day").mouseleave(function(){
                //jQuery(this).find('.author-ranking').show();
                jQuery(this).find('.author-ranking').css('display', "none");
            })*/
            /*
            //NOT WORKING, MOVED TO PHP
            jQuery(".author-ranking").each(function(i) {
                if(jQuery(this).find("ul").length) {
                    //Gold
                    jQuery(this).find("li:nth-child(1)").find(".aut_barra div").css('background-color', "#FFD700");
                    //Silver
                    jQuery(this).find("li:nth-child(2)").find(".aut_barra div").css('background-color', "#A8A8A8");
                    //Bronze
                    jQuery(this).find("li:nth-child(3)").find(".aut_barra div").css('background-color', "#965A38");
                }
                //jQuery.each(".aut_barra").css('background-color', "#964");
            });*/
            
        
});