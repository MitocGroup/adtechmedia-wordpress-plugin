import { Selector } from 'testcafe';
import Login from '../../poms/components/login-form.po';
import config from '../../config/config.cfg';
import PayPreview from '../../poms/components/contentEditorPay.po';

const login = new Login();
const payPreview = new PayPreview();
const contentEditorPay = 'Check that content editor is availabe and can be modified for Pay';

fixture `Check that content editor is availabe and inner content can be modified and saved for Pay`
 
  .page`${config.www_base_host}`;
test(contentEditorPay, async t => {

  await t
    // .resizeWindow(1920, 1080)
    .typeText(login.login, 'root')                             // start login to WP plugin with navigation
    .typeText('#user_pass', 'ASkLkZj#f%31Ya91eO')                  //wp 4.7.6
    //  .typeText(login.pass, '$EnC$@l6)ieTLAYtkK')                //wp 4.8
    .click(login.submit);

    await t
    .expect(login.nameInput.innerText).contains('Dashboard')
    .expect(login.menu).ok()
    .click(login.menu)
    .expect(login.submenuAdtechmedia).ok()
    .hover(login.menuPlugins)
    .click(login.submenuAdtechmedia);                       // last step of login. It clicking on Adtechmedia link from the left menu

    await t
    // .wait(12000)
    .expect(payPreview.pay.with({                           //confirmation of successfull page load
      timeout: 15000,
      visibilityCheck: true,
    }).visible).ok();

    await t
    .click(payPreview.pay)
    .click(payPreview.payHeadline)
    .click(payPreview.payHeadlineSetupWanted)
    .typeText(payPreview.payHeadlineSetupWantedText, '!!!!Please support quality journalism. {payment-setup}!!!!', {replace : true})
    .click(payPreview.payHeadlinePaymentAvailble)
    .typeText(payPreview.payHeadlinePaymentAvailbleText, '!@# Please support quality journalism. !@# ', {replace : true})
    .click(payPreview.paySalutation)
    .typeText(payPreview.paySalutationText, '@#$% Dear {user} , !!!!', {replace : true})
    .click(payPreview.payBodyMessage)
    .click(payPreview.payBodyMessageMicrAndAdv)
    .typeText(payPreview.payBodyMessageMicrAndAdvText, '!@#$ Please support quality journalism. Would you like to pay {price} to continue reading? As alternative, you can watch this ad and continue reading for free.!@#$', {replace: true})
    .click(payPreview.payBodyMessageMicrAndSub)
    .typeText(payPreview.payBodyMessageMicrAndSubText, '!@#$!$Please support quality journalism. Would you like to pay {price} to continue reading? As alternative, you can subscribe to {plan-name} plan and pay {plan-price} per {plan-period} for unlimited access.!!@#!$', {replace: true})
    .click(payPreview.payBodyMessageSubAndAdv)
    .typeText(payPreview.payBodyMessageSubAndAdvText, '!@!$Please support quality journalism. Would you like to subscribe to {plan-name} plan and pay {plan-price} per {plan-period} for unlimited access? As alternative, you can watch this ad and continue reading for free.!@#!@%', {replace: true})
    .click(payPreview.payChangePaymentOption)
    .typeText(payPreview.payChangePaymentOptionText, '!@#$ {provider} is your default payment gateway. Do you want to change it? {choose-option}!@#$', {replace: true})
    .click(payPreview.payChoosePaymentOption)
    .typeText(payPreview.payChoosePaymentOptionText, '!@#$ Choose a payment option below !@#$', {replace: true})
    .click(payPreview.payFontColor)
    .typeText(payPreview.payFontSize, '15px', {replace: true})
    .click(payPreview.payTextTransform)
    .click(payPreview.payTextTransformNone)
    .click(payPreview.payTextTransform)
    .click(payPreview.payTextTransformUppercase)
    .click(payPreview.payTextTransform)
    .click(payPreview.payTextTransformCapitalize)
    .click(payPreview.payTextTransform)
    .click(payPreview.payTextTransformLowercase)
    .click(payPreview.payFontStyle)
    .click(payPreview.payFontStyleNormal)
    .click(payPreview.payFontStyle)
    .click(payPreview.payFontStyleItalique)
    .click(payPreview.payFontStyle)
    .click(payPreview.payFontStyleOblique)
    .click(payPreview.payFontWeight)
    .click(payPreview.payFontWeightNormal)
    .click(payPreview.payFontWeight)
    .click(payPreview.payFontWeightBold)
    .click(payPreview.payFontWeight)
    .click(payPreview.payFontWeightBolder)
    .click(payPreview.payFontWeight)
    .click(payPreview.payFontWeightLighter);

    await t
    .click(payPreview.payConnectHere)
    .expect(payPreview.paySendField.visible).ok()
    .click(payPreview.payClickHere)
    .click(payPreview.payAppleLogo)
    .expect(payPreview.payAppleLogo.visible).ok()
    .click(payPreview.payAmazonLogo)
    .expect(payPreview.payAmazonLogo.visible).ok()
    .click(payPreview.payPaypalLogo)
    .expect(payPreview.payPaypalLogo.visible).ok()
    .click(payPreview.payNextBtn)
    .hover(payPreview.payAndroidLogo)
    .click(payPreview.payStripeLogo)
    .click(payPreview.payBackBtnStripe)
    .click(payPreview.payBackBtn)
    .click(payPreview.payAppleLogo)
    .click(payPreview.payAppleInfo)
    .expect(payPreview.payAppleInfoText.innerText).eql("We partner with Apple Pay to manage your data securely. When you setup with us your Apple Pay, we initially charge only once the total amount pledged so far. Then we aggregate your monthly usage and charge one transaction per account per month. If you didn\'t use us in any given month, no charges will occur on your account during that month. We\'ll keep you informed through regular messages sent to your email address.")
    .click(payPreview.payAmazonLogo)
    .click(payPreview.payAmazonInfo)
    .expect(payPreview.payAmazonInfoText.innerText).eql('We partner with AMAZON to manage your data securely. When you setup with us your Amazon Payments, we initially charge only once the total amount pledged so far. Then we aggregate your monthly usage and charge one transaction per account per month. If you didn\'t use us in any given month, no charges will occur on your account during that month. We\'ll keep you informed through regular messages sent to your email address.')
    .click(payPreview.payPaypalLogo)
    .click(payPreview.payPayPalInfo)
    .expect(payPreview.payPayPalInfoText.innerText).eql('We partner with PAYPAL to manage your data securely. When you setup with us your PayPal Account, we initially charge only once the total amount pledged so far. Then we aggregate your monthly usage and charge one transaction per account per month. If you didn\'t use us in any given month, no charges will occur on your account during that month. We\'ll keep you informed through regular messages sent to your email address.');
    
    await t
    .hover(payPreview.payMoreBtn)
    .click(payPreview.payMoreBtn1);
    // .expect(payPreview.payMoreThisMonthYellow.visible).ok()
    // .expect(payPreview.payMoreThisMonthGreen.visible).ok()
    // .expect(payPreview.payMoreThisMonthBlue.visible).ok();
  });
