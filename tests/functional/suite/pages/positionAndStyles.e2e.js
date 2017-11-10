import { Selector } from 'testcafe';
import Login from '../../poms/components/login-form.po';
import config from '../../config/config.cfg';
import PositionStyle from '../../poms/components/positionAndStyling.po'

const login = new Login();
const positionStyle = new PositionStyle();
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
    .expect(positionStyle.offsetTop.with({                           //confirmation of successfull page load
      timeout: 15000,
      visibilityCheck: true,
    }).visible).ok();

    await t
    .typeText(positionStyle.offsetTop, '45px', {replace: true})
    .typeText(positionStyle.border, '12px solid #d3d3d3', {replace: true})
    .typeText(positionStyle.footerBorder, '5px solid #e3e3e3', {replace: true})
    .typeText(positionStyle.offsetCenter, '40px', {replace: true})
    .typeText(positionStyle.font, '"TimesNewRoman", sans-serif', {replace: true})
    .typeText(positionStyle.width, '835', {replace: true})
    .typeText(positionStyle.scrollOffsetTop, '125', {replace: true})
    .typeText(positionStyle.boxShadow, '5 3px 4px 1 rgba(0, 0, 0, 0.1)', {replace: true})
    .click(positionStyle.saveConf);

    await t
    .click(positionStyle.switchStick)
    .click(positionStyle.saveConf);
});    