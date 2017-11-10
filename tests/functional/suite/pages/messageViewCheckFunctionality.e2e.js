import { Selector } from 'testcafe';
import Login from '../../poms/components/login-form.po';
import config from '../../config/config.cfg';
import Message from '../../poms/components/contentEditorMessageView.po';

const login = new Login();
const message = new Message();
const contentEditorMessageView = 'Check that content editor is availabe and can be modified for Message View tab';

fixture `Check that content editor is availabe and inner content can be modified and saved for Message View tab`
 
  .page`${config.www_base_host}`;
test(contentEditorMessageView, async t => {

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
    .expect(message.messageTab.with({                           //confirmation of successfull page load
      timeout: 15000,
      visibilityCheck: true,
    }).visible).ok();

    await t
    .click(message.messageTab)
    .click(message.refundConfirmed)
    .typeText(message.refundConfirmedText, '123 !@# Original charge has been refunded. Thanks for continue supporting quality journalism. 123!!', {replace: true})
    .click(message.unsubscribeConfirmed)
    .typeText(message.unsubscribeConfirmedText, '!@# 123 Your subscription is expiring on {cancel-date} Until then you can still enjoy reading premium content.1123 !!!', {replace: true})
    .click(message.unsubscribeConfirmed)
    .typeText(message.unsubscribeConfirmedText, '!@# 13 Your subscription is expiring on {cancel-date} Until then you can still enjoy reading premium content. 123', {replace: true})
    .click(message.freeContent)
    .typeText(message.freeContentText, '123 !@# Congratulations! This content is available for free. 123 !!')
    .click(message.color)
    .typeText(message.fontSize, '16px')
    .click(message.textTransform)
    .click(message.textTransformCapitalize)
    .click(message.textTransform)
    .click(message.textTransformNone)
    .click(message.textTransform)
    .click(message.textTransformLowercase)
    .click(message.textTransform)
    .click(message.textTransformUppercase)
    .click(message.fontStyle)
    .click(message.fontStyleNormal)
    .click(message.fontStyle)
    .click(message.fontStyleOblique)
    .click(message.fontStyle)
    .click(message.fontStyleItalique)
    .click(message.fontWeigth)
    .click(message.fontWeightLigher)
    .click(message.fontWeigth)
    .click(message.fontWeightNormal)
    .click(message.fontWeigth)
    .click(message.fontWeightBold)
    .click(message.fontWeigth)
    .click(message.fontWeightBolder)


  });
