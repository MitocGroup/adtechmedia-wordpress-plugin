/**
 * Created by yama_gs on 21.10.2016.
 */
function getCSSFields(template,type, tab) {
    var inputs=getInputs(template,type, tab),
        styles={};

    jQuery.each(inputs,function (i,input) {
        if(jQuery(input).val()!="") {
            styles[jQuery(input).data('template-css')] = jQuery(input).val();
        }
    });
    console.log(styles);
    return styles;
}
function getInputs(template,type, tab) {
    return jQuery("[data-template='"+template+"'] [data-template='"+type+"'] [data-template='"+tab+"'] [data-template='style'] input");
}
jQuery(document).ready(function () {
    var atmTemplating = atmTpl.default;

    var templateName = 'pledge'; // unlockLine, pledge, pay, refund, refunded, adViewed
    var componentName = 'pledgeComponent'; // @see atmTemplating.stories()
    var optionName = 'heading-headline'; // @see atmTemplating.stories()
    var optionNameTemplate = 'pledge-collapsed-message-message';
    var styling = {};

    
    (function ($) {
        // read available template stories
        var stories = atmTemplating.stories();
        console.log(stories);

        // render template view to the container
        //console.log(document.querySelector('#render-pledge'));
        var vm = atmTemplating.render(templateName, '#render-pledge');

        $form = $('section');
        $headingHeadlineInput = $form.find('input[name="' + optionNameTemplate + '"]');

        // setup default component value
        $headingHeadlineInput.val(stories[componentName][optionName].content);

        var throttledSync = jQuery.throttle(200, function () {
            var options = {};
            options[optionName] = $headingHeadlineInput.val();
            styling[optionName] = getCSSFields('pledge','collapsed','message');
            // update template
            atmTemplating.updateTemplate(componentName, options,styling);

            // redraw the view
            vm.redraw();
        });

        // bind changes
        $headingHeadlineInput.bind('keyup', throttledSync);
        getInputs('pledge','collapsed','message').bind('keyup', throttledSync);
        $form.bind('submit', function (e) {
            e.preventDefault();
            e.stopPropagation();

            var options = {};
            options[optionName] = $headingHeadlineInput.val();
            styling[optionName] = getCSSFields('pledge','collapsed','message');
            // dump template content to the console
            console.log(atmTemplating.templateRendition(componentName).render(options,styling));

            return false;
        });
    })(jQuery);
});