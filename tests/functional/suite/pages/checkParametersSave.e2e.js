import { Selector } from 'testcafe';
import Login from '../../poms/components/login-form.po';
import config from '../../config/config.cfg';
import Elements from '../../poms/components/fields_elements.po';

const login = new Login();
const elements = new Elements();
const parametersSave = 'Check that changed parameters for WP plugin can be saved';

fixture `Check parameters that could be modified and saved`
 
  .page`${config.www_base_host}`;
test(parametersSave, async t => {

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
    .expect(elements.price.with({                           //confirmation of successfull page load
      timeout: 15000,
      visibilityCheck: true,
    }).visible).ok();

    await t
    .typeText(elements.price,'1.23', { replace: true })
    .typeText(elements.contentPaywall, '1', {replace: true})
    .typeText(elements.contentPreview, '3', {replace: true})
    .click(elements.contentLock)
    .click(elements.contentLockBlur)
    .hover(elements.save)
    .click(elements.save)

    await t
    .expect(elements.notyfyBar.with({
        timeout: 15000,
        visibilityCheck: true,
      }).visible).ok();

    await t
    .click(elements.contentPaywallType)
    .click(elements.contentPaywallTransaction)
    .click(elements.contentPreviewType)
    .click(elements.contentPreviewParagraph)
    .typeText(elements.ab, '100', {replace: true})
    .hover(elements.save)
    .click(elements.save);

    await t
    .expect(elements.notyfyBar.with({
        timeout: 15000,
        visibilityCheck: true,
      }).visible).ok();
    
    await t
    .typeText(elements.price,'0.45', { replace: true })
    .typeText(elements.contentPaywall, '0', {replace: true})
    .typeText(elements.contentPreview, '0', {replace: true})
    .click(elements.contentLock)
    .click(elements.contentLockBlurScramble)
    .hover(elements.save)
    .click(elements.save)

    await t
    .expect(elements.notyfyBar.with({
        timeout: 15000,
        visibilityCheck: true,
      }).visible).ok();

    await t
    .click(elements.contentPaywallType)
    .click(elements.contentPaywallCurrency)
    .click(elements.contentPreviewType)
    .click(elements.contentPreviewWords)
    .typeText(elements.ab, '50', {replace: true})
    .hover(elements.save)
    .click(elements.save);

    await t
    .expect(elements.notyfyBar.with({
        timeout: 15000,
        visibilityCheck: true,
      }).visible).ok();

});    