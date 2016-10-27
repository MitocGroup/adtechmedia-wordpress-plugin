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
?>

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
					</div>
					<div class="flex-container">
						<div class="flex-item-6 flex-end">
							<div class="custom-input">
								<button type="submit" class="btn"><i class="mdi mdi-account-plus"></i> Register</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</section>

	<section>
		<form method="post" action="">
			<?php settings_fields( $plugin_meta_data_class ); ?>
			<h1 class="heading">
				<i class="custom-icon edit"></i>
				Content configuration
			</h1>

			<div class="content">
				<div class="flex-container">
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
							<button type="submit" class="btn"><i class="mdi mdi-check"></i>Save</button>
						</div>
					</div>
					<div class="flex-item-6">
						<div class="mockup">
							<img class="logo-img" src="<?php echo plugins_url( '../images/logo.svg', __FILE__ ) ?>"
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
								<img src="<?php echo plugins_url( '../images/Collaborative-team.jpg', __FILE__ ) ?>"/>

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

</main>


