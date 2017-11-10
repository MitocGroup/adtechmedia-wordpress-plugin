import { Selector } from 'testcafe';
import Login from '../../poms/components/login-form.po';
import config from '../../config/config.cfg';
import Confirm from '../../poms/components/contentEditorPayConfirm.po';

const login = new Login();
const confirm = new Confirm();
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
    .expect(confirm.payConfirm.with({                           //confirmation of successfull page load
      timeout: 15000,
      visibilityCheck: true,
    }).visible).ok();

    await t
    .click(confirm.payConfirm)
    .click(confirm.payHeadline)
    .typeText(confirm.payHeadlineText, '!@#$ Premium content unlocked. {not-satisfied}  {refund-button} 123', {replace: true})
    .click(confirm.payBodyMessage)
    .typeText(confirm.payBodyMessageText, '!@# Thanks for contributing {price} and help us do the job we love! 123', {replace: true})
    .click(confirm.payFeeling)
    .typeText(confirm.payFeelingText, '!@# Please leave a feedback 123', {replace: true})
    .click(confirm.payFeelingHappy)
    .typeText(confirm.payFeelingHappyText, 'So - Good', {replace: true})
    .click(confirm.payFeelingOk)
    .typeText(confirm.payFeelingOkText, '!@# OK !!', {replace: true})
    .click(confirm.payFeelinNotHappy)
    .typeText(confirm.payFeelinNotHappyText, ' ! Very SAD !!', {replace: true})
    .click(confirm.payShareExperience)
    .typeText(confirm.payShareExperienceText, '1234 Share your experience !!!', {replace: true})
    .click(confirm.payColor)
    .typeText(confirm.payText, '14px')
    .click(confirm.payTextTransform)
    .click(confirm.payTextTransformNone)
    .click(confirm.payTextTransform)
    .click(confirm.payTextTransformCapitalise)
    .click(confirm.payTextTransform)
    .click(confirm.payTextTransformUppercase)
    .click(confirm.payTextTransform)
    .click(confirm.payTextTransformLowercase)
    .click(confirm.payFontStyle)
    .click(confirm.payFontStyleNormal)
    .click(confirm.payFontStyle)
    .click(confirm.payFontStyleItalique)
    .click(confirm.payFontStyle)
    .click(confirm.payFontStyleOblique)
    .click(confirm.payFontWeight)
    .click(confirm.payFontWeightNormal)
    .click(confirm.payFontWeight)
    .click(confirm.payFontWeightBold)
    .click(confirm.payFontWeight)
    .click(confirm.payFontWeightBolder)
    .click(confirm.payFontWeight)
    .click(confirm.payFontWeightLighter);

    await t
    .click(confirm.paySmile)
    .click(confirm.payMeh)
    .click(confirm.paySad)
  });
