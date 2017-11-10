import { Selector } from 'testcafe';
import { isVisible } from '../../config/config.cfg';

export class Pom {
  constructor () {
    this.headingInfo = Selector('#content-for-atm-modal > div > div > div > div > div.flex-row.align-center > div.atm-heading-info.flex-item-10', isVisible);
    this.pluginText = Selector('#content-for-atm-modal > div > div > div > div > div.flex-row.align-center > div.atm-heading-info.flex-item-10', isVisible);
  }
}
