import url from 'url';
import { config, sharedFunctions, metadata } from '../../helpers/config-import';
import { Pom } from '../../helpers/poms-import';

const plugin = new Pom();

const fix = fixture`Check ATM Plugin view and content`
  .page`${url.resolve(config.www_base_host, metadata.freeContent)}`;

sharedFunctions.windowResolution(fix);

test('Check "Congratulations! This content is available for free." text is displayed for "free content" view', async t => {
  await t
    .expect(plugin.pluginText.innerText).eql('    Congratulations! This content is available for free. ');
});
