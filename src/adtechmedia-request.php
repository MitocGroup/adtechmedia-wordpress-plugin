<?php
/**
 * Adtechmedia_Request
 *
 * @category File
 * @package  Adtechmedia_Plugin
 * @author    yama-gs
 */

/**
 * Class Adtechmedia_Request
 */
class Adtechmedia_Request {

	/**
	 * Create content API request
	 *
	 * @param string $content_id id of content.
	 * @param string $property_id id of property.
	 * @param string $content content.
	 * @param string $key API key.
	 * @return bool|mixed
	 */
	public static function content_create( $content_id, $property_id, $content, $key ) {
		if ( empty( $key ) ) {
			return false;
		}
		$data = [
			'ContentId' => $content_id,
			'PropertyId' => $property_id,
			'Content' => $content,
		];
		$response = self::make(
			Adtechmedia_Config::get( 'api_end_point' ) . 'atm-admin/content/create',
			'PUT',
			[ 'X-Api-Key' => $key ],
			$data,
			[ 'Id' ]
		);

		if ( $response && isset( $response['Id'] ) ) {
			return $response['Id'];
		} else {
			return false;
		}
	}

	/**
	 * Get content API request
	 *
	 * @param string  $content_id id of content.
	 * @param string  $property_id id of property.
	 * @param string  $scramble_strategy scramble strategy.
	 * @param string  $offset_type offset type.
	 * @param string  $offset_element_selector offset element elector.
	 * @param integer $offset offset.
	 * @param string  $key API key.
	 * @return bool|mixed
	 */
	public static function content_retrieve(
		$content_id,
		$property_id,
		$scramble_strategy,
		$offset_type,
		$offset_element_selector,
		$offset,
		$key
	) {
		if ( empty( $key ) ) {
			return false;
		}
		$data = [
			'ContentId' => $content_id,
			'PropertyId' => $property_id,
			'ScrambleStrategy' => $scramble_strategy,
			'OffsetType' => self::get_offset_type( $offset_type ),
			'OffsetElementSelector' => $offset_element_selector,
			'Offset' => $offset,
		];
		$response = self::make(
			Adtechmedia_Config::get( 'api_end_point' ) . 'atm-admin/content/retrieve',
			'GET',
			[ 'X-Api-Key' => $key ],
			$data,
			[ 'Content' ]
		);

		if ( $response && isset( $response['Content'] ) ) {
			return $response['Content'];
		} else {
			return false;
		}
	}

	/**
	 * Get lis of countries
	 *
	 * @param string $key API key.
	 * @return bool|mixed
	 */
	public static function get_countries_list( $key ) {
		if ( empty( $key ) ) {
			return false;
		}
		$list = get_transient( 'adtechmedia-supported-countries' );
		if ( false === $list ) {
			$response = self::make(
				Adtechmedia_Config::get( 'api_end_point' ) . 'atm-admin/property/supported-countries',
				'GET',
				[ 'X-Api-Key' => $key ],
				null,
				[ 'Countries' ]
			);

			if ( $response && isset( $response['Countries'] ) ) {
				$list = $response['Countries'];
			} else {
				$list = false;
			}
			set_transient( 'adtechmedia-supported-countries', $list, 3600 * 2 );
		}

		return $list;
	}

	/**
	 * Create API key
	 *
	 * @param string $name key name.
	 * @param string $host website host.
	 * @return bool|mixed
	 */
	public static function api_key_create( $name, $host ) {
		$data = [
			'Name' => $name,
			'Hostname' => $host,
		];
		$response = self::make(
			Adtechmedia_Config::get( 'api_end_point' ) . 'atm-admin/api-gateway-key/create',
			'PUT',
			[],
			$data,
			[ 'Key' ]
		);

		if ( $response && isset( $response['Key'] ) ) {

			return $response['Key'];
		} else {
			return false;
		}
	}

	/**
	 * Update API key
	 *
	 * @param string $id id of key.
	 * @param string $name key name.
	 * @param string $host website host.
	 * @return bool|mixed
	 */
	public static function api_key_update( $id, $name, $host ) {
		$data = [
			'id' => $id,
			'Name' => $name,
			'Hostname' => $host,
		];
		$response = self::make(
			Adtechmedia_Config::get( 'api_end_point' ) . 'atm-admin/api-gateway-key/update',
			'POST',
			[],
			$data,
			[ 'Key' ]
		);

		if ( $response && isset( $response['Key'] ) ) {

			return $response['Key'];
		} else {
			return false;
		}
	}

	/**
	 * Convert pledged type
	 *
	 * @param string $pledged_type pledged type.
	 * @return string
	 */
	private static function get_pledged_type( $pledged_type ) {
		$types = [
			'transactions' => 'count',
			'pledged currency' => 'amount',
		];
		return $types[ $pledged_type ];
	}

