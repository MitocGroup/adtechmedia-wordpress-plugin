import { Selector } from 'testcafe';
import Login from '../../poms/components/login-form.po';
import config from '../../config/config.cfg';
import Preview from '../../poms/components/contentEditorPledge.po';

const login = new Login();
const preview = new Preview();
const contentEditorPledge = 'Check that content editor is availabe and can be modified for Pledge';

fixture `Check that content editor is availabe and inner content can be modified and saved for Pledge`
 
  .page`${config.www_base_host}`;
test(contentEditorPledge, async t => {

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
    .expect(preview.pledge.with({                           //confirmation of successfull page load
      timeout: 15000,
      visibilityCheck: true,
    }).visible).ok();

    await t
    .click(preview.pledge)
    .click(preview.pledgeHeadline)
    .typeText(preview.pledgeHeadlineText, '!!!Please support quality journalism.!!!', {replace : true})
    .click(preview.pledgeSalutation)
    .typeText(preview.pledgeSalutationText, '!@!Dear {user} ,!@!', {replace : true})
    .click(preview.pledgeBodyMessage)
    .click(preview.pledgeMicrAndAdv)
    .typeText(preview.pledgeMicrAndAdvText, '!!!! Please support quality journalism. Would you pledge to pay {price} to continue reading? As alternative, you can watch this ad and continue reading for free. !!!!!!', {replace : true})
    .click(preview.pledgeMictAndSub)
    .typeText(preview.pledgeMicrAndAdvText, '!!!! Please support quality journalism. Would you pledge to pay {price} to continue reading? As alternative, you can subscribe to {plan-name} plan and pay {plan-price} per {plan-period} for unlimited access. !!!!!!', {replace : true})
    .click(preview.pledgeColor)
    .typeText(preview.pledgeFontSize, '17px', {replace: true})
    .click(preview.pledgeTextTransform)
    .click(preview.pledgeTextTransformNone)
    .click(preview.pledgeTextTransform)
    .click(preview.pledgeTextTransformUppercase)
    .click(preview.pledgeTextTransform)
    .click(preview.pledgeTextTransformCapitalize)
    .click(preview.pledgeTextTransform)
    .click(preview.pledgeTextTransformLowercase)
    .click(preview.pledgeFontStyle)
    .click(preview.pledgeFontStyleNormal)
    .click(preview.pledgeFontStyle)
    .click(preview.pledgeFontStyleItalique)
    .click(preview.pledgeFontStyle)
    .click(preview.pledgeFontStyleOblique)
    .click(preview.pledgeFontWeight)
    .click(preview.pledgeFontWeightNormal)
    .click(preview.pledgeFontWeight)
    .click(preview.pledgeFontWeightBold)
    .click(preview.pledgeFontWeight)
    .click(preview.pledgeFontWeightBolder)
    .click(preview.pledgeFontWeight)
    .click(preview.pledgeFontWeightLighter)
    .click(preview.saveBtn);

    await t
    .expect(preview.pledgeCheckHeadline.innerText).contains('!!!Please support quality journalism.!!!')
    .expect(preview.pledgeCheckSalutation.innerText).contains('!@!Dear reader ,!@!')
    .expect(preview.pledgeCheckBody.innerText).contains('!!!! please support quality journalism. ')
    .click(preview.pledgeLinkConnect)
    .expect(preview.pledgeSendButton.visible).ok()
    .click(preview.pledgeExpandArrow);
})
