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
		$countries[ $countries_element['Name'] ] = $countries_element['RevenueMethod'];
		foreach ( $countries_element['Currency'] as $currency ) {
			if ( ! in_array( $currency, $currencies ) ) {
				$currencies[] = $currency;
			}
		}
	}
}
$content_paywall = [
	'transactions',
	'pledged currency',
];
$content_offset_types = [ 'paragraphs', 'words' ];

echo '<script>';
// @codingStandardsIgnoreStart
echo 'var templateInputs =JSON.parse(\'';
$template_inputs = $this->get_plugin_option( 'template_inputs' );
echo empty( $template_inputs ) ? '{}' : $template_inputs;
echo '\');';
echo 'var templateStyleInputs =JSON.parse(\'';
$template_style_inputs = $this->get_plugin_option( 'template_style_inputs' );
echo empty( $template_style_inputs ) ? '{}' : $template_style_inputs;
echo '\');';
echo 'var templatePositionInputs =JSON.parse(\'';
$template_position = $this->get_plugin_option( 'template_position' );
echo empty( $template_position ) ? '{}' : $template_position;
echo '\');';
echo 'var templateOverallStylesInputs =JSON.parse(\'';
$template_overall_styles_inputs = $this->get_plugin_option( 'template_overall_styles_inputs' );
echo empty( $template_overall_styles_inputs ) ? '{}' : $template_overall_styles_inputs;
echo '\');';
// @codingStandardsIgnoreEnd
echo '</script>';
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
		background: none!important;;
	}

	/**/
	/*.atm-base-modal {
		background-color: #ffb7a7;
	}
	.atm-targeted-modal .atm-head-modal .atm-modal-heading {
		background-color: #ffb7a7;
	}
	.atm-targeted-modal{
		border: 3px solid rgba(131, 214, 255, 1);
	}
	.atm-base-modal .atm-footer{
		background-color: #49ff96;
		border: 3px solid rgb(255, 193, 22);
	}
	.atm-targeted-modal {
		font-family: "FuturaICG", sans-serif;
	}*/
</style>

<style id="overall-template-styling">
	<?php
	// @codingStandardsIgnoreStart
	$template_overall_styles = $this->get_plugin_option( 'template_overall_styles' );
	echo empty( $template_overall_styles ) ? '' : $template_overall_styles;
	// @codingStandardsIgnoreEnd
	?>