	/**
	 * Convert offset type
	 *
	 * @param string $offset_type offset type.
	 * @return string
	 */
	private static function get_offset_type( $offset_type ) {
		$types = [
			'words' => 'words',
			'paragraphs' => 'elements',
		];
		return $types[ $offset_type ];
	}

	/**
	 * Update property by data array
	 *
	 * @param string $id property id.
	 * @param string $key API key.
	 * @param array  $data array to send as config defaults.
	 * @return array|bool
	 */
	public static function property_update_config_by_array( $id, $key, $data ) {
		if ( empty( $key ) ) {
			return false;
		}
		$data = [
			'Id' => $id,
			'ConfigDefaults' => $data,
		];
		$response = self::make(
			Adtechmedia_Config::get( 'api_end_point' ) . 'atm-admin/property/update-config',
			'PATCH',
			[ 'X-Api-Key' => $key ],
			$data,
			[ 'BuildPath', 'Id' ]
		);
		if ( $response && isset( $response['BuildPath'] ) && isset( $response['Id'] ) ) {

			return [ 'BuildPath' => $response['BuildPath'], 'Id' => $response['Id'] ];
		} else {
			return false;
		}
	}

	/**
	 * Update property
	 *
	 * @param string  $id property id.
	 * @param string  $container container of article.
	 * @param string  $selector elements to hide.
	 * @param integer $price price of page.
	 * @param string  $ads_video ads video.
	 * @param string  $key API key.
	 * @param integer $content_offset offset elements to hide.
	 * @param string  $content_lock lock method.
	 * @param string  $revenue_method evenue method.
	 * @param integer $payment_pledged payment pledged.
	 * @param string  $offset_type offset type.
	 * @param string  $currency currency.
	 * @param string  $pledged_type pledged type.
	 * @return array|bool
	 */
	public static function property_update_config(
		$id,
		$container,
		$selector,
		$price,
		$ads_video,
		$key,
		$content_offset,
		$content_lock,
		$revenue_method,
		$payment_pledged,
		$offset_type,
		$currency,
		$pledged_type
	) {
		if ( empty( $key ) ) {
			return false;
		}
		$data = [
			'Id' => $id,
			'ConfigDefaults' => [
				'content' => [
					'container' => $container,
					'selector' => $selector,
					'offset' => $content_offset,
					'lock' => $content_lock,
					'offsetType' => self::get_offset_type( $offset_type ),
					'authorCb' => 'function(onReady) {
					var fullName = window.WP_ATM_AUTHOR_NAME;
					var avatarUrl = window.WP_ATM_AUTHOR_AVATAR;
					onReady({
						fullName: fullName,
						avatar: avatarUrl,
					});
				}',
				],
				'revenueMethod' => $revenue_method,
				'ads' => [ 'relatedVideoCb' => "function (onReady) { onReady('$ads_video') }" ],

				/*
				'styles' => [
					 'main' => '',
					 'main' => 'LmF0bS10YXJnZXRlZC1jb250YWluZXIgewogIGRpc3BsYXk6IG5vbmU7CiAgdG9wOiA0OHB4OwogIHotaW5kZXg6IDk5OTk7CiAgdHJhbnNpdGlvbjogdG9wIDAuMnMgY3ViaWMtYmV6aWVyKDAsIDEsIDEsIDEpOwogIC13ZWJraXQtdHJhbnNpdGlvbjogdG9wIDAuMnMgY3ViaWMtYmV6aWVyKDAsIDEsIDEsIDEpOyB9CiAgLmF0bS10YXJnZXRlZC1jb250YWluZXIubW9kYWwtc2hvd24gewogICAgZGlzcGxheTogYmxvY2s7IH0KICAucmliYm9uLXZpc2libGUgLmF0bS10YXJnZXRlZC1jb250YWluZXIgewogICAgdG9wOiAxMjlweDsgfQoKLmF0bS10YXJnZXRlZC1tb2RhbCB7CiAgYmFja2dyb3VuZDogI2ZmZjsKICBib3JkZXI6IDFweCBzb2xpZCAjZDNkM2QzOwogIGJvcmRlci1yYWRpdXM6IDlweDsKYm9yZGVyLXRvcC1sZWZ0LXJhZGl1czogMHB4OwogICAgYm9yZGVyLWJvdHRvbS1sZWZ0LXJhZGl1czogMHB4OwogIGJveC1zaXppbmc6IGJvcmRlci1ib3g7CiAgZm9udC1zaXplOiAxNnB4OwogIGZvbnQtZmFtaWx5OiAibnl0LWNoZWx0ZW5oYW0iLCBnZW9yZ2lhLCAidGltZXMgbmV3IHJvbWFuIiwgdGltZXMsIHNlcmlmOyB9CiAgLmF0bS10YXJnZXRlZC1tb2RhbCAuYXRtLWhlYWQtbW9kYWwgLmF0bS1tb2RhbC1ib2R5IHAgewogICAgZm9udC1zaXplOiAxNnB4OwogICAgZm9udC1mYW1pbHk6ICJueXQtY2hlbHRlbmhhbSIsIGdlb3JnaWEsICJ0aW1lcyBuZXcgcm9tYW4iLCB0aW1lcywgc2VyaWY7IH0KICAuYXRtLXRhcmdldGVkLW1vZGFsIC5hdG0taGVhZC1tb2RhbCAuYXRtLW1vZGFsLWJvZHkgLnBheS1oZWxwLWJsb2NrIHAgewogICAgZm9udC1zaXplOiAxNHB4OyB9CiAgICAuYXRtLXRhcmdldGVkLW1vZGFsIC5hdG0taGVhZC1tb2RhbCAuYXRtLW1vZGFsLWJvZHkgLnBheS1oZWxwLWJsb2NrIHAgYSB7CiAgICAgIGZvbnQtc2l6ZTogMTNweDsKICAgICAgZGlzcGxheTogaW5saW5lLWJsb2NrOyB9CiAgLmF0bS10YXJnZXRlZC1tb2RhbCBhIHsKICAgIGNvbG9yOiAjMzI2ODkxOyB9CgouY29udHJpYi1wcmljZSB7CiAgZm9udC1zaXplOiAxNHB4OyB9CgouYXRtLWJhc2UtbW9kYWwgLmF0bS1tYWluIHsKICBmb250LXNpemU6IDE2cHg7CiAgbGluZS1oZWlnaHQ6IDE3cHg7IH0KICAuYXRtLWJhc2UtbW9kYWwgLmF0bS1tYWluIC5wbGVkZ2UtYm90dG9tIHNtYWxsIHsKICAgIGZvbnQtc2l6ZTogMTRweDsgfQoKLmF0bS1idXR0b24gewogIGJhY2tncm91bmQ6ICM2Mjg4YTU7IH0KICAuYXRtLWJ1dHRvbi5wbGVkZ2UtdGFyZ2V0ZWQsIC5hdG0tYnV0dG9uLnJlZnVuZC10YXJnZXRlZCB7CiAgICBiYWNrZ3JvdW5kOiAjNjI4OGE1OyB9CiAgICAuYXRtLWJ1dHRvbi5wbGVkZ2UtdGFyZ2V0ZWQ6aG92ZXIsIC5hdG0tYnV0dG9uLnJlZnVuZC10YXJnZXRlZDpob3ZlciB7CiAgICAgIGJhY2tncm91bmQ6ICM0ZDZlODc7IH0KICAuYXRtLWJ1dHRvbjpob3ZlciB7CiAgICBiYWNrZ3JvdW5kOiAjNGQ2ZTg3OyB9CgoudW5sb2NrLWJ0biB7CiAgYmFja2dyb3VuZDogIzYyODhhNTsKICBmb250LWZhbWlseTogIm55dC1jaGVsdGVuaGFtIiwgZ2VvcmdpYSwgInRpbWVzIG5ldyByb21hbiIsIHRpbWVzLCBzZXJpZjsgfQoudW5sb2NrLWJ0bjpob3ZlciB7CiAgICBjb2xvcjogI2QxZDFkMTsKfQoubW9vZC1ibG9jay1pbmZvIHsKICBmb250LXNpemU6IDE2cHg7CiAgZm9udC1mYW1pbHk6ICJueXQtY2hlbHRlbmhhbSIsIGdlb3JnaWEsICJ0aW1lcyBuZXcgcm9tYW4iLCB0aW1lcywgc2VyaWY7IH0KCi5wYXktaGVscC1zbSwKLmNsb3NlLWNvbm5lY3QgewogIGZvbnQtc2l6ZTogMTNweDsgfQoKLnNoYXJlLWJsb2NrIC5zaGFyZXRvb2xzLW1lbnUgewogIG1hcmdpbi10b3A6IDEwcHg7IH0KCi5zaGFyZS1ibG9jay1pbm5lciAuc2hhcmV0b29sOmxhc3QtY2hpbGQgewogIG1hcmdpbjogMDsgfQouc2hhcmUtYmxvY2staW5uZXIgLnNoYXJldG9vbC5mYWNlYm9vay1zaGFyZXRvb2wgYTpob3ZlciB7CiAgYmFja2dyb3VuZDogIzNCNTk5ODsgfQouc2hhcmUtYmxvY2staW5uZXIgLnNoYXJldG9vbC50d2l0dGVyLXNoYXJldG9vbCBhOmhvdmVyIHsKICBiYWNrZ3JvdW5kOiAjNDA5OUZGOyB9Ci5zaGFyZS1ibG9jay1pbm5lciAuc2hhcmV0b29sLmVtYWlsLXNoYXJldG9vbCBhOmhvdmVyLCAuc2hhcmUtYmxvY2staW5uZXIgLnNoYXJldG9vbC5zaG93LWFsbC1zaGFyZXRvb2wgYTpob3ZlciB7CiAgYmFja2dyb3VuZDogIzY2NjY2NjsgfQouc2hhcmUtYmxvY2staW5uZXIgLnNoYXJldG9vbCBhIHsKICB3aWR0aDogMjVweDsKICBoZWlnaHQ6IDI1cHg7CmRpc3BsYXk6IGJsb2NrOwogIGJhY2tncm91bmQ6IHJnYmEoMCwgMCwgMCwgMC44KTsKICBjb2xvcjogI2ZmZjsKICBib3JkZXItcmFkaXVzOiA1MCU7CiAgdGV4dC1hbGlnbjogY2VudGVyOyB9CiAgLnNoYXJlLWJsb2NrLWlubmVyIC5zaGFyZXRvb2wgYSBpIHsKICAgIGZvbnQtc2l6ZTogMTNweDsgCmxpbmUtaGVpZ2h0OiAyNXB4O30KLmF0bS1iYXNlLW1vZGFsIC5hdG0tbWFpbiAuc2hhcmUtYmxvY2sgLnNoYXJldG9vbHMtbWVudSAuc2hhcmV0b29sIHsKICAgIGRpc3BsYXk6IGlubGluZS1ibG9jazsKfQpAbWVkaWEgKG1heC13aWR0aDogMTY0OXB4KSB7CiAgLmF0bS10YXJnZXRlZC1tb2RhbCB7CiAgICBtYXJnaW4tbGVmdDogLTMwcHg7IH0gfQpAbWVkaWEgKG1heC13aWR0aDogMTI3OXB4KSB7CiAgLmF0bS10YXJnZXRlZC1tb2RhbCB7CiAgICB3aWR0aDogNjYwcHg7IH0gfQpAbWVkaWEgKG1heC13aWR0aDogMTE5OXB4KSB7CiAgLmF0bS10YXJnZXRlZC1tb2RhbCB7CiAgICBtYXJnaW4tbGVmdDogLTE1cHg7IH0gfQpAbWVkaWEgKG1heC13aWR0aDogMTE1NHB4KSB7CiAgLmF0bS10YXJnZXRlZC1tb2RhbCB7CiAgICB3aWR0aDogNjMwcHg7IH0gfQpAbWVkaWEgKG1pbi13aWR0aDogNzY1cHgpIGFuZCAobWF4LXdpZHRoOiAxMDE5cHgpIHsKICAuYXRtLXRhcmdldGVkLW1vZGFsIHsKICAgIHdpZHRoOiA3MDVweDsKICAgIG1hcmdpbi1sZWZ0OiAwOyB9IH0KQG1lZGlhIChtYXgtd2lkdGg6IDc2NHB4KSB7CiAgLmF0bS10YXJnZXRlZC1jb250YWluZXIgewogICAgd2lkdGg6IDEwMCU7IH0KCiAgLmF0bS10YXJnZXRlZC1tb2RhbCB7CiAgICB3aWR0aDogNTQwcHg7CiAgICBtYXJnaW4tbGVmdDogMDsKICAgIGxlZnQ6IDQ1cHggIWltcG9ydGFudDsKICAgIHBvc2l0aW9uOiBhYnNvbHV0ZTsgfSB9CkBtZWRpYSAobWF4LXdpZHRoOiA1OTlweCkgewogIC5hdG0tdGFyZ2V0ZWQtbW9kYWwgewogICAgd2lkdGg6IDEwMCU7CiAgICBsZWZ0OiAwICFpbXBvcnRhbnQ7IH0gfQouYXRtLXRhcmdldGVkLW1vZGFsIC5hdG0taGVhZC1tb2RhbCAuYXRtLW1vZGFsLWhlYWRpbmcgewp3aWR0aDogOTRweDsKaGVpZ2h0OiA0NTBweDsKfQouYXRtLWhlYWQtbW9kYWwgLmF0bS1tb2RhbC1oZWFkaW5nID4gZGl2ewpwb3NpdGlvbjogcmVsYXRpdmU7Cn0KLmF0bS1oZWFkLW1vZGFsIC5hdG0tbW9kYWwtaGVhZGluZyAuYXRtLWhlYWRpbmctaW5mb3sKICAgIHRyYW5zZm9ybTogcm90YXRlKC05MGRlZyk7CiAgICB0cmFuc2Zvcm0tb3JpZ2luOiBsZWZ0IHRvcCAwOwogICAgaGVpZ2h0OiAyMXB4OwogICAgd2lkdGg6IDQyNXB4OwogICAgcG9zaXRpb246IGFic29sdXRlOwogICAgYm90dG9tOiAtMjRweDsKICAgIGRpc3BsYXk6IGlubGluZS10YWJsZTsKbGluZS1oZWlnaHQ6IDIwcHg7CmxlZnQ6IC00cHg7Cn0KLmF0bS1oZWFkLW1vZGFsIC5hdG0tbW9kYWwtaGVhZGluZyAuYXZhdGFyLXNtewpwb3NpdGlvbjogYWJzb2x1dGU7CiAgICB0b3A6IDhweDsKbGVmdDogY2FsYyg1MCUgLSAyNXB4KTsKd2lkdGg6IDUwcHg7CiAgICBoZWlnaHQ6IDUwcHg7CiAgICBkaXNwbGF5OiBpbmxpbmUtdGFibGU7Cn0KLmF0bS1oZWFkLW1vZGFsIC5hdG0tbW9kYWwtaGVhZGluZyAuYXZhdGFyLXNtIC5hdG0tYXZhdGFyLXNtYWxsewogICAgaGVpZ2h0OiBhdXRvOwogICAgd2lkdGg6IGF1dG87Cn0KLmF0bS1oZWFkLW1vZGFsIC5hdG0tbW9kYWwtaGVhZGluZyAuYXZhdGFyLXNtIC5hdG0tYXZhdGFyLXNtYWxsIGltZ3sKICAgIHdpZHRoOiA1MHB4OwogICAgaGVpZ2h0OiA1MHB4OwogICAgYm9yZGVyLXJhZGl1czogNTAlOwp9Ci5hdG0taGVhZC1tb2RhbCAuYXRtLWZvb3RlcnsKd2lkdGg6IDk0cHg7Cn0KCi5hdG0taGVhZC1tb2RhbCAuYXRtLWZvb3RlciAuYXRtLWJ1dHRvbnsKICAgIG1pbi13aWR0aDogODNweDsKICAgIG1hcmdpbi1ib3R0b206IDRweDsKfQouYXRtLWhlYWQtbW9kYWwgLmF0bS1tb2RhbC1oZWFkaW5nIC5mbGV4LXJvdyAuZmxleC1pdGVtLTEudGV4dC1yaWdodHsKICAgIHBvc2l0aW9uOiBhYnNvbHV0ZTsKICAgIHJpZ2h0OiA0cHg7CiAgICBib3R0b206IC0zcHg7CiAgICB0cmFuc2Zvcm06IHJvdGF0ZSgtOTBkZWcpOwp9Ci5hdG0tdGFyZ2V0ZWQtbW9kYWwgLmF0bS1oZWFkLW1vZGFsIC5hdG0tbW9kYWwtYm9keSB7CiAgICB3aWR0aDogNTAwcHg7Cn0KLmF0bS1oZWFkLW1vZGFsIC5hdG0tbW9kYWwtYm9keSAuYXRtLWJhc2UtbW9kYWwgLmF0bS1hdmF0YXIgaW1newp3aWR0aDogOTBweDsKfQouYXRtLWhlYWQtbW9kYWwgLmF0bS1tb2RhbC1ib2R5IC5hdG0tbWFpbiAuYXRtLW9wZW4tbW9kYWx7CnRyYW5zZm9ybTogcm90YXRlKC05MGRlZyk7Cn0KCi5hdG0taGVhZC1tb2RhbCAuYXRtLW1vZGFsLWJvZHkgKyAuYXRtLWZvb3RlcnsKICAgIHdpZHRoOiAxMDAlOwogICAgdGV4dC1hbGlnbjogY2VudGVyOwogICAgcGFkZGluZy10b3A6IDRweDsKfQouYXRtLW5vdGlmaWNhdGlvbnMtY29udGFpbmVyewogICAgei1pbmRleDogNTA7Cn0KLmF0bS1ub3RpZmljYXRpb25zLWNvbnRhaW5lciAubm90aWZpY2F0aW9uIHAgc3BhbnsKbWluLXdpZHRoOiA0OHB4Owp9'
					 'main' => 'LmF0bS10YXJnZXRlZC1jb250YWluZXIgewogIGRpc3BsYXk6IG5vbmU7CiAgdG9wOiA0OHB4OwogIHotaW5kZXg6IDk5OTk7CiAgdHJhbnNpdGlvbjogdG9wIDAuMnMgY3ViaWMtYmV6aWVyKDAsIDEsIDEsIDEpOwogIC13ZWJraXQtdHJhbnNpdGlvbjogdG9wIDAuMnMgY3ViaWMtYmV6aWVyKDAsIDEsIDEsIDEpOyB9CiAgLmF0bS10YXJnZXRlZC1jb250YWluZXIubW9kYWwtc2hvd24gewogICAgZGlzcGxheTogYmxvY2s7IH0KICAucmliYm9uLXZpc2libGUgLmF0bS10YXJnZXRlZC1jb250YWluZXIgewogICAgdG9wOiAxMjlweDsgfQoKLmF0bS10YXJnZXRlZC1tb2RhbCB7CiAgYmFja2dyb3VuZDogI2ZmZjsKICBib3JkZXI6IDFweCBzb2xpZCAjZDNkM2QzOwogIGJvcmRlci1yYWRpdXM6IDAgMCA5cHggOXB4OwogIGJveC1zaXppbmc6IGJvcmRlci1ib3g7CiAgZm9udC1zaXplOiAxNnB4OwogIGZvbnQtZmFtaWx5OiAibnl0LWNoZWx0ZW5oYW0iLCBnZW9yZ2lhLCAidGltZXMgbmV3IHJvbWFuIiwgdGltZXMsIHNlcmlmOyB9CiAgLmF0bS10YXJnZXRlZC1tb2RhbCAuYXRtLWhlYWQtbW9kYWwgLmF0bS1tb2RhbC1ib2R5IHAgewogICAgZm9udC1zaXplOiAxNnB4OwogICAgZm9udC1mYW1pbHk6ICJueXQtY2hlbHRlbmhhbSIsIGdlb3JnaWEsICJ0aW1lcyBuZXcgcm9tYW4iLCB0aW1lcywgc2VyaWY7IH0KICAuYXRtLXRhcmdldGVkLW1vZGFsIC5hdG0taGVhZC1tb2RhbCAuYXRtLW1vZGFsLWJvZHkgLnBheS1oZWxwLWJsb2NrIHAgewogICAgZm9udC1zaXplOiAxNHB4OyB9CiAgICAuYXRtLXRhcmdldGVkLW1vZGFsIC5hdG0taGVhZC1tb2RhbCAuYXRtLW1vZGFsLWJvZHkgLnBheS1oZWxwLWJsb2NrIHAgYSB7CiAgICAgIGZvbnQtc2l6ZTogMTNweDsKICAgICAgZGlzcGxheTogaW5saW5lLWJsb2NrOyB9CiAgLmF0bS10YXJnZXRlZC1tb2RhbCBhIHsKICAgIGNvbG9yOiAjMzI2ODkxOyB9CgouY29udHJpYi1wcmljZSB7CiAgZm9udC1zaXplOiAxNHB4OyB9CgouYXRtLWJhc2UtbW9kYWwgLmF0bS1tYWluIHsKICBmb250LXNpemU6IDE2cHg7CiAgbGluZS1oZWlnaHQ6IDE3cHg7IH0KICAuYXRtLWJhc2UtbW9kYWwgLmF0bS1tYWluIC5wbGVkZ2UtYm90dG9tIHNtYWxsIHsKICAgIGZvbnQtc2l6ZTogMTRweDsgfQoKLmF0bS1idXR0b24gewogIGJhY2tncm91bmQ6ICM2Mjg4YTU7IH0KICAuYXRtLWJ1dHRvbi5wbGVkZ2UtdGFyZ2V0ZWQsIC5hdG0tYnV0dG9uLnJlZnVuZC10YXJnZXRlZCB7CiAgICBiYWNrZ3JvdW5kOiAjNjI4OGE1OyB9CiAgICAuYXRtLWJ1dHRvbi5wbGVkZ2UtdGFyZ2V0ZWQ6aG92ZXIsIC5hdG0tYnV0dG9uLnJlZnVuZC10YXJnZXRlZDpob3ZlciB7CiAgICAgIGJhY2tncm91bmQ6ICM0ZDZlODc7IH0KICAuYXRtLWJ1dHRvbjpob3ZlciB7CiAgICBiYWNrZ3JvdW5kOiAjNGQ2ZTg3OyB9CgoudW5sb2NrLWJ0biB7CiAgYmFja2dyb3VuZDogIzYyODhhNTsKICBmb250LWZhbWlseTogIm55dC1jaGVsdGVuaGFtIiwgZ2VvcmdpYSwgInRpbWVzIG5ldyByb21hbiIsIHRpbWVzLCBzZXJpZjsgfQoudW5sb2NrLWJ0bjpob3ZlciB7CiAgICBjb2xvcjogI2QxZDFkMTsKfQoubW9vZC1ibG9jay1pbmZvIHsKICBmb250LXNpemU6IDE2cHg7CiAgZm9udC1mYW1pbHk6ICJueXQtY2hlbHRlbmhhbSIsIGdlb3JnaWEsICJ0aW1lcyBuZXcgcm9tYW4iLCB0aW1lcywgc2VyaWY7IH0KCi5wYXktaGVscC1zbSwKLmNsb3NlLWNvbm5lY3QgewogIGZvbnQtc2l6ZTogMTNweDsgfQoKLnNoYXJlLWJsb2NrIC5zaGFyZXRvb2xzLW1lbnUgewogIG1hcmdpbi10b3A6IDEwcHg7IH0KCi5zaGFyZS1ibG9jay1pbm5lciAuc2hhcmV0b29sOmxhc3QtY2hpbGQgewogIG1hcmdpbjogMDsgfQouc2hhcmUtYmxvY2staW5uZXIgLnNoYXJldG9vbC5mYWNlYm9vay1zaGFyZXRvb2wgYTpob3ZlciB7CiAgYmFja2dyb3VuZDogIzNCNTk5ODsgfQouc2hhcmUtYmxvY2staW5uZXIgLnNoYXJldG9vbC50d2l0dGVyLXNoYXJldG9vbCBhOmhvdmVyIHsKICBiYWNrZ3JvdW5kOiAjNDA5OUZGOyB9Ci5zaGFyZS1ibG9jay1pbm5lciAuc2hhcmV0b29sLmVtYWlsLXNoYXJldG9vbCBhOmhvdmVyLCAuc2hhcmUtYmxvY2staW5uZXIgLnNoYXJldG9vbC5zaG93LWFsbC1zaGFyZXRvb2wgYTpob3ZlciB7CiAgYmFja2dyb3VuZDogIzY2NjY2NjsgfQouc2hhcmUtYmxvY2staW5uZXIgLnNoYXJldG9vbCBhIHsKICB3aWR0aDogMjVweDsKICBoZWlnaHQ6IDI1cHg7CmRpc3BsYXk6IGJsb2NrOwogIGJhY2tncm91bmQ6IHJnYmEoMCwgMCwgMCwgMC44KTsKICBjb2xvcjogI2ZmZjsKICBib3JkZXItcmFkaXVzOiA1MCU7CiAgdGV4dC1hbGlnbjogY2VudGVyOyB9CiAgLnNoYXJlLWJsb2NrLWlubmVyIC5zaGFyZXRvb2wgYSBpIHsKICAgIGZvbnQtc2l6ZTogMTNweDsgCmxpbmUtaGVpZ2h0OiAyNXB4O30KLmF0bS1iYXNlLW1vZGFsIC5hdG0tbWFpbiAuc2hhcmUtYmxvY2sgLnNoYXJldG9vbHMtbWVudSAuc2hhcmV0b29sIHsKICAgIGRpc3BsYXk6IGlubGluZS1ibG9jazsKfQpAbWVkaWEgKG1heC13aWR0aDogMTY0OXB4KSB7CiAgLmF0bS10YXJnZXRlZC1tb2RhbCB7CiAgICBtYXJnaW4tbGVmdDogLTMwcHg7IH0gfQpAbWVkaWEgKG1heC13aWR0aDogMTE5OXB4KSB7CiAgLmF0bS10YXJnZXRlZC1tb2RhbCB7CiAgICBtYXJnaW4tbGVmdDogLTE1cHg7IH0gfQpAbWVkaWEgKG1heC13aWR0aDogNzY0cHgpIHsKICAuYXRtLXRhcmdldGVkLWNvbnRhaW5lciB7CiAgICB3aWR0aDogMTAwJTsgfQoKICAuYXRtLXRhcmdldGVkLW1vZGFsIHsKICAgIHdpZHRoOiA1NDBweDsKICAgIG1hcmdpbi1sZWZ0OiAwOwogICAgbGVmdDogNDVweCAhaW1wb3J0YW50OwogICAgcG9zaXRpb246IGFic29sdXRlOyB9IH0KQG1lZGlhIChtYXgtd2lkdGg6IDU5OXB4KSB7CiAgLmF0bS10YXJnZXRlZC1tb2RhbCB7CiAgICB3aWR0aDogMTAwJTsKICAgIGxlZnQ6IDAgIWltcG9ydGFudDsgfSB9Ci5hdG0tYmFzZS1tb2RhbCAuYXRtLXNpZGViYXItbGVmdCAuYXRtLWF2YXRhciBpbWcgewp3aWR0aDogOTBweDsKfQouYXRtLXRhcmdldGVkLW1vZGFsIC5hdG0taGVhZC1tb2RhbCAuYXRtLW1vZGFsLWhlYWRpbmcgewpoZWlnaHQ6IGF1dG87CiAgICBwYWRkaW5nOiAzcHggMTBweDsKfQ==',
				],*/

				'payment' => [
					'price' => $price,
					'pledged' => $payment_pledged,
					'currency' => $currency,
					'pledgedType' => self::get_pledged_type( $pledged_type ),
				],

				/*
				'targetModal' => [
					'toggleCb' => 'function(cb) {cb(true);}',
					'targetCb' => "function(modalNode, cb) {
                                    var mainModal=modalNode;
                                    mainModal.mount(document.querySelector('#content-for-atm-modal'), mainModal.constructor.MOUNT_APPEND);
                                    mainModal.rootNode.classList.add('atm-targeted-container');
                                    mainModal.rootNode.style.width = '100%';
                                    cb();
                                    }",
				],*/
			],
		];
		$response = self::make(
			Adtechmedia_Config::get( 'api_end_point' ) . 'atm-admin/property/update-config',
			'PATCH',
			[ 'X-Api-Key' => $key ],
			$data,
			[ 'BuildPath', 'Id' ]
		);
		if ( $response && isset( $response['BuildPath'] ) && isset( $response['Id'] ) ) {

			return [ 'BuildPath' => $response['BuildPath'], 'Id' => $response['Id'] ];
		} else {
			return false;
		}
	}

	/**
	 * Update a property email
	 *
	 * @param string $id property id.
	 * @param string $support_email admin email.
	 * @param string $country country.
	 * @param string $key API key.
	 * @return array|bool
	 */
	public static function property_update( $id, $support_email, $country, $key ) {
		if ( empty( $key ) ) {
			return false;
		}
		$data = [
			'Name' => $id,
			'SupportEmail' => $support_email,
			'Country' => $country,
		];
		$response = self::make(
			Adtechmedia_Config::get( 'api_end_point' ) . 'atm-admin/property/update',
			'POST',
			[ 'X-Api-Key' => $key ],
			$data,
			[ 'BuildPath', 'Id' ]
		);

		if ( $response && isset( $response['BuildPath'] ) && isset( $response['Id'] ) ) {

			return [ 'BuildPath' => $response['BuildPath'], 'Id' => $response['Id'] ];
		} else {
			return false;
		}
	}

	/**
	 * Create a property
	 *
	 * @param string $name property name.
	 * @param string $website website.
	 * @param string $support_email admin email.
	 * @param string $country country.
	 * @param string $key API key.
	 * @return array|bool
	 */
	public static function property_create( $name, $website, $support_email, $country, $key ) {
		if ( empty( $key ) ) {
			return false;
		}
		$data = [
			'Name' => $name,
			'Website' => $website,
			'SupportEmail' => $support_email,
			'Country' => $country,
		];
		$response = self::make(
			Adtechmedia_Config::get( 'api_end_point' ) . 'atm-admin/property/create',
			'PUT',
			[ 'X-Api-Key' => $key ],
			$data,
			[ 'BuildPath', 'Id' ]
		);

		if ( $response && isset( $response['BuildPath'] ) && isset( $response['Id'] ) ) {

			return [ 'BuildPath' => $response['BuildPath'], 'Id' => $response['Id'] ];
		} else {
			return false;
		}
	}

	/**
	 * Make http request
	 *
	 * @param string $url url to request.
	 * @param string $method request method.
	 * @param array  $headers headers.
	 * @param array  $body body.
	 * @param array  $excepted_params params excepted in response.
	 * @return array|bool|mixed|object
	 */
	public static function make( $url, $method = 'GET', $headers = [], $body = [], $excepted_params = [] ) {
		$max_time = ini_get( 'max_execution_time' );
		set_time_limit( 0 );
		$headers = array_merge( [ 'Content-Type' => 'application/json' ], $headers );

		$min_delay = Adtechmedia_Config::get( 'minDelay' );
		$factor = Adtechmedia_Config::get( 'factor' );
		$max_tries = Adtechmedia_Config::get( 'maxTries' );
		$tries = 0;
		$delay = $min_delay;

		if ( 'GET' == $method ) {
			if ( count( $body ) > 0 ) {
				$url .= '?' . http_build_query( $body );
				$body = null;
			}
		} else {
			$body = json_encode( $body );
		}
		while ( $tries < $max_tries ) {

			$response = wp_remote_request(
				$url,
				[ 'method' => $method, 'timeout' => 15, 'headers' => $headers, 'body' => $body ]
			);
			if ( self::check_response( $response, $excepted_params ) ) {
				set_time_limit( $max_time );
				return json_decode( $response['body'], true );
			}
			$tries++;
			$delay *= $factor;
			usleep( $delay );
		}
		set_time_limit( $max_time );
		return false;
	}

	/**
	 * Check response in fine
	 *
	 * @param array $response response.
	 * @param array $params params excepted in response.
	 * @return bool
	 */
	private static function check_response( $response, $params ) {
		if ( is_wp_error( $response ) ) {
			return false;
		}
		if ( isset( $response['body'] ) ) {
			$body = json_decode( $response['body'], true );
		} else {
			return false;
		}
		foreach ( $params as $key ) {
			if ( ! isset( $body[ $key ] ) ) {
				return false;
			}
		}
		return true;
	}
}
