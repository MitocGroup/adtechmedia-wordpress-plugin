import { Selector } from 'testcafe';

const isVisible = {
    visibilityCheck: true,
    timeout: 60000
  }

export default class positionStyle {
    constructor () {
      this.offsetTop = Selector('#wpbody-content > main > section:nth-child(3) > div > div.general-settings > div > div:nth-child(3) > div:nth-child(1) > input');
      this.saveConf = Selector('#save-templates-config');
      this.border = Selector('#wpbody-content > main > section:nth-child(3) > div > div.general-settings > div > div:nth-child(1) > div:nth-child(2) > input');
      this.footerBorder = Selector('#wpbody-content > main > section:nth-child(3) > div > div.general-settings > div > div:nth-child(2) > div:nth-child(2) > input');
      this.offsetCenter = Selector('#wpbody-content > main > section:nth-child(3) > div > div.general-settings > div > div:nth-child(3) > div:nth-child(2) > input');
      this.font = Selector('#wpbody-content > main > section:nth-child(3) > div > div.general-settings > div > div:nth-child(1) > div:nth-child(3) > input');
      this.width = Selector('#wpbody-content > main > section:nth-child(3) > div > div.general-settings > div > div:nth-child(2) > div:nth-child(3) > input');
      this.scrollOffsetTop = Selector ('#wpbody-content > main > section:nth-child(3) > div > div.general-settings > div > div:nth-child(3) > div:nth-child(3) > input');
      this.boxShadow = Selector('#wpbody-content > main > section:nth-child(3) > div > div.general-settings > div > div:nth-child(1) > div:nth-child(4) > input');
      this.switchStick = Selector('#wpbody-content > main > section:nth-child(3) > div > div.general-settings > div > div:nth-child(3) > div.col.col-xs-3.switcher > label > input[type="checkbox"]');
    }
}
