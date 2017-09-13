<?php
/**
 * Created by PhpStorm.
 * User: yama_gs
 * Date: 20.10.2016
 * Time: 15:00
 *
 * @category Adtechmedia
 * @package  Adtechmedia_Plugin
 * @author    yama-gs
 */

$countries_list = Adtechmedia_Request::get_countries_list( $this->get_plugin_option( 'key' ) );
$currencies = [];
$countries = [];
if ( is_array( $countries_list ) ) {
	foreach ( $countries_list as $countries_element ) {
		$countries[ $countries_element['Name'] ] = $countries_element['RevenueModel'];
		$currencies[ $countries_element['Name'] ] = array_map(
			function ( $a ) {
				return strtoupper( $a );
			},
			$countries_element['Currency']
		);
	}
}
/* mock for better UX */
if ( empty( $countries ) && empty( $this->get_plugin_option( 'key' ) ) ) {
	$countries['United States'] = [ 'advertising+micropayments' ];
}
$content_paywall = [
	'transactions',
	'pledged currency',
];
$content_offset_types = [ 'paragraphs', 'words' ];

// @codingStandardsIgnoreStart
echo '<script>' . PHP_EOL;
echo 'var appearanceSettings = ' . $this->get_plugin_option( 'appearance_settings' ) . ';' . PHP_EOL;
echo 'var apiKey = "' . addslashes( $this->get_plugin_option( 'key' ) ) . '";' . PHP_EOL;
echo 'var propertyId = "' . addslashes( $this->get_plugin_option( 'Id' ) ) . '";' . PHP_EOL;
echo 'var themeId = "' . addslashes( wp_get_theme()->get( 'Name' ) ) . '";' . PHP_EOL;
echo 'var themeVersion = "' . addslashes( wp_get_theme()->get( 'Version' ) ) . '";' . PHP_EOL;
echo 'var isLocalhost = "' . addslashes( Adtechmedia_Config::is_localhost() ) . '";' . PHP_EOL;
echo 'var isStage = "' . addslashes( Adtechmedia_Config::is_stage() ) . '";' . PHP_EOL;
echo 'var platformId = "' . addslashes( Adtechmedia_Config::get ( 'platform_id' ) ) . '";' . PHP_EOL;
echo 'var platformVersion = "' . addslashes( preg_replace( '/^(\d+)([^\d].*)?$/', '$1', get_bloginfo( 'version' ) ) ) . '";' . PHP_EOL;
echo 'var termsUrl = \'' . addslashes( Adtechmedia_Config::get ( 'terms_url' ) ) . '\';' . PHP_EOL;
echo 'var forceSaveTemplates = ' . ( empty( $this->get_plugin_option( 'force-save-templates' ) ) ? 'false' : 'true' )  . ';' . PHP_EOL;
echo 'var updatedAppearance = ' . $this->get_plugin_option( 'updated_appearance' ) . ';' . PHP_EOL;
echo '</script>' . PHP_EOL;
// @codingStandardsIgnoreEnd
if ( ! empty( $this->get_plugin_option( 'force-save-templates' ) ) ) {
	$this->delete_plugin_option( 'force-save-templates' );
}
?>
<style>
	.atm-targeted-modal {
		width: auto;
	}

	@media (max-width: 1649px) {
		.atm-targeted-modal {
			margin-left: 0px;
		}
	}
	.atm-targeted-container .share-block-inner .sharetool a,
	.atm-targeted-container .share-block-inner .sharetool a:hover{
		background: none!important;
	}
</style>

<style id="overall-template-styling">
	.atm-blured-config-section > *:not(.atm-missing-key-msg) {
		-webkit-filter: blur(10px);
		-moz-filter: blur(10px);
		-o-filter: blur(10px);
		-ms-filter: blur(10px);
		filter: blur(10px);
		-webkit-transition: all 5s linear;
		transition        : all 5s linear;
		-moz-transition   : all 5s linear;
		-webkit-transition: all 5s linear;
		-o-transition     : all 5s linear;
		-webkit-touch-callout: none;
		-webkit-user-select: none;
		-khtml-user-select: none;
		-moz-user-select: none;
		-ms-user-select: none;
		user-select: none;
		pointer-events: none;
	}
	.atm-missing-key-msg {
		z-index: 999;
		padding: 15px;
		background: #fdfdfd;
		box-shadow: 0 1px 7px 0 rgba(0, 0, 0, 0.08);
		position: absolute;
		left: 0;
		right: 0;
		margin-left: auto;
		margin-right: auto;
		width: 500px;
	}
	.atm-missing-key-msg button {
		padding: 3px;
	}
	.atm-targeted-container {
		z-index: 0 !important;
	}
	
	/*fix for wp 4.5 and plugin All in One Schema*/
	.vue-tabs  li.tab {
		border:0;
	}
	.vue-tabs li.tab.active {
		padding-top: 0;
		top:0;
	}
	.vue-tabs li.tab.active a:focus {
		-webkit-box-shadow: 0 0 0 1px #5b9dd9, 0 0 2px 1px rgba(30, 140, 190, .8);
		box-shadow: 0 0 0 1px #5b9dd9, 0 0 2px 1px rgba(30, 140, 190, .8);
	}
	.editor-container .tabs-container .tab-container {
		width: initial;
		float: initial;
	}
