/**
 * Created by yama_gs on 21.10.2016.
 */
/*function getCSSFields(template,type, tab) {
    var inputs=getStyleInputs(template,type, tab),
        styles={};

    jQuery.each(inputs,function (i,input) {
        if(jQuery(input).val()!="") {
            styles[jQuery(input).data('template-css')] = jQuery(input).val();
        }
    });
    return styles;
}*/
function getCSSFields(selector) {
    var inputs=jQuery(selector),
        styles={};

    jQuery.each(inputs,function (i,input) {
        if(jQuery(input).val()!="") {
            styles[jQuery(input).data('template-css')] = jQuery(input).val();
        }
    });
    return styles;
}
function getStyleInputs(template, type, tab) {
    return jQuery("[data-template='"+template+"'] [data-template='"+type+"'] [data-template='"+tab+"'] [data-template='style'] input");
}
function getDatatemplate(value){
    return "[data-template='"+value+"']";
}
jQuery(document).ready(function () {
    var atmTemplating = atmTpl.default;

    var templateName = 'pledge'; // unlockLine, pledge, pay, refund, refunded, adViewed
    var componentName = 'pledgeComponent'; // @see atmTemplating.stories()
    var optionName = 'heading-headline'; // @see atmTemplating.stories()
    var optionName2 = 'body-welcome'; // @see atmTemplating.stories()
    var optionNameTemplate = 'pledge-collapsed-message-message';
    var optionNameTemplate2 = 'pledge-expanded-message-message';
    var styling = {};
    var renderPledgeExpandedId='#render-pledge-expanded';
    var templates =[
        {
            name:'pledge',
            component:'pledgeComponent',
            dataTab:'pledge',
            options:[
                {
                    name:'heading-headline',
                    contentInputName:'message',
                    dataSection:'collapsed',
                    dataTab:'message',
                    renderBlockId: '#render-pledge-collapsed'
                },
                {
                    name:'body-welcome',
                    contentInputName:'welcome',
                    dataSection:'expanded',
                    dataTab:'message',
                    renderBlockId: '#render-pledge-expanded'
                }
            ]
        }
    ];

    
    (function ($) {
        // read available template stories
        var stories = atmTemplating.stories();
        console.log(stories);
        var views={};
        jQuery.each(templates,function (i,template) {
            var tab = jQuery(getDatatemplate(template.dataTab));
            jQuery.each(template.options,function (j,option) {
                var subTab = tab.find(getDatatemplate(option.dataSection)).find(getDatatemplate(option.dataTab));
                var input = subTab.find('input[name="' + option.contentInputName + '"]');
                var viewKey=template.dataTab+option.dataSection+option.dataTab;
                views[viewKey]={
                    view:atmTemplating.render(template.name, option.renderBlockId),
                    input:input,
                    optionName:option.name,
                    componentName:template.component
                }
            });
        });

        // render template view to the container
        //console.log(document.querySelector('#render-pledge'));
        //var vm = atmTemplating.render(templateName, '#render-pledge-collapsed');
        //var vm2 = atmTemplating.render(templateName, renderPledgeExpandedId);

        $form = $('section');
        $headingHeadlineInput = $form.find('input');
        /*$bodyWelcomeInput = $form.find('input[name="' + optionNameTemplate2 + '"]');*/

        // setup default component value
        //$headingHeadlineInput.val(stories[componentName][optionName].content);
        //$bodyWelcomeInput.val(stories[componentName][optionName2].content);
        var throttledSync = jQuery.throttle(200, function (e) {
            var viewKey='';
            var styleSelector=" "+ getDatatemplate('style')+' input ';
            jQuery.each(jQuery(this).parents('[data-template]'),function (i, block) {
                var data=jQuery(block).data('template');
                if(data!='style') {
                    viewKey=jQuery(block).data('template')+viewKey;
                    styleSelector = getDatatemplate(data) + " "+ styleSelector;
                }

            });
            var options = {};
            var styling = {};

            console.log(viewKey);
            options[views[viewKey].optionName] = views[viewKey].input.val();
            styling[views[viewKey].optionName] = getCSSFields(styleSelector);


            // update template
            atmTemplating.updateTemplate(views[viewKey].componentName, options,styling);

            // redraw the view
            views[viewKey].view.redraw();
        });
        /*var throttledSync2 = jQuery.throttle(200, function () {
            var options = {};
            options[optionName2] = $bodyWelcomeInput.val();
            //styling[optionName] = getCSSFields('pledge','collapsed','message');
            // update template
            atmTemplating.updateTemplate(componentName, options,styling);

            // redraw the view
            vm2.redraw();
        });*/
        // bind changes
        $headingHeadlineInput.bind('keyup', throttledSync);
        //$bodyWelcomeInput.bind('keyup', throttledSync2);
        //getStyleInputs('pledge','collapsed','message').bind('keyup', throttledSync);
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