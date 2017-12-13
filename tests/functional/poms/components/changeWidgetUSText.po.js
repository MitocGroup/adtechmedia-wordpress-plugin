import { Selector } from 'testcafe';
import {isVisible} from '../../config/config.cfg';


export default class textChecks {
    constructor () {
      this.pledgeHeadline = Selector('#content-for-atm-modal > div > div > div > div > div.flex-row.align-center > div.atm-heading-info.flex-item-10',isVisible);
      this.pledgeSalut = Selector('#content-for-atm-modal > div > div > div > div > div > div.atm-main > div.salutation-block', isVisible);
      this.pledgeBodyMessage = Selector('#content-for-atm-modal > div > div > div > div > div > div.atm-main > div.flex-row > div',isVisible);
      this.payHeadline = Selector('#content-for-atm-modal > div > div > div > div > div.flex-row.align-center > div.atm-heading-info.flex-item-10 > span > span', isVisible);
      this.paySalute = Selector('#content-for-atm-modal > div > div > div > div > div > div.atm-main > div.salutation-block > span',isVisible);
      this.payBodyMessage = Selector('#content-for-atm-modal > div > div > div > div > div > div.atm-main > div.flex-row > div > span', isVisible);
      this.payChoosePaymentText = Selector('#content-for-atm-modal > div > div > div > div > div > div.atm-pay.atm-main-addition > div.pay-help-text > div > h3 > span', isVisible);
      
    }
}