import { Selector } from 'testcafe';
import Login from '../../poms/components/login-form.po';
import config from '../../config/config.cfg (mine)';
// import CountryCurrencyRevenue from './configuration/general-configuration.po.js';
const CountryCurrencyRevenue = require('../../poms/components/general-configuration.po');

const login = new Login();
const countryCurrencyRevenue = new CountryCurrencyRevenue();
const countrySave = 'Country changed and Save to DB -> USA, UK, Canada, Romania';

fixture`Save functionality`
  // .page`http://localhost/~admin_user/wordpress_4.8/wp-admin/`;   //wp 4.8 
  // .page`http://localhost/~admin/wordpress_4.7.6/wp-admin/`;   //wp 4.7.6
  .page`${config.www_base_host}`;
test(countrySave, async t => {

  await t
    .typeText(login.login, 'root')                             // start login to WP plugin with navigation
    .typeText('#user_pass', 'ASkLkZj#f%31Ya91eO')                  //wp 4.7.6
    //  .typeText(login.pass, '$EnC$@l6)ieTLAYtkK')                //wp 4.8
    .click(login.submit)

  await t
    .resizeWindow(1920, 1080)

  await t
    .expect(login.nameInput.innerText).contains('Dashboard')
    .expect(login.menu).ok()
    .click(login.menu)
    .expect(login.submenuAdtechmedia).ok()
    .click(login.submenuAdtechmedia);                       // last step of login. It clicking on Adtechmedia link from the left menu

  await t
    .wait(12000)
    .expect(countryCurrencyRevenue.countryMain.with({                           //confirmation of that if the page is loaded successfully
      timeout: 15000,
      visibilityCheck: true,
    }).visible).ok();

  await t                                                                   //USA verification start
    .hover(countryCurrencyRevenue.countryMain);                                 //block that selects first value for revenue

  await t
    .click(countryCurrencyRevenue.countryMain)
    .click(countryCurrencyRevenue.country1)
    .expect(countryCurrencyRevenue.country1.innerText).eql('United States')
    .click(countryCurrencyRevenue.revenueMethod)
    .click(countryCurrencyRevenue.revenueMethod1)
    .click(countryCurrencyRevenue.saveBTN)                                     //click on Save button, then wait top menu to display
    .expect(countryCurrencyRevenue.notyBAR.with({
      timeout: 20000,
      visibilityCheck: true,
    }).visible).ok();

  await t
    .click(countryCurrencyRevenue.nav);                                       //simulation of reshresh the page
  await t
    .expect(countryCurrencyRevenue.check).ok();
  await t
    .click(login.menu)
    .expect(login.submenuAdtechmedia).ok()
    .click(login.submenuAdtechmedia)

  await t
    .wait(7000)
    .hover(countryCurrencyRevenue.countryMain)                                // block that checks if changes are applied for select1
    .expect(countryCurrencyRevenue.country1.innerText).eql('United States')
    .expect(countryCurrencyRevenue.revenueMethod).ok()
    .expect(countryCurrencyRevenue.revenueMethod.selectedIndex).eql(0)        // check that changes are applied after save and reshresh
    .expect(countryCurrencyRevenue.priceCurrency1.innerText).eql('USD');

  await t
    .hover(countryCurrencyRevenue.countryMain)                                //repeat cycle of selecting for another value
    .click(countryCurrencyRevenue.revenueMethod)
    .click(countryCurrencyRevenue.revenueMethod2)                             //select second valued for revenue
    .click(countryCurrencyRevenue.saveBTN)
    .expect(countryCurrencyRevenue.notyBAR.with({
      timeout: 15000,
      visibilityCheck: true,
    }).visible).ok();

  await t
    .click(countryCurrencyRevenue.nav);                                       //simulation of reshresh the page
  await t
    .expect(countryCurrencyRevenue.check).ok();
  await t
    .click(login.menu)
    .expect(login.submenuAdtechmedia).ok()
    .click(login.submenuAdtechmedia)                                          //end simulation of the refresh

  await t
    .wait(9000)
    .hover(countryCurrencyRevenue.countryMain)                                //block that checks save for second value of revenue
    .expect(countryCurrencyRevenue.country1.innerText).eql('United States')
    .expect(countryCurrencyRevenue.revenueMethod).ok()
    .expect(countryCurrencyRevenue.revenueMethod.selectedIndex).eql(1)        // check that changes are applied after save and reshresh
    .expect(countryCurrencyRevenue.priceCurrency1.innerText).eql('USD');

  await t
    .hover(countryCurrencyRevenue.countryMain)                                //repeat cycle of selecting for another value
    .click(countryCurrencyRevenue.revenueMethod)
    .click(countryCurrencyRevenue.revenueMethod3)
    .click(countryCurrencyRevenue.saveBTN)
    .expect(countryCurrencyRevenue.notyBAR.with({
      timeout: 15000,
      visibilityCheck: true,
    }).visible).ok();

  await t
    .click(countryCurrencyRevenue.nav);                                        //simulation of reshresh the page
  await t
    .expect(countryCurrencyRevenue.check).ok();
  await t
    .click(login.menu)
    .expect(login.submenuAdtechmedia).ok()
    .click(login.submenuAdtechmedia)                                           //end simulation of the refresh

  await t
    .wait(7000)
    .click(login.submenuAdtechmedia)
    .expect(countryCurrencyRevenue.country1.innerText).eql('United States')
    .expect(countryCurrencyRevenue.revenueMethod).ok()
    .expect(countryCurrencyRevenue.revenueMethod.selectedIndex).eql(2)
    .expect(countryCurrencyRevenue.priceCurrency1.innerText).eql('USD');       //end of checks for USA country

  await t
    .wait(7000)                                                               //Romania verification start
    .hover(countryCurrencyRevenue.countryMain)                                  //block that selects first value for revenue
    .click(countryCurrencyRevenue.countryMain)
    .click(countryCurrencyRevenue.country2)
    .expect(countryCurrencyRevenue.country2.innerText).eql('Romania')
    .click(countryCurrencyRevenue.revenueMethod)
    .click(countryCurrencyRevenue.revenueMethod1);
  await t
    .click(countryCurrencyRevenue.saveBTN)                //click on Save button, then wait top menu to display
    .expect(countryCurrencyRevenue.notyBAR.with({
      timeout: 20000,
      visibilityCheck: true,
    }).visible).ok();

  await t
    .click(countryCurrencyRevenue.nav);                    //simulation of reshresh the page
  await t
    .expect(countryCurrencyRevenue.check).ok();
  await t
    .click(login.menu)
    .expect(login.submenuAdtechmedia).ok()
    .click(login.submenuAdtechmedia)                        //end simulation of the refresh

  await t
    .wait(7000)
    .hover(countryCurrencyRevenue.countryMain)              // block that checks if changes are applied for select1
    .expect(countryCurrencyRevenue.country2.innerText).eql('Romania')
    .expect(countryCurrencyRevenue.revenueMethod).ok()
    .expect(countryCurrencyRevenue.revenueMethod.selectedIndex).eql(0)    // check that changes are applied after save and reshresh
    .expect(countryCurrencyRevenue.priceCurrency1.innerText).eql('RON');

  await t
    .hover(countryCurrencyRevenue.countryMain)          //repeat cycle of selecting for another value
    .click(countryCurrencyRevenue.revenueMethod)
    .click(countryCurrencyRevenue.revenueMethod2)       //select second valued for revenue
    .click(countryCurrencyRevenue.saveBTN)
    .expect(countryCurrencyRevenue.notyBAR.with({
      timeout: 15000,
      visibilityCheck: true,
    }).visible).ok();

  await t
    .click(countryCurrencyRevenue.nav);                    //simulation of reshresh the page
  await t
    .expect(countryCurrencyRevenue.check).ok();
  await t
    .click(login.menu)
    .expect(login.submenuAdtechmedia).ok()
    .click(login.submenuAdtechmedia)                        //end simulation of the refresh

  await t
    .wait(7000)
    .hover(countryCurrencyRevenue.countryMain)            //block that checks save for second value of revenue
    .expect(countryCurrencyRevenue.country2.innerText).eql('Romania')
    .expect(countryCurrencyRevenue.revenueMethod).ok()
    .expect(countryCurrencyRevenue.revenueMethod.selectedIndex).eql(1)      // check that changes are applied after save and reshresh
    .expect(countryCurrencyRevenue.priceCurrency1.innerText).contains('RON');

  await t
    .hover(countryCurrencyRevenue.countryMain)          //repeat cycle of selecting for another value
    .click(countryCurrencyRevenue.revenueMethod)
    .click(countryCurrencyRevenue.revenueMethod3)
    .click(countryCurrencyRevenue.priceCurrency)
    .click(countryCurrencyRevenue.priceCurrency2)
    .click(countryCurrencyRevenue.saveBTN)
    .expect(countryCurrencyRevenue.notyBAR.with({
      timeout: 15000,
      visibilityCheck: true,
    }).visible).ok();

  await t
    .click(countryCurrencyRevenue.nav);                    //simulation of reshresh the page
  await t
    .expect(countryCurrencyRevenue.check).ok();
  await t
    .click(login.menu)
    .expect(login.submenuAdtechmedia).ok()
    .click(login.submenuAdtechmedia)                        //end simulation of the refresh

  await t
    .wait(7000)
    .click(login.submenuAdtechmedia)
    .expect(countryCurrencyRevenue.country2.innerText).eql('Romania')
    .expect(countryCurrencyRevenue.revenueMethod).ok()
    .expect(countryCurrencyRevenue.revenueMethod.selectedIndex).eql(2)
    .expect(countryCurrencyRevenue.priceCurrency2.innerText).contains('EUR');      //End of checks for Romania

    await t
    .wait(7000)                                                               //Canada verification start
    .hover(countryCurrencyRevenue.countryMain)                                  //block that selects first value for revenue
    .click(countryCurrencyRevenue.countryMain)
    .click(countryCurrencyRevenue.country3)
    .expect(countryCurrencyRevenue.country3.innerText).eql('Canada')
    .click(countryCurrencyRevenue.revenueMethod)
    .click(countryCurrencyRevenue.revenueMethod1);
  await t
    .click(countryCurrencyRevenue.saveBTN)                //click on Save button, then wait top menu to display
    .expect(countryCurrencyRevenue.notyBAR.with({
      timeout: 20000,
      visibilityCheck: true,
    }).visible).ok();

  await t
    .click(countryCurrencyRevenue.nav);                                    //simulation of reshresh the page
  await t
    .expect(countryCurrencyRevenue.check).ok();
  await t
    .click(login.menu)
    .expect(login.submenuAdtechmedia).ok()
    .click(login.submenuAdtechmedia)                                       //end simulation of the refresh

  await t
    .wait(7000)
    .hover(countryCurrencyRevenue.countryMain)                             // block that checks if changes are applied for select1
    .expect(countryCurrencyRevenue.country3.innerText).eql('Canada')
    .expect(countryCurrencyRevenue.revenueMethod).ok()
    .expect(countryCurrencyRevenue.revenueMethod.selectedIndex).eql(0)    // check that changes are applied after save and reshresh
    .expect(countryCurrencyRevenue.priceCurrency1.innerText).eql('CAD');

  await t
    .hover(countryCurrencyRevenue.countryMain)                            //repeat cycle of selecting for another value
    .click(countryCurrencyRevenue.revenueMethod)
    .click(countryCurrencyRevenue.revenueMethod2)                         //select second valued for revenue
    .click(countryCurrencyRevenue.saveBTN)
    .expect(countryCurrencyRevenue.notyBAR.with({
      timeout: 15000,
      visibilityCheck: true,
    }).visible).ok();

  await t
    .click(countryCurrencyRevenue.nav);                    //simulation of reshresh the page
  await t
    .expect(countryCurrencyRevenue.check).ok();
  await t
    .click(login.menu)
    .expect(login.submenuAdtechmedia).ok()
    .click(login.submenuAdtechmedia)                        //end simulation of the refresh

  await t
    .wait(7000)
    .hover(countryCurrencyRevenue.countryMain)            //block that checks save for second value of revenue
    .expect(countryCurrencyRevenue.country3.innerText).eql('Canada')
    .expect(countryCurrencyRevenue.revenueMethod).ok()
    .expect(countryCurrencyRevenue.revenueMethod.selectedIndex).eql(1)      // check that changes are applied after save and reshresh
    .expect(countryCurrencyRevenue.priceCurrency1.innerText).contains('CAD');

  await t
    .hover(countryCurrencyRevenue.countryMain)          //repeat cycle of selecting for another value
    .click(countryCurrencyRevenue.revenueMethod)
    .click(countryCurrencyRevenue.revenueMethod3)
    .click(countryCurrencyRevenue.priceCurrency)
    .click(countryCurrencyRevenue.priceCurrency2)
    .click(countryCurrencyRevenue.saveBTN)
    .expect(countryCurrencyRevenue.notyBAR.with({
      timeout: 15000,
      visibilityCheck: true,
    }).visible).ok();

  await t
    .click(countryCurrencyRevenue.nav);                    //simulation of reshresh the page
  await t
    .expect(countryCurrencyRevenue.check).ok();
  await t
    .click(login.menu)
    .expect(login.submenuAdtechmedia).ok()
    .click(login.submenuAdtechmedia)                        //end simulation of the refresh

  await t
    .wait(7000)
    .click(login.submenuAdtechmedia)
    .expect(countryCurrencyRevenue.country3.innerText).eql('Canada')
    .expect(countryCurrencyRevenue.revenueMethod).ok()
    .expect(countryCurrencyRevenue.revenueMethod.selectedIndex).eql(2)
    .expect(countryCurrencyRevenue.priceCurrency2.innerText).contains('USD');      //End of checks for Canada

    await t
    .wait(7000)                                                               //UK verification start
    .hover(countryCurrencyRevenue.countryMain)                                  //block that selects first value for revenue
    .click(countryCurrencyRevenue.countryMain)
    .click(countryCurrencyRevenue.country4)
    .expect(countryCurrencyRevenue.country4.innerText).eql('United Kingdom')
    .click(countryCurrencyRevenue.revenueMethod)
    .click(countryCurrencyRevenue.revenueMethod1);
  await t
    .click(countryCurrencyRevenue.saveBTN)                //click on Save button, then wait top menu to display
    .expect(countryCurrencyRevenue.notyBAR.with({
      timeout: 20000,
      visibilityCheck: true,
    }).visible).ok();

  await t
    .click(countryCurrencyRevenue.nav);                                    //simulation of reshresh the page
  await t
    .expect(countryCurrencyRevenue.check).ok();
  await t
    .click(login.menu)
    .expect(login.submenuAdtechmedia).ok()
    .click(login.submenuAdtechmedia)                                       //end simulation of the refresh

  await t
    .wait(7000)
    .hover(countryCurrencyRevenue.countryMain)                             // block that checks if changes are applied for select1
    .expect(countryCurrencyRevenue.country4.innerText).eql('United Kingdom')
    .expect(countryCurrencyRevenue.revenueMethod).ok()
    .expect(countryCurrencyRevenue.revenueMethod.selectedIndex).eql(0)    // check that changes are applied after save and reshresh
    .expect(countryCurrencyRevenue.priceCurrency1.innerText).eql('GBP');

  await t
    .hover(countryCurrencyRevenue.countryMain)                            //repeat cycle of selecting for another value
    .click(countryCurrencyRevenue.revenueMethod)
    .click(countryCurrencyRevenue.revenueMethod2)                         //select second valued for revenue
    .click(countryCurrencyRevenue.saveBTN)
    .expect(countryCurrencyRevenue.notyBAR.with({
      timeout: 15000,
      visibilityCheck: true,
    }).visible).ok();

  await t
    .click(countryCurrencyRevenue.nav);                    //simulation of reshresh the page
  await t
    .expect(countryCurrencyRevenue.check).ok();
  await t
    .click(login.menu)
    .expect(login.submenuAdtechmedia).ok()
    .click(login.submenuAdtechmedia)                        //end simulation of the refresh

  await t
    .wait(7000)
    .hover(countryCurrencyRevenue.countryMain)            //block that checks save for second value of revenue
    .expect(countryCurrencyRevenue.country4.innerText).eql('United Kingdom')
    .expect(countryCurrencyRevenue.revenueMethod).ok()
    .expect(countryCurrencyRevenue.revenueMethod.selectedIndex).eql(1)      // check that changes are applied after save and reshresh
    .expect(countryCurrencyRevenue.priceCurrency1.innerText).contains('GBP');

  await t
    .hover(countryCurrencyRevenue.countryMain)          //repeat cycle of selecting for another value
    .click(countryCurrencyRevenue.revenueMethod)
    .click(countryCurrencyRevenue.revenueMethod3)
    .click(countryCurrencyRevenue.priceCurrency)
    .click(countryCurrencyRevenue.priceCurrency2)
    .click(countryCurrencyRevenue.saveBTN)
    .expect(countryCurrencyRevenue.notyBAR.with({
      timeout: 15000,
      visibilityCheck: true,
    }).visible).ok();

  await t
    .click(countryCurrencyRevenue.nav);                    //simulation of reshresh the page
  await t
    .expect(countryCurrencyRevenue.check).ok();
  await t
    .click(login.menu)
    .expect(login.submenuAdtechmedia).ok()
    .click(login.submenuAdtechmedia)                        //end simulation of the refresh

  await t
    .wait(7000)
    .click(login.submenuAdtechmedia)
    .expect(countryCurrencyRevenue.country4.innerText).eql('United Kingdom')
    .expect(countryCurrencyRevenue.revenueMethod).ok()
    .expect(countryCurrencyRevenue.revenueMethod.selectedIndex).eql(2)
    .expect(countryCurrencyRevenue.priceCurrency2.innerText).contains('EUR');      //End of checks for UK

});
