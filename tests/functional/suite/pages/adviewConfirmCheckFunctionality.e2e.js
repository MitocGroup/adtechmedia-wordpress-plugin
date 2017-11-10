import { Selector } from 'testcafe';
import Login from '../../poms/components/login-form.po';
import config from '../../config/config.cfg';
import Adview from '../../poms/components/contentEditorAdView.po';

const login = new Login();
const adview = new Adview();
const contentEditorPayConfirm = 'Check that content editor is availabe and can be modified for Pay Confirm';

fixture `Check that content editor is availabe and inner content can be modified and saved for Pay Confirm`
 
  .page`${config.www_base_host}`;
test(contentEditorPayConfirm, async t => {

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
    .expect(adview.adviewConfirmed.with({                           //confirmation of successfull page load
      timeout: 15000,
      visibilityCheck: true,
    }).visible).ok();

    await t
    .click(adview.adviewConfirmed)
    .click(adview.headline)
    .typeText(adview.headlineText, '123 !! Premium content unlocked. {not-satisfied}!@#', {replace: true})
    .click(adview.shareExperienceBody)
    .typeText(adview.shareExperienceBodyText, ' 123 !@# Share experience on {share-facebook} or {share-twitter} 12324 !!', {replace: true})
    .click(adview.bodyMessage)
    .typeText(adview.bodyMessageText, ' !@# 212 Thanks for watching the ad and help us do the job we love! 134 ee33', {replace:true})
    .click(adview.Feeling)
    .typeText(adview.FeelingText, ' 123 !@# Please leave a feedback 124 !!', {replace: true})
    .click(adview.FeelingHappy)
    .typeText(adview.FeelingHappyText, '!! Awesome Good !!', {replace: true})
    .click(adview.FeelingOk)
    .typeText(adview.FeelingOkText, '!@# Not much liked !!!', {replace: true})
    .click(adview.FeelingBad)
    .typeText(adview.FeelingBadText, ' !!! So Bad !!', {replace: true})
    .click(adview.shareExperience)
    .typeText(adview.shareExperienceText, '!@# 223 Share your experience !!! 34', {replace: true})
    .click(adview.color)
    .typeText(adview.fontSize, '11px')
    .click(adview.textTransform)
    .click(adview.textTransformNone)
    .click(adview.textTransform)
    .click(adview.textTransformCapitalize)
    .click(adview.textTransform)
    .click(adview.textTransformUppercase)
    .click(adview.textTransform)
    .click(adview.textTransformLowercase)
    .click(adview.fontStyle)
    .click(adview.fontStyleNormal)
    .click(adview.fontStyle)
    .click(adview.fontStyleOblique)
    .click(adview.fontStyle)
    .click(adview.fontStyleItalique)
    .click(adview.fontWeight)
    .click(adview.fontWeightNormal)
    .click(adview.fontWeight)
    .click(adview.fontWeightBold)
    .click(adview.fontWeight)
    .click(adview.fontWeightBolded)
    .click(adview.fontWeight)
    .click(adview.fontWeightLigher)
  });
