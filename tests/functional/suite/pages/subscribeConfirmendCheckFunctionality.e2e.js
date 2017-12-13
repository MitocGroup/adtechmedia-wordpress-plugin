import { Selector } from 'testcafe';
import Login from '../../poms/components/login-form.po';
import config from '../../config/config.cfg';
import SubscribeConfirm from '../../poms/components/contentEditorSubscribeConfirm.po';

const login = new Login();
const subscribeConfirm = new SubscribeConfirm();
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
    .expect(subscribeConfirm.subsConfirm.with({                           //confirmation of successfull page load
      timeout: 15000,
      visibilityCheck: true,
    }).visible).ok();

    await t
    .click(subscribeConfirm.subsConfirm)
    .click(subscribeConfirm.subsHeadline)
    .typeText(subscribeConfirm.subsHeadlineText, '!@# You are subscribed to {plan} plan. {not-satisfied}  {unsubscribe-button} !!!@@@', {replace: true})
    .click(subscribeConfirm.subsBodyMessage)
    .typeText(subscribeConfirm.subsBodyMessageText, "!@# 1234 You are subscribed to {plan} plan. You'll be charge {amount} per {period} to your {source} account.1324!!!", {replace: true})
    .click(subscribeConfirm.subsFeeling)
    .typeText(subscribeConfirm.subsFeelingText, '!@##34 Please leave a feedback!!! 34', {replace: true})
    .click(subscribeConfirm.subsFeelingHappy)
    .typeText(subscribeConfirm.subsFeelingHappyText, ' Very Good!!!', {replace: true})
    .click(subscribeConfirm.subsFeelingOk)
    .typeText(subscribeConfirm.subsFeelingOkText, 'Not so well', {replace: true})
    .click(subscribeConfirm.subsFeelingNotHappy)
    .typeText(subscribeConfirm.subsFeelingNotHappyText, '!@## Sad man !!!', {replace: true})
    .click(subscribeConfirm.subsShareExperience)
    .typeText(subscribeConfirm.subsShareExperienceText, '!@#$1234 Share your experience 234!!', {replace: true})
    .click(subscribeConfirm.subsColor)
    .typeText(subscribeConfirm.subsFontSize, '13px', {replace: true})
    .click(subscribeConfirm.subsTextTransform)
    .click(subscribeConfirm.subsTextTransformNone)
    .click(subscribeConfirm.subsTextTransform)
    .click(subscribeConfirm.subsTextTransformCapitalize)
    .click(subscribeConfirm.subsTextTransform)
    .click(subscribeConfirm.subsTextTransformUppercase)
    .click(subscribeConfirm.subsTextTransform)
    .click(subscribeConfirm.subsTextTransformLowercase)
    .click(subscribeConfirm.subsFontStyle)
    .click(subscribeConfirm.subsFontStyleNormal)
    .click(subscribeConfirm.subsFontStyle)
    .click(subscribeConfirm.subsFontStyleItalique)
    .click(subscribeConfirm.subsFontStyle)
    .click(subscribeConfirm.subsFontStyleOblique)
    .click(subscribeConfirm.subsFontWeight)
    .click(subscribeConfirm.subsFontWeightNormal)
    .click(subscribeConfirm.subsFontWeight)
    .click(subscribeConfirm.subsFontWeightBold)
    .click(subscribeConfirm.subsFontWeight)
    .click(subscribeConfirm.subsFontWeightBolder)
    .click(subscribeConfirm.subsFontWeight)
    .click(subscribeConfirm.subsFontWeightLighter);

    await t
    .click(subscribeConfirm.subsSmile)
    .click(subscribeConfirm.subMeh)
    .click(subscribeConfirm.subsSad)
    .click(subscribeConfirm.subsFb)
    .click(subscribeConfirm.subsTwitter)
    .click(subscribeConfirm.subsEmail)
    .click(subscribeConfirm.subsShare)
    .click(subscribeConfirm.subsArrowCollaps)
  });
