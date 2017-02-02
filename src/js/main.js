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

function getInputsData(inputs){
  var styles = {};
  jQuery.each(inputs, function (i, input) {
    if (jQuery(input).val() !== '') {
      if (jQuery(input).is(':checkbox')) {
        styles[jQuery(input).attr('name')] = jQuery(input).prop('checked');
      } else {
        styles[jQuery(input).attr('name')] = jQuery(input).val();
      }

    }
  });
  return styles;
}

function getPositionFields() {
  var inputs = jQuery('[data-template="position"] input');

  return getInputsData(inputs);
}

function getOverallStylingFields() {
  var styles = {},
    inputs = jQuery('[data-template="overall-styling"] input');
  jQuery.each(inputs, function (i, input) {
    if (jQuery(input).val() !== '') {
      styles[jQuery(input).attr('data-template-css')] = jQuery(input).val();
    }
  });
  return styles;
}

function getOverallStyling() {
  var css = '',
    stylesData = getOverallStylingFields();
  if (stylesData.hasOwnProperty('background-color')) {
    css += '.atm-base-modal {background-color: ' + stylesData['background-color'] + ';}' +
      '.atm-targeted-modal .atm-head-modal ' +
      '.atm-modal-heading {background-color: ' + stylesData['background-color'] + ';}';
  }
  jQuery.each(['border', 'box-shadow'], function (i, key) {
    if (stylesData.hasOwnProperty(key)) {
      css += '.atm-targeted-modal{'+key+': ' + stylesData[key] + ';}';
    }
  });
  if (stylesData.hasOwnProperty('footer-background-color')) {
    css += '.atm-base-modal .atm-footer{background-color: ' + stylesData['footer-background-color'] + ';}';
  }
  if (stylesData.hasOwnProperty('footer-border')) {
    css += '.atm-base-modal .atm-footer{border: ' + stylesData['footer-border'] + ';}';
  }
  if (stylesData.hasOwnProperty('font-family')) {
    css += '.atm-targeted-container .mood-block-info,' +
      '.atm-targeted-modal,' +
      '.atm-targeted-modal .atm-head-modal .atm-modal-body p,' +
      '.atm-unlock-line .unlock-btn {font-family: ' + stylesData['font-family'] + ';}';
  }
  return css;
}
function applayOverallStyling(css) {
  var style = jQuery('#overall-template-styling');
  style.html(css);
}
function fillOverallStylesFields() {
  /*global templateOverallStylesInputs*/
  var inputs = jQuery('[data-template="overall-styling"] input');
  jQuery.each(inputs, function (i, input) {
    var key = jQuery(input).attr('data-template-css');
    if (templateOverallStylesInputs.hasOwnProperty(key)) {
      jQuery(input).val(templateOverallStylesInputs[key])
    }
  });
}
function fillPositionFields() {
  /*global templatePositionInputs*/
  var inputs = jQuery('[data-template="position"] input');
  jQuery.each(inputs, function (i, input) {
    var key = jQuery(input).attr('name');
    if (templatePositionInputs.hasOwnProperty(key)) {
      if (jQuery(input).is(':checkbox')) {
        //styles[jQuery(input).attr('name')] = jQuery(input).prop('checked');
        jQuery(input).prop('checked', templatePositionInputs[key]);
      } else {
        jQuery(input).val(templatePositionInputs[key])
      }
    }
  });
  if (!jQuery('#checkbox-sticky').prop('checked')) {
    jQuery('.disable-if-sticky input').attr('disabled', 'disabled');
  } else {
    jQuery('.disable-if-sticky input').removeAttr('disabled');
  }
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
  if ('auth' === value){
    value = 'pledge';
  }
  return '[data-template="' + value + '"]';
}

function initModal() {
  // Get the modal.
  var modal = document.getElementById('terms-modal');

  // Get the button that opens the modal.
  var btn = document.getElementById('terms-btn');

  // Get the <span> element that closes the modal.
  var span = document.getElementsByClassName('close')[0];

  // When the user clicks the button, open the modal.
  btn.onclick = function () {
    modal.style.display = 'block';
  };

  // When the user clicks on <span> (x), close the modal.
  span.onclick = function () {
    modal.style.display = 'none';
  };

  // When the user clicks anywhere outside of the modal, close it.
  window.onclick = function (event) {
    if (event.target === modal) {
      modal.style.display = 'none';
    }
  }
}

