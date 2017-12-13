import { Selector } from 'testcafe';

export default class login {
    constructor () {
      this.menu = Selector('#menu-plugins');
      this.menuPlugins = Selector('#menu-plugins > a > div.wp-menu-image.dashicons-before.dashicons-admin-plugins');
      // this.submenuAdtechmedia = Selector('#menu-plugins > ul > li:nth-child(5)');
      this.submenuAdtechmedia = Selector('#menu-plugins > ul > li:nth-child(5) > a');
      this.login = Selector('#user_login');
      this.pass = Selector('#user_pass');
      this.submit = Selector('#wp-submit');
      this.nameInput = Selector ('#wpbody-content > .wrap > h1');
    }
}
