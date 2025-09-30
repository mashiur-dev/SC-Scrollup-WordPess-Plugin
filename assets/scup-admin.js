(function( $ ) {
    "use strict";

    /* Range Fields Input */
    let scupRange = $('input.range');

    scupRange.each(function()
    {
        var thisRange = jQuery(this);
        if ( thisRange.val() !== '' )
            thisRange.next('span').text($(this).val()+' px');
        
    });
        
    scupRange.on('input', function ()
    {

        var scupRangeID = $(this).attr('id'),
            scupRangeOutput = $('#' + scupRangeID + '_output');
        
        scupRangeOutput.text($(this).val()+' px');

    });

    // Icons Selector
    jQuery('.jomps-icons').each(function()
    {
        let thisEl = jQuery(this);
        let selectedIcon = thisEl.find("input.sc-selected-icon").val();

        if (selectedIcon !== "") {
            let selectedIconUnique = selectedIcon.split(" ").pop();

            thisEl
              .find(".jomps-icons-selector")
              .find("li")
              .find("." + selectedIconUnique)
              .parent("li")
              .addClass("active");
        }

    });
    
    jQuery('.jomps-icons-selector').find('li').on('click', function()
    {
        let thisLi   = jQuery(this),
            liMain   = thisLi.parents('.jomps-icons'),
            liParent = liMain.find('.jomps-icons-selector'),
            icon     = thisLi.find('i').attr('class');

        liParent.find('li').removeClass('active');
        thisLi.addClass('active');

        liMain.find('input').val( icon );
    });

})(jQuery);