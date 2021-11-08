(function( $ ) {
    "use strict";

    /* Range Fields Input */
    var scupRange = $('input.range');
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

    jQuery('.jomps-icons').each(function()
    {
        var thisEl = jQuery(this);
        if ( thisEl.find('input').val() !== '' )
            thisEl.find('.jomps-icons-selector').find('li').find( '.' + thisEl.find('input').val() ).parent('li').addClass('active');
    });
    
    jQuery('.jomps-icons-selector').find('li').on('click', function()
    {
        var thisLi   = jQuery(this),
            liMain   = thisLi.parents('.jomps-icons'),
            liParent = liMain.find('.jomps-icons-selector'),
            icon     = thisLi.find('i').attr('class');

        liParent.find('li').removeClass('active');
        thisLi.addClass('active');

        liMain.find('input').val( icon );
    });

})(jQuery);