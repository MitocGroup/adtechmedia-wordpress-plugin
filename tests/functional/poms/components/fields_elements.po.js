import { Selector } from 'testcafe';

const isVisible = {
    visibilityCheck: true,
    timeout: 60000
  }

export default class elements {
    constructor () {
      this.price = Selector('#price');
      this.contentPaywall = Selector('#payment_pledged');
      this.contentPaywallType = Selector('#content_paywall');
      this.contentPaywallTransaction = Selector('#content_paywall > option:nth-child(1)');
      this.contentPaywallCurrency = Selector('#content_paywall > option:nth-child(2)');
      this.contentPreview = Selector('#content_offset');
      this.contentLock = Selector('#content_lock');
      this.contentLockBlur = Selector('#content_lock > option:nth-child(2)');
      this.contentLockBlurScramble = Selector('#content_lock > option:nth-child(1)');
      this.save = Selector('#content-config > div > div > div.flex-item-6.configuration-fields > div.custom-input > button');
      this.notyfyBar = Selector ('.noty_type_success');
      this.contentPreviewType = Selector('#content_offset_type');
      this.contentPreviewParagraph = Selector('#content_offset_type > option:nth-child(1)');
      this.contentPreviewWords = Selector('#content_offset_type > option:nth-child(2)');
      this.ab = Selector('#ab_percentage');
      
    }
}
