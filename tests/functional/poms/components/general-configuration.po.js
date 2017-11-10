import { Selector } from 'testcafe';

export default class CountryCurrencyRevenue {
    constructor () {
      this.country1 = Selector('#country > option:nth-child(1)');
      this.country2 = Selector('#country > option:nth-child(2)');
      this.country3 = Selector('#country > option:nth-child(3)');
      this.country4 = Selector('#country > option:nth-child(4)');
      this.priceCurrency = Selector('#price_currency');
      this.priceCurrency1 = Selector('#price_currency > option:nth-child(1)');
      this.priceCurrency2 = Selector('#price_currency > option:nth-child(2)');
      this.countryMain = Selector('#country');
      this.revenueMethod = Selector ('#revenue_method');
      this.spinner = Selector ('.vue-simple-spinner');
      this.revenueMethod1 = Selector ('#revenue_method > option:nth-child(1)');
      this.revenueMethod2 = Selector ('#revenue_method > option:nth-child(2)');
      this.revenueMethod3 = Selector ('#revenue_method > option:nth-child(3)');
      this.saveBTN = Selector ('#save-revenue-model');
      this.notyBAR = Selector ('.noty_type_success');
      this.nav = Selector('#menu-users');
      this.check = Selector('#email');
    }
}

module.exports = CountryCurrencyRevenue;
