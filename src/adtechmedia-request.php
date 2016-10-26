<?php

/**
 * Created by PhpStorm.
 * User: yama_gs
 * Date: 13.10.2016
 * Time: 14:50
 */
class Adtechmedia_Request {

	/**
	 * @param $content_id
	 * @param $property_id
	 * @param $content
	 * @param $key
	 * @return bool|mixed
	 */
	public static function content_create( $content_id, $property_id, $content, $key ) {
		if (empty($key)) {
			return false;
		}
		$data = [
			"ContentId" => $content_id,
			"PropertyId" => $property_id,
			"Content" => $content,
		];
		$response = self::make(
			Adtechmedia_Config::get( 'api_end_point' ) . 'atm-admin/content/create',
			'PUT',
			[ 'X-Api-Key' => $key ],
			$data,
			[ 'Id' ]
		);

		if ($response && isset($response['Id'])) {
			return $response['Id'];
		} else {
			return false;
		}
	}

	/**
	 * @param $content_id
	 * @param $property_id
	 * @param $scramble_strategy
	 * @param $offset_type
	 * @param $offset_element_selector
	 * @param $offset
	 * @param $key
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
		if (empty($key)) {
			return false;
		}
		$data = [
			"ContentId" => $content_id,
			"PropertyId" => $property_id,
			"ScrambleStrategy" => $scramble_strategy,
			"OffsetType" => $offset_type,
			"OffsetElementSelector" => $offset_element_selector,
			"Offset" => $offset,
		];
		$response = self::make(
			Adtechmedia_Config::get( 'api_end_point' ) . 'atm-admin/content/retrieve',
			'GET',
			[ 'X-Api-Key' => $key ],
			$data,
			[ 'Content' ]
		);

		if ($response && isset($response['Content'])) {
			return $response['Content'];
		} else {
			return false;
		}
	}

	public static function get_countries_list( $key ) {
		if (empty($key)) {
			return false;
		}
		$list = get_transient( 'adtechmedia-supported-countries' );
		if ($list === false) {
			$response = self::make(
				Adtechmedia_Config::get( 'api_end_point' ) . 'atm-admin/property/supported-countries',
				'GET',
				[ 'X-Api-Key' => $key ],
				null,
				[ 'Countries' ]
			);

			if ($response && isset($response['Countries'])) {
				$list = $response['Countries'];
			} else {
				$list = false;
			}
			set_transient( 'adtechmedia-supported-countries', $list, 1 );
		}

		return $list;
	}

	/**
	 * @param $name
	 * @param $host
	 * @return bool|mixed
	 */
	public static function api_key_create( $name, $host ) {
		$data = [
			"Name" => $name,
			"Hostname" => $host,
		];
		$response = self::make(
			Adtechmedia_Config::get( 'api_end_point' ) . 'atm-admin/api-gateway-key/create',
			'PUT',
			[ ],
			$data,
			[ 'Key' ]
		);

		if ($response && isset($response['Key'])) {

			return $response['Key'];
		} else {
			return false;
		}
	}

	/**
	 * @param $id
	 * @param $name
	 * @param $host
	 * @return bool|mixed
	 */
	public static function api_key_update( $id, $name, $host ) {
		$data = [
			"id" => $id,
			"Name" => $name,
			"Hostname" => $host,
		];
		$response = self::make(
			Adtechmedia_Config::get( 'api_end_point' ) . 'atm-admin/api-gateway-key/update',
			'POST',
			[ ],
			$data,
			[ 'Key' ]
		);

		if ($response && isset($response['Key'])) {

			return $response['Key'];
		} else {
			return false;
		}
	}

	private static function get_pledged_type( $pledged_type ) {
		$types = [
			'transactions' => 'count',
			'pledged currency' => 'amount'
		];
		return $types[ $pledged_type ];
	}

	private static function get_offset_type( $offset_type ) {
		$types = [
			'words' => 'words',
			'paragraphs' => 'elements'
		];
		return $types[ $offset_type ];
	}

