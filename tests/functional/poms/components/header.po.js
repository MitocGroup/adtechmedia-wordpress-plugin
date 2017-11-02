import { Selector } from 'testcafe';
import { isVisible } from '../../config/config.cfg';

export class Header {
  constructor () {
    this.title = Selector('#masthead > div > div > h1 > a', isVisible);
  }
}