</style>
<style id="overall-template-api"></style>
<main>
	<section>
		<form method="post" id="general-config" action="">
			<?php settings_fields( $main_data_class ); ?>

			<h1 class="heading">
				<i class="custom-icon cog"></i>
				General configuration
			</h1>
			<div class="content <?php echo empty( $this->get_plugin_option( 'key' ) ) ? 'atm-blured-config-section' : '' ?>">
				<div class="atm-missing-key-msg" <?php echo empty( $this->get_plugin_option( 'key' ) ) ? '' : 'style="display: none !important"' ?>>
					<p>
						The email <b>"<?php echo esc_html( $this->get_plugin_option( 'support_email' ) ) ?>"</b> has been already used for activation.<br/>
						In order to activate this one you have to confirm your identity.<br/>
						We've sent the confirmation email.<br/>
						Please check out your inbox.
					</p>
					<br/><br/>
					<small><i>
						If you haven't received the email, you can 
						<button onclick="requestApiToken(event)">ask to resend it</button>
					</i></small>
				</div>
				<div class="general-fields">
					<div class="flex-container">
						<div class="flex-item-6">
							<div class="form-select custom-label">
								<label>
									<i class="mdi mdi-map-marker"></i> Country
								</label>
								<select name="country" id="country">
									<?php
									foreach ( $countries as $name => $methods ) {
										$selected = ($this->get_plugin_option( 'country' ) === $name) ? 'selected' : '';
										echo "<option value='" . esc_html( $name ) . "' data-methods='"
											. wp_json_encode( $methods ) . "' data-currency='"
											. wp_json_encode( $currencies[ $name ] ) . "' " . esc_html( $selected ) . '>' . esc_html( $name ) . '</option>';
									}
									?>
								</select>

							</div>
							<div class="block-info">
								Choose the country of origin where revenue will be collected
							</div>
							<br/><!-- ToDo: Remove <br/> and add spacer through CSS -->
							<div class="form-select custom-label">
								<label>
									<i class="mdi mdi-lan"></i> Revenue Model
								</label>
								<?php $this->create_form_control(
									'revenue_method',
									array_merge( [ '' ], $countries[ $this->get_plugin_option( 'country' ) ] ? : [] ),
									$this->get_plugin_option( 'revenue_method' )
								); ?>
							</div>
							<div class="block-info">
								Choose the revenue model that will be used on this blog
							</div>
							
							<div class="custom-input">
								<button type="button" id="save-revenue-model" class="btn"><i class="mdi mdi-check"></i> Save</button>
							</div>
						</div>
						<div class="flex-item-6">
							<div class="block-info align-justify">
								<b>IMPORTANT:</b> Registration step is not required to be able to use this plugin.
								Once you generate some revenue and want to transfer it into your bank account,
								then we encourage you to register here (using "Email address"). Follow the steps
								to setup your account on AdTechMedia.io platform and enjoy the influx of revenue
								into your bank account.
							</div>
							<br/><!-- ToDo: Remove <br/> and add spacer through CSS -->
							<div class="custom-input">
								<input type="text" id="support_email" name="support_email" value="<?php echo esc_html( $this->get_plugin_option( 'support_email' ) ) ?>" size="100"/>
								<label><i class="mdi mdi-email"></i> Email address</label>
							</div>
							<div class="block-info">
								This email address will be used to register, connect and interact
								with AdTechMedia.io platform.
							</div>
							<br/><!-- ToDo: Remove <br/> and add spacer through CSS -->
							<div class="block-info">
								<input type="checkbox" id="terms" name="terms">
								<label><a id="terms-btn">I agree to Terms of Use</a></label>
							</div>
							<div class="custom-input">
								<a href="<?php echo empty( $this->get_plugin_option( 'client-id' ) ) ? 'javascript:void(0)' : esc_html( sprintf( Adtechmedia_Config::get( 'register_url_tpl' ), $this->get_plugin_option( 'client-id' ) ) ) ?>" target="_blank" id="btn-register" class="btn" disabled><i class="mdi mdi-account-plus"></i> Register</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</section>

	<section <?php echo empty( $this->get_plugin_option( 'key' ) ) ? 'style="display: none !important"' : '' ?>>
		<form method="post" action="" id="content-config">
			<?php settings_fields( $plugin_meta_data_class ); ?>
			<h1 class="heading">
				<i class="custom-icon edit"></i>
				Content configuration
			</h1>

			<div class="content">
				<div class="flex-container content-config">
					<div class="flex-item-6 configuration-fields">
						<div class="custom-label mixed-fields">
							<label><i class="mdi mdi-currency-usd"></i> Content pricing</label>

							<div class="flex-container">
								<div class="flex-item-6">
									<div class="custom-input">
										<?php $this->create_form_control(
											'price',
											$plugin_meta_data['price'],
											$this->get_plugin_option( 'price' ),
											'e.g. 10'
										); ?>
										<span class="bar"></span>
									</div>
								</div>
								<div class="flex-item-6">
									<div class="form-select">
										<select name="price_currency" id="price_currency">
											<?php
											$price_currency_value = $this->get_plugin_option( 'price_currency' );
											$coutry = $this->get_plugin_option( 'country' );
											if ( isset( $currencies[ $coutry ] ) ) {
												foreach ( $currencies[ $coutry ] as $currency ) {
													echo "<option value='";
													echo esc_html( $currency );
													echo "' " .
														(( strnatcasecmp( $currency , $price_currency_value ) === 0 ) ? 'selected' : '')
														. ' >' .
														esc_html( strtoupper( $currency ) ) . '</option>';
												}
											}
											?>
										</select>
									</div>
								</div>
							</div>

							<div class="block-info">
								Specify the price and the currency to be collected per article per micropayment
								(e.g. "0.05" &amp; "USD" means 5&cent;, while "5" &amp; "USD" means $5)
							</div>
						</div>

						<div class="custom-label mixed-fields">
							<label><i class="mdi mdi-currency-usd"></i> Content paywall</label>

							<div class="flex-container">
								<div class="flex-item-6">
									<div class="custom-input">
										<?php $this->create_form_control(
											'payment_pledged',
											$plugin_meta_data['payment_pledged'],
											$this->get_plugin_option( 'payment_pledged' ),
											'e.g. 2',
											'number',
											'min=0 step=1'
										); ?>
										<span class="bar"></span>
									</div>
								</div>
								<div class="flex-item-6">
									<div class="form-select">
										<select name="content_paywall" id="content_paywall">
											<?php
											$content_paywall_value = $this->get_plugin_option( 'content_paywall' );
											foreach ( $content_paywall as $content_paywall_one ) {
												echo "<option value='";
												echo esc_html( $content_paywall_one );
												echo "' " .
													(($content_paywall_one === $content_paywall_value) ? 'selected' : '')
													. ' >' . esc_html( $content_paywall_one ) . '</option>';
											}
											?>
										</select>
									</div>
								</div>
							</div>

							<div class="block-info">
								Provide the threshold (number of transactions or total amount of pledged currency) that
								should be used before displaying pay view
							</div>
						</div>

						<div class="custom-label mixed-fields">
							<label><i class="mdi mdi-eye"></i> Content preview</label>

							<div class="flex-container">
								<div class="flex-item-6">
									<div class="custom-input">
										<?php $this->create_form_control(
											'content_offset',
											$plugin_meta_data['content_offset'],
											$this->get_plugin_option( 'content_offset' ),
											'e.g. 2',
											'number',
											'min=0 step=1'
										); ?>
										<span class="bar"></span>
									</div>
								</div>
								<div class="flex-item-6">
									<div class="form-select">
										<select name="content_offset_type" id="content_offset_type">
											<?php
											$offset_type_value = $this->get_plugin_option( 'content_offset_type' );
											foreach ( $content_offset_types as $content_offset_type ) {
												echo "<option value='";
												echo esc_html( $content_offset_type );
												echo "' " .
													(($content_offset_type === $offset_type_value) ? 'selected' : '')
													. ' >' . esc_html( $content_offset_type ) . '</option>';
											}
											?>
										</select>
									</div>
								</div>
							</div>
							<div class="block-info">
								Specify how many paragraphs or words will be shown for free, before displaying unlock
								view (also known as unlock button)
							</div>
						</div>

						<div class="custom-label mixed-fields">
							<div class="flex-container">
								<div class="flex-item-6">
									<label style="position: relative"><i class="mdi mdi-lock-open"></i> Content locking algorithm</label>
								</div>
								<div class="flex-item-6">
									<label style="position: relative"><i class="mdi mdi-target"></i> A/B target audience</label>
								</div>
							</div>

							<div class="flex-container">
								<div class="flex-item-6">
									<div class="custom-input">
										<?php $this->create_form_control(
											'content_lock',
											$plugin_meta_data['content_lock'],
											$this->get_plugin_option( 'content_lock' )
										); ?>
										<span class="bar"></span>
									</div>
								</div>

								<div class="flex-item-6">
									<div class="custom-input">
										<?php $this->create_form_control(
											'ab_percentage',
											$plugin_meta_data['ab_percentage'],
											$this->get_plugin_option( 'ab_percentage' ),
											'',
											'number',
											'min=0 max=100 step=1'
										); ?>
										<span class="bar"></span>
									</div>
								</div>
							</div>
							<div class="block-info">
								Provide which unlocking algorithm will be used to hide premium content
							</div>
						</div>

						<div class="custom-input">
							<button type="button" class="btn"><i class="mdi mdi-check"></i> Save</button>
						</div>
					</div>
					<div class="flex-item-6">
						<div class="mockup">
							<img class="logo-img"
								 src="<?php echo esc_html( plugins_url( '../images/logo.svg', __FILE__ ) ) ?>"
								 alt="AdTechMedia"/>

							<div class="mockup-head">
								<div class="flex-container">
									<div class="flex-item-6">
										<h1>Article Title</h1>
									</div>
									<div class="flex-item-6 flex-center">
										<div class="icons-cont align-right">
											<i>5&cent;</i>
											<i class="mdi mdi-facebook"></i>
											<i class="mdi mdi-twitter"></i>
										</div>
									</div>
								</div>
								<div class="flex-container">
									<div class="flex-item-6">
										By John Smith, <i>author</i>
									</div>
									<div class="flex-item-6 align-right">September 22nd, 2016</div>
								</div>
							</div>

							<div class="mockup-cont">
								<img
									src="<?php echo esc_html( plugins_url( '../images/collaborative-team.jpg', __FILE__ ) ) ?>"/>

								<p>It is a long established fact that a reader will be distracted by
									the readable content of a page when looking at its layout.
								</p>

								<p>It is a long established fact that a reader will be distracted by
									the readable content of a page when looking at its layout.
									The point of using Lorem Ipsum is that it has a more-or-less normal
									distribution of letters, as opposed to using 'Content here, content here',
									making it look like readable English.
								</p>

								<div class="blurry">
									<p>It is a long established fact that a reader will be distracted by
										the readable content of a page when looking at its layout.
										The point of using Lorem Ipsum is that it has a more-or-less normal
										distribution of letters, as opposed to using 'Content here, content here',
										making it look like readable English.
										It is a long established fact that a reader will be distracted by
										the readable content of a page when looking at its layout.
										The point of using Lorem Ipsum is that it has a more-or-less normal
										distribution of letters, as opposed to using 'Content here, content here',
										making it look like readable English.
									</p>
									<button type="button" class="btn">
										<i class="mdi mdi-lock-open-outline"></i>
										unlock content
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</section>

	<section <?php echo empty( $this->get_plugin_option( 'key' ) ) ? 'style="display: none !important"' : '' ?>>
		<h1 class="heading">
			<i class="custom-icon templates"></i>
			Templates management
			<div class="pull-right">
				<button id="save-templates-config" type="button" class="btn"><i class="mdi mdi-check"></i> Save Configuration</button>
			</div>
		</h1>
		
		<div id="template-editor">
			<!-- ATM template editor here -->
		</div>
	</section>

	<section <?php echo empty( $this->get_plugin_option( 'key' ) ) ? 'style="display: none !important"' : '' ?>>
		<h1 class="heading">
			<i class="custom-icon templates"></i>
			Business Rules
			<!-- <div class="pull-right">
				<button id="save-br" type="button" class="btn"><i class="mdi mdi-check"></i> Save Business Rules</button>
			</div> -->
		</h1>
		
		<div id="br-manager">
			<!-- ATM template editor here -->
		</div>
	</section>

	<div id="terms-modal" class="modal">
		<div class="modal-content">
			<span class="close">&times;</span>
			<h1 class="modal-header">Terms of Use</h1>
			<div id="modal-content"></div>
		</div>
	</div>
</main>
