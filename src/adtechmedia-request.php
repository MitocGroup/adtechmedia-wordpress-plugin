<?php
/**
 * Adtechmedia_Request
 *
 * @category File
 * @package  Adtechmedia_Plugin
 * @author   yamagleb
 */

/**
 * Class Adtechmedia_Request
 */
class Adtechmedia_Request {
	/**
	 * Create content API request
	 *
	 * @param string $property_id id of property.
	 * @param string $type type of decision.
	 * @param array  $data decision content.
	 * @param string $key API key.
	 * @return mixed
	 *
	 * @todo return false by default?
	 */
	public static function br_decide_show( $property_id, $type, $data, $key ) {
		if ( empty( $key ) ) {
			return null;
		}
		$data = [
			'Id' => $property_id,
			'Type' => $type,
			'Data' => $data,
		];
		$result = self::make(
			Adtechmedia_Config::get( 'api_end_point' ) . 'atm-admin/business-rules/decide',
			'GET',
			[ 'X-Api-Key' => $key ],
			$data
		);
		return $result['matched'] ? $result['result'] : true;
	}

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
	 * Get property API request
	 *
	 * @return bool|mixed
	 */
	public static function property_retrieve() {
		$key = Adtechmedia_OptionsManager::get_plugin_option( 'key' );
		$id = Adtechmedia_OptionsManager::get_plugin_option( 'Id' );
		if ( empty( $key ) ) {
			return false;
		}
		return self::make(
			Adtechmedia_Config::get( 'api_end_point' ) . 'atm-admin/property/retrieve',
			'GET',
			[
				'X-Api-Key' => $key,
			],
			[
				'Id' => $id,
			]
		);
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
		$list = get_transient( 'adtechmedia-supported-countries-new' );
		if ( empty( $list ) ) {
			$response = self::make(
				Adtechmedia_Config::get( 'api_end_point' ) . 'atm-admin/property/supported-countries',
				'GET',
				[ 'X-Api-Key' => $key ],
				null,
				[ 'Countries' ]
			);

			if ( $response && isset( $response['Countries'] ) ) {
				$list = $response['Countries'];
				set_transient( 'adtechmedia-supported-countries-new', $list, 3600 * 2 );
			} else {
				$list = [];
			}
		}

		return $list;
	}

	/**
	 * Request an API token
	 *
	 * @param string $email Email address.
	 * @param string $return_template Return template.
	 * @return bool|mixed
	 */
	public static function request_api_token( $email, $return_template ) {
		$data = [
			'Email' => $email,
			'LinkTpl' => $return_template,
		];
		self::make(
			Adtechmedia_Config::get( 'api_end_point' ) . 'deep-account/client/token-send',
			'PUT',
			[],
			$data,
			[]
		);
		return false;
	}

	/**
	 * Exchange API token to key
	 *
	 * @param string $email Email address.
	 * @param string $token Api exchange token.
	 * @return bool|mixed
	 */
	public static function api_token2key( $email, $token ) {
		$data = [
			'Email' => $email,
			'TempToken' => $token,
		];
		$response = self::make(
			Adtechmedia_Config::get( 'api_end_point' ) . 'deep-account/client/token-exchange',
			'GET',
			[],
			$data,
			[ 'apiKey', 'clientId' ]
		);

		if ( $response && isset( $response['apiKey'] ) && isset( $response['clientId'] ) ) {
			return [
				'apiKey' 	 => $response['apiKey'],
				'clientId' => $response['clientId'],
			];
		}
		return false;
	}

