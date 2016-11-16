/**
 * Created by yama_gs on 21.10.2016.
 */

function getCSSFields(inputs) {
    var styles = {};

    jQuery.each(inputs, function (i, input) {
        if (jQuery(input).val() != "") {
            styles[jQuery(input).data('template-css')] = jQuery(input).val();
        }
    });
    return styles;
}
function inputsToObject(inputs) {
    var res = {};
    jQuery.each(inputs, function (key, value) {
        res[key] = value.input.val();
    });
    return res;
}
function styleInputsToObject(inputs) {
    var res = {};
    jQuery.each(inputs, function (key, value) {
        res[key] = getCSSFields(value.inputs);
    });
    return res;
}
function getDatatemplate(value) {
    return "[data-template='" + value + "']";
}
jQuery(document).ready(function () {
    var atmTemplating = atmTpl.default;

    var templates = [
        {
            name : 'pledge',
            component : 'pledgeComponent',
            dataTab : 'pledge',
            sections : [
                {
                    dataSection : 'collapsed',
                    renderBlockId : '#render-pledge-collapsed',
                    tabs : [{
                        name : 'heading-headline',
                        contentInputName : 'message',
                        dataTab : 'message'
                    }]
                },
                {
                    dataSection : 'expanded',
                    renderBlockId : '#render-pledge-expanded',
                    tabs : [{
                        name : 'body-welcome',
                        contentInputName : 'welcome',
                        dataTab : 'salutation'
                    }, {
                        name : 'body-msg-mp-ad',
                        contentInputName : 'message',
                        dataTab : 'message'
                    }]
                }
            ]
        }
    ];

    (function ($) {
        // read available template stories
        var stories = atmTemplating.stories();
        console.log(stories);
        var views = {};
        var inputs = {};
        var options = {};
        var styling = {};
        var styleInputs = {};
        jQuery.each(templates, function (i, template) {
            var tab = jQuery(getDatatemplate(template.dataTab));
            options[template.component] = {};
            styling[template.component] = {};
            jQuery.each(template.sections, function (j, section) {
                var sectionTab = tab.find(getDatatemplate(section.dataSection));
                var viewKey = template.dataTab + section.dataSection;
                jQuery.each(section.tabs, function (j, tab) {
                    var subTab = sectionTab.find(getDatatemplate(tab.dataTab));
                    inputs[viewKey + tab.dataTab] = {
                        input : subTab.find('input[name="' + tab.contentInputName + '"]'),
                        optionName : tab.name
                    };
                    styleInputs[viewKey + tab.dataTab + 'style'] = {
                        inputs : subTab.find(getDatatemplate('style') + ' input ')
                    }
                });

                views[viewKey] = {
                    view : atmTemplating.render(template.name, section.renderBlockId),
                    componentName : template.component
                };
                if (section.dataSection == 'expanded') {
                    views[viewKey].view.small(false);
                }
            });
        });

        $form = $('section');
        $inputs = $form.find('input');


        var throttledSync = jQuery.throttle(200, function (e) {
            var viewKey = '';
            var inputKey = '';
            var parent = 0;
            jQuery.each(jQuery(this).parents('[data-template]'), function (i, block) {
                var data = jQuery(block).data('template');
                if (data != 'style') {
                    inputKey = jQuery(block).data('template') + inputKey;
                    if (parent > 0) {
                        viewKey = jQuery(block).data('template') + viewKey;
                    }
                    parent++;
                }
            });

            //console.log(JSON.stringify(inputsToObject(inputs)));

            options[views[viewKey].componentName][inputs[inputKey].optionName] = inputs[inputKey].input.val();
            styling[views[viewKey].componentName][inputs[inputKey].optionName] = getCSSFields(styleInputs[inputKey + 'style'].inputs);

            // update template
            atmTemplating.updateTemplate(views[viewKey].componentName, options[views[viewKey].componentName], styling[views[viewKey].componentName]);

            // redraw the view
            views[viewKey].view.redraw();
        });

        $inputs.bind('keyup', throttledSync);

        jQuery('#save-templates').bind('click', function (e) {
            //e.preventDefault();
            //.stopPropagation();
            console.log(inputsToObject(inputs));
            console.log(styleInputsToObject(styleInputs));
            /*var options = {};
             options[optionName] = $headingHeadlineInput.val();
             styling[optionName] = getCSSFields('pledge', 'collapsed', 'message');
             // dump template content to the console
             console.log(atmTemplating.templateRendition(componentName).render(options, styling));*/

            //return false;
        });
    })(jQuery);
});