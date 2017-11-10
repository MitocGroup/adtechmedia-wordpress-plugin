import { Selector } from 'testcafe';

export default class payPreview {
  constructor() {
    const elementsInRow = (nr, elem) => {   //made till end this logic
      let arr = [];
      for (let i = 0; i < nr; i++) {
        arr.push(elem);
      }
      return arr.join(' > ');      //that is for less lines
    }

    const ntc = (nth) => `:nth-child(${nth})`;
    const div4 = elementsInRow(4, 'div');

    const _paySelector = `#wpbody-content > main > section${ntc(3)} > div > div.tabs-container > div > div >`;
    const paySelector = (full = false) => full ? `${_paySelector} ${div4}.vue-tabs.preview-tabs.col-xs-6` : _paySelector;


    this.pay = Selector(`${paySelector()} ul > li${ntc(2)}`);
    this.payHeadline = Selector(`${paySelector(true)} > ul > li.tab.active`);
    this.payHeadlineSetupWanted = Selector(`${paySelector(true)} > ${div4} > ul > li.tab.active`);
    this.payHeadlineSetupWantedText = Selector(`${paySelector(true)} > ${div4} > div > div > div.row.content > div > .textcomplete`);
    this.payHeadlinePaymentAvailble = Selector(`${paySelector(true)} > ${div4} > ul > li${ntc(2)}`);
    this.payHeadlinePaymentAvailbleText = Selector(`${paySelector(true)} > ${div4} > div > div > div.row.content > div > .textcomplete`);
    this.paySalutation = Selector(`${paySelector(true)} > ul > li${ntc(2)}`);
    this.paySalutationText = Selector(`${paySelector(true)} > ${div4}.row.content > div > .textcomplete`);
    this.payBodyMessage = Selector(`${paySelector(true)} > ul > li${ntc(3)}`);
    this.payBodyMessageMicrAndAdv = Selector(`${paySelector(true)} > ${div4} > ul > li.tab.active`);
    this.payBodyMessageMicrAndAdvText = Selector(`${paySelector(true)} > ${div4} > div > div > div.row.content > div > .textcomplete`);
    this.payBodyMessageMicrAndSub = Selector(`${paySelector(true)} > ${div4} > ul > li${ntc(2)}`);
    this.payBodyMessageMicrAndSubText = Selector(`${paySelector(true)} > ${div4} > div > div > div.row.content > div > .textcomplete`);
    this.payBodyMessageSubAndAdv = Selector(`${paySelector(true)} > ${div4} > ul > li${ntc(3)}`);
    this.payBodyMessageSubAndAdvText = Selector(`${paySelector(true)} > ${div4} > div > div > div.row.content > div > .textcomplete`);
    this.payChangePaymentOption = Selector(`${paySelector(true)} > ul > li${ntc(4)}`);
    this.payChangePaymentOptionText = Selector(`${paySelector(true)} > ${div4}.row.content > div > .textcomplete`);
    this.payChoosePaymentOption = Selector(`${paySelector(true)} > ul > li${ntc(5)}`);
    this.payChoosePaymentOptionText = Selector(`${paySelector(true)} > ${div4}.row.content > div`);
    this.payFontColor = Selector(`${paySelector(true)} > ${div4}${ntc(2)} > div > ul > li:nth-child(20)`);
    this.payFontSize = Selector(`${paySelector(true)} > ${div4}${ntc(3)} > div${ntc(1)}`);
    this.payTextTransform = Selector(`${paySelector(true)} > ${div4}${ntc(3)} > div.vfl-has-label.col-xs-6.vfl-label-on-input.vfl-select > select`);
    this.payTextTransformNone = Selector(`${paySelector(true)} > ${div4}${ntc(3)} > div.vfl-has-label.col-xs-6.vfl-label-on-input.vfl-select > select > option${ntc(1)}`);
    this.payTextTransformCapitalize = Selector(`${paySelector(true)} > ${div4}${ntc(3)} > div.vfl-has-label.col-xs-6.vfl-label-on-input.vfl-select > select > option${ntc(2)}`);
    this.payTextTransformUppercase = Selector(`${paySelector(true)} > ${div4}${ntc(3)} > div.vfl-has-label.col-xs-6.vfl-label-on-input.vfl-select > select > option${ntc(3)}`);
    this.payTextTransformLowercase = Selector(`${paySelector(true)} > ${div4}${ntc(3)} > div.vfl-has-label.col-xs-6.vfl-label-on-input.vfl-select > select > option${ntc(4)}`);
    this.payFontStyle = Selector(`${paySelector(true)} > ${div4}${ntc(4)} > div${ntc(1)} > select`);
    this.payFontStyleNormal = Selector(`${paySelector(true)} > ${div4}${ntc(4)} > div${ntc(1)} > select > option${ntc(1)}`);
    this.payFontStyleItalique = Selector(`${paySelector(true)} > ${div4}${ntc(4)} > div${ntc(1)} > select > option${ntc(2)}`);
    this.payFontStyleOblique = Selector(`${paySelector(true)} > ${div4}${ntc(4)} > div${ntc(1)} > select > option${ntc(3)}`);
    this.payFontWeight = Selector(`${paySelector(true)} > ${div4}${ntc(4)} > div${ntc(2)} > select`);
    this.payFontWeightNormal = Selector(`${paySelector(true)} > ${div4}${ntc(4)} > div${ntc(2)} > select > option${ntc(1)}`);
    this.payFontWeightBold = Selector(`${paySelector(true)} > ${div4}${ntc(4)} > div${ntc(2)} > select > option${ntc(2)}`);
    this.payFontWeightBolder = Selector(`${paySelector(true)} > ${div4}${ntc(4)} > div${ntc(2)} > select > option${ntc(3)}`);
    this.payFontWeightLighter = Selector(`${paySelector(true)} > ${div4}${ntc(4)} > div${ntc(2)} > select > option${ntc(4)}`);
    this.payConnectHere = Selector('#wpbody-content > main > section:nth-child(3) > div > div.tabs-container > div > div > div > div > div > div.preview.col-xs-6 > div:nth-child(1) > div > div > div > div > div.atm-main > div.pledge-bottom.clearfix > div.logging-opt > div > small > a');
    this.paySendField = Selector(`#wpbody-content > main > section:nth-child(3) > div > div.tabs-container > div > div > div > div > div > div.preview.col-xs-6 > div:nth-child(1) > div > div > div > div > div.atm-main > div.pledge-bottom.clearfix > div.logging-opt > div > div > form > div > div.form-item.flex-item-5 > input[type="email"]`);
    this.payClickHere = Selector('#wpbody-content > main > section:nth-child(3) > div > div.tabs-container > div > div > div > div > div > div.preview.col-xs-6 > div:nth-child(1) > div > div > div > div > div.atm-main > div.pledge-bottom.clearfix > div.logging-opt > small > a');
    this.payClickHere = Selector('#wpbody-content > main > section:nth-child(3) > div > div.tabs-container > div > div > div > div > div > div.preview.col-xs-6 > div:nth-child(1) > div > div > div > div > div.atm-main > div.pledge-bottom.clearfix > div.logging-opt > small > span > a');
    this.payLogos = Selector('#wpbody-content > main > section:nth-child(3) > div > div.tabs-container > div > div > div > div > div > div.preview.col-xs-6 > div:nth-child(1) > div > div > div > div > div.atm-pay.atm-main-addition > div');
    this.payAppleLogo = Selector('#wpbody-content > main > section:nth-child(3) > div > div.tabs-container > div > div > div > div > div > div.preview.col-xs-6 > div:nth-child(1) > div > div > div > div > div.atm-pay.atm-main-addition > div > div:nth-child(1)');
    this.payAmazonLogo = Selector('#wpbody-content > main > section:nth-child(3) > div > div.tabs-container > div > div > div > div > div > div.preview.col-xs-6 > div:nth-child(1) > div > div > div > div > div.atm-pay.atm-main-addition > div > div:nth-child(2)');
    this.payPaypalLogo = Selector('#wpbody-content > main > section:nth-child(3) > div > div.tabs-container > div > div > div > div > div > div.preview.col-xs-6 > div:nth-child(1) > div > div > div > div > div.atm-pay.atm-main-addition > div > div:nth-child(3)');
    this.payNextBtn = Selector('#wpbody-content > main > section:nth-child(3) > div > div.tabs-container > div > div > div > div > div > div.preview.col-xs-6 > div:nth-child(1) > div > div > div > div > div.atm-pay.atm-main-addition > div > div.flex-item-1.justify-center.more-payments');
    this.payAndroidLogo = Selector('#wpbody-content > main > section:nth-child(3) > div > div.tabs-container > div > div > div > div > div > div.preview.col-xs-6 > div:nth-child(1) > div > div > div > div > div.atm-pay.atm-main-addition > div > div:nth-child(2)');
    this.payStripeLogo = Selector('#wpbody-content > main > section:nth-child(3) > div > div.tabs-container > div > div > div > div > div > div.preview.col-xs-6 > div:nth-child(1) > div > div > div > div > div.atm-pay.atm-main-addition > div > div:nth-child(3)');
    this.payBackBtn = Selector('#wpbody-content > main > section:nth-child(3) > div > div.tabs-container > div > div > div > div > div > div.preview.col-xs-6 > div:nth-child(1) > div > div > div > div > div.atm-pay.atm-main-addition > div > div.flex-item-1.justify-center.more-payments');
    this.payBackBtnStripe = Selector('#wpbody-content > main > section:nth-child(3) > div > div.tabs-container > div > div > div > div > div > div.preview.col-xs-6 > div:nth-child(1) > div > div > div > div > div.atm-footer > i');
    this.payAppleInfo = Selector('#wpbody-content > main > section:nth-child(3) > div > div.tabs-container > div > div > div > div > div > div.preview.col-xs-6 > div:nth-child(1) > div > div > div > div > div.atm-pay.atm-main-addition > div > div:nth-child(1) > div > i');
    this.payAppleInfoText = Selector('#wpbody-content > main > section:nth-child(3) > div > div.tabs-container > div > div > div > div > div > div.preview.col-xs-6 > div:nth-child(1) > div > div > div > div > div.atm-pay.atm-main-addition > div.pay-help-text > span');
    this.payAmazonInfo = Selector('#wpbody-content > main > section:nth-child(3) > div > div.tabs-container > div > div > div > div > div > div.preview.col-xs-6 > div:nth-child(1) > div > div > div > div > div.atm-pay.atm-main-addition > div.flex-row.payment-options > div:nth-child(2) > div > i');
    this.payAmazonInfoText = Selector('#wpbody-content > main > section:nth-child(3) > div > div.tabs-container > div > div > div > div > div > div.preview.col-xs-6 > div:nth-child(1) > div > div > div > div > div.atm-pay.atm-main-addition > div.pay-help-text > span');
    this.payPayPalInfo = Selector('#wpbody-content > main > section:nth-child(3) > div > div.tabs-container > div > div > div > div > div > div.preview.col-xs-6 > div:nth-child(1) > div > div > div > div > div.atm-pay.atm-main-addition > div.flex-row.payment-options > div:nth-child(3) > div > i');
    this.payPayPalInfoText = Selector('#wpbody-content > main > section:nth-child(3) > div > div.tabs-container > div > div > div > div > div > div.preview.col-xs-6 > div:nth-child(1) > div > div > div > div > div.atm-pay.atm-main-addition > div.pay-help-text > span');
    this.payMoreBtn = Selector('#wpbody-content > main > section:nth-child(3) > div > div.tabs-container > div > div > div > div > div > div.preview.col-xs-6 > div:nth-child(1) > div > div > div > div > div.atm-main > div.pledge-bottom.clearfix > div:nth-child(2) > button > i');
    this.payMoreBtn1 = Selector('#wpbody-content > main > section:nth-child(3) > div > div.tabs-container > div > div > div > div > div > div.preview.col-xs-6 > div:nth-child(1) > div > div > div > div > div.atm-main > div.pledge-bottom.clearfix > div:nth-child(2) > button > .more');
    // this.payMoreThisMonthYellow = Selector('#wpbody-content > main > section:nth-child(3) > div > div.tabs-container > div > div > div > div > div > div.preview.col-xs-6 > div:nth-child(2) > div > div > div > div > div.atm-main > div.pay-tabs > div:nth-child(3) > div > div.flex-item.bc-yellow');
    // this.payMoreThisMonthYellow = Selector('#tab1 > .pay-content > .flex-row > .bc-yellow');
    // this.payMoreThisMonthGreen = Selector('#wpbody-content > main > section:nth-child(3) > div > div.tabs-container > div > div > div > div > div > div.preview.col-xs-6 > div:nth-child(2) > div > div > div > div > div.atm-main > div.pay-tabs > div:nth-child(3) > div > div.flex-item.bc-green');
    // this.payMoreThisMonthBlue = Selector('#wpbody-content > main > section:nth-child(3) > div > div.tabs-container > div > div > div > div > div > div.preview.col-xs-6 > div:nth-child(2) > div > div > div > div > div.atm-main > div.pay-tabs > div:nth-child(3) > div > div.flex-item.bc-blue');
    // this.payMoreLastMonth = Selector('#wpbody-content > main > section:nth-child(3) > div > div.tabs-container > div > div > div > div > div > div.preview.col-xs-6 > div:nth-child(2) > div > div > div > div > div.atm-main > div.pay-tabs > label:nth-child(5)');


  }
}