jQuery(document).ready(function () {
  /*global atmTpl, templateInputs, templateStyleInputs, save_template, noty*/
  atmTpl.default.config({revenueMethod: 'micropayments'});
  var atmTemplating = atmTpl.default;

  //atmTpl.config({revenueMethod: 'advertising'});
  fillPositionFields();
  fillOverallStylesFields();

  var tabs = [
    {
      id: 'pledge-salutation',
      dataTab: 'salutation',
      options: [
        {
          name: 'body-welcome',
          inputName: 'welcome',
          type: 'expanded'
        }
      ]
    },
    {
      id: 'pledge-message',
      dataTab: 'message',
      options: [
        {
          name: 'body-msg-mp',
          inputName: 'message-expanded',
          type: 'expanded'
        },
        {
          name: 'heading-headline',
          inputName: 'message-collapsed',
          type: 'collapsed'
        }
      ]
    },
    {
      id: 'auth-user',
      dataTab: 'user',
      component : 'authComponent',
      view:['pledge','pay'],
      options: [
        {
          name: 'logged-headline',
          inputName: 'user-logged',
          type: 'collapsed'
        },
        {
          name: 'used-headline',
          inputName: 'user-used',
          type: 'expanded'
        }
      ]
    },
    {
      id: 'pay-salutation',
      dataTab: 'salutation',
      options: [
        {
          name: 'body-salutation',
          inputName: 'salutation',
          type: 'expanded'
        }
      ]
    },
    {
      id: 'pay-message',
      dataTab: 'message',
      options: [
        {
          name: 'body-msg-mp',
          inputName: 'message-expanded',
          type: 'expanded'
        },
        {
          name: 'heading-headline-setup',
          inputName: 'message-collapsed',
          type: 'collapsed'
        }
      ]
    },
    {
      id: 'refund-mood-ok',
      dataTab: 'mood-ok',
      options: [
        {
          name: 'body-feeling-ok',
          inputName: 'body-feeling-ok',
          type: 'expanded'
        }
      ]
    },
    {
      id: 'refund-mood',
      dataTab: 'mood',
      options: [
        {
          name: 'body-feeling',
          inputName: 'body-feeling',
          type: 'expanded'
        }
      ]
    }, {
      id: 'refund-mood-happy',
      dataTab: 'mood-happy',
      options: [
        {
          name: 'body-feeling-happy',
          inputName: 'body-feeling-happy',
          type: 'expanded'
        }
      ]
    },
    {
      id: 'refund-mood-not-happy',
      dataTab: 'mood-not-happy',
      options: [
        {
          name: 'body-feeling-not-happy',
          inputName: 'body-feeling-not-happy',
          type: 'expanded'
        }
      ]
    },
    {
      id: 'refund-message',
      dataTab: 'message',
      options: [
        {
          name: 'body-msg',
          inputName: 'message-expanded',
          type: 'expanded'
        },
        {
          name: 'heading-headline',
          inputName: 'message-collapsed',
          type: 'collapsed'
        }
      ]
    },
    {
      id: 'refund-share',
      dataTab: 'share',
      options: [
        {
          name: 'body-share-experience',
          inputName: 'body-share-experience',
          type: 'expanded'
        }
      ]
    }

  ];

  var componentsViews = [
    {
      name:'pledge',
      collapsed:'#render-pledge-collapsed',
      expanded:'#render-pledge-expanded'
    },
    {
      name:'pay',
      collapsed:'#render-pay-collapsed',
      expanded:'#render-pay-expanded'
    },
    {
      name:'refund',
      collapsed:'#render-refund-collapsed',
      expanded:'#render-refund-expanded'
    },
  ]

  var components =[
    {
      name : 'pledge',
      component : 'pledgeComponent',
      dataTab : 'pledge',
      view:'pledge',
      sections : [
        'pledge-salutation',
        'pledge-message',
        'auth-user'
      ]
    },
    {
      name : 'pay',
      component : 'payComponent',
      dataTab : 'pay',
      view:'pay',
      sections : [
        'pay-salutation',
        'pay-message',
        'auth-user'
      ]
    },
    {
      name : 'refund',
      component : 'refundComponent',
      dataTab : 'refund',
      view:'refund',
      sections : [
        'refund-mood-ok',
        'refund-mood',
        'refund-mood-happy',
        'refund-mood-not-happy',
        'refund-message',
        'refund-share'
      ]
    }
  ];

  (function ($) {
    // read available template stories
    //atmTpl.default.config({revenueMethod: 'advertising'});
    var stories = atmTemplating.stories();
    console.log(stories);
    var views = {};
    var tabViews = {};
    var inputs = {};
    var options = {};
    var styling = {};
    var styleInputs = {};

    function toggleTemplates() {
      var sender = jQuery(jQuery(this.$el).parents('[data-view]')[0]),
        viewKey = sender.attr('data-view-key'),
        type = sender.attr('data-view'),
        typeOther = 'expanded',
        small = true,
        senderParent = sender.parent(),
        senderParentExpaned = senderParent.find('[data-view-text="expanded"]'),
        senderParentCollapsed = senderParent.find('[data-view-text="collapsed"]');
      if (type === 'expanded') {
        typeOther = 'collapsed';
        small = false;
      }
      senderParent.find('[data-view="' + typeOther + '"]').attr('data-view', type);
      sender.attr('data-view', typeOther);
      views[viewKey][typeOther]._watchers['showModalBody'].forEach(function(unwatch) {return unwatch()});
      delete views[viewKey][typeOther]._watchers['showModalBody'];
      views[viewKey][typeOther].small(small);
      views[viewKey][typeOther].watch('showModalBody', toggleTemplates);
      var tmp = views[viewKey]['expanded'];
      views[viewKey]['expanded'] = views[viewKey]['collapsed'];
      views[viewKey]['collapsed'] = tmp;
      tmp = senderParentExpaned.html();
      senderParentExpaned.html(senderParentCollapsed.html());
      senderParentCollapsed.html(tmp);
    }


    jQuery.each(components, function (i, template) {
      var tab = jQuery(getDatatemplate(template.dataTab));
      options[template.component] = {};
      styling[template.component] = {};
      var viewKey = template.dataTab;
      views[viewKey] = {};

      var viewKeys = [];
      var noViewKeys = [];

      viewKeys.push(viewKey);

      var tamplateView = componentsViews.filter(function(view) {
        return view.name === template.view;
      });

      if(tamplateView.length === 1) {
        tamplateView = tamplateView[0];
      } else {
        return false;
      }


      jQuery.each(template.sections, function (j, section) {
        var viewTab = tabs.filter(function (tab) {
          return tab.id === section;
        });

        if (viewTab.length === 1) {
          section = viewTab[0];
        } else {
          return false;
        }

        var componentName = template.component;
        if(section.hasOwnProperty('component')) {
          componentName = section.component;
          viewKey = section.dataTab;
          views[viewKey] = {};
          noViewKeys.push(viewKey);

        } else {
          viewKey = template.dataTab;
        }
        views[viewKey]['component'] = componentName;
        tabViews[viewKey] = tamplateView.name;
        if(section.hasOwnProperty('view')) {
          tabViews[viewKey] = section.view;
        }

        var sectionTab = tab.find(getDatatemplate(section.dataTab));
        var styleInputsKey = viewKey + section.dataTab + 'style';
        styleInputs[styleInputsKey] = {
          inputs : sectionTab.find(getDatatemplate('style') + ' input, ' + getDatatemplate('style') + ' select')
        };
        jQuery.each(section.options, function (j, option) {
          var inputsKey = viewKey + section.dataTab + option.type;
          var componentSelector = '[data-template="'+template.dataTab+'"]'
          + '[data-template="'+section.dataTab+'"]'
          + 'input[name="' + option.inputName + '"]';
          inputs[inputsKey] = {
            input : sectionTab.find('input[name="' + option.inputName + '"]'),
            optionName : option.name,
            type : option.type,
            tabSelector:'[data-template="'+section.dataTab+'"] input[name="' + option.inputName + '"]',
            componentSelector:componentSelector
          };

          if (templateInputs.hasOwnProperty(inputsKey)) {
            inputs[inputsKey].input.val(templateInputs[inputsKey]);
            inputs[inputsKey].input.attr('placeholder', templateInputs[inputsKey]);
            if(!options.hasOwnProperty(componentName)) {
              options[componentName] = {};
            }
            if(!styling.hasOwnProperty(componentName)) {
              styling[componentName] = {};
            }
            options[componentName][option.name] = templateInputs[inputsKey];
            styling[componentName][option.name] = templateStyleInputs[styleInputsKey];
          } else {
            if(stories.hasOwnProperty(componentName) && stories[componentName].hasOwnProperty(option.name)) {
              var val = stories[componentName][option.name].content;
              inputs[inputsKey].input.val(val);
              inputs[inputsKey].input.attr('placeholder', val);

              options[componentName] = {};
              options[componentName][option.name] = val;
              // if (templateStyleInputs.hasOwnProperty(styleInputsKey)) {
              //   styling[componentName][option.name] = templateStyleInputs[styleInputsKey];
              // }

            }
          }

        });
        fillCSSFields(styleInputsKey, templateStyleInputs, styleInputs);



      });


      jQuery.each(viewKeys, function (j, viewKeyItem) {
        if(!views[viewKeyItem].hasOwnProperty('component')) {
          views[viewKeyItem]['component'] = template.component;
        }

        views[viewKeyItem]['expanded'] = atmTemplating.render(template.name, tamplateView.expanded);
        views[viewKeyItem]['expanded'].small(false);
        views[viewKeyItem]['collapsed'] = atmTemplating.render(template.name, tamplateView.collapsed);
        jQuery(tamplateView.expanded).attr('data-view-key', viewKeyItem);
        jQuery(tamplateView.collapsed).attr('data-view-key', viewKeyItem);
        atmTemplating.updateTemplate(
            views[viewKeyItem]['component'],
            options[views[viewKeyItem]['component']],
            styling[views[viewKeyItem]['component']]
        );
        views[viewKeyItem].expanded.redraw();
        views[viewKeyItem].collapsed.redraw();

        views[viewKeyItem].expanded.watch('showModalBody', toggleTemplates);
        views[viewKeyItem].collapsed.watch('showModalBody', toggleTemplates);

      });
    });

    var throttledSync = jQuery.throttle(200, function (e) {
      var thisValue = $(this).val();
      var dataTemplateCss = $(this).attr('data-template-css');
      var viewKey = jQuery(jQuery(this).parents('[data-template]')[2]).data('template');
      var tabKey = jQuery(jQuery(this).parents('[data-template]')[1]).data('template');
      jQuery.each(['expanded', 'collapsed'], function (i, type) {
        var inputKey = viewKey + tabKey;

        if (inputs.hasOwnProperty(inputKey + type)) {
          options[views[viewKey].component][inputs[inputKey + type].optionName] = inputs[inputKey + type].input.val();
          styling[views[viewKey].component][inputs[inputKey + type].optionName] =
            getCSSFields(styleInputs[inputKey + 'style'].inputs);

        }
        else {
          inputKey = tabKey + tabKey;
          if (inputs.hasOwnProperty(inputKey + type)) {
            var inputSelector = inputs[inputKey + type].tabSelector;

            var oldValue =   options[views[tabKey].component][inputs[inputKey + type].optionName];
            var newValue =   inputs[inputKey + type].input.val();
            if(!styling.hasOwnProperty(views[tabKey].component)) {
              styling[views[tabKey].component] = {};
            }
            jQuery.each(jQuery(inputSelector), function(i,item) {
              if($(item).val() !== oldValue) {
                newValue = $(item).val();
              }
            });

            jQuery.each(jQuery(inputSelector), function(i,item) {
              if($(item).val() !== newValue) {
                $(item).val(newValue);
              }
            });

            var styleSelector = '[data-template="'+tabKey+'"] [data-template-css="'+dataTemplateCss+'"]';
            var newStyle =   thisValue;
            jQuery.each(jQuery(styleSelector), function(i,item) {
              if(jQuery(item).val() !== newStyle) {
                jQuery(item).val(newStyle);
              }
            });
            options[views[tabKey].component][inputs[inputKey + type].optionName] = newValue;
            styling[views[tabKey].component][inputs[inputKey + type].optionName] =
                getCSSFields(styleInputs[inputKey + 'style'].inputs);
          }
        }
      });

      var needToRedraw = [];
      if(tabViews.hasOwnProperty(tabKey)) {
        needToRedraw = tabViews[tabKey];

        atmTemplating.updateTemplate(
            views[tabKey].component,
            options[views[tabKey].component],
            styling[views[tabKey].component]
        );
      } else {
        needToRedraw = tabViews[viewKey];

      }

      if(!Array.isArray(needToRedraw)) {
        needToRedraw = [needToRedraw];
      }
      jQuery.each(needToRedraw, function (i, type) {
//        update template

        atmTemplating.updateTemplate(
            views[type].component,
            options[views[type].component],
            styling[views[type].component]
        );
        // redraw the view
        views[type].expanded.redraw();
        views[type].collapsed.redraw();
        views[type].expanded.watch('showModalBody', toggleTemplates);
        views[type].collapsed.watch('showModalBody', toggleTemplates);

      });

    });

    var $form = $('section.views-tabs');
    var $inputs = $form.find('input');
    var $selects = $form.find('select');
    var $colorInputs = $form.find('input[type="color"]');

    $inputs.bind('keyup', throttledSync);
    $colorInputs.bind('change', throttledSync);
    $selects.bind('change', throttledSync);

    var overallSync = jQuery.throttle(200, function () {
      applayOverallStyling(getOverallStyling());
    });
    jQuery('[data-template="overall-styling"] input').bind('keyup', overallSync);
    jQuery('[data-template="overall-styling"] input[type="color"]').bind('change', overallSync);

    function addLoader(btn){
      var icon = btn.find('i');
      btn.addClass('disabled');
      icon.removeClass('mdi mdi-check');
      icon.addClass('fa fa-spinner fa-spin');
    }

    function removeLoader(btn){
      var icon = btn.find('i');
      btn.removeClass('disabled');
      icon.removeClass('fa fa-spinner fa-spin');
      icon.addClass('mdi mdi-check');
    }
    function showSuccess(){
      noty({
        type: 'success',
        text: 'AdTechMedia parameters have been saved successfully',
        timeout: 2000
      });
    }
    function addValidate(form, rules, messages) {
      jQuery.each(rules, function(name, item) {
        jQuery('input[name="'+name+'"]').on('focus', function() {
          var item = jQuery('input[name="'+name+'"]');

          if(jQuery(item).hasClass('invalid')) {
            jQuery(item).removeClass('invalid');
            var label = jQuery(item).parents('.custom-label').find('label');
            if (!label[0]) {
              label = jQuery(item).parents('.custom-input').find('label');
            }
            label.removeClass('invalid');
          }
        });
      });

      return form.validate({
        rules: rules,
        errorClass: 'invalid',
        onclick: false,
        onkeyup: false,
        onfocusout: false,
        showErrors: function(errorMap, errorList) {
          jQuery.each(errorList, function(i, item) {
            if(!jQuery(item.element).hasClass('invalid')) {
              jQuery(item.element).addClass('invalid');
              var label = jQuery(item.element).parents('.custom-label').find('label');
              if (!label[0]) {
                label = jQuery(item.element).parents('.custom-input').find('label');
              }
              label.addClass('invalid');
            }
          });

          var errorsMeassge = '';
          jQuery.each(errorMap, function(i, item) {
            errorsMeassge += '<br>' + item;
          });
          if(errorsMeassge !== '') {
            return noty({
              type: 'error',
              text: errorsMeassge,
              timeout: 5000
            });
          }
        },
        messages: messages
      });
    }
    function showError(){
      noty({
        type: 'error',
        text: 'AdTechMedia parameters failed to save. Please retry or contact plugin support team.',
        timeout: 2000
      });
    }
    jQuery('.save-templates').bind('click', function (e) {
      var btn = jQuery(this);
      var viewKey = jQuery(btn.parents('[data-template]')[0]).data('template');

      //get compnents in this view
      var viewComponents = {};
      jQuery.each(components, function(i,template) {
        if(template.hasOwnProperty('view')) {
          var templateView = template.view;
          if(!Array.isArray(templateView)) {
            templateView = [templateView] ;
          }
          jQuery.each(templateView,function(i,view) {
            if(view === viewKey) {
              viewComponents[template.component] = atmTemplating.templateRendition(template.component).render(
                  options[template.component],
                  styling[template.component]
              );
            }
          });
        }
      });

      jQuery.each(tabs, function(i,template) {
        if(template.hasOwnProperty('view')) {
          var templateView = template.view;
          if(!Array.isArray(templateView)) {
            templateView = [templateView] ;
          }
          jQuery.each(templateView,function(i,view) {
            if(view === viewKey) {
              viewComponents[template.component] = atmTemplating.templateRendition(template.component).render(
                  options[template.component],
                  styling[template.component]
              );
            }
          });
        }
      });

      var valid = addValidate(jQuery('#overall-styling-and-position'), {
        width: {
          required: true,
          cssSize: true
        },
        offset_top: {
          required: true,
          cssSize: true
        },
        offset_left: {
          required: true,
          cssSize: true
        },
        scrolling_offset_top: {
          required: true,
          cssSize: true
        },
        border:{
          required: true,
        },
        font_family:{
          required: true,
        },
        box_shadow:{
          required: true,
        },
        footer_border:{
          required: true,
        }
      }, {
        width: {
          required: 'The field \'Width\' is required.',
          cssSize: 'The field \'Width\' must be valid CSS size.'
        },
        offset_top: {
          required: 'The field \'Offset top\' is required.',
          cssSize: 'The field \'Offset top\' must be valid CSS size.'
        },
        offset_left: {
          required: 'The field \'Offset from center\' is required.',
          cssSize: 'The field \'Offset from center\' must be valid CSS size.'
        },
        scrolling_offset_top: {
          required: 'The field \'Scrolling offset top\' is required.',
          cssSize: 'The field \'Scrolling offset top\' must be valid CSS size.'
        },
        border:{
          required: 'The field \'Border\' is required.',
        },
        font_family:{
          required: 'The field \'Font Family\' is required.',
        },
        box_shadow:{
          required: 'The field \'Box Shadow\' is required.',
        },
        footer_border:{
          required: 'The field \'Footer Border\' is required.',
        }
      });

      if(valid.form()) {
        addLoader(btn);
        jQuery.ajax({
          url: save_template.ajax_url,
          type: 'post',
          data: {
            action: 'save_template',
            nonce: save_template.nonce,
            inputs: JSON.stringify(inputsToObject(inputs)),
            styleInputs: JSON.stringify(styleInputsToObject(styleInputs)),
            position: JSON.stringify(getPositionFields()),
            overallStyles: getOverallStyling(),
            overallStylesInputs: JSON.stringify(getOverallStylingFields()),
            components: Object.keys(viewComponents),
            templates: viewComponents
          },
          success: function (response) {
            removeLoader(btn);
            showSuccess();
          },
          error: function (response) {
            removeLoader(btn);
            showError();
          }
        });
      }
    });

    jQuery('#save-revenue-model').bind('click', function (e) {
      var btn = jQuery(this);
      var form = jQuery('#save-revenue-model').parents('form');
      var valid = addValidate(jQuery(form), {
        email: {
          required: true,
          email: true
        }
      }, {
        email: {
          required: 'The field \'Email address\' is required.',
          email: 'Your email address must be in the format of name@domain.com.'
        }
      });
      if(valid.form()) {
        addLoader(btn);
        jQuery.ajax({
          url: save_template.ajax_url,
          type: 'post',
          data: {
            action: 'save_template',
            nonce: save_template.nonce,
            revenueMethod: jQuery('select[name="revenue_method"]').val()
          },
          success: function (response) {
            removeLoader(btn);
            showSuccess();
          },
          error: function (response) {
            removeLoader(btn);
            showError();
          }
        });
      }
    });
    jQuery('#country').bind('change', function (e) {
      var country = jQuery(this),
        method = jQuery('#revenue_method');
      method.empty();
      $.each(country.find(':selected').data('methods'), function(key,value) {
        method.append($('<option></option>')
          .attr('value', value).text(value));
      });
    });
    jQuery('#content-config button').bind('click', function (e) {
      var btn = jQuery(this);

      var valid = addValidate(jQuery('#content-config'), {
        price: {
          required: true,
          digits: true,
          min:1
        },
        payment_pledged: {
          required: true,
          digits: true
        },
        content_offset: {
          required: true,
          digits: true,
          min:1
        },
        ads_video: {
          required: false,
          url: true
        }
      }, {
        price: {
          required: 'The field \'Content pricing\' is required.',
          digits: 'The field \'Content pricing\' must be a digits.'
        },
        payment_pledged: {
          required: 'The field \'Content paywall\' is required.',
          digits: 'The field \'Content paywall\' must be a digits.'
        },
        content_offset: {
          required: 'The field \'Content preview\' is required.',
          digits: 'The field \'Content preview\' must be a digits.'
        },
        ads_video: {
          required: false,
          url: 'The field \'Content preview\' must be a valid url.'
        }
      });
      if(valid.form()) {
        addLoader(btn);
        jQuery.ajax({
          url : save_template.ajax_url,
          type : 'post',
          data : {
            action : 'save_template',
            nonce : save_template.nonce,
            contentConfig : JSON.stringify(getInputsData(
                jQuery('#content-config .content input,#content-config .content select')
            ))
          },
          success : function (response) {
            removeLoader(btn);
            showSuccess();
          },
          error : function (response) {
            removeLoader(btn);
            showError();
          }
        });
      }
    });

    var generalConfValid = false;
    var formGeneralConfig = jQuery('#general-config');
    jQuery('#btn-register').on('click', function (e) {
      if (generalConfValid) {
        formGeneralConfig.submit();
      } else {
        e.preventDefault();

        var valid = addValidate(formGeneralConfig, {
          support_email : {
            required : true,
            email : true
          }
        }, {
          support_email : {
            required : 'The field \'Email address\' is required.',
            email : 'Your email address must be in the format of name@domain.com.'
          }
        });

        if (valid.form()) {
          generalConfValid = true;
          this.click();
        }
      }
    });
  })(jQuery);

  jQuery('#checkbox-sticky').on('change', function () {
    if (!jQuery(this).prop('checked')) {
      jQuery('.disable-if-sticky input').attr('disabled', 'disabled');
    } else {
      jQuery('.disable-if-sticky input').removeAttr('disabled');
    }
  });

  function checkBtnRegister(checkbox) {
    var button = jQuery('#btn-register');
    if (jQuery(checkbox).prop('checked')) {
      jQuery(button).removeAttr('disabled');
    } else {
      jQuery(button).attr('disabled', 'true');
    }
  }

  var terms = jQuery('#terms');
  terms.on('change', function () {
    checkBtnRegister(this);
  });
  checkBtnRegister(terms);

  initModal();

  jQuery('#modal-content').load('https://www.adtechmedia.io/terms/dialog.html');

  function firstSynch(){
    jQuery('[data-template="user"] input[name]').trigger('keyup');
    jQuery('[data-template="user"] input[data-template-css]').trigger('keyup');
    jQuery('[data-template="user"] select[data-template-css]').trigger('change');
    jQuery('[data-template="user"] input[type="color"][data-template-css]').trigger('change');
  }
  firstSynch();

  jQuery.get('https://www.adtechmedia.io/terms/dialog.html').done(function (data) {
    jQuery('#modal-content').append(data);
  }).fail(function () {
    var str = '<a href="https://www.adtechmedia.io/terms/dialog.html"'
      +' target="_blank">https://www.adtechmedia.io/terms/dialog.html</a>';
    jQuery('#modal-content').append(str);
  });

  jQuery.validator.methods.cssSize = function( value, element ) {
    return this.optional( element ) || /(auto|0)$|^[+-]?[0-9]+.?([0-9]+)?(px|em|ex|%|in|cm|mm|pt|pc)/.test( value );
  }


});