	/**
	 * @param $id
	 * @param $container
	 * @param $selector
	 * @param $price
	 * @param $author_name
	 * @param $author_avatar
	 * @param $ads_video
	 * @param $key
	 * @param $content_offset
	 * @param $content_lock
	 * @param $revenue_method
	 * @param $payment_pledged
	 * @param $offset_type
	 * @param $currency
	 * @param $pledged_type
	 * @return array|bool
	 */
	public static function property_update(
		$id,
		$container,
		$selector,
		$price,
		$author_name,
		$author_avatar,
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
		if (empty($key)) {
			return false;
		}
		$data = [
			"Id" => $id,
			"ConfigDefaults" => [
				"content" => [
					'container' => $container,
					'selector' => $selector,
					"offset" => $content_offset,
					'lock' => $content_lock,
					"offsetType" => self::get_offset_type( $offset_type ),
					'authorCb' => "function(onReady) {
                    var name = document.querySelector('.entry-footer .author .url');
                    var avatar = document.querySelector('.entry-footer .author img');
					var fullName = name ? name.text : null;
					var avatarUrl = avatar ? avatar.src : null;
					var authorMetadata = {'avatar':avatarUrl};
					onReady({
						fullName: fullName,
						avatar: authorMetadata ? authorMetadata.avatar : 'https://avatars.io/twitter/nytimes',
					});
				}",
				],
				'revenueMethod' => $revenue_method,
				'ads' => [ 'relatedVideoCb' => "function (onReady) { onReady('$ads_video') }" ],
				'styles' => [
					//'main' => 'LmF0bS10YXJnZXRlZC1jb250YWluZXIgewogIGRpc3BsYXk6IG5vbmU7CiAgdG9wOiA0OHB4OwogIHotaW5kZXg6IDk5OTk7CiAgdHJhbnNpdGlvbjogdG9wIDAuMnMgY3ViaWMtYmV6aWVyKDAsIDEsIDEsIDEpOwogIC13ZWJraXQtdHJhbnNpdGlvbjogdG9wIDAuMnMgY3ViaWMtYmV6aWVyKDAsIDEsIDEsIDEpOyB9CiAgLmF0bS10YXJnZXRlZC1jb250YWluZXIubW9kYWwtc2hvd24gewogICAgZGlzcGxheTogYmxvY2s7IH0KICAucmliYm9uLXZpc2libGUgLmF0bS10YXJnZXRlZC1jb250YWluZXIgewogICAgdG9wOiAxMjlweDsgfQoKLmF0bS10YXJnZXRlZC1tb2RhbCB7CiAgYmFja2dyb3VuZDogI2ZmZjsKICBib3JkZXI6IDFweCBzb2xpZCAjZDNkM2QzOwogIGJvcmRlci1yYWRpdXM6IDlweDsKYm9yZGVyLXRvcC1sZWZ0LXJhZGl1czogMHB4OwogICAgYm9yZGVyLWJvdHRvbS1sZWZ0LXJhZGl1czogMHB4OwogIGJveC1zaXppbmc6IGJvcmRlci1ib3g7CiAgZm9udC1zaXplOiAxNnB4OwogIGZvbnQtZmFtaWx5OiAibnl0LWNoZWx0ZW5oYW0iLCBnZW9yZ2lhLCAidGltZXMgbmV3IHJvbWFuIiwgdGltZXMsIHNlcmlmOyB9CiAgLmF0bS10YXJnZXRlZC1tb2RhbCAuYXRtLWhlYWQtbW9kYWwgLmF0bS1tb2RhbC1ib2R5IHAgewogICAgZm9udC1zaXplOiAxNnB4OwogICAgZm9udC1mYW1pbHk6ICJueXQtY2hlbHRlbmhhbSIsIGdlb3JnaWEsICJ0aW1lcyBuZXcgcm9tYW4iLCB0aW1lcywgc2VyaWY7IH0KICAuYXRtLXRhcmdldGVkLW1vZGFsIC5hdG0taGVhZC1tb2RhbCAuYXRtLW1vZGFsLWJvZHkgLnBheS1oZWxwLWJsb2NrIHAgewogICAgZm9udC1zaXplOiAxNHB4OyB9CiAgICAuYXRtLXRhcmdldGVkLW1vZGFsIC5hdG0taGVhZC1tb2RhbCAuYXRtLW1vZGFsLWJvZHkgLnBheS1oZWxwLWJsb2NrIHAgYSB7CiAgICAgIGZvbnQtc2l6ZTogMTNweDsKICAgICAgZGlzcGxheTogaW5saW5lLWJsb2NrOyB9CiAgLmF0bS10YXJnZXRlZC1tb2RhbCBhIHsKICAgIGNvbG9yOiAjMzI2ODkxOyB9CgouY29udHJpYi1wcmljZSB7CiAgZm9udC1zaXplOiAxNHB4OyB9CgouYXRtLWJhc2UtbW9kYWwgLmF0bS1tYWluIHsKICBmb250LXNpemU6IDE2cHg7CiAgbGluZS1oZWlnaHQ6IDE3cHg7IH0KICAuYXRtLWJhc2UtbW9kYWwgLmF0bS1tYWluIC5wbGVkZ2UtYm90dG9tIHNtYWxsIHsKICAgIGZvbnQtc2l6ZTogMTRweDsgfQoKLmF0bS1idXR0b24gewogIGJhY2tncm91bmQ6ICM2Mjg4YTU7IH0KICAuYXRtLWJ1dHRvbi5wbGVkZ2UtdGFyZ2V0ZWQsIC5hdG0tYnV0dG9uLnJlZnVuZC10YXJnZXRlZCB7CiAgICBiYWNrZ3JvdW5kOiAjNjI4OGE1OyB9CiAgICAuYXRtLWJ1dHRvbi5wbGVkZ2UtdGFyZ2V0ZWQ6aG92ZXIsIC5hdG0tYnV0dG9uLnJlZnVuZC10YXJnZXRlZDpob3ZlciB7CiAgICAgIGJhY2tncm91bmQ6ICM0ZDZlODc7IH0KICAuYXRtLWJ1dHRvbjpob3ZlciB7CiAgICBiYWNrZ3JvdW5kOiAjNGQ2ZTg3OyB9CgoudW5sb2NrLWJ0biB7CiAgYmFja2dyb3VuZDogIzYyODhhNTsKICBmb250LWZhbWlseTogIm55dC1jaGVsdGVuaGFtIiwgZ2VvcmdpYSwgInRpbWVzIG5ldyByb21hbiIsIHRpbWVzLCBzZXJpZjsgfQoudW5sb2NrLWJ0bjpob3ZlciB7CiAgICBjb2xvcjogI2QxZDFkMTsKfQoubW9vZC1ibG9jay1pbmZvIHsKICBmb250LXNpemU6IDE2cHg7CiAgZm9udC1mYW1pbHk6ICJueXQtY2hlbHRlbmhhbSIsIGdlb3JnaWEsICJ0aW1lcyBuZXcgcm9tYW4iLCB0aW1lcywgc2VyaWY7IH0KCi5wYXktaGVscC1zbSwKLmNsb3NlLWNvbm5lY3QgewogIGZvbnQtc2l6ZTogMTNweDsgfQoKLnNoYXJlLWJsb2NrIC5zaGFyZXRvb2xzLW1lbnUgewogIG1hcmdpbi10b3A6IDEwcHg7IH0KCi5zaGFyZS1ibG9jay1pbm5lciAuc2hhcmV0b29sOmxhc3QtY2hpbGQgewogIG1hcmdpbjogMDsgfQouc2hhcmUtYmxvY2staW5uZXIgLnNoYXJldG9vbC5mYWNlYm9vay1zaGFyZXRvb2wgYTpob3ZlciB7CiAgYmFja2dyb3VuZDogIzNCNTk5ODsgfQouc2hhcmUtYmxvY2staW5uZXIgLnNoYXJldG9vbC50d2l0dGVyLXNoYXJldG9vbCBhOmhvdmVyIHsKICBiYWNrZ3JvdW5kOiAjNDA5OUZGOyB9Ci5zaGFyZS1ibG9jay1pbm5lciAuc2hhcmV0b29sLmVtYWlsLXNoYXJldG9vbCBhOmhvdmVyLCAuc2hhcmUtYmxvY2staW5uZXIgLnNoYXJldG9vbC5zaG93LWFsbC1zaGFyZXRvb2wgYTpob3ZlciB7CiAgYmFja2dyb3VuZDogIzY2NjY2NjsgfQouc2hhcmUtYmxvY2staW5uZXIgLnNoYXJldG9vbCBhIHsKICB3aWR0aDogMjVweDsKICBoZWlnaHQ6IDI1cHg7CmRpc3BsYXk6IGJsb2NrOwogIGJhY2tncm91bmQ6IHJnYmEoMCwgMCwgMCwgMC44KTsKICBjb2xvcjogI2ZmZjsKICBib3JkZXItcmFkaXVzOiA1MCU7CiAgdGV4dC1hbGlnbjogY2VudGVyOyB9CiAgLnNoYXJlLWJsb2NrLWlubmVyIC5zaGFyZXRvb2wgYSBpIHsKICAgIGZvbnQtc2l6ZTogMTNweDsgCmxpbmUtaGVpZ2h0OiAyNXB4O30KLmF0bS1iYXNlLW1vZGFsIC5hdG0tbWFpbiAuc2hhcmUtYmxvY2sgLnNoYXJldG9vbHMtbWVudSAuc2hhcmV0b29sIHsKICAgIGRpc3BsYXk6IGlubGluZS1ibG9jazsKfQpAbWVkaWEgKG1heC13aWR0aDogMTY0OXB4KSB7CiAgLmF0bS10YXJnZXRlZC1tb2RhbCB7CiAgICBtYXJnaW4tbGVmdDogLTMwcHg7IH0gfQpAbWVkaWEgKG1heC13aWR0aDogMTI3OXB4KSB7CiAgLmF0bS10YXJnZXRlZC1tb2RhbCB7CiAgICB3aWR0aDogNjYwcHg7IH0gfQpAbWVkaWEgKG1heC13aWR0aDogMTE5OXB4KSB7CiAgLmF0bS10YXJnZXRlZC1tb2RhbCB7CiAgICBtYXJnaW4tbGVmdDogLTE1cHg7IH0gfQpAbWVkaWEgKG1heC13aWR0aDogMTE1NHB4KSB7CiAgLmF0bS10YXJnZXRlZC1tb2RhbCB7CiAgICB3aWR0aDogNjMwcHg7IH0gfQpAbWVkaWEgKG1pbi13aWR0aDogNzY1cHgpIGFuZCAobWF4LXdpZHRoOiAxMDE5cHgpIHsKICAuYXRtLXRhcmdldGVkLW1vZGFsIHsKICAgIHdpZHRoOiA3MDVweDsKICAgIG1hcmdpbi1sZWZ0OiAwOyB9IH0KQG1lZGlhIChtYXgtd2lkdGg6IDc2NHB4KSB7CiAgLmF0bS10YXJnZXRlZC1jb250YWluZXIgewogICAgd2lkdGg6IDEwMCU7IH0KCiAgLmF0bS10YXJnZXRlZC1tb2RhbCB7CiAgICB3aWR0aDogNTQwcHg7CiAgICBtYXJnaW4tbGVmdDogMDsKICAgIGxlZnQ6IDQ1cHggIWltcG9ydGFudDsKICAgIHBvc2l0aW9uOiBhYnNvbHV0ZTsgfSB9CkBtZWRpYSAobWF4LXdpZHRoOiA1OTlweCkgewogIC5hdG0tdGFyZ2V0ZWQtbW9kYWwgewogICAgd2lkdGg6IDEwMCU7CiAgICBsZWZ0OiAwICFpbXBvcnRhbnQ7IH0gfQouYXRtLXRhcmdldGVkLW1vZGFsIC5hdG0taGVhZC1tb2RhbCAuYXRtLW1vZGFsLWhlYWRpbmcgewp3aWR0aDogOTRweDsKaGVpZ2h0OiA0NTBweDsKfQouYXRtLWhlYWQtbW9kYWwgLmF0bS1tb2RhbC1oZWFkaW5nID4gZGl2ewpwb3NpdGlvbjogcmVsYXRpdmU7Cn0KLmF0bS1oZWFkLW1vZGFsIC5hdG0tbW9kYWwtaGVhZGluZyAuYXRtLWhlYWRpbmctaW5mb3sKICAgIHRyYW5zZm9ybTogcm90YXRlKC05MGRlZyk7CiAgICB0cmFuc2Zvcm0tb3JpZ2luOiBsZWZ0IHRvcCAwOwogICAgaGVpZ2h0OiAyMXB4OwogICAgd2lkdGg6IDQyNXB4OwogICAgcG9zaXRpb246IGFic29sdXRlOwogICAgYm90dG9tOiAtMjRweDsKICAgIGRpc3BsYXk6IGlubGluZS10YWJsZTsKbGluZS1oZWlnaHQ6IDIwcHg7CmxlZnQ6IC00cHg7Cn0KLmF0bS1oZWFkLW1vZGFsIC5hdG0tbW9kYWwtaGVhZGluZyAuYXZhdGFyLXNtewpwb3NpdGlvbjogYWJzb2x1dGU7CiAgICB0b3A6IDhweDsKbGVmdDogY2FsYyg1MCUgLSAyNXB4KTsKd2lkdGg6IDUwcHg7CiAgICBoZWlnaHQ6IDUwcHg7CiAgICBkaXNwbGF5OiBpbmxpbmUtdGFibGU7Cn0KLmF0bS1oZWFkLW1vZGFsIC5hdG0tbW9kYWwtaGVhZGluZyAuYXZhdGFyLXNtIC5hdG0tYXZhdGFyLXNtYWxsewogICAgaGVpZ2h0OiBhdXRvOwogICAgd2lkdGg6IGF1dG87Cn0KLmF0bS1oZWFkLW1vZGFsIC5hdG0tbW9kYWwtaGVhZGluZyAuYXZhdGFyLXNtIC5hdG0tYXZhdGFyLXNtYWxsIGltZ3sKICAgIHdpZHRoOiA1MHB4OwogICAgaGVpZ2h0OiA1MHB4OwogICAgYm9yZGVyLXJhZGl1czogNTAlOwp9Ci5hdG0taGVhZC1tb2RhbCAuYXRtLWZvb3RlcnsKd2lkdGg6IDk0cHg7Cn0KCi5hdG0taGVhZC1tb2RhbCAuYXRtLWZvb3RlciAuYXRtLWJ1dHRvbnsKICAgIG1pbi13aWR0aDogODNweDsKICAgIG1hcmdpbi1ib3R0b206IDRweDsKfQouYXRtLWhlYWQtbW9kYWwgLmF0bS1tb2RhbC1oZWFkaW5nIC5mbGV4LXJvdyAuZmxleC1pdGVtLTEudGV4dC1yaWdodHsKICAgIHBvc2l0aW9uOiBhYnNvbHV0ZTsKICAgIHJpZ2h0OiA0cHg7CiAgICBib3R0b206IC0zcHg7CiAgICB0cmFuc2Zvcm06IHJvdGF0ZSgtOTBkZWcpOwp9Ci5hdG0tdGFyZ2V0ZWQtbW9kYWwgLmF0bS1oZWFkLW1vZGFsIC5hdG0tbW9kYWwtYm9keSB7CiAgICB3aWR0aDogNTAwcHg7Cn0KLmF0bS1oZWFkLW1vZGFsIC5hdG0tbW9kYWwtYm9keSAuYXRtLWJhc2UtbW9kYWwgLmF0bS1hdmF0YXIgaW1newp3aWR0aDogOTBweDsKfQouYXRtLWhlYWQtbW9kYWwgLmF0bS1tb2RhbC1ib2R5IC5hdG0tbWFpbiAuYXRtLW9wZW4tbW9kYWx7CnRyYW5zZm9ybTogcm90YXRlKC05MGRlZyk7Cn0KCi5hdG0taGVhZC1tb2RhbCAuYXRtLW1vZGFsLWJvZHkgKyAuYXRtLWZvb3RlcnsKICAgIHdpZHRoOiAxMDAlOwogICAgdGV4dC1hbGlnbjogY2VudGVyOwogICAgcGFkZGluZy10b3A6IDRweDsKfQouYXRtLW5vdGlmaWNhdGlvbnMtY29udGFpbmVyewogICAgei1pbmRleDogNTA7Cn0KLmF0bS1ub3RpZmljYXRpb25zLWNvbnRhaW5lciAubm90aWZpY2F0aW9uIHAgc3BhbnsKbWluLXdpZHRoOiA0OHB4Owp9'
					'main' => 'LmF0bS10YXJnZXRlZC1jb250YWluZXIgewogIGRpc3BsYXk6IG5vbmU7CiAgdG9wOiA0OHB4OwogIHotaW5kZXg6IDk5OTk7CiAgdHJhbnNpdGlvbjogdG9wIDAuMnMgY3ViaWMtYmV6aWVyKDAsIDEsIDEsIDEpOwogIC13ZWJraXQtdHJhbnNpdGlvbjogdG9wIDAuMnMgY3ViaWMtYmV6aWVyKDAsIDEsIDEsIDEpOyB9CiAgLmF0bS10YXJnZXRlZC1jb250YWluZXIubW9kYWwtc2hvd24gewogICAgZGlzcGxheTogYmxvY2s7IH0KICAucmliYm9uLXZpc2libGUgLmF0bS10YXJnZXRlZC1jb250YWluZXIgewogICAgdG9wOiAxMjlweDsgfQoKLmF0bS10YXJnZXRlZC1tb2RhbCB7CiAgYmFja2dyb3VuZDogI2ZmZjsKICBib3JkZXI6IDFweCBzb2xpZCAjZDNkM2QzOwogIGJvcmRlci1yYWRpdXM6IDAgMCA5cHggOXB4OwogIGJveC1zaXppbmc6IGJvcmRlci1ib3g7CiAgZm9udC1zaXplOiAxNnB4OwogIGZvbnQtZmFtaWx5OiAibnl0LWNoZWx0ZW5oYW0iLCBnZW9yZ2lhLCAidGltZXMgbmV3IHJvbWFuIiwgdGltZXMsIHNlcmlmOyB9CiAgLmF0bS10YXJnZXRlZC1tb2RhbCAuYXRtLWhlYWQtbW9kYWwgLmF0bS1tb2RhbC1ib2R5IHAgewogICAgZm9udC1zaXplOiAxNnB4OwogICAgZm9udC1mYW1pbHk6ICJueXQtY2hlbHRlbmhhbSIsIGdlb3JnaWEsICJ0aW1lcyBuZXcgcm9tYW4iLCB0aW1lcywgc2VyaWY7IH0KICAuYXRtLXRhcmdldGVkLW1vZGFsIC5hdG0taGVhZC1tb2RhbCAuYXRtLW1vZGFsLWJvZHkgLnBheS1oZWxwLWJsb2NrIHAgewogICAgZm9udC1zaXplOiAxNHB4OyB9CiAgICAuYXRtLXRhcmdldGVkLW1vZGFsIC5hdG0taGVhZC1tb2RhbCAuYXRtLW1vZGFsLWJvZHkgLnBheS1oZWxwLWJsb2NrIHAgYSB7CiAgICAgIGZvbnQtc2l6ZTogMTNweDsKICAgICAgZGlzcGxheTogaW5saW5lLWJsb2NrOyB9CiAgLmF0bS10YXJnZXRlZC1tb2RhbCBhIHsKICAgIGNvbG9yOiAjMzI2ODkxOyB9CgouY29udHJpYi1wcmljZSB7CiAgZm9udC1zaXplOiAxNHB4OyB9CgouYXRtLWJhc2UtbW9kYWwgLmF0bS1tYWluIHsKICBmb250LXNpemU6IDE2cHg7CiAgbGluZS1oZWlnaHQ6IDE3cHg7IH0KICAuYXRtLWJhc2UtbW9kYWwgLmF0bS1tYWluIC5wbGVkZ2UtYm90dG9tIHNtYWxsIHsKICAgIGZvbnQtc2l6ZTogMTRweDsgfQoKLmF0bS1idXR0b24gewogIGJhY2tncm91bmQ6ICM2Mjg4YTU7IH0KICAuYXRtLWJ1dHRvbi5wbGVkZ2UtdGFyZ2V0ZWQsIC5hdG0tYnV0dG9uLnJlZnVuZC10YXJnZXRlZCB7CiAgICBiYWNrZ3JvdW5kOiAjNjI4OGE1OyB9CiAgICAuYXRtLWJ1dHRvbi5wbGVkZ2UtdGFyZ2V0ZWQ6aG92ZXIsIC5hdG0tYnV0dG9uLnJlZnVuZC10YXJnZXRlZDpob3ZlciB7CiAgICAgIGJhY2tncm91bmQ6ICM0ZDZlODc7IH0KICAuYXRtLWJ1dHRvbjpob3ZlciB7CiAgICBiYWNrZ3JvdW5kOiAjNGQ2ZTg3OyB9CgoudW5sb2NrLWJ0biB7CiAgYmFja2dyb3VuZDogIzYyODhhNTsKICBmb250LWZhbWlseTogIm55dC1jaGVsdGVuaGFtIiwgZ2VvcmdpYSwgInRpbWVzIG5ldyByb21hbiIsIHRpbWVzLCBzZXJpZjsgfQoudW5sb2NrLWJ0bjpob3ZlciB7CiAgICBjb2xvcjogI2QxZDFkMTsKfQoubW9vZC1ibG9jay1pbmZvIHsKICBmb250LXNpemU6IDE2cHg7CiAgZm9udC1mYW1pbHk6ICJueXQtY2hlbHRlbmhhbSIsIGdlb3JnaWEsICJ0aW1lcyBuZXcgcm9tYW4iLCB0aW1lcywgc2VyaWY7IH0KCi5wYXktaGVscC1zbSwKLmNsb3NlLWNvbm5lY3QgewogIGZvbnQtc2l6ZTogMTNweDsgfQoKLnNoYXJlLWJsb2NrIC5zaGFyZXRvb2xzLW1lbnUgewogIG1hcmdpbi10b3A6IDEwcHg7IH0KCi5zaGFyZS1ibG9jay1pbm5lciAuc2hhcmV0b29sOmxhc3QtY2hpbGQgewogIG1hcmdpbjogMDsgfQouc2hhcmUtYmxvY2staW5uZXIgLnNoYXJldG9vbC5mYWNlYm9vay1zaGFyZXRvb2wgYTpob3ZlciB7CiAgYmFja2dyb3VuZDogIzNCNTk5ODsgfQouc2hhcmUtYmxvY2staW5uZXIgLnNoYXJldG9vbC50d2l0dGVyLXNoYXJldG9vbCBhOmhvdmVyIHsKICBiYWNrZ3JvdW5kOiAjNDA5OUZGOyB9Ci5zaGFyZS1ibG9jay1pbm5lciAuc2hhcmV0b29sLmVtYWlsLXNoYXJldG9vbCBhOmhvdmVyLCAuc2hhcmUtYmxvY2staW5uZXIgLnNoYXJldG9vbC5zaG93LWFsbC1zaGFyZXRvb2wgYTpob3ZlciB7CiAgYmFja2dyb3VuZDogIzY2NjY2NjsgfQouc2hhcmUtYmxvY2staW5uZXIgLnNoYXJldG9vbCBhIHsKICB3aWR0aDogMjVweDsKICBoZWlnaHQ6IDI1cHg7CmRpc3BsYXk6IGJsb2NrOwogIGJhY2tncm91bmQ6IHJnYmEoMCwgMCwgMCwgMC44KTsKICBjb2xvcjogI2ZmZjsKICBib3JkZXItcmFkaXVzOiA1MCU7CiAgdGV4dC1hbGlnbjogY2VudGVyOyB9CiAgLnNoYXJlLWJsb2NrLWlubmVyIC5zaGFyZXRvb2wgYSBpIHsKICAgIGZvbnQtc2l6ZTogMTNweDsgCmxpbmUtaGVpZ2h0OiAyNXB4O30KLmF0bS1iYXNlLW1vZGFsIC5hdG0tbWFpbiAuc2hhcmUtYmxvY2sgLnNoYXJldG9vbHMtbWVudSAuc2hhcmV0b29sIHsKICAgIGRpc3BsYXk6IGlubGluZS1ibG9jazsKfQpAbWVkaWEgKG1heC13aWR0aDogMTY0OXB4KSB7CiAgLmF0bS10YXJnZXRlZC1tb2RhbCB7CiAgICBtYXJnaW4tbGVmdDogLTMwcHg7IH0gfQpAbWVkaWEgKG1heC13aWR0aDogMTE5OXB4KSB7CiAgLmF0bS10YXJnZXRlZC1tb2RhbCB7CiAgICBtYXJnaW4tbGVmdDogLTE1cHg7IH0gfQpAbWVkaWEgKG1heC13aWR0aDogNzY0cHgpIHsKICAuYXRtLXRhcmdldGVkLWNvbnRhaW5lciB7CiAgICB3aWR0aDogMTAwJTsgfQoKICAuYXRtLXRhcmdldGVkLW1vZGFsIHsKICAgIHdpZHRoOiA1NDBweDsKICAgIG1hcmdpbi1sZWZ0OiAwOwogICAgbGVmdDogNDVweCAhaW1wb3J0YW50OwogICAgcG9zaXRpb246IGFic29sdXRlOyB9IH0KQG1lZGlhIChtYXgtd2lkdGg6IDU5OXB4KSB7CiAgLmF0bS10YXJnZXRlZC1tb2RhbCB7CiAgICB3aWR0aDogMTAwJTsKICAgIGxlZnQ6IDAgIWltcG9ydGFudDsgfSB9Ci5hdG0tYmFzZS1tb2RhbCAuYXRtLXNpZGViYXItbGVmdCAuYXRtLWF2YXRhciBpbWcgewp3aWR0aDogOTBweDsKfQouYXRtLXRhcmdldGVkLW1vZGFsIC5hdG0taGVhZC1tb2RhbCAuYXRtLW1vZGFsLWhlYWRpbmcgewpoZWlnaHQ6IGF1dG87CiAgICBwYWRkaW5nOiAzcHggMTBweDsKfQ=='
				],
				"payment" => [
					"price" => $price,
					"pledged" => $payment_pledged,
					"currency" => $currency,
					"pledgedType" => self::get_pledged_type( $pledged_type ),
				],
				/*"templates"=>[
					"modalComponent"=>"PGRpdiBjbGFzcz0iYXRtLXRhcmdldGVkLW1vZGFsIj4KICAgIDxzbG90IG5hbWU9ImNvbnRlbnQiPgogICAgICAgIDxkaXYgY2xhc3M9ImF0bS1ub3RpZmljYXRpb25zLWNvbnRhaW5lciI+CiAgICAgICAgICAgIDxub3RpZmljYXRpb25zPjwvbm90aWZpY2F0aW9ucz4KICAgICAgICA8L2Rpdj4KICAgICAgICA8ZGl2IGNsYXNzPSJhdG0taGVhZC1tb2RhbCI+CiAgICAgICAgICAgIDxkaXYgdi1pZj0iIXNob3dNb2RhbEJvZHkgfHwgc21hbGwiIGNsYXNzPSJhdG0tbW9kYWwtaGVhZGluZyI+CiAgICAgICAgICAgICAgICA8ZGl2IGNsYXNzPSJmbGV4LXJvdyBhbGlnbi1jZW50ZXIiPgogICAgICAgICAgICAgICAgICAgIDxkaXYgY2xhc3M9ImZsZXgtaXRlbS0xIGF2YXRhci1zbSI+CiAgICAgICAgICAgICAgICAgICAgICAgIDxhdXRob3Igc21hbGw9InRydWUiIHYtYmluZDphdXRob3I9ImF1dGhvciI+PC9hdXRob3I+CiAgICAgICAgICAgICAgICAgICAgPC9kaXY+CiAgICAgICAgICAgICAgICAgICAgPGRpdiB2LWJpbmQ6Y2xhc3M9IlsgJ2F0bS1oZWFkaW5nLWluZm8nLCB7ICdmbGV4LWl0ZW0tMTAnOiAhc21hbGwsICdmbGV4LWl0ZW0tMTEnOiBzbWFsbCB9IF0iPgogICAgICAgICAgICAgICAgICAgICAgICA8c2xvdCBuYW1lPSJoZWFkaW5nIj48L3Nsb3Q+CiAgICAgICAgICAgICAgICAgICAgPC9kaXY+CiAgICAgICAgICAgICAgICAgICAgPGRpdiB2LWlmPSIhc21hbGwgJiYgIXNob3dNb2RhbEJvZHkiIGNsYXNzPSJmbGV4LWl0ZW0tMSB0ZXh0LXJpZ2h0Ij4KICAgICAgICAgICAgICAgICAgICAgICAgPGkgdi1vbjpjbGljay5zdG9wLnByZXZlbnQ9InNob3dNb2RhbEJvZHkgPSAhc2hvd01vZGFsQm9keSIgY2xhc3M9ImF0bS1vcGVuLW1vZGFsIGF0bS1vcGVuLW1vZGFsLWFjdGlvbiBmYSBmYS1hbmdsZS1jaXJjbGVkLWRvd24iIGFyaWEtaGlkZGVuPSJ0cnVlIj48L2k+CiAgICAgICAgICAgICAgICAgICAgPC9kaXY+CiAgICAgICAgICAgICAgICA8L2Rpdj4KICAgICAgICAgICAgPC9kaXY+CiAgICAgICAgICAgIDxkaXYgdi1pZj0ic2hvd01vZGFsQm9keSAmJiAhc21hbGwiIGNsYXNzPSJhdG0tbW9kYWwtYm9keSI+CiAgICAgICAgICAgICAgICA8ZGl2IGNsYXNzPSJhdG0tYmFzZS1tb2RhbCI+CiAgICAgICAgICAgICAgICAgICAgPGRpdiBjbGFzcz0iYXRtLXNpZGViYXItbGVmdCI+CiAgICAgICAgICAgICAgICAgICAgICAgIDxzbG90IG5hbWU9InNpZGViYXJMZWZ0Ij4KICAgICAgICAgICAgICAgICAgICAgICAgICAgIDxhdXRob3Igdi1iaW5kOmF1dGhvcj0iYXV0aG9yIj48L2F1dGhvcj4KICAgICAgICAgICAgICAgICAgICAgICAgPC9zbG90PgogICAgICAgICAgICAgICAgICAgIDwvZGl2PgogICAgICAgICAgICAgICAgICAgIDxkaXYgY2xhc3M9ImF0bS1tYWluIj4KICAgICAgICAgICAgICAgICAgICAgICAgPHNsb3QgbmFtZT0ibWFpbiI+PC9zbG90PgogICAgICAgICAgICAgICAgICAgIDwvZGl2PgogICAgICAgICAgICAgICAgICAgIDxkaXYgY2xhc3M9ImF0bS1wYXkgYXRtLW1haW4tYWRkaXRpb24iPgogICAgICAgICAgICAgICAgICAgICAgICA8c2xvdCBuYW1lPSJhZGRpdGlvbiI+PC9zbG90PgogICAgICAgICAgICAgICAgICAgIDwvZGl2PgogICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgPC9kaXY+CiAgICAgICAgICAgIDwvZGl2PgogICAgICAgICAgICA8ZGl2IHYtaWY9IiFub0Zvb3RlciIgY2xhc3M9ImF0bS1mb290ZXIiPgogICAgICAgICAgICAgICAgICAgICAgICA8c2xvdCBuYW1lPSJmb290ZXIiPjwvc2xvdD4KICAgICAgICAgICAgPC9kaXY+CiAgICAgICAgPC9kaXY+CiAgICA8L3Nsb3Q+CjwvZGl2Pgo=",
					"pledgeComponent"=>"PG1vZGFsIHYtYmluZDphdXRob3I9ImF1dGhvciIgdi1iaW5kOnNob3ctbW9kYWwtYm9keS5zeW5jPSJzaG93TW9kYWxCb2R5Ij4KICAgIDx0ZW1wbGF0ZSBzbG90PSJoZWFkaW5nIj4KICAgICAgICBTdXBwb3J0IHF1YWxpdHkgam91cm5hbGlzbS4KICAgICAgICA8YnV0dG9uIHYtaWY9IjAgJiYgY29uZmlnLl9taWNyb3BheW1lbnRzIiB2LW9uOmNsaWNrLnN0b3AucHJldmVudD0icGxlZGdlKCkiIHYtYmluZDpkaXNhYmxlZD0icGxlZGdlRGlzYWJsZWQiIGNsYXNzPSJhdG0tYnV0dG9uIHBsZWRnZS10YXJnZXRlZCI+CiAgICAgICAgICAgIDxpIHYtYmluZDpjbGFzcz0iWyAnZmEnLCB7ICdmYS1vayc6ICFwbGVkZ2VJblByb2dyZXNzLCAnZmEtc3Bpbic6IHBsZWRnZUluUHJvZ3Jlc3MsICdmYS1jaXJjbGUtbm90Y2gnOiBwbGVkZ2VJblByb2dyZXNzIH0gXSIgYXJpYS1oaWRkZW49InRydWUiPjwvaT4gcGxlZGdlIHt7IGNvbmZpZy5wYXltZW50LnByaWNlIH19JmNlbnQ7CiAgICAgICAgPC9idXR0b24+CiAgICAgICAgb3IKICAgICAgICA8YnV0dG9uIHYtaWY9IjAgJiYgY29uZmlnLl9hZHZlcnRpc2luZyIgdi1vbjpjbGljay5zdG9wLnByZXZlbnQ9InNob3dBZCgpIiBjbGFzcz0iYXRtLWJ1dHRvbiBzaG93LWFkIj4KICAgICAgICAgICAgPGkgY2xhc3M9ImZhIGZhLXBsYXkiIGFyaWEtaGlkZGVuPSJ0cnVlIj48L2k+IHNob3cgYWQKICAgICAgICA8L2J1dHRvbj4KICAgIDwvdGVtcGxhdGU+CiAgICA8dGVtcGxhdGUgc2xvdD0ibWFpbiI+CiAgICAgICAgPGRpdiBjbGFzcz0iZmxleC1yb3ciPgogICAgICAgICAgICA8ZGl2IGNsYXNzPSJmbGV4LWl0ZW0tMTEiPgogICAgICAgICAgICAgICAgPHA+RGVhciB7eyAodXNlciAmJiB1c2VyLmZ1bGxOYW1lKSA/IHVzZXIuZnVsbE5hbWUgOiAncmVhZGVyJyB9fSw8L3A+CiAgICAgICAgICAgIDwvZGl2PgogICAgICAgICAgICA8ZGl2IGNsYXNzPSJmbGV4LWl0ZW0tMSI+CiAgICAgICAgICAgICAgICA8aSB2LW9uOmNsaWNrLnN0b3AucHJldmVudD0ic2hvd01vZGFsQm9keSA9ICFzaG93TW9kYWxCb2R5IiBjbGFzcz0iYXRtLW9wZW4tbW9kYWwgZmEgZmEtYW5nbGUtY2lyY2xlZC11cCIgYXJpYS1oaWRkZW49InRydWUiPjwvaT4KICAgICAgICAgICAgPC9kaXY+CiAgICAgICAgPC9kaXY+CiAgICAgICAgPGRpdiBjbGFzcz0iZmxleC1yb3ciPgogICAgICAgICAgICA8ZGl2IHYtaWY9ImNvbmZpZy5fbWljcm9wYXltZW50cyAmJiBjb25maWcuX2FkdmVydGlzaW5nIiBjbGFzcz0iZmxleC1pdGVtLTEwIj4KICAgICAgICAgICAgICAgIFBsZWFzZSBzdXBwb3J0IHF1YWxpdHkgam91cm5hbGlzbS4gV291bGQgeW91IHBsZWRnZSB0byBwYXkgYSBzbWFsbCBmZWUgb2YKICAgICAgICAgICAgICAgIDxzcGFuIHYtaWY9ImNvbmZpZy5wYXltZW50LnByaWNlIiBjbGFzcz0iY29udHJpYi1wcmljZSI+e3sgY29uZmlnLnBheW1lbnQucHJpY2UgfX0mY2VudDs8L3NwYW4+IHRvIGNvbnRpbnVlIHJlYWRpbmc/IE9yLCBhcyBhbiBhbHRlcm5hdGl2ZSwgd2F0Y2ggdGhpcyBhZCBhbmQgY29udGludWUgcmVhZGluZyBmb3IgZnJlZS4KICAgICAgICAgICAgPC9kaXY+CiAgICAgICAgICAgIDxkaXYgdi1pZj0iY29uZmlnLl9taWNyb3BheW1lbnRzICYmICFjb25maWcuX2FkdmVydGlzaW5nIiBjbGFzcz0iZmxleC1pdGVtLTEwIj4KICAgICAgICAgICAgICAgIFBsZWFzZSBzdXBwb3J0IHF1YWxpdHkgam91cm5hbGlzbS4gCiAgICAgICAgICAgICAgICBXb3VsZCB5b3UgcGxlZGdlIHRvIHBheSBhIHNtYWxsIGZlZSBvZiAKICAgICAgICAgICAgICAgIDxzcGFuIHYtaWY9ImNvbmZpZy5wYXltZW50LnByaWNlIiBjbGFzcz0iY29udHJpYi1wcmljZSI+e3sgY29uZmlnLnBheW1lbnQucHJpY2UgfX0mY2VudDs8L3NwYW4+IAogICAgICAgICAgICAgICAgdG8gY29udGludWUgcmVhZGluZz8KICAgICAgICAgICAgPC9kaXY+CiAgICAgICAgICAgIDxkaXYgdi1pZj0iY29uZmlnLl9hZHZlcnRpc2luZyAmJiAhY29uZmlnLl9taWNyb3BheW1lbnRzIiBjbGFzcz0iZmxleC1pdGVtLTEwIj4KICAgICAgICAgICAgICAgIFBsZWFzZSBzdXBwb3J0IHF1YWxpdHkgam91cm5hbGlzbS4gV2F0Y2ggdGhpcyBhZCBhbmQgY29udGludWUgcmVhZGluZyBmb3IgZnJlZS4KICAgICAgICAgICAgPC9kaXY+CiAgICAgICAgICAgIDxkaXYgdi1pZj0iY29uZmlnLl9taWNyb3BheW1lbnRzIiBjbGFzcz0iZmxleC1pdGVtLTIgcGxlZGdlLXByaWNlLWJsb2NrIj4KICAgICAgICAgICAgICAgIDxzcGFuIHYtaWY9ImNvbmZpZy5wYXltZW50LnByaWNlIiBjbGFzcz0icGxlZGdlLXByaWNlIj57eyBjb25maWcucGF5bWVudC5wcmljZSB9fSZjZW50Ozwvc3Bhbj4KICAgICAgICAgICAgPC9kaXY+CiAgICAgICAgPC9kaXY+CiAgICAgICAgPGRpdiBjbGFzcz0icGxlZGdlLWJvdHRvbSBjbGVhcmZpeCI+CiAgICAgICAgICAgIDxhdXRoIHYtYmluZDp1c2VyPSJ1c2VyIj48L2F1dGg+CiAgICAgICAgPC9kaXY+CiAgICA8L3RlbXBsYXRlPgogICAgPHRlbXBsYXRlIHNsb3Q9ImZvb3RlciI+CiAgICAgICAgPGJ1dHRvbiB2LWlmPSJjb25maWcuX21pY3JvcGF5bWVudHMiIHYtb246Y2xpY2suc3RvcC5wcmV2ZW50PSJwbGVkZ2UoKSIgdi1iaW5kOmRpc2FibGVkPSJwbGVkZ2VEaXNhYmxlZCIgY2xhc3M9ImF0bS1idXR0b24gcGxlZGdlIj4KICAgICAgICAgICAgPGkgdi1iaW5kOmNsYXNzPSJbICdmYScsIHsgJ2ZhLW9rJzogIXBsZWRnZUluUHJvZ3Jlc3MsICdmYS1zcGluJzogcGxlZGdlSW5Qcm9ncmVzcywgJ2ZhLWNpcmNsZS1ub3RjaCc6IHBsZWRnZUluUHJvZ3Jlc3MgfSBdIiBhcmlhLWhpZGRlbj0idHJ1ZSI+PC9pPiBwbGVkZ2Uge3sgY29uZmlnLnBheW1lbnQucHJpY2UgfX0mY2VudDsKICAgICAgICA8L2J1dHRvbj4KICAgICAgICA8YnV0dG9uIHYtaWY9ImNvbmZpZy5fYWR2ZXJ0aXNpbmciIHYtb246Y2xpY2suc3RvcC5wcmV2ZW50PSJzaG93QWQoKSIgY2xhc3M9ImF0bS1idXR0b24gc2hvdy1hZCI+CiAgICAgICAgICAgIDxpIGNsYXNzPSJmYSBmYS1wbGF5IiBhcmlhLWhpZGRlbj0idHJ1ZSI+PC9pPiBzaG93IGFkCiAgICAgICAgPC9idXR0b24+CiAgICA8L3RlbXBsYXRlPgo8L21vZGFsPgo=",
				],*/
				'targetModal' => [
					'targetCb' => "function(modalNode, cb) {
                                    var mainModal=modalNode;
   
                                    var paragraphSelector = 'p';
                                    var anParagraph = document.querySelector(paragraphSelector);
                                
                                    if (!anParagraph) {
                                      throw new Error('Could not find any paragraph \"' + paragraphSelector + '\"');
                                    }
                                
                                    var contentLeft = document.getElementById('main').offsetLeft;
                                    var topBlock=document.querySelector('.site');
                                    var htmlBlock=document.querySelector('html');
                                    var siteContentBlock=document.querySelector('.site-inner');
                                    var entryContentBlock=document.querySelector('.entry-content');
                                    var contentAreaBlock=document.querySelector('.content-area');
                                    mainModal.mount(document.querySelector('article'), mainModal.constructor.MOUNT_APPEND)
                                    mainModal.rootNode.classList.add('atm-targeted-container');
                                    mainModal.rootNode.style.position = 'fixed';
                                    mainModal.rootNode.style.left = (siteContentBlock.offsetLeft+entryContentBlock.offsetLeft+contentAreaBlock.offsetLeft)+'px';
                                    mainModal.rootNode.style.top = (topBlock.offsetTop+htmlBlock.offsetTop)+'px';
                                    mainModal.rootNode.style.width = (Math.max(entryContentBlock.offsetWidth,515))+'px';
                                
                                    var adjustMarginTop = function (e) {
                                      var modalOffset = document.body.scrollTop > 200;
                                
                                      if (modalOffset) {
                                        mainModal.rootNode.classList.add('modal-shown');
                                      } else {
                                        mainModal.rootNode.classList.remove('modal-shown');
                                      }
                                    };
                               
                                    
                                    document.addEventListener('scroll', adjustMarginTop);
                             
                                
                                    adjustMarginTop(null);
                                
                                    cb();
                                    }",
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
		if ($response && isset($response['BuildPath']) && isset($response['Id'])) {

			return [ 'BuildPath' => $response['BuildPath'], 'Id' => $response['Id'] ];
		} else {
			return false;
		}
	}

	/**
	 * @param $name
	 * @param $website
	 * @param $support_email
	 * @param $country
	 * @param $key
	 * @return array|bool
	 */
	public static function property_create( $name, $website, $support_email, $country, $key ) {
		if (empty($key)) {
			return false;
		}
		$data = [
			"Name" => $name,
			"Website" => $website,
			"SupportEmail" => $support_email,
			"Country" => $country,
		];
		$response = self::make(
			Adtechmedia_Config::get( 'api_end_point' ) . 'atm-admin/property/create',
			'PUT',
			[ 'X-Api-Key' => $key ],
			$data,
			[ 'BuildPath', 'Id' ]
		);


		if ($response && isset($response['BuildPath']) && isset($response['Id'])) {

			return [ 'BuildPath' => $response['BuildPath'], 'Id' => $response['Id'] ];
		} else {
			return false;
		}
	}

	/**
	 * @param $url
	 * @param string $method
	 * @param array $headers
	 * @param array $body
	 * @param array $excepted_params
	 * @return array|bool|mixed|object
	 */
	public static function make( $url, $method = 'GET', $headers = [ ], $body = [ ], $excepted_params = [ ] ) {
		$max_time = ini_get( "max_execution_time" );
		set_time_limit( 0 );
		$headers = array_merge( [ 'Content-Type' => 'application/json' ], $headers );

		$min_delay = Adtechmedia_Config::get( 'minDelay' );
		$factor = Adtechmedia_Config::get( 'factor' );
		$max_tries = Adtechmedia_Config::get( 'maxTries' );
		$tries = 0;
		$delay = $min_delay;

		if ($method == 'GET') {
			if (count( $body ) > 0) {
				$url .= '?' . http_build_query( $body );
				$body = null;
			}
		} else {
			$body = json_encode( $body );
		}
		while ($tries < $max_tries) {

			$response = wp_remote_request(
				$url,
				[ 'method' => $method, 'timeout' => 15, 'headers' => $headers, 'body' => $body ]
			);
			if (self::check_response( $response, $excepted_params )) {
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
	 * @param $response
	 * @param $params
	 * @return bool
	 */
	private static function check_response( $response, $params ) {
		$logfile = plugin_dir_path( __FILE__ ) . '/http_requests_2.txt';//todo remove logging
		$output = "\n\n" . date( 'h:i:s' ) . "\n" . print_r( $response, true ) . "\n";

		file_put_contents( $logfile, $output . PHP_EOL . PHP_EOL, FILE_APPEND );
		if (is_wp_error( $response )) {
			/*if (WP_DEBUG) {
				echo '<pre>' . print_r($response->get_error_message(), true) . '</pre>';
			}*/
			return false;
		}
		if (isset($response['body'])) {
			$body = json_decode( $response['body'], true );
		} else {
			return false;
		}
		foreach ($params as $key) {
			if (!isset($body[ $key ])) {
				return false;
			}
		}
		return true;
	}
}