/**
 * Created by yama_gs on 21.10.2016.
 */

function getCSSFields(inputs) {
  var styles = {};

  jQuery.each(inputs, function (i, input) {
    if (jQuery(input).val() !== '') {
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
  return '[data-template="' + value + '"]';
}
jQuery(document).ready(function () {
  var atmTemplating = atmTpl.default;

  var templates = [
    {
      name : 'pledge',
      component : 'pledgeComponent',
      dataTab : 'pledge',
      collapsed : '#render-pledge-collapsed',
      expanded : '#render-pledge-expanded',
      sections : [
        {
          dataTab : 'salutation',
          options : [{
            name : 'body-welcome',
            inputName : 'welcome',
            type : 'expanded'
          }]
        }, {
          dataTab : 'message',
          options : [{
            name : 'body-msg-mp-ad',
            inputName : 'message-expanded',
            type : 'expanded'
          }, {
            name : 'heading-headline',
            inputName : 'message-collapsed',
            type : 'collapsed'
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
      var viewKey = template.dataTab ;
      views[viewKey] = {};
      jQuery.each(template.sections, function (j, section) {
        var sectionTab = tab.find(getDatatemplate(section.dataTab));

        jQuery.each(section.options, function (j, option) {
          //var subTab = sectionTab.find(getDatatemplate(tab.dataTab));
          inputs[viewKey + section.dataTab + option.type] = {
            input : sectionTab.find('input[name="' + option.inputName + '"]'),
            optionName : option.name,
            type: option.type
          };

        });
        styleInputs[viewKey + section.dataTab + 'style'] = {
          inputs : sectionTab.find(getDatatemplate('style') + ' input ')
        };
        /*views[viewKey] = {
          view : atmTemplating.render(template.name, section.renderBlockId),
          componentName : template.component
        };
        if (section.dataSection == 'expanded') {
          views[viewKey].view.small(false);
        }*/
      });
      views[viewKey]['expanded'] = atmTemplating.render(template.name, template.expanded);
      views[viewKey]['expanded'].small(false);
      views[viewKey]['component'] = template.component;
      views[viewKey]['collapsed'] = atmTemplating.render(template.name, template.collapsed);

    });

    $form = $('section');
    $inputs = $form.find('input');


    var throttledSync = jQuery.throttle(200, function (e) {
      var viewKey = jQuery(jQuery(this).parents('[data-template]')[2]).data('template');

      var inputKey = viewKey + jQuery(jQuery(this).parents('[data-template]')[1]).data('template')

      /*console.log(viewKey);
      console.log(inputKey);
      //console.log(styleKey);
      console.log(views);
      console.log(options);
      console.log(styling);
      console.log(styleInputs);

      console.log(inputs);*/
      //var parent = 0;
      //var parent = 0;
      /*jQuery.each(jQuery(this).parents('[data-template]'), function (i, block) {
        var data = jQuery(block).data('template');
        if (parent == 0) {
        if (data == 'style') {
          inputKey = jQuery(block).data('template') + inputKey;

            //viewKey = jQuery(block).data('template') + viewKey;

        }else{

        }
        } else{

        }
        parent++;
      });*/

      //console.log(JSON.stringify(inputsToObject(inputs)));
      jQuery.each(['expanded','collapsed'], function (i, type) {
        //console.log(type);
        if(inputs.hasOwnProperty(inputKey+type)) {
          options[views[viewKey].component][inputs[inputKey + type].optionName] = inputs[inputKey + type].input.val();
          styling[views[viewKey].component][inputs[inputKey + type].optionName] = getCSSFields(styleInputs[inputKey + 'style'].inputs);
        }
      });
      // update template
      atmTemplating.updateTemplate(views[viewKey].component, options[views[viewKey].component], styling[views[viewKey].component]);

      // redraw the view
      views[viewKey].expanded.redraw();
      views[viewKey].collapsed.redraw();
    });

    $inputs.bind('keyup', throttledSync);

    jQuery('#save-templates').bind('click', function (e) {
      console.log(inputsToObject(inputs));
      console.log(styleInputsToObject(styleInputs));

      /*var options = {};
       options[optionName] = $headingHeadlineInput.val();
       styling[optionName] = getCSSFields('pledge', 'collapsed', 'message');
       // dump template content to the console
       console.log(atmTemplating.templateRendition(componentName).render(options, styling));*/
    });
  })(jQuery);
});
