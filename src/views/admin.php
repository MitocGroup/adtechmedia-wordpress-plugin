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
		foreach ( $countries_element['Currency'] as $currency ) {
			if ( ! in_array( $currency, $currencies, true ) ) {
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
$template_inputs = addslashes( $this->get_plugin_option( 'template_inputs' ) );
echo empty( $template_inputs ) ? '{}' : $template_inputs;
echo '\');';
echo 'var templateStyleInputs =JSON.parse(\'';
$template_style_inputs = addslashes( $this->get_plugin_option( 'template_style_inputs' ) );
echo empty( $template_style_inputs ) ? '{}' : $template_style_inputs;
echo '\');';
echo 'var templatePositionInputs =JSON.parse(\'';
$template_position = addslashes( $this->get_plugin_option( 'template_position' ) );
echo empty( $template_position ) ? '{}' : $template_position;
echo '\');';
echo 'var templateOverallStylesInputs =JSON.parse(\'';
$template_overall_styles_inputs = addslashes( $this->get_plugin_option( 'template_overall_styles_inputs' ) );
echo empty( $template_overall_styles_inputs ) ? '{}' : $template_overall_styles_inputs;
echo '\');';
echo 'var templateOverallStylesInputsDefault =JSON.parse(\'';
$template_overall_styles_inputs_default = addslashes( Adtechmedia_Config::get ( 'template_overall_styles_inputs' ) );
echo empty( $template_overall_styles_inputs_default ) ? '{}' : $template_overall_styles_inputs_default;
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
		<form method="post" id="general-config" action="">
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
									<?php
									foreach ( $countries as $name => $methods ) {
										$selected = ($this->get_plugin_option( 'country' ) === $name) ? 'selected' : '';
										echo "<option value='" . esc_html( $name ) . "' data-methods='"
											. wp_json_encode( $methods ) . "' " . esc_html( $selected ) . '>' . esc_html( $name ) . '</option>';
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
									array_merge( [ '' ] ,$countries[ $this->get_plugin_option( 'country' ) ] ),
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
							<br/><!-- ToDo: Remove <br/> and add spacer through CSS -->
							<div class="block-info">
								<input type="checkbox" id="terms" name="terms">
								<label><a id="terms-btn">I agree to Terms of Use</a></label>
							</div>
							<div class="custom-input">
								<a href="https://www.adtechmedia.io/admin/accounts/signup" target="_blank" id="btn-register" class="btn" disabled><i class="mdi mdi-account-plus"></i> Register</a>
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
											foreach ( $currencies as $currency ) {
												echo "<option value='";
												echo esc_html( $currency );
												echo "' " .
													(($currency === $price_currency_value) ? 'selected' : '')
													. ' >' .
													esc_html( strtoupper( $currency ) ) . '</option>';
											}
											?>
										</select>
									</div>
								</div>
							</div>

							<div class="block-info">
								Specify the price and the currency to be collected per article per micropayment
								(e.g. "10" &amp; "USD" means 10&cent;, while "100" &amp; "USD" means $1)
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
								Specify the link to video ad that will be used for demo purposes
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

	<section>
		<h1 class="heading">
			<i class="custom-icon templates"></i>
			Templates management
			<div class=" pull-right">
				<button type="button" class="btn return-to-default-values"><i class="mdi mdi-check"></i> Reset to default values</button>
			</div>
		</h1>

		<div class="content templating">

			<div class="templates-views templates-views-common">
				<div class="template-view">
					<div class="header-view">Overall styling and position
					</div>
					<section class="content-view" >
						<form id="overall-styling-and-position">
						<div class="flex-container flex-gutter" data-template="overall-styling">
							<div class="flex-item-2">
								<div class="custom-label">
									<label>Background Color</label>
									<div class="custom-input">
										<input type="color" data-template-css="background-color" value="#ffffff" placeholder="#ffffff" required="" />
										<span class="bar"></span>
									</div>
								</div>
							</div>
							<div class="flex-item-2">
								<div class="custom-label">
									<label>Border</label>
									<div class="custom-input">
										<input type="text" data-template-css="border" name="border" value="1px solid #d3d3d3" placeholder="1px solid #d3d3d3" required="" />
										<span class="bar"></span>
									</div>
								</div>
							</div>
							<div class="flex-item-2">
								<div class="custom-label">
									<label>Font Family</label>
									<div class="custom-input">
										<input type="text" data-template-css="font-family" name="font_family" value="'Merriweather', sans-serif" placeholder="'Merriweather', sans-serif" required="" />
										<span class="bar"></span>
									</div>
								</div>
							</div>
							<div class="flex-item-2">
								<div class="custom-label">
									<label>Box Shadow</label>
									<div class="custom-input">
										<input type="text" data-template-css="box-shadow" name="box_shadow" value="0 1px 2px 0 rgba(0, 0, 0, 0.1)" placeholder="0 1px 2px 0 rgba(0, 0, 0, 0.1)" required="" />
										<span class="bar"></span>
									</div>
								</div>
							</div>
							<div class="flex-item-2">
								<div class="custom-label">
									<label>Footer Background Color</label>
									<div class="custom-input">
										<input type="color" data-template-css="footer-background-color" value="#fafafa" placeholder="#fafafa" required="" />
										<span class="bar"></span>
									</div>
								</div>
							</div>
							<div class="flex-item-2">
								<div class="custom-label">
									<label>Footer Border</label>
									<div class="custom-input">
										<input type="text" data-template-css="footer-border" name="footer_border" value="1px solid #e3e3e3" placeholder="1px solid #e3e3e3" required="" />
										<span class="bar"></span>
									</div>
								</div>
							</div>
						</div>

						<div class="flex-container flex-gutter flex-end" data-template="position">
							<div class="flex-item-2">
								<span class="accent-color">Sticky</span>
								<div class="">
									<input type="checkbox" name="sticky" id="checkbox-sticky" class="cbx hidden" checked />
									<label for="checkbox-sticky" class="custom-checkbox"></label>
								</div>
							</div>
							<div class="flex-item-2 disable-if-sticky">
								<div class="custom-label">
									<label>Width</label>
									<div class="custom-input">
										<input type="text" name="width" value="600px" placeholder="600px" />
										<span class="bar"></span>
									</div>
								</div>
							</div>
							<div class="flex-item-2 disable-if-sticky">
								<div class="custom-label">
									<label>Offset top</label>
									<div class="custom-input">
										<input type="text" name="offset_top" value="20px" placeholder="20px" />
										<span class="bar"></span>
									</div>
								</div>
							</div>
							<div class="flex-item-2 disable-if-sticky">
								<div class="custom-label">
									<label>Offset from center</label>
									<div class="custom-input">
										<input type="text" name="offset_left" value="-60px" placeholder="-60px" />
										<span class="bar"></span>
									</div>
								</div>
							</div>
							<div class="flex-item-2 disable-if-sticky">
								<div class="custom-label">
									<label>Scrolling offset top</label>
									<div class="custom-input">
										<input type="text" name="scrolling_offset_top" value="100px" placeholder="100px" />
										<span class="bar"></span>
									</div>
								</div>
							</div>
							<div class="flex-item-2">
								<div class="custom-input pull-right">
									<button type="button" class="btn save-templates"><i
											class="mdi mdi-check"></i> Save
									</button>
								</div>
							</div>
						</div>
						</form>
					</section>
				</div>
			</div>
			<div class="clearfix">
				<div class="">

				<?php
				include 'template.php';
				?>
				</div>
			</div>
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
