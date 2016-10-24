<?php
/**
 * Created by PhpStorm.
 * User: yama_gs
 * Date: 20.10.2016
 * Time: 15:00
 */
?>

<main>
	<section>
		<h1 class="heading">
			<i class="custom-icon add"></i>
			Plugin management
		</h1>

		<div class="content">
			<div class="general-fields">
				<div class="flex-container">
					<div class="flex-item-6">
						<div class="custom-input">
							<input type="text" required/>
							<span class="bar"></span>
							<label><i class="mdi mdi-email"></i> Email address</label>
						</div>
					</div>
					<div class="flex-item-6 flex-end">
						<button type="button" class="btn"><i class="mdi mdi-account-plus"></i> Register</button>
					</div>
				</div>
				<div class="flex-container">
					<div class="flex-item-6">
						<div class="block-info">
							It is a long established fact that a reader will be distracted
							by the readable content of a page when looking at its layout.
							The point of using Lorem Ipsum is that it has a more-or-less normal
							distribution of letters
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section>
		<form method="post" action="">
			<?php settings_fields( $mainDataClass ); ?>
			<h1 class="heading">
				<i class="custom-icon cog"></i>
				General configuration
			</h1>
			<div class="content">
				<div class="general-fields">
					<div class="flex-container">
						<div class="flex-item-6">
							<div class="custom-input">
								<?php $this->createFormControl(
									'key',
									$mainData['key'],
									$this->getPluginOption( 'key' )
								); ?>
								<span class="bar"></span>
								<label><i class="mdi mdi-key-variant"></i> API Key</label>
							</div>
						</div>
						<div class="flex-item-6 flex-end">
							<button type="submit" class="btn"><i class="mdi mdi-autorenew"></i> Regenerate</button>
						</div>
					</div>
					<div class="flex-container">
						<div class="flex-item-6">
							<div class="block-info">
								It is a long established fact that a reader will be distracted
								by the readable content of a page when looking at its layout.
								The point of using Lorem Ipsum is that it has a more-or-less normal
								distribution of letters
							</div>
						</div>
					</div>
				</div>
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
								It is a long established fact that a reader will be distracted
								by the readable content of a page when looking at its layout.
								The point of using Lorem Ipsum is that it has a more-or-less normal
								distribution of letters
							</div>
						</div>
						<div class="flex-item-6">
							<div class="form-select custom-label">
								<label>
									<i class="mdi mdi-lan"></i> Revenue Model
								</label>
								<?php $this->createFormControl(
									'revenue_method',
									$mainData['revenue_method'],
									$this->getPluginOption( 'revenue_method' )
								); ?>
							</div>
							<div class="block-info">
								It is a long established fact that a reader will be distracted
								by the readable content of a page when looking at its layout.
								The point of using Lorem Ipsum is that it has a more-or-less normal
								distribution of letters
							</div>
						</div>
					</div>
				</div>
				<h2>Additional fields</h2>
				<?php $fields = [ 'support_email' ];
				foreach ( $fields as $field ) {
					?>
					<div class="general-fields">
						<div class="flex-container">
							<div class="flex-item-6">
								<div class="custom-input">
									<?php $this->createFormControl(
										$field,
										$mainData[ $field ],
										$this->getPluginOption( $field )
									); ?>
									<span class="bar"></span>
									<label><i class="mdi mdi-key-variant"></i> <?php echo $mainData[ $field ][0] ?></label>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
		</form>
	</section>

	<section>
		<form method="post" action="">
			<?php settings_fields( $pluginMetaDataClass ); ?>
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
										<?php $this->createFormControl(
											'price',
											$pluginMetaData['price'],
											$this->getPluginOption( 'price' )
										); ?>
										<span class="bar"></span>
									</div>
								</div>
								<div class="flex-item-6">
									<div class="form-select">
										<select>
											<option>currency units</option>
										</select>
									</div>
								</div>
							</div>

							<div class="block-info">
								It is a long established fact that a reader will be distracted
								by the readable content of a page when looking at its layout.
								The point of using Lorem Ipsum is that it has a more-or-less normal
								distribution of letters
							</div>
						</div>

						<div class="custom-label mixed-fields">
							<label><i class="mdi mdi-currency-usd"></i> Content paywall</label>

							<div class="flex-container">
								<div class="flex-item-6">
									<div class="custom-input">
										<?php $this->createFormControl(
											'payment_pledged',
											$pluginMetaData['payment_pledged'],
											$this->getPluginOption( 'payment_pledged' )
										); ?>
										<span class="bar"></span>
									</div>
								</div>
								<div class="flex-item-6">
									<div class="form-select">
										<select>
											<option>transactions</option>
										</select>
									</div>
								</div>
							</div>

							<div class="block-info">
								It is a long established fact that a reader will be distracted
								by the readable content of a page when looking at its layout.
								The point of using Lorem Ipsum is that it has a more-or-less normal
								distribution of letters
							</div>
						</div>

						<div class="custom-label mixed-fields">
							<label><i class="mdi mdi-eye"></i> Content preview</label>

							<div class="flex-container">
								<div class="flex-item-6">
									<div class="custom-input">
										<?php $this->createFormControl(
											'content_offset',
											$pluginMetaData['content_offset'],
											$this->getPluginOption( 'content_offset' )
										); ?>
										<span class="bar"></span>
									</div>
								</div>
								<div class="flex-item-6">
									<div class="form-select">
										<select>
											<option>paragraphs</option>
										</select>
									</div>
								</div>
							</div>
							<div class="block-info">
								It is a long established fact that a reader will be distracted
								by the readable content of a page when looking at its layout.
								The point of using Lorem Ipsum is that it has a more-or-less normal
								distribution of letters
							</div>
						</div>

						<div class="custom-label mixed-fields">
							<label>
								<i class="mdi mdi-lock-open"></i> Content unlocking algorithm
							</label>
							<div class="form-select">
								<?php $this->createFormControl(
									'content_lock',
									$pluginMetaData['content_lock'],
									$this->getPluginOption( 'content_lock' )
								); ?>
							</div>
							<div class="block-info">
								It is a long established fact that a reader will be distracted
								by the readable content of a page when looking at its layout.
								The point of using Lorem Ipsum is that it has a more-or-less normal
								distribution of letters
							</div>
						</div>
						

						<?php $fields = [
							/*
                            "container",
                            "author_name",
                            "author_avatar",*/
							'ads_video',
						];
foreach ( $fields as $field ) {
	?>
	<div class="custom-input">

<?php $this->createFormControl(
	$field,
	$pluginMetaData[ $field ],
	$this->getPluginOption( $field )
); ?>
		<span class="bar"></span>
		<label><i class="mdi mdi-share-variant"></i> <?php echo $pluginMetaData[ $field ][0] ?></label>

	</div>
<?php } ?>

						<div class="custom-input">

							<button type="submit" class="btn"><i class="mdi mdi-autorenew"></i>Save</button>

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


