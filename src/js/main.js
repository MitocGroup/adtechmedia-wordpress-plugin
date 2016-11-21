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

function fillCSSFields(key, inputValues, inputFields) {
  if (inputValues.hasOwnProperty(key)) {
    jQuery.each(inputValues[key], function (name, value) {
      inputFields[key].inputs.filter('[data-template-css="' + name + '"]').val(value);
    });
  }
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
    },
    {
      name : 'pay',
      component : 'payComponent',
      dataTab : 'pay',
      collapsed : '#render-pay-collapsed',
      expanded : '#render-pay-expanded',
      sections : [
        {
          dataTab : 'salutation',
          options : [{
            name : 'body-salutation',
            inputName : 'salutation',
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
    },
    {
      name : 'refund',
      component : 'refundComponent',
      dataTab : 'refund',
      collapsed : '#render-refund-collapsed',
      expanded : '#render-refund-expanded',
      sections : [
        {
          dataTab : 'mood-ok',
          options : [{
            name : 'body-feeling-ok',
            inputName : 'body-feeling-ok',
            type : 'expanded'
          }]
        }, {
          dataTab : 'mood',
          options : [{
            name : 'body-feeling',
            inputName : 'body-feeling',
            type : 'expanded'
          }]
        }, {
          dataTab : 'mood-happy',
          options : [{
            name : 'body-feeling-happy',
            inputName : 'body-feeling-happy',
            type : 'expanded'
          }]
        }, {
          dataTab : 'mood-not-happy',
          options : [{
            name : 'body-feeling-not-happy',
            inputName : 'body-feeling-not-happy',
            type : 'expanded'
          }]
        }, {
          dataTab : 'message',
          options : [{
            name : 'body-msg',
            inputName : 'message-expanded',
            type : 'expanded'
          }, {
            name : 'heading-headline',
            inputName : 'message-collapsed',
            type : 'collapsed'
          }]
        }, {
          dataTab : 'share',
          options : [{
            name : 'body-share-experience',
            inputName : 'body-share-experience',
            type : 'expanded'
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
      var viewKey = template.dataTab;
      views[viewKey] = {};
      jQuery.each(template.sections, function (j, section) {
        var sectionTab = tab.find(getDatatemplate(section.dataTab));
        var styleInputsKey = viewKey + section.dataTab + 'style';
        styleInputs[styleInputsKey] = {
          inputs : sectionTab.find(getDatatemplate('style') + ' input ')
        };
        jQuery.each(section.options, function (j, option) {
          var inputsKey = viewKey + section.dataTab + option.type;
          inputs[inputsKey] = {
            input : sectionTab.find('input[name="' + option.inputName + '"]'),
            optionName : option.name,
            type : option.type
          };
          if (templateInputs.hasOwnProperty(inputsKey)) {
            inputs[inputsKey].input.val(templateInputs[inputsKey]);
            options[template.component][option.name] = templateInputs[inputsKey];
            styling[template.component][option.name] = templateStyleInputs[styleInputsKey];
          }

        });
        fillCSSFields(styleInputsKey, templateStyleInputs, styleInputs);
      });
      views[viewKey]['expanded'] = atmTemplating.render(template.name, template.expanded);
      views[viewKey]['expanded'].small(false);
      views[viewKey]['component'] = template.component;
      views[viewKey]['collapsed'] = atmTemplating.render(template.name, template.collapsed);
      atmTemplating.updateTemplate(template.component, options[template.component], styling[template.component]);
      views[viewKey].expanded.redraw();
      views[viewKey].collapsed.redraw();
    });

    $form = $('section');
    $inputs = $form.find('input');


    var throttledSync = jQuery.throttle(200, function (e) {
      var viewKey = jQuery(jQuery(this).parents('[data-template]')[2]).data('template');

      var inputKey = viewKey + jQuery(jQuery(this).parents('[data-template]')[1]).data('template')

      jQuery.each(['expanded', 'collapsed'], function (i, type) {
        //console.log(type);
        if (inputs.hasOwnProperty(inputKey + type)) {
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

    jQuery('.save-templates').bind('click', function (e) {
      var viewKey = jQuery(jQuery(this).parents('[data-template]')[0]).data('template');

      jQuery.ajax({
        url : save_template.ajax_url,
        type : 'post',
        data : {
          action : 'save_template',
          inputs : JSON.stringify(inputsToObject(inputs)),
          styleInputs : JSON.stringify(styleInputsToObject(styleInputs)),
          component : views[viewKey].component,
          template : atmTemplating.templateRendition(views[viewKey].component).render(options[views[viewKey].component], styling[views[viewKey].component])
        },
        success : function (response) {
          alert(response)
        }
      });
    });
  })(jQuery);
});
