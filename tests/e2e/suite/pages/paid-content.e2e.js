import url from 'url';
import { config, sharedFunctions, metadata } from '../../helpers/config-import';
import { Pom } from '../../helpers/poms-import';

const plugin = new Pom();

const fix = fixture`Check ATM Plugin view and content`
  .page`${url.resolve(config.www_base_host, metadata.paidContent)}`;

sharedFunctions.windowResolution(fix);

test('Check "Please support quality journalism" text with "pledge" and "show ad" buttons are displayed in the collapsed plugin view', async t => {
  await t
    .expect(plugin.headingInfo.innerText).eql(' Please support quality journalism.  pledge $0.05    show ad ');
});
