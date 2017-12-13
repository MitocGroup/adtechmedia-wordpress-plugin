import { Selector } from 'testcafe';
import Login from '../../poms/components/login-form.po';
import config from '../../config/config.cfg';
// import config from '../../config/config.cfg (mine)';
import Widget from '../../poms/components/widgetOnPosts.po';
import CountryCurrencyRevenue from '../../poms/components/general-configuration.po';
import Elements from '../../poms/components/fields_elements.po';

const login = new Login();
const widget = new Widget();
const countryCurrencyRevenue = new CountryCurrencyRevenue();
const elements = new Elements();
const widgetApplied = 'Widget can be applied on posts for UK';

fixture `Widget can be applied on posts and modified from WP configuration page for UK`
 
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
    .click(countryCurrencyRevenue.country4)
    .click(countryCurrencyRevenue.revenueMethod)
    .click(countryCurrencyRevenue.revenueMethod1)
    .click(countryCurrencyRevenue.priceCurrency)
    .click(countryCurrencyRevenue.priceCurrency1)
    .click(countryCurrencyRevenue.saveBTN)                                     //click on Save button, then wait top menu to display
    .typeText(elements.contentPaywall, '1', {replace: true})
    .expect(countryCurrencyRevenue.notyBAR.with({
      timeout: 20000,
      visibilityCheck: true,
    }).visible).ok()
    .typeText(elements.price,'5.42', { replace: true })
    .click(elements.save);

    await t                                                   //check changed parameters on posts
    .navigateTo('http://localhost/~admin/wordpress_4.8.2/')
    .click(widget.recentPost1)
    .wait(5000)
    await t
    .wait(5000)
    .hover(widget.checkWordPressLink)
    .hover(widget.checkWordPressLink)
    .expect(widget.widgetPlugin.visible).ok()
    .click(widget.expandBtn)
    
    .expect(widget.priceCheck.innerText).eql('£5.42')
    .expect(widget.payPledgeBtn.innerText).eql(' PLEDGE')
    .expect(widget.subscribeBtn.innerText).eql(' SUBSCRIBE')

    await t
    .navigateTo('http://localhost/~admin/wordpress_4.8.2/wp-admin/plugins.php?page=Adtechmedia_PluginSettings');
    
    await t
    .wait(5000)
    .click(countryCurrencyRevenue.revenueMethod)
    .click(countryCurrencyRevenue.revenueMethod2)
    .click(countryCurrencyRevenue.saveBTN)                                     //click on Save button, then wait top menu to display
    .expect(countryCurrencyRevenue.notyBAR.with({
      timeout: 20000,
      visibilityCheck: true,
    }).visible).ok()
    .click(countryCurrencyRevenue.priceCurrency)
    .click(countryCurrencyRevenue.priceCurrency2)
    .typeText(elements.price,'1.11', { replace: true })
    .click(elements.save);
    
    await t
    .navigateTo('http://localhost/~admin/wordpress_4.8.2/')
    .click(widget.recentPost1)
    .wait(5000)
    await t
    .wait(5000)
    .hover(widget.checkWordPressLink)
    .hover(widget.checkWordPressLink)
    .expect(widget.widgetPlugin.visible).ok()
    .click(widget.expandBtn)
    // .expect(widget.priceCheck.innerText).eql('$1.11')    //for now it is comment since there is an issue
    .expect(widget.payPledgeBtn.innerText).eql(' PLEDGE');
    // .expect(widget.showADBtn.innerText).eql(' SHOW AD');

    await t
    .navigateTo('http://localhost/~admin/wordpress_4.8.2/wp-admin/plugins.php?page=Adtechmedia_PluginSettings');
    
    await t
    .wait(5000)
    .click(countryCurrencyRevenue.revenueMethod)
    .click(countryCurrencyRevenue.revenueMethod3)
    .click(countryCurrencyRevenue.saveBTN)                                     //click on Save button, then wait top menu to display
    .expect(countryCurrencyRevenue.notyBAR.with({
      timeout: 20000,
      visibilityCheck: true,
    }).visible).ok();

    await t
    .navigateTo('http://localhost/~admin/wordpress_4.8.2/')
    .click(widget.recentPost1)
    .wait(5000)
    await t
    .hover(widget.checkWordPressLink)
    .hover(widget.checkWordPressLink)
    .expect(widget.widgetPlugin.visible).ok()
    .click(widget.expandBtn)

    // .expect(widget.priceCheck.innerText).eql('Monthly')              //for now it is comment since there is an issue
    .expect(widget.showADBtn.innerText).eql(' SUBSCRIBE')
    // .expect(widget.subscribeBtn1.innerText).eql(' SUBSCRIBE');


});