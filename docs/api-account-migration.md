# Steps to migrate to ATM Api with deep-account integrated

- Replace `atm-admin/api-gateway-key/create` call with `deep-account/client/token-send` with `Email` and `LinkTpl` parameters (e.g. `LinkTpl="http://localhost:8080/wp-admin/plugins.php?page=Adtechmedia_PluginSettings&atm-token=%tmp-token%"` where `%tmp-token%` is a placeholder).
- Hide admin page and leave only one section (`General Setup`) blured and show a message that says that `You must authorize. An email has been sent...` (ask PM for details)
- Once the user clicks on authorize link (`LinkTpl`) from the email, you'll have available the `ExchangeToken` (`atm-token` query parameter from `LinkTpl`)
- Read the `atm-token` and make a call to `deep-account/client/token-exchange` to get the api key(`apiKey`)
- Save your `apiKey` and make other setup requests...
- Done.
