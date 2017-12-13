import { Selector } from 'testcafe';
import Login from '../../poms/components/login-form.po';
import config from '../../config/config.cfg';
// import config from '../../config/config.cfg (mine)';
import Widget from '../../poms/components/widgetOnPosts.po';
import CountryCurrencyRevenue from '../../poms/components/general-configuration.po';
import Elements from '../../poms/components/fields_elements.po';
import Preview from '../../poms/components/contentEditorPledge.po';
import TextChecks from '../../poms/components/changeWidgetUSText.po'

const login = new Login();
const widget = new Widget();
const countryCurrencyRevenue = new CountryCurrencyRevenue();
const elements = new Elements();
const preview = new Preview();
const textChecks = new TextChecks();
const widgetApplied = 'Widget can be applied on posts for US with changed text - pledge';

fixture `Widget can be applied on posts and modified from WP configuration page for US with changed text - pledge`
 
//   .page`${config.www_base_host}/wp-admin/`;
.page`${config.www_base_host}`;
test(widgetApplied, async t => {

  await t
    .typeText(login.login, 'root')                             // start login to WP plugin with navigation
    // .typeText('#user_pass', 'ASkLkZj#f%31Ya91eO')                  //wp 4.7.6
     .typeText(login.pass, 'aQB9JKsg*LJjVUsNk$')                //wp 4.8
    // .typeText(login.login, 'admin')                         //for pantheon site
    // .typeText(login.pass, '3VsoRnGyB5mQ3UuS')               //for pantheon site
    .click(login.submit);   

    await t
    .expect(login.nameInput.innerText).contains('Dashboard')
    .expect(login.menu).ok()
    .click(login.menu)
    .expect(login.submenuAdtechmedia).ok()
    .hover(login.menuPlugins)
    .click(login.submenuAdtechmedia);                       // last step of login. It clicking on Adtechmedia link from the left menu

    await t
    .expect(widget.abParameter.with({                           //confirmation of successfull page load
      timeout: 15000,
      visibilityCheck: true,
    }).visible).ok()

    await t
    .wait(10000)
    .typeText(widget.abParameterText, '100', {replace: true})       //change parameters for widget
    .click(widget.saveBtn)
    .click(countryCurrencyRevenue.countryMain)
    .click(countryCurrencyRevenue.country1)
    .click(countryCurrencyRevenue.revenueMethod)
    .click(countryCurrencyRevenue.revenueMethod2)
    .click(countryCurrencyRevenue.saveBTN)                                     //click on Save button, then wait top menu to display
    .typeText(elements.contentPaywall, '1', {replace: true})
    .expect(countryCurrencyRevenue.notyBAR.with({
      timeout: 20000,
      visibilityCheck: true,
    }).visible).ok()
    .typeText(elements.price,'1.23', { replace: true })
    .click(elements.save)
    .click(preview.pledge)
    .click(preview.pledgeHeadline)
    .typeText(preview.pledgeHeadlineText, '!!!Please support quality journalism.!!!', {replace : true})
    .click(preview.pledgeSalutation)
    .typeText(preview.pledgeSalutationText, '!@!Dear {user} ,!@!', {replace : true})
    .click(preview.pledgeBodyMessage)
    .click(preview.pledgeMicrAndAdv)
    .typeText(preview.pledgeMicrAndAdvText, '!!!! Please support quality journalism. Would you pledge to pay {price} to continue reading? As alternative, you can watch this ad and continue reading for free. !!!!!!', {replace : true})
    .click(preview.saveBtn);

    await t                                                   //check changed parameters on posts
    .navigateTo('http://localhost/~admin/wordpress_4.8.2/')
    .click(widget.recentPost1)
    .wait(5000)
    await t
    .hover(widget.checkWordPressLink)
    .hover(widget.checkWordPressLink)
    .expect(widget.widgetPlugin.visible).ok()
    .expect(textChecks.pledgeHeadline.innerText).contains('!!!Please support quality journalism.!!!')

    await t
    .click(widget.expandBtn)
    .expect(textChecks.pledgeSalut.innerText).contains('!@!Dear reader ,!@!')
    .expect(textChecks.pledgeBodyMessage.innerText).contains('!!!! Please support quality journalism.');
});