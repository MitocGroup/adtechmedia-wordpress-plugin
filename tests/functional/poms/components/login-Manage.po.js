import { Selector } from 'testcafe';
import { isVisible } from '../../config/config.cfg'; 

export default class loginManage {
    constructor () {
      this.returningCustomer = Selector('#md-tab-label-0-1');
      this.email = Selector('#email');
      this.password = Selector('#password');
      this.loginBtn = Selector('#md-tab-content-0-1 > div > deep-account-sign-in > div > form > button');
      this.newCustomer = Selector('#md-tab-label-0-0', isVisible);
      this.topMenu = Selector('#main > div > div > div.flex-item-4.self-center > deep-account-auth > div > md-tab-group > md-tab-header > div.mat-tab-label-container > div > div', isVisible);
      this.tabLiveStats = Selector('#myTab > li.active > a > span',isVisible);
    }
}
