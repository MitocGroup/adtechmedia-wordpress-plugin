import { Selector } from 'testcafe';
import {isVisible} from '../../config/config.cfg';


export default class widget {
    constructor () {
      this.abParameter = Selector('.flex-item-6',isVisible);
      this.abParameterText = Selector('#ab_percentage', isVisible);
      this.postmenu = Selector('#menu-posts > a > div.wp-menu-name',isVisible);
      this.saveBtn = Selector('#content-config > div > div > div.flex-item-6.configuration-fields > div.custom-input > button',isVisible);
      this.unlockBtn = Selector('.unlock-btn',isVisible);
      this.checkWordPressLink = Selector('#meta-2 > ul > li:nth-child(5)',isVisible);
      this.control = Selector('#commentform > p.comment-form-comment',isVisible);
      this.widgetPlugin = Selector('#content-for-atm-modal > div',isVisible);
      this.expandBtn = Selector('#content-for-atm-modal > div > div > div > div > div.flex-row.align-center > div.flex-item-1.text-right > i',isVisible);
      this.sticky = Selector('#wpbody-content > main > section:nth-child(3) > div > div.general-settings > div > div:nth-child(3) > div.col.col-xs-3.switcher > label > input[type="checkbox"]',isVisible);
      this.saveCfgBtn = Selector('#save-templates-config',isVisible)
      this.recentPost1 = Selector('#recent-posts-2 > ul > li:nth-child(1) > a',isVisible);
      this.recentPost2 = Selector('#recent-posts-2 > ul > li:nth-child(2) > a',isVisible);
      this.priceCheck = Selector('#content-for-atm-modal > div > div > div > div > div > div.atm-main > div.flex-row > div > span:nth-child(1)',isVisible);
      this.payPledgeBtn = Selector('#content-for-atm-modal > div > div > div > div > div > div.atm-footer > div.footer-buttons > button.atm-button.pledge',isVisible);
      this.subscribeBtn = Selector('#content-for-atm-modal > div > div > div > div > div > div.atm-footer > div.footer-buttons > button.atm-button.show-ad',isVisible);
<<<<<<< HEAD
      this.subscribeBtn1 = Selector('.accent-button',isVisible);
=======
>>>>>>> 454ddaed6d94599ac9f7bad7055f1bfeae234c61
      this.showADBtn = Selector('.show-ad',isVisible);


    }
}