	/**
	 * Create API key
	 *
	 * @param string $email Email address.
	 * @return bool|mixed
	 * @throws Error Server error.
	 */
	public static function api_key_create( $email ) {
		$data = [
			'Email' => $email,
		];
		$response = self::make(
			Adtechmedia_Config::get( 'api_end_point' ) . 'deep-account/client/register',
			'POST',
			[],
			$data,
			[]
		);

		if ( $response ) {
			if ( isset( $response['apiKey'] ) && isset( $response['clientId'] ) ) {
				return [
					'apiKey' 	 => $response['apiKey'],
					'clientId' => $response['clientId'],
				];
			} else if ( isset( $response['errorMessage'] ) ) {
				$error = json_decode( $response['errorMessage'], true );
				if ( preg_match( '/UsernameExistsException/i', $error['errorMessage'] ) ) {
					$error['errorMessage'] = sprintf(
						'An existing client found for email "%s". Please login to be able to use the plugin.',
						$email
					);
				}

				throw new Error( $error['errorMessage'] );
			} else {
				throw new Error( 'Missing apiKey or clientId parameters in response' );
			}
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
			'paragraphs' => 'elements', // legacy...
			'elements'	=> 'elements',
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

				'payment' => [
					'price' => $price,
					'pledged' => $payment_pledged,
					'currency' => $currency,
					'pledgedType' => self::get_pledged_type( $pledged_type ),
				],
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
			'Id' => $id,
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
	 * Log http request
	 *
	 * @param string  $url url to request.
	 * @param mixed   $response response.
	 * @param integer $retries retries.
	 */
	protected static function _log_request( $url, $response, $retries ) {
		if ( Adtechmedia_Config::is_localhost() ) {
			// @codingStandardsIgnoreStart
			$log = str_repeat( '-', 20 ) . PHP_EOL;
			$log .= 'URL: ' . $url . PHP_EOL;
			$log .= 'RESPONSE: ' . print_r( $response, true ) . PHP_EOL;
			$log .= 'RETRIES: ' . $retries . PHP_EOL;
			$log .= str_repeat( '-', 20 ) . PHP_EOL;
			$log_file = $_SERVER['DOCUMENT_ROOT'] . '/atm.request.' . date( 'j.n.Y' ) . '.log';
			file_put_contents( $log_file, $log, FILE_APPEND );
			// @codingStandardsIgnoreEnd
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
	 * @param mixed  $json_flags json_decode flags to use.
	 * @return array|bool|mixed|object
	 */
	public static function make( $url, $method = 'GET', $headers = [], $body = [], $excepted_params = [], $json_flags = null ) {
		$max_time = ini_get( 'max_execution_time' );
		set_time_limit( 0 );
		$headers = array_merge( [ 'Content-Type' => 'application/json' ], $headers );

		$min_delay = Adtechmedia_Config::get( 'minDelay' );
		$factor = Adtechmedia_Config::get( 'factor' );
		$max_tries = Adtechmedia_Config::get( 'maxTries' );
		$tries = 0;
		$delay = $min_delay;

		if ( 'GET' === $method ) {
			if ( count( $body ) > 0 ) {
				$url .= '?' . http_build_query( $body );
				$body = null;
			}
		} else {
			if ( null === $json_flags ) {
				$body = wp_json_encode( $body );
			} else {
				$body = wp_json_encode( $body, $json_flags );
			}
		}
		while ( $tries < $max_tries ) {
			$response = wp_remote_request(
				$url,
				[ 'method' => $method, 'timeout' => 150, 'headers' => $headers, 'body' => $body ]
			);

			self::_log_request( $url, $response, $tries );

			if ( isset( $response ) && ! ( $response instanceof WP_Error )
				&& (
					( isset( $response['http_response'] ) && 403 !== $response['http_response']->get_status() ) // >=4.6
					|| ( isset( $response['response'] ) && 403 !== $response['response']['code'] ) // <=4.5
				) && isset( $response['body'] ) ) {

				if ( self::check_response( $response, $excepted_params ) ) {
					set_time_limit( $max_time );
					return json_decode( $response['body'], true );
				}
				return false;
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

	/**
	 * Create theme config
	 *
	 * @param array  $data theme config.
	 * @param string $key API key.
	 *
	 * @return array|bool|mixed|object
	 */
	public static function theme_config_create(
		$data,
		$key
	) {
		$response = self::make(
			Adtechmedia_Config::get( 'api_end_point' ) . 'atm-admin/theme-config/create',
			'PUT',
			[ 'X-Api-Key' => $key ],
			( $data )
		);

		if ( $response ) {
			return $response;
		} else {
			return false;
		}
	}

	/**
	 * Retrieve theme config
	 *
	 * @param string $id user Id.
	 * @param string $theme name.
	 * @param string $key API key.
	 *
	 * @return array|bool|mixed|object
	 */
	public static function theme_config_retrieve(
		$id,
		$theme,
		$key
	) {
		if ( is_null( $id ) ) {
			$data = [
				'Theme' => $theme,
			];
		} elseif ( is_null( $theme ) ) {
			$data = [
				'Id' => $id,
			];
		} else {
			$data = [
				'Id' => $id,
				'Theme' => $theme,
			];
		}

		$response = self::make(
			Adtechmedia_Config::get( 'api_end_point' ) . 'atm-admin/theme-config/retrieve',
			'GET',
			[ 'X-Api-Key' => $key ],
			$data
		);

		if ( $response ) {
			return $response;
		} else {
			return false;
		}
	}

	/**
	 * Update theme config
	 *
	 * @param array  $data theme config.
	 * @param string $key API key.
	 *
	 * @return array|bool|mixed|object
	 */
	public static function theme_config_update(
		$data,
		$key
	) {
		$response = self::make(
			Adtechmedia_Config::get( 'api_end_point' ) . 'atm-admin/theme-config/update',
			'POST',
			[ 'X-Api-Key' => $key ],
			( $data )
		);

		if ( $response ) {
			return $response;
		} else {
			return false;
		}
	}

}