</style>
<main>
	<section>
		<form method="post" action="">
			<?php settings_fields( $main_data_class ); ?>

			<h1 class="heading">
				<i class="custom-icon cog"></i>
				General configuration
			</h1>
			<div class="content">
				<div class="general-fields">
					<div class="flex-container">
						<div class="flex-item-6">
							<div class="form-select custom-label">
								<label>
									<i class="mdi mdi-map-marker"></i> Country
								</label>
								<select name="country" id="country">
									<option value="United States">United States</option>
								</select>
							</div>
							<div class="block-info">
								Choose the country of origin where revenue will be collected
							</div>
						</div>
						<div class="flex-item-6">
							<div class="form-select custom-label">
								<label>
									<i class="mdi mdi-lan"></i> Revenue Model
								</label>
								<?php $this->create_form_control(
									'revenue_method',
									$main_data['revenue_method'],
									$this->get_plugin_option( 'revenue_method' )
								); ?>
							</div>
							<div class="block-info">
								Choose the revenue model that will be used on this blog
							</div>
						</div>
					</div>
				</div>
				<div class="general-fields">
					<div class="flex-container">
						<div class="flex-item-6">
							<div class="custom-input">
								<?php $this->create_form_control(
									'support_email',
									$main_data['support_email'],
									$this->get_plugin_option( 'support_email' ),
									'e.g. john.smith@mail.com'
								); ?>
								<span class="bar"></span>
								<label><i class="mdi mdi-email"></i> Email address</label>
							</div>
							<div class="block-info">
								Provide your email address that will be used to register, connect and interact
								with AdTechMedia.io platform
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
						</div>
					</div>
					<div class="flex-container">
						<div class="flex-item-6 ">
							<div class="custom-input">
								<button type="submit" class="btn"><i class="mdi mdi-account-plus"></i> Register</button>
							</div>
						</div>
						<div class="flex-item-6 flex-end">
						<div class="custom-input">
							<button type="button" id="save-revenue-model" class="btn"><i class="mdi mdi-check"></i>Save</button>
						</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</section>

	<section>
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
											'e.g. 0.10'
										); ?>
										<span class="bar"></span>
									</div>
								</div>
								<div class="flex-item-6">
									<div class="form-select">
										<select name="price_currency" id="price_currency">
											<?php
											$price_currency_value = $this->get_plugin_option( 'price_currency' );
											foreach ( $currencies as $currency ) {
												echo "<option value='";
												echo esc_html( $currency );
												echo "' " .
													(($currency == $price_currency_value) ? 'selected' : '')
													. ' >' .
													esc_html( strtoupper( $currency ) ) . '</option>';
											}
											?>
										</select>
									</div>
								</div>
							</div>

							<div class="block-info">
								Specify the price and the currency to collect for each article, in case readers decide
								to use the micropayments choice
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
											'e.g. 5'
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
													(($content_paywall_one == $content_paywall_value) ? 'selected' : '')
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
											'e.g. 2'
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
													(($content_offset_type == $offset_type_value) ? 'selected' : '')
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
							<label>
								<i class="mdi mdi-lock-open"></i> Content unlocking algorithm
							</label>
							<div class="form-select">
								<?php $this->create_form_control(
									'content_lock',
									$plugin_meta_data['content_lock'],
									$this->get_plugin_option( 'content_lock' )
								); ?>
							</div>
							<div class="block-info">
								Provide which unlocking algorithm will be used to hide premium content
							</div>
						</div>
						<div class="custom-label mixed-fields">
							<label><i class="mdi mdi-link"></i> Link to video ad</label>
							<div class="flex-container">
								<div class="flex-item-12">
									<div class="custom-input">
										<?php $this->create_form_control(
											'ads_video',
											$plugin_meta_data['ads_video'],
											$this->get_plugin_option( 'ads_video' ),
											'e.g. https://youtu.be/DiBh8r3lPpM'
										); ?>
										<span class="bar"></span>
									</div>
								</div>
							</div>

							<div class="block-info">
								Speficy the link to video ad that will be used for demo purposes
							</div>
						</div>

						<div class="custom-input">
							<button type="button" class="btn"><i class="mdi mdi-check"></i>Save</button>
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
									src="<?php echo esc_html( plugins_url( '../images/Collaborative-team.jpg', __FILE__ ) ) ?>"/>

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

	<section>
		<h1 class="heading">
			<i class="custom-icon templates"></i>
			Templates management
		</h1>

		<div class="content templating">
			<div class="templates-views templates-views-common">
				<div class="template-view">
					<div class="header-view">Overall position and styling
					</div>
					<section class="content-view" >
							<div class="flex-container flex-gutter flex-end" data-template="position">
							<div class="flex-item-2">
								<span class="accent-color">Sticky</span>
								<div class="">
									<input type="checkbox" name="sticky" id="checkbox-sticky" class="cbx hidden"/>
									<label for="checkbox-sticky" class="custom-checkbox"></label>
								</div>
							</div>
							<div class="flex-item-2 disable-if-sticky">
								<div class="custom-label">
									<label>Width</label>
									<div class="custom-input">
										<input placeholder="width" name="width" type="text">
										<span class="bar"></span>
									</div>
								</div>
							</div>
							<div class="flex-item-2 disable-if-sticky">
								<div class="custom-label">
									<label>Offset top</label>
									<div class="custom-input">
										<input placeholder="offset top" name="offset_top"  type="text">
										<span class="bar"></span>
									</div>
								</div>
							</div>
							<div class="flex-item-2 disable-if-sticky">
								<div class="custom-label">
									<label>Offset from center</label>
									<div class="custom-input">
										<input placeholder="offset left" name="offset_left"  type="text">
										<span class="bar"></span>
									</div>
								</div>
							</div>
							<div class="flex-item-2 disable-if-sticky">
								<div class="custom-label">
									<label>Scrolling offset top</label>
									<div class="custom-input">
										<input placeholder="scrolling offset top" name="scrolling_offset_top"  type="text">
										<span class="bar"></span>
									</div>
								</div>
							</div>
							</div>

							<div class="flex-container flex-gutter" data-template="overall-styling">
								<div class="flex-item-2">
									<div class="custom-label">
										<label>Background Color</label>
										<div class="custom-input">
											<input placeholder="background-color" data-template-css="background-color" required=""
												   type="color">
											<span class="bar"></span>
										</div>
									</div>
								</div>
								<div class="flex-item-2">
									<div class="custom-label">
										<label>Border</label>
										<div class="custom-input">
											<input placeholder="border" data-template-css="border" required="" type="text">
											<span class="bar"></span>
										</div>
									</div>
								</div>
								<div class="flex-item-2">
									<div class="custom-label">
										<label>Font Family</label>
										<div class="custom-input">
											<input placeholder="font-family" data-template-css="font-family" required=""
												   type="text">
											<span class="bar"></span>
										</div>
									</div>
								</div>
								<div class="flex-item-2">
									<div class="custom-label">
										<label>Box Shadow</label>
										<div class="custom-input">
											<input placeholder="box-shadow" data-template-css="box-shadow" required=""
												   type="text">
											<span class="bar"></span>
										</div>
									</div>
								</div>
								<div class="flex-item-2">
									<div class="custom-label">
										<label>Footer Background Color</label>
										<div class="custom-input">
											<input placeholder="footer background-color" data-template-css="footer-background-color"
												   required="" type="color" >
											<span class="bar"></span>
										</div>
									</div>
								</div>
								<div class="flex-item-2">
									<div class="custom-label">
										<label>Footer Border</label>
										<div class="custom-input">
											<input placeholder="footer-border" required=""
												   data-template-css="footer-border"
												   type="text">
											<span class="bar"></span>
										</div>
									</div>
								</div>
							</div>

						</section>
				</div>
			</div>
			<div class="clearfix">
				<div class="">



					<section class="views-tabs">
						<input id="pledge" name="main-tabs" checked="" type="radio">
						<input id="refund" name="main-tabs" type="radio">
						<input id="pay" name="main-tabs" type="radio">
						<input id="other" name="main-tabs" type="radio">

						<ul class="templates-menu">
							<li class="custom-tooltip">
								<label for="pledge" class="tab-name">
									<i class="mdi mdi-library"></i>
									<span>Pledge</span>
								</label>
								<div class="tooltip">
									<div class="tooltip__background"></div>
									<span class="tooltip__label">Pledge Template</span>
								</div>
							</li>
							<li class="custom-tooltip">
								<label for="pay" class="tab-name">
									<i class="mdi mdi-credit-card"></i>
									<span>Pay</span>
								</label>
								<div class="tooltip">
									<div class="tooltip__background"></div>
									<span class="tooltip__label">Pay Template</span>
								</div>
							</li>
							<li class="custom-tooltip">
								<label for="refund" class="tab-name">
									<i class="mdi mdi-backup-restore"></i>
									<span>Refund</span>
								</label>
								<div class="tooltip">
									<div class="tooltip__background"></div>
									<span class="tooltip__label">Refund Template</span>
								</div>
							</li>
							<li class="custom-tooltip">
								<label for="other" class="tab-name">
									<i class="mdi mdi-note-plus"></i>
									<span>Other</span>
								</label>
								<div class="tooltip">
									<div class="tooltip__background"></div>
									<span class="tooltip__label">Other Templates</span>
								</div>
							</li>
						</ul>

						<div class="templates-views pledge" data-template="pledge">
							<div class="template-view">
								<div class="header-view">pledge template
								</div>
								<div class="content-view clearfix">
									<div class="flex-container">
										<div class="flex-item-6 modal-shown no-transition" >
											<div class="template-name" data-view-text="expanded">
												Expanded view
											</div>
											<div id="render-pledge-expanded" class="modal-shown no-transition" data-view="expanded"></div>
											<div class="template-name" data-view-text="collapsed">
												Collapsed view
											</div>
											<div id="render-pledge-collapsed" data-view="collapsed"></div>
										</div>
										<div class="flex-item-6">
											<section class="config-tabs">
												<input id="pledge-ext-salutation" name="pledge-ext" checked=""
													   type="radio">
												<label for="pledge-ext-salutation" class="tab-name">
													Salutation
												</label>
												<div class="tab-content" data-template="salutation">
													<div class="custom-label" data-template="expanded">
														<label>Salutation</label>
														<div class="custom-input">
															<input placeholder="Dear {user}," name="welcome"
																   value="Dear {user}," required="" type="text">
															<span class="bar"></span>
														</div>
													</div>

													<div class="flex-container flex-gutter" data-template="style">
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Color</label>
																<div class="custom-input">
																	<input placeholder="color" data-template-css="color"
																		   required="" type="color">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Font Size</label>
																<div class="custom-input">
																	<input placeholder="font-size"
																		   data-template-css="font-size" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Font Weight</label>
																<div class="custom-input">
																	<input placeholder="font-weight"
																		   data-template-css="font-weight" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
													</div>

													<div class="flex-container flex-gutter" data-template="style">
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Font Style</label>
																<div class="custom-input">
																	<input placeholder="font-style"
																		   data-template-css="font-style" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Text Align</label>
																<div class="custom-input">
																	<input placeholder="text-align"
																		   data-template-css="text-align" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Text Transform</label>
																<div class="custom-input">
																	<input placeholder="text-transform"
																		   data-template-css="text-transform"
																		   required="" type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
													</div>
												</div>

												<input id="pledge-ext-message" value="card" name="pledge-ext"
													   type="radio">
												<label for="pledge-ext-message" class="tab-name">
													Message
												</label>
												<div class="tab-content" data-template="message">
													<div class="custom-label" data-template="expanded">
														<label>Message (Expanded View)</label>
														<div class="custom-input">
															<input name="message-expanded"
																   placeholder="Please support quality journalism. Would you pledge to pay a small fee of {price} to continue reading?"
																   value="Please support quality journalism. Would you pledge to pay a small fee of {price} to continue reading?"
																   required="" type="text">
															<span class="bar"></span>
														</div>
													</div>
													<div class="custom-label" data-template="collapsed">
														<label>Message (Collapsed View)</label>
														<div class="custom-input">
															<input name="message-collapsed"
																   placeholder="Please support quality journalism."
																   value="Please support quality journalism. {pledge-button}"
																   required="" type="text">
															<span class="bar"></span>
														</div>
													</div>
													<div class="flex-container flex-gutter" data-template="style">
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Color</label>
																<div class="custom-input">
																	<input placeholder="color" data-template-css="color"
																		   required="" type="color">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Font Size</label>
																<div class="custom-input">
																	<input placeholder="font-size"
																		   data-template-css="font-size" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Font Weight</label>
																<div class="custom-input">
																	<input placeholder="font-weight"
																		   data-template-css="font-weight" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
													</div>

													<div class="flex-container flex-gutter" data-template="style">
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Font Style</label>
																<div class="custom-input">
																	<input placeholder="font-style"
																		   data-template-css="font-style" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Text Align</label>
																<div class="custom-input">
																	<input placeholder="text-align"
																		   data-template-css="text-align" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Text Transform</label>
																<div class="custom-input">
																	<input placeholder="text-transform"
																		   data-template-css="text-transform" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
													</div>
												</div>

												<input id="pledge-ext-user" value="card" name="pledge-ext" type="radio">
												<label for="pledge-ext-user" class="tab-name">
													User
												</label>
												<div class="tab-content">
													<div class="custom-label">
														<label>Connect Message</label>
														<div class="custom-input">
															<input placeholder="Already used us before? {connect_url}"
																   value="Already used us before? {connect_url}"
																   required="" type="text">
															<span class="bar"></span>
														</div>
													</div>

													<div class="custom-label">
														<label>Disconnect Message</label>
														<div class="custom-input">
															<input placeholder="Not {user}? {disconnect_url}"
																   value="Not {user}? {disconnect_url}" required=""
																   type="text">
															<span class="bar"></span>
														</div>
													</div>

													<div class="flex-container flex-gutter">
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Color</label>
																<div class="custom-input">
																	<input placeholder="color" required="" type="color">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Font Size</label>
																<div class="custom-input">
																	<input placeholder="font-size" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Font Weight</label>
																<div class="custom-input">
																	<input placeholder="font-weight" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
													</div>

													<div class="flex-container flex-gutter">
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Font Style</label>
																<div class="custom-input">
																	<input placeholder="font-style" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Text Align</label>
																<div class="custom-input">
																	<input placeholder="text-align" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Text Transform</label>
																<div class="custom-input">
																	<input placeholder="text-transform" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
													</div>
												</div>

												<input id="pledge-ext-button" value="card" name="pledge-ext"
													   type="radio">
												<label for="pledge-ext-button" class="tab-name">
													Button
												</label>
												<div class="tab-content">
													<div class="flex-container flex-gutter">
														<div class="flex-item-6">
															<div class="custom-label">
																<label>Micropayments Button Text</label>
																<div class="custom-input">
																	<input placeholder="PLEDGE {price}"
																		   value="PLEDGE {price}" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-6">
															<div class="custom-label">
																<label>Micropayments Button Icon</label>
																<div class="custom-input">
																	<input placeholder="fa-check" value="fa-check"
																		   required="" type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
													</div>

													<div class="flex-container flex-gutter">
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Background Color</label>
																<div class="custom-input">
																	<input placeholder="background-color" required=""
																		   type="color">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Border</label>
																<div class="custom-input">
																	<input placeholder="border" required="" type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Font Size</label>
																<div class="custom-input">
																	<input placeholder="font-size" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
													</div>

													<div class="flex-container flex-gutter">
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Font Weight</label>
																<div class="custom-input">
																	<input placeholder="font-weight" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Border Radius</label>
																<div class="custom-input">
																	<input placeholder="border-radius" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Color</label>
																<div class="custom-input">
																	<input placeholder="color" required="" type="color">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
													</div>

													<div class="flex-container flex-gutter">
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Font Style</label>
																<div class="custom-input">
																	<input placeholder="font-style" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Text Align</label>
																<div class="custom-input">
																	<input placeholder="text-align" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Text Transform</label>
																<div class="custom-input">
																	<input placeholder="text-transform" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
													</div>
												</div>

												<input id="pledge-ext-arrow" value="card" name="pledge-ext"
													   type="radio">
												<label for="pledge-ext-arrow" class="tab-name">
													Arrow
												</label>
												<div class="tab-content">
													<div class="flex-container flex-gutter">
														<div class="flex-item-6">
															<div class="custom-label">
																<label>Closing Arrow</label>
																<div class="custom-input">
																	<input placeholder="fa-chevron-circle-up"
																		   value="fa-chevron-circle-up" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-6">
															<div class="custom-label">
																<label>Color</label>
																<div class="custom-input">
																	<input placeholder="color" value="" required=""
																		   type="color">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
													</div>

													<div class="flex-container flex-gutter">
														<div class="flex-item-6">
															<div class="custom-label">
																<label>Opening Arrow</label>
																<div class="custom-input">
																	<input placeholder="fa-chevron-circle-down"
																		   value="fa-chevron-circle-down" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-6">
															<div class="custom-label">
																<label>Color</label>
																<div class="custom-input">
																	<input placeholder="color" value="" required=""
																		   type="color">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
													</div>
												</div>

											</section>
										</div>
									</div>
									<div class="custom-input pull-right">
										<button type="button" class="btn save-templates"><i
												class="mdi mdi-check"></i>Save
										</button>
									</div>
								</div>
							</div>
						</div>

						<div class="templates-views pay" data-template="pay">
							<div class="template-view">
								<div class="header-view">pay template</div>
								<div class="content-view clearfix">
									<div class="flex-container">
										<div class="flex-item-6">
											<div class="template-name" data-view-text="expanded">
												Expanded view
											</div>
											<div id="render-pay-expanded" data-view="expanded" ></div>

											<div class="template-name" data-view-text="collapsed">
												Collapsed view
											</div>
											<div id="render-pay-collapsed" data-view="collapsed"></div>
										</div>
										<div class="flex-item-6">
											<section class="config-tabs">
												<input id="pay-ext-salutation" name="pay-ext" checked="" type="radio">
												<label for="pay-ext-salutation" class="tab-name">
													Salutation
												</label>
												<div class="tab-content" data-template="salutation">
													<div class="custom-label" data-template="expanded">
														<label>Salutation</label>
														<div class="custom-input">
															<input name="salutation" placeholder="Dear {user}," value="Dear {user},"
																   required="" type="text">
															<span class="bar"></span>
														</div>
													</div>

													<div class="flex-container flex-gutter" data-template="style">
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Color</label>
																<div class="custom-input">
																	<input placeholder="color" data-template-css="color" required="" type="color">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Font Size</label>
																<div class="custom-input">
																	<input placeholder="font-size" required=""
																		   data-template-css="font-size"
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Font Weight</label>
																<div class="custom-input">
																	<input data-template-css="font-weight" placeholder="font-weight" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
													</div>

													<div class="flex-container flex-gutter" data-template="style">
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Font Style</label>
																<div class="custom-input">
																	<input placeholder="font-style" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Text Align</label>
																<div class="custom-input">
																	<input placeholder="text-align" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Text Transform</label>
																<div class="custom-input">
																	<input placeholder="text-transform" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
													</div>
												</div>

												<input id="pay-ext-message" name="pay-ext" type="radio">
												<label for="pay-ext-message" class="tab-name">
													Message
												</label>
												<div class="tab-content" data-template="message">
													<div class="custom-label" data-template="expanded">
														<label>Message (Expanded View)</label>
														<div class="custom-input">
															<input
																name="message-expanded"
																placeholder="Please support quality journalism. Would you pledge to pay a small fee of {price} to continue reading?"
																value="Please support quality journalism. Would you pledge to pay a small fee of {price} to continue reading?"
																required="" type="text">
															<span class="bar"></span>
														</div>
													</div>

													<div class="custom-label" data-template="collapsed">
														<label>Message (Collapsed View)</label>
														<div class="custom-input">
															<input
																name="message-collapsed"
																placeholder="Support quality journalism. {pay-button} "
																value="Support quality journalism. {pay-button} "
																required="" type="text">
															<span class="bar"></span>
														</div>
													</div>

													<div class="flex-container flex-gutter" data-template="style">
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Color</label>
																<div class="custom-input">
																	<input data-template-css="color" placeholder="color" required="" type="color">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Font Size</label>
																<div class="custom-input">
																	<input data-template-css="font-size" placeholder="font-size" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Font Weight</label>
																<div class="custom-input">
																	<input data-template-css="font-weight" placeholder="font-weight" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
													</div>

													<div class="flex-container flex-gutter" data-template="style">
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Font Style</label>
																<div class="custom-input">
																	<input data-template-css="font-style" placeholder="font-style" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Text Align</label>
																<div class="custom-input">
																	<input data-template-css="text-align" placeholder="text-align" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Text Transform</label>
																<div class="custom-input">
																	<input  data-template-css="text-transform" placeholder="text-transform" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
													</div>
												</div>

												<input id="pay-ext-user" name="pay-ext" type="radio">
												<label for="pay-ext-user" class="tab-name">
													User
												</label>
												<div class="tab-content">
													<div class="custom-label">
														<label>Connect Message</label>
														<div class="custom-input">
															<input placeholder="Already used us before? {connect_url}"
																   value="Already used us before? {connect_url}"
																   required=""
																   type="text">
															<span class="bar"></span>
														</div>
													</div>

													<div class="custom-label">
														<label>Disconnect Message</label>
														<div class="custom-input">
															<input placeholder="Not {user}? {disconnect_url}"
																   value="Not {user}? {disconnect_url}" required=""
																   type="text">
															<span class="bar"></span>
														</div>
													</div>

													<div class="flex-container flex-gutter">
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Color</label>
																<div class="custom-input">
																	<input placeholder="color" required="" type="color">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Font Size</label>
																<div class="custom-input">
																	<input placeholder="font-size" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Font Weight</label>
																<div class="custom-input">
																	<input placeholder="font-weight" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
													</div>

													<div class="flex-container flex-gutter">
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Font Style</label>
																<div class="custom-input">
																	<input placeholder="font-style" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Text Align</label>
																<div class="custom-input">
																	<input placeholder="text-align" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Text Transform</label>
																<div class="custom-input">
																	<input placeholder="text-transform" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
													</div>
												</div>

												<input id="pay-ext-input" name="pay-ext" type="radio">
												<label for="pay-ext-input" class="tab-name">
													Input
												</label>
												<div class="tab-content">
													<div class="flex-container flex-gutter">
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Background Color</label>
																<div class="custom-input">
																	<input placeholder="background-color" required=""
																		   type="color">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Border</label>
																<div class="custom-input">
																	<input placeholder="border" required="" type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Border Radius</label>
																<div class="custom-input">
																	<input placeholder="border-radius" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
													</div>

													<div class="flex-container flex-gutter">
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Font Size</label>
																<div class="custom-input">
																	<input placeholder="font-size" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Font Weight</label>
																<div class="custom-input">
																	<input placeholder="font-weight" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Color</label>
																<div class="custom-input">
																	<input placeholder="color" required="" type="color">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
													</div>

													<div class="flex-container flex-gutter">
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Box Shadow</label>
																<div class="custom-input">
																	<input placeholder="box-shadow" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Text Transform</label>
																<div class="custom-input">
																	<input placeholder="text-transform" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Text Align</label>
																<div class="custom-input">
																	<input placeholder="text-align" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
													</div>
												</div>

												<input id="pay-ext-button" name="pay-ext" type="radio">
												<label for="pay-ext-button" class="tab-name">
													Button
												</label>
												<div class="tab-content">
													<div class="flex-container flex-gutter">
														<div class="flex-item-6">
															<div class="custom-label">
																<label>Pay Button Text</label>
																<div class="custom-input">
																	<input placeholder="PAY" value="PAY" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-6">
															<div class="custom-label">
																<label>Pay Button Icon</label>
																<div class="custom-input">
																	<input placeholder="fa-check" value="fa-check"
																		   required="" type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
													</div>

													<div class="flex-container flex-gutter">
														<div class="flex-item-6">
															<div class="custom-label">
																<label>Setup Button Text</label>
																<div class="custom-input">
																	<input placeholder="SETUP" value="SETUP" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-6">
															<div class="custom-label">
																<label>Setup Button Icon</label>
																<div class="custom-input">
																	<input placeholder="fa-cog" value="fa-cog"
																		   required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
													</div>

													<div class="flex-container flex-gutter">
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Background Color</label>
																<div class="custom-input">
																	<input placeholder="background-color" required=""
																		   type="color">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Border</label>
																<div class="custom-input">
																	<input placeholder="border" required="" type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Font Size</label>
																<div class="custom-input">
																	<input placeholder="font-size" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
													</div>

													<div class="flex-container flex-gutter">
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Font Weight</label>
																<div class="custom-input">
																	<input placeholder="font-weight" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Border Radius</label>
																<div class="custom-input">
																	<input placeholder="border-radius" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Color</label>
																<div class="custom-input">
																	<input placeholder="color" required="" type="color">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
													</div>

													<div class="flex-container flex-gutter">
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Font Style</label>
																<div class="custom-input">
																	<input placeholder="font-style" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Text Align</label>
																<div class="custom-input">
																	<input placeholder="text-align" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Text Transform</label>
																<div class="custom-input">
																	<input placeholder="text-transform" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
													</div>
												</div>

												<input id="pay-ext-arrow" name="pay-ext" type="radio">
												<label for="pay-ext-arrow" class="tab-name">
													Arrow
												</label>
												<div class="tab-content">
													<div class="flex-container flex-gutter">
														<div class="flex-item-6">
															<div class="custom-label">
																<label>Closing Arrow</label>
																<div class="custom-input">
																	<input placeholder="fa-chevron-circle-up"
																		   value="fa-chevron-circle-up" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-6">
															<div class="custom-label">
																<label>Color</label>
																<div class="custom-input">
																	<input placeholder="color" value="" required=""
																		   type="color">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
													</div>

													<div class="flex-container flex-gutter">
														<div class="flex-item-6">
															<div class="custom-label">
																<label>Opening Arrow</label>
																<div class="custom-input">
																	<input placeholder="fa-chevron-circle-down"
																		   value="fa-chevron-circle-down" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-6">
															<div class="custom-label">
																<label>Color</label>
																<div class="custom-input">
																	<input placeholder="color" value="" required=""
																		   type="color">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
													</div>
												</div>

											</section>
										</div>
									</div>
									<div class="custom-input pull-right">
										<button type="button" class="btn save-templates"><i class="mdi mdi-check"></i>Save</button>
									</div>
								</div>
							</div>
						</div>

						<div class="templates-views refund" data-template="refund">
							<div class="template-view">
								<div class="header-view">refund template</div>
								<div class="content-view clearfix">
									<div class="flex-container">
										<div class="flex-item-6">
											<div class="template-name" data-view-text="expanded">
												Expanded view
											</div>
											<div id="render-refund-expanded"  data-view="expanded"></div>

											<div class="template-name" data-view-text="collapsed">
												Collapsed view
											</div>
											<div id="render-refund-collapsed" data-view="collapsed"></div>
										</div>
										<div class="flex-item-6">
											<section class="config-tabs">
												<input id="refund-ext-message" name="refund-ext" checked=""
													   type="radio">
												<label for="refund-ext-message" class="tab-name">
													Message
												</label>
												<div class="tab-content" data-template="message">
													<div class="custom-label" data-template="expanded">
														<label>Message (Expanded View)</label>
														<div class="custom-input">
															<input
																name="message-expanded"
																placeholder="Thanks for contributing {price} and help us do the job we {heart}"
																value="Thanks for contributing {price} and help us do the job we {heart}"
																required="" type="text">
															<span class="bar"></span>
														</div>
													</div>

													<div class="custom-label" data-template="collapsed">
														<label>Message (Collapsed View)</label>
														<div class="custom-input">
															<input
																name="message-collapsed"
																placeholder="Premium content unlocked. notSatisfied_url Get immediate"
																value="Premium content unlocked. notSatisfied_url Get immediate"
																required="" type="text">
															<span class="bar"></span>
														</div>
													</div>

													<div class="flex-container flex-gutter" data-template="style">
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Color</label>
																<div class="custom-input">
																	<input placeholder="color" data-template-css="color" required="" type="color">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Font Size</label>
																<div class="custom-input">
																	<input placeholder="font-size" data-template-css="font-size" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Font Weight</label>
																<div class="custom-input">
																	<input placeholder="font-weight" data-template-css="font-weight" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
													</div>

													<div class="flex-container flex-gutter" data-template="style">
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Font Style</label>
																<div class="custom-input">
																	<input placeholder="font-style" data-template-css="font-style" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Text Align</label>
																<div class="custom-input">
																	<input placeholder="text-align" data-template-css="text-align" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Text Transform</label>
																<div class="custom-input">
																	<input placeholder="text-transform" data-template-css="text-transform"  required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
													</div>
												</div>

												<input id="refund-ext-mood" name="refund-ext" type="radio">
												<label for="refund-ext-mood" class="tab-name">
													Mood
												</label>
												<div class="tab-content" >
													<div class="custom-label" data-template="mood">
														<label>Message</label>
														<div class="custom-input" data-template="expanded">
															<input
																name="body-feeling"
																placeholder="How do you feel now?"
																   value="How do you feel now?" required="" type="text">
															<span class="bar"></span>
														</div>
													</div>

													<div class="flex-container flex-gutter" data-template="mood">
														<div class="flex-item-4" data-template="style">
															<div class="custom-label">
																<label>Color</label>
																<div class="custom-input">
																	<input placeholder="color"  data-template-css="color" required="" type="color">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4" data-template="style">
															<div class="custom-label">
																<label>Font Size</label>
																<div class="custom-input">
																	<input placeholder="font-size"  data-template-css="font-size" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4" data-template="style">
															<div class="custom-label">
																<label>Font Weight</label>
																<div class="custom-input">
																	<input placeholder="font-weight" data-template-css="font-weight" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
													</div>

													<div class="flex-container flex-gutter" data-template="mood">
														<div class="flex-item-4" data-template="style">
															<div class="custom-label">
																<label>Font Style</label>
																<div class="custom-input">
																	<input placeholder="font-style" data-template-css="font-style" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4" data-template="style">
															<div class="custom-label">
																<label>Text Align</label>
																<div class="custom-input">
																	<input placeholder="text-align" data-template-css="text-align" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4" data-template="style">
															<div class="custom-label">
																<label>Text Transform</label>
																<div class="custom-input">
																	<input placeholder="text-transform" data-template-css="text-transform" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
													</div>

													<div class="flex-container flex-gutter"  data-template="mood-happy">
														<div class="flex-item-6" data-template="expanded">
															<div class="custom-label">
																<label>Happy Mood Text</label>
																<div class="custom-input">
																	<input
																		name="body-feeling-happy"
																		placeholder="Happy" value="Happy" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-6" data-template="style">
															<div class="custom-label">
																<label>Happy Mood Color</label>
																<div class="custom-input">
																	<input placeholder="color" data-template-css="color" required="" type="color">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
													</div>

													<div class="flex-container flex-gutter" data-template="mood-ok">
														<div class="flex-item-6"  data-template="expanded">
															<div class="custom-label">
																<label>Neutral Mood Text</label>
																<div class="custom-input">
																	<input
																		name="body-feeling-ok"
																		placeholder="OK" value="Ok" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-6" data-template="style">
															<div class="custom-label">
																<label>Neutral Mood Color</label>
																<div class="custom-input">
																	<input placeholder="color" data-template-css="color"  required="" type="color">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
													</div>

													<div class="flex-container flex-gutter" data-template="mood-not-happy">
														<div class="flex-item-6" data-template="expanded">
															<div class="custom-label">
																<label>Not happy Mood Text</label>
																<div class="custom-input">
																	<input
																		name="body-feeling-not-happy"
																		placeholder="Not happy" value="Not happy"
																		   required="" type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-6" data-template="style">
															<div class="custom-label">
																<label>Not happy Mood Color</label>
																<div class="custom-input">
																	<input placeholder="color" data-template-css="color"  required="" type="color">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
													</div>
												</div>

												<input id="refund-ext-share" name="refund-ext" type="radio">
												<label for="refund-ext-share" class="tab-name">
													Share
												</label>
												<div class="tab-content" data-template="share">
													<div class="custom-label" data-template="expanded">
														<label>Message</label>
														<div class="custom-input">
															<input
																name="body-share-experience"
																placeholder="Share your experience"
																   value="Share your experience" required=""
																   type="text">
															<span class="bar"></span>
														</div>
													</div>

													<div class="flex-container flex-gutter" data-template="style">
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Color</label>
																<div class="custom-input">
																	<input  data-template-css="color" placeholder="color" required="" type="color">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Font Size</label>
																<div class="custom-input">
																	<input  data-template-css="font-size" placeholder="font-size" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Font Weight</label>
																<div class="custom-input">
																	<input data-template-css="font-weight" placeholder="font-weight" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
													</div>

													<div class="flex-container flex-gutter" data-template="style">
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Font Style</label>
																<div class="custom-input">
																	<input data-template-css="font-style" placeholder="font-style" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Text Align</label>
																<div class="custom-input">
																	<input  data-template-css="text-align"  placeholder="text-align" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Text Transform</label>
																<div class="custom-input">
																	<input data-template-css="text-transform"  placeholder="text-transform" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
													</div>

													<div class="flex-container flex-gutter">
														<div class="flex-item-6">
															<div class="custom-label">
																<label>Share Tool</label>
																<div class="custom-input">
																	<input placeholder="fa-facebook" value="fa-facebook"
																		   required="" type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-6">
															<div class="custom-label">
																<label>Share Tool Color</label>
																<div class="custom-input">
																	<input placeholder="color" required="" type="color">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
													</div>

													<div class="flex-container flex-gutter">
														<div class="flex-item-6">
															<div class="custom-label">
																<label>Share Tool</label>
																<div class="custom-input">
																	<input placeholder="fa-twitter" value="fa-twitter"
																		   required="" type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-6">
															<div class="custom-label">
																<label>Share Tool Color</label>
																<div class="custom-input">
																	<input placeholder="color" required="" type="color">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
													</div>

													<div class="flex-container flex-gutter">
														<div class="flex-item-6">
															<div class="custom-label">
																<label>Share Tool</label>
																<div class="custom-input">
																	<input placeholder="fa-email" value="fa-email"
																		   required="" type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-6">
															<div class="custom-label">
																<label>Share Tool Color</label>
																<div class="custom-input">
																	<input placeholder="color" required="" type="color">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
													</div>

													<div class="flex-container flex-gutter">
														<div class="flex-item-6">
															<div class="custom-label">
																<label>Share Tool</label>
																<div class="custom-input">
																	<input placeholder="fa-share" value="fa-share"
																		   required="" type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-6">
															<div class="custom-label">
																<label>Share Tool Color</label>
																<div class="custom-input">
																	<input placeholder="color" required="" type="color">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
													</div>
												</div>

												<input id="refund-ext-button" name="refund-ext" type="radio">
												<label for="refund-ext-button" class="tab-name">
													Button
												</label>
												<div class="tab-content">
													<div class="flex-container flex-gutter">
														<div class="flex-item-6">
															<div class="custom-label">
																<label>Refund Button Text</label>
																<div class="custom-input">
																	<input placeholder="REFUND" value="REFUND"
																		   required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-6">
															<div class="custom-label">
																<label>Refund Button Icon</label>
																<div class="custom-input">
																	<input placeholder="fa-money" value="fa-money"
																		   required="" type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
													</div>

													<div class="flex-container flex-gutter">
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Background Color</label>
																<div class="custom-input">
																	<input placeholder="background-color" required=""
																		   type="color">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Border</label>
																<div class="custom-input">
																	<input placeholder="border" required="" type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Font Size</label>
																<div class="custom-input">
																	<input placeholder="font-size" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
													</div>

													<div class="flex-container flex-gutter">
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Font Weight</label>
																<div class="custom-input">
																	<input placeholder="font-weight" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Border Radius</label>
																<div class="custom-input">
																	<input placeholder="border-radius" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Color</label>
																<div class="custom-input">
																	<input placeholder="color" required="" type="color">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
													</div>

													<div class="flex-container flex-gutter">
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Font Style</label>
																<div class="custom-input">
																	<input placeholder="font-style" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Text Align</label>
																<div class="custom-input">
																	<input placeholder="text-align" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Text Transform</label>
																<div class="custom-input">
																	<input placeholder="text-transform" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
													</div>
												</div>

												<input id="refund-ext-arrow" name="refund-ext" type="radio">
												<label for="refund-ext-arrow" class="tab-name">
													Arrow
												</label>
												<div class="tab-content">
													<div class="flex-container flex-gutter">
														<div class="flex-item-6">
															<div class="custom-label">
																<label>Closing Arrow</label>
																<div class="custom-input">
																	<input placeholder="fa-chevron-circle-up"
																		   value="fa-chevron-circle-up" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-6">
															<div class="custom-label">
																<label>Color</label>
																<div class="custom-input">
																	<input placeholder="color" value="" required=""
																		   type="color">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
													</div>

													<div class="flex-container flex-gutter">
														<div class="flex-item-6">
															<div class="custom-label">
																<label>Opening Arrow</label>
																<div class="custom-input">
																	<input placeholder="fa-chevron-circle-down"
																		   value="fa-chevron-circle-down" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-6">
															<div class="custom-label">
																<label>Color</label>
																<div class="custom-input">
																	<input placeholder="color" value="" required=""
																		   type="color">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
													</div>
												</div>

											</section>
										</div>
									</div>
									<div class="custom-input pull-right">
										<button type="button" class="btn save-templates"><i class="mdi mdi-check"></i>Save</button>
									</div>
								</div>
							</div>
						</div>

						<div class="templates-views other">
							<div class="template-view">
								<div class="header-view">other templates <i class="fa fa-angle-right"
																			aria-hidden="true"></i> unlock view
								</div>
								<div class="content-view">
									<div class="flex-container">
										<div class="flex-item-6">
											<div class="atm-base-modal">
												<div class="atm-main price-view">
													<div class="unlock-cont">
														<p class="blurred">
															It is a long established fact that a reader will be
															distracted
															by
															the readable content of a page when looking at its layout.
															The point of using Lorem Ipsum is that it has a more-or-less
															normal
															distribution of letters, as opposed to using 'Content here,
															content here',
															making it look like readable English.
															It is a long established fact that a reader will be
															distracted
															by
															the readable content of a page when looking at its layout.
															The point of using Lorem Ipsum is that it has a more-or-less
															normal
															distribution of letters, as opposed to using 'Content here,
															content here',
															making it look like readable English.
														</p>
														<button class="atm-button unlock-btn">
															<i class="fa fa-unlock-alt" aria-hidden="true"></i> unlock
															content
														</button>
													</div>
												</div>
											</div>
										</div>
										<div class="flex-item-6">
											<section class="config-tabs">
												<input id="other-unlock" name="unlock-content" checked="" type="radio">
												<label for="other-unlock" class="tab-name">
													Button
												</label>
												<div class="tab-content">
													<div class="flex-container flex-gutter">
														<div class="flex-item-6">
															<div class="custom-label">
																<label>Unlock Button Text</label>
																<div class="custom-input">
																	<input placeholder="UNLOCK CONTENT"
																		   value="UNLOCK CONTENT" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-6">
															<div class="custom-label">
																<label>Unlock Button Icon</label>
																<div class="custom-input">
																	<input placeholder="fa-unlock-alt"
																		   value="fa-unlock-alt"
																		   required="" type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
													</div>

													<div class="flex-container flex-gutter">
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Background Color</label>
																<div class="custom-input">
																	<input placeholder="background-color" required=""
																		   type="color">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Border</label>
																<div class="custom-input">
																	<input placeholder="border" required="" type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Font Size</label>
																<div class="custom-input">
																	<input placeholder="font-size" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
													</div>

													<div class="flex-container flex-gutter">
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Font Weight</label>
																<div class="custom-input">
																	<input placeholder="font-weight" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Border Radius</label>
																<div class="custom-input">
																	<input placeholder="border-radius" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Color</label>
																<div class="custom-input">
																	<input placeholder="color" required="" type="color">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
													</div>

													<div class="flex-container flex-gutter">
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Font Style</label>
																<div class="custom-input">
																	<input placeholder="font-style" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Text Align</label>
																<div class="custom-input">
																	<input placeholder="text-align" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Text Transform</label>
																<div class="custom-input">
																	<input placeholder="text-transform" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
													</div>
												</div>
											</section>
										</div>
									</div>
								</div>
							</div>

							<div class="template-view">
								<div class="header-view">other templates <i class="fa fa-angle-right"
																			aria-hidden="true"></i> price view
								</div>
								<div class="content-view">
									<div class="flex-container">
										<div class="flex-item-6">
											<div class="atm-base-modal">
												<div class="atm-main price-view">
													<p class="blurred">Dear reader,</p>
													<div>
														<span class="blurred">Please support quality journalism</span>
														<span class="contrib-price">5¢</span> <span class="blurred">to continue reading?</span>
														<span class="show-sm blurred">lease support quality journalism lease support quality journalism lease support quality journalism</span>
													</div>
													<div class="pledge-bottom clearfix blurred">
														<div class="connect-component">
															<small>
																Already used us before? <a>Connect here</a>
															</small>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="flex-item-6">
											<section class="config-tabs">
												<input id="other-price" name="other-view-price" checked="" type="radio">
												<label for="other-price" class="tab-name">
													Price
												</label>
												<div class="tab-content">
													<div class="custom-label">
														<label>Price</label>
														<div class="custom-input">
															<input placeholder="{price}" value="{price}" required=""
																   type="text">
															<span class="bar"></span>
														</div>
													</div>

													<div class="flex-container flex-gutter">
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Background Color</label>
																<div class="custom-input">
																	<input placeholder="background-color" required=""
																		   type="color">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Border</label>
																<div class="custom-input">
																	<input placeholder="border" required="" type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Border Radius</label>
																<div class="custom-input">
																	<input placeholder="border-radius" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
													</div>

													<div class="flex-container flex-gutter">
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Color</label>
																<div class="custom-input">
																	<input placeholder="color" required="" type="color">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Font Style</label>
																<div class="custom-input">
																	<input placeholder="font-style" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
														<div class="flex-item-4">
															<div class="custom-label">
																<label>Font Weight</label>
																<div class="custom-input">
																	<input placeholder="font-weight" required=""
																		   type="text">
																	<span class="bar"></span>
																</div>
															</div>
														</div>
													</div>
												</div>
											</section>
										</div>
									</div>
								</div>
							</div>
						</div>
					</section>

				</div>
			</div>
		</div>
	</section>
</main>


