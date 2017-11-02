import url from 'url';
import { config, sharedFunctions } from '../../helpers/config-import';
import { Header } from '../../helpers/poms-import';

const header = new Header();

const fix = fixture`Check 'Home' page content`
  .page`${url.resolve(config.www_base_host, '/')}`;

sharedFunctions.windowResolution(fix);

test('Check "AdTechMedia WordPress" title is displayed', async t => {
  await t.expect(header.title.innerText).eql('AdTechMedia WordPress');
});
