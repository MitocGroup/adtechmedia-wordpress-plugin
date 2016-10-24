<?php

/**
 * Created by PhpStorm.
 * User: yama_gs
 * Date: 13.10.2016
 * Time: 14:50
 */
class Adtechmedia_Request
{

    /**
     * @param $contentId
     * @param $propertyId
     * @param $content
     * @param $key
     * @return bool|mixed
     */
    public static function contentCreate($contentId, $propertyId, $content, $key)
    {
        $data = [
            "ContentId" => $contentId,
            "PropertyId" => $propertyId,
            "Content" => $content,
        ];
        $response = self::make(
            Adtechmedia_Config::get('api_end_point') . 'atm-admin/content/create',
            'PUT',
            ['X-Api-Key' => $key],
            $data,
            ['Id']
        );

        if ($response && isset($response['Id'])) {
            return $response['Id'];
        } else {
            return false;
        }
    }

    /**
     * @param $contentId
     * @param $propertyId
     * @param $scrambleStrategy
     * @param $offsetType
     * @param $offsetElementSelector
     * @param $offset
     * @param $key
     * @return bool|mixed
     */
    public static function contentRetrieve(
        $contentId,
        $propertyId,
        $scrambleStrategy,
        $offsetType,
        $offsetElementSelector,
        $offset,
        $key
    ) {
        $data = [
            "ContentId" => $contentId,
            "PropertyId" => $propertyId,
            "ScrambleStrategy" => $scrambleStrategy,
            "OffsetType" => $offsetType,
            "OffsetElementSelector" => $offsetElementSelector,
            "Offset" => $offset,
        ];
        $response = self::make(
            Adtechmedia_Config::get('api_end_point') . 'atm-admin/content/retrieve',
            'GET',
            ['X-Api-Key' => $key],
            $data,
            ['Content']
        );

        if ($response && isset($response['Content'])) {
            return $response['Content'];
        } else {
            return false;
        }
    }

    public static function getCountriesList($key)
    {
        $list = get_transient('adtechmedia-supported-countries');
        if ($list === false) {
            $response = self::make(
                Adtechmedia_Config::get('api_end_point') . 'atm-admin/property/supported-countries',
                'GET',
                ['X-Api-Key' => $key],
                null,
                ['Countries']
            );

            if ($response && isset($response['Countries'])) {
                $list = $response['Countries'];
            } else {
                $list = false;
            }
            set_transient('adtechmedia-supported-countries', $list, 3600);
        }

        return $list;
    }

    /**
     * @param $name
     * @param $host
     * @return bool|mixed
     */
    public static function apiKeyCreate($name, $host)
    {
        $data = [
            "Name" => $name,
            "Hostname" => $host,
        ];
        $response = self::make(
            Adtechmedia_Config::get('api_end_point') . 'atm-admin/api-gateway-key/create',
            'PUT',
            [],
            $data,
            ['Key']
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
    public static function apiKeyUpdate($id, $name, $host)
    {
        $data = [
            "id" => $id,
            "Name" => $name,
            "Hostname" => $host,
        ];
        $response = self::make(
            Adtechmedia_Config::get('api_end_point') . 'atm-admin/api-gateway-key/update',
            'POST',
            [],
            $data,
            ['Key']
        );

        if ($response && isset($response['Key'])) {

            return $response['Key'];
        } else {
            return false;
        }
    }

    /**
     * @param $id
     * @param $container
     * @param $selector
     * @param $price
     * @param $authorName
     * @param $authorAvatar
     * @param $adsVideo
     * @param $key
     * @param $contentOffset
     * @param $contentLock
     * @param $revenueMethod
     * @param $paymentPledged
     * @param $offsetType
     * @param $currency
     * @return array|bool
     */
    public static function propertyUpdate(
        $id,
        $container,
        $selector,
        $price,
        $authorName,
        $authorAvatar,
        $adsVideo,
        $key,
        $contentOffset,
        $contentLock,
        $revenueMethod,
        $paymentPledged,
        $offsetType,
        $currency
    ) {

        $data = [
            "Id" => $id,
            "ConfigDefaults" => [
                "content" => [
                    'container' => $container,
                    'selector' => $selector,
                    "offset" => $contentOffset,
                    'lock' => $contentLock,
                    "offsetType" => $offsetType,
                    'authorCb' => "function(onReady) {
					var fullName = '$authorName';
					var authorMetadata = {'avatar':'$authorAvatar'};
					onReady({
						fullName: fullName,
						avatar: authorMetadata ? authorMetadata.avatar : 'https://avatars.io/twitter/nytimes',
					});
				}",
                ],
                'revenueMethod' => $revenueMethod,
                'ads' => ['relatedVideoCb' => "function (onReady) { onReady('$adsVideo') }"],
                'styles' => [
                    'main' => 'LmF0bS10YXJnZXRlZC1jb250YWluZXIgewogIGRpc3BsYXk6IG5vbmU7CiAgdG9wOiA0OHB4OwogIHotaW5kZXg6IDk5OTk7CiAgdHJhbnNpdGlvbjogdG9wIDAuMnMgY3ViaWMtYmV6aWVyKDAsIDEsIDEsIDEpOwogIC13ZWJraXQtdHJhbnNpdGlvbjogdG9wIDAuMnMgY3ViaWMtYmV6aWVyKDAsIDEsIDEsIDEpOyB9CiAgLmF0bS10YXJnZXRlZC1jb250YWluZXIubW9kYWwtc2hvd24gewogICAgZGlzcGxheTogYmxvY2s7IH0KICAucmliYm9uLXZpc2libGUgLmF0bS10YXJnZXRlZC1jb250YWluZXIgewogICAgdG9wOiAxMjlweDsgfQoKLmF0bS10YXJnZXRlZC1tb2RhbCB7CiAgYmFja2dyb3VuZDogI2ZmZjsKICBib3JkZXI6IDFweCBzb2xpZCAjZDNkM2QzOwogIGJvcmRlci1yYWRpdXM6IDlweDsKICB3aWR0aDogNzA1cHg7CiAgYm94LXNpemluZzogYm9yZGVyLWJveDsKICBmb250LXNpemU6IDE2cHg7CiAgZm9udC1mYW1pbHk6ICJueXQtY2hlbHRlbmhhbSIsIGdlb3JnaWEsICJ0aW1lcyBuZXcgcm9tYW4iLCB0aW1lcywgc2VyaWY7IH0KICAuYXRtLXRhcmdldGVkLW1vZGFsIC5hdG0taGVhZC1tb2RhbCAuYXRtLW1vZGFsLWJvZHkgcCB7CiAgICBmb250LXNpemU6IDE2cHg7CiAgICBmb250LWZhbWlseTogIm55dC1jaGVsdGVuaGFtIiwgZ2VvcmdpYSwgInRpbWVzIG5ldyByb21hbiIsIHRpbWVzLCBzZXJpZjsgfQogIC5hdG0tdGFyZ2V0ZWQtbW9kYWwgLmF0bS1oZWFkLW1vZGFsIC5hdG0tbW9kYWwtYm9keSAucGF5LWhlbHAtYmxvY2sgcCB7CiAgICBmb250LXNpemU6IDE0cHg7IH0KICAgIC5hdG0tdGFyZ2V0ZWQtbW9kYWwgLmF0bS1oZWFkLW1vZGFsIC5hdG0tbW9kYWwtYm9keSAucGF5LWhlbHAtYmxvY2sgcCBhIHsKICAgICAgZm9udC1zaXplOiAxM3B4OwogICAgICBkaXNwbGF5OiBpbmxpbmUtYmxvY2s7IH0KICAuYXRtLXRhcmdldGVkLW1vZGFsIGEgewogICAgY29sb3I6ICMzMjY4OTE7IH0KCi5jb250cmliLXByaWNlIHsKICBmb250LXNpemU6IDE0cHg7IH0KCi5hdG0tYmFzZS1tb2RhbCAuYXRtLW1haW4gewogIGZvbnQtc2l6ZTogMTZweDsKICBsaW5lLWhlaWdodDogMTdweDsgfQogIC5hdG0tYmFzZS1tb2RhbCAuYXRtLW1haW4gLnBsZWRnZS1ib3R0b20gc21hbGwgewogICAgZm9udC1zaXplOiAxNHB4OyB9CgouYXRtLWJ1dHRvbiB7CiAgYmFja2dyb3VuZDogIzYyODhhNTsgfQogIC5hdG0tYnV0dG9uLnBsZWRnZS10YXJnZXRlZCwgLmF0bS1idXR0b24ucmVmdW5kLXRhcmdldGVkIHsKICAgIGJhY2tncm91bmQ6ICM2Mjg4YTU7IH0KICAgIC5hdG0tYnV0dG9uLnBsZWRnZS10YXJnZXRlZDpob3ZlciwgLmF0bS1idXR0b24ucmVmdW5kLXRhcmdldGVkOmhvdmVyIHsKICAgICAgYmFja2dyb3VuZDogIzRkNmU4NzsgfQogIC5hdG0tYnV0dG9uOmhvdmVyIHsKICAgIGJhY2tncm91bmQ6ICM0ZDZlODc7IH0KCi51bmxvY2stYnRuIHsKICBiYWNrZ3JvdW5kOiAjNjI4OGE1OwogIGZvbnQtZmFtaWx5OiAibnl0LWNoZWx0ZW5oYW0iLCBnZW9yZ2lhLCAidGltZXMgbmV3IHJvbWFuIiwgdGltZXMsIHNlcmlmOyB9Ci51bmxvY2stYnRuOmhvdmVyIHsKICAgIGNvbG9yOiAjZDFkMWQxOwp9Ci5tb29kLWJsb2NrLWluZm8gewogIGZvbnQtc2l6ZTogMTZweDsKICBmb250LWZhbWlseTogIm55dC1jaGVsdGVuaGFtIiwgZ2VvcmdpYSwgInRpbWVzIG5ldyByb21hbiIsIHRpbWVzLCBzZXJpZjsgfQoKLnBheS1oZWxwLXNtLAouY2xvc2UtY29ubmVjdCB7CiAgZm9udC1zaXplOiAxM3B4OyB9Cgouc2hhcmUtYmxvY2sgLnNoYXJldG9vbHMtbWVudSB7CiAgbWFyZ2luLXRvcDogMTBweDsgfQoKLnNoYXJlLWJsb2NrLWlubmVyIC5zaGFyZXRvb2w6bGFzdC1jaGlsZCB7CiAgbWFyZ2luOiAwOyB9Ci5zaGFyZS1ibG9jay1pbm5lciAuc2hhcmV0b29sLmZhY2Vib29rLXNoYXJldG9vbCBhOmhvdmVyIHsKICBiYWNrZ3JvdW5kOiAjM0I1OTk4OyB9Ci5zaGFyZS1ibG9jay1pbm5lciAuc2hhcmV0b29sLnR3aXR0ZXItc2hhcmV0b29sIGE6aG92ZXIgewogIGJhY2tncm91bmQ6ICM0MDk5RkY7IH0KLnNoYXJlLWJsb2NrLWlubmVyIC5zaGFyZXRvb2wuZW1haWwtc2hhcmV0b29sIGE6aG92ZXIsIC5zaGFyZS1ibG9jay1pbm5lciAuc2hhcmV0b29sLnNob3ctYWxsLXNoYXJldG9vbCBhOmhvdmVyIHsKICBiYWNrZ3JvdW5kOiAjNjY2NjY2OyB9Ci5zaGFyZS1ibG9jay1pbm5lciAuc2hhcmV0b29sIGEgewogIHdpZHRoOiAyNXB4OwogIGhlaWdodDogMjVweDsKZGlzcGxheTogYmxvY2s7CiAgYmFja2dyb3VuZDogcmdiYSgwLCAwLCAwLCAwLjgpOwogIGNvbG9yOiAjZmZmOwogIGJvcmRlci1yYWRpdXM6IDUwJTsKICB0ZXh0LWFsaWduOiBjZW50ZXI7IH0KICAuc2hhcmUtYmxvY2staW5uZXIgLnNoYXJldG9vbCBhIGkgewogICAgZm9udC1zaXplOiAxM3B4OyAKbGluZS1oZWlnaHQ6IDI1cHg7fQouYXRtLWJhc2UtbW9kYWwgLmF0bS1tYWluIC5zaGFyZS1ibG9jayAuc2hhcmV0b29scy1tZW51IC5zaGFyZXRvb2wgewogICAgZGlzcGxheTogaW5saW5lLWJsb2NrOwp9CkBtZWRpYSAobWF4LXdpZHRoOiAxNjQ5cHgpIHsKICAuYXRtLXRhcmdldGVkLW1vZGFsIHsKICAgIG1hcmdpbi1sZWZ0OiAtMzBweDsgfSB9CkBtZWRpYSAobWF4LXdpZHRoOiAxMjc5cHgpIHsKICAuYXRtLXRhcmdldGVkLW1vZGFsIHsKICAgIHdpZHRoOiA2NjBweDsgfSB9CkBtZWRpYSAobWF4LXdpZHRoOiAxMTk5cHgpIHsKICAuYXRtLXRhcmdldGVkLW1vZGFsIHsKICAgIG1hcmdpbi1sZWZ0OiAtMTVweDsgfSB9CkBtZWRpYSAobWF4LXdpZHRoOiAxMTU0cHgpIHsKICAuYXRtLXRhcmdldGVkLW1vZGFsIHsKICAgIHdpZHRoOiA2MzBweDsgfSB9CkBtZWRpYSAobWluLXdpZHRoOiA3NjVweCkgYW5kIChtYXgtd2lkdGg6IDEwMTlweCkgewogIC5hdG0tdGFyZ2V0ZWQtbW9kYWwgewogICAgd2lkdGg6IDcwNXB4OwogICAgbWFyZ2luLWxlZnQ6IDA7IH0gfQpAbWVkaWEgKG1heC13aWR0aDogNzY0cHgpIHsKICAuYXRtLXRhcmdldGVkLWNvbnRhaW5lciB7CiAgICB3aWR0aDogMTAwJTsgfQoKICAuYXRtLXRhcmdldGVkLW1vZGFsIHsKICAgIHdpZHRoOiA1NDBweDsKICAgIG1hcmdpbi1sZWZ0OiAwOwogICAgbGVmdDogNDVweCAhaW1wb3J0YW50OwogICAgcG9zaXRpb246IGFic29sdXRlOyB9IH0KQG1lZGlhIChtYXgtd2lkdGg6IDU5OXB4KSB7CiAgLmF0bS10YXJnZXRlZC1tb2RhbCB7CiAgICB3aWR0aDogMTAwJTsKICAgIGxlZnQ6IDAgIWltcG9ydGFudDsgfSB9Cg=='
                ],
                "payment" => [
                    "price" => $price,
                    "pledged" => $paymentPledged,
                    "currency" => $currency
                ],
                /*'targetModal' => [
                            'targetCb' => "function (mainModal, cb) { ;cb() }"
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
                                
                                    mainModal.mount(document.querySelector('article'), mainModal.constructor.MOUNT_APPEND)
                                    mainModal.rootNode.classList.add('atm-targeted-container');
                                    mainModal.rootNode.style.position = 'fixed';
                                    mainModal.rootNode.style.left = 'calc(50% - 300px)';
                                
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
            Adtechmedia_Config::get('api_end_point') . 'atm-admin/property/update-config',
            'PATCH',
            ['X-Api-Key' => $key],
            $data,
            ['BuildPath', 'Id']
        );

        if ($response && isset($response['BuildPath']) && isset($response['Id'])) {

            return ['BuildPath' => $response['BuildPath'], 'Id' => $response['Id']];
        } else {
            return false;
        }
    }

    /**
     * @param $name
     * @param $website
     * @param $supportEmail
     * @param $country
     * @param $key
     * @return array|bool
     */
    public static function propertyCreate($name, $website, $supportEmail, $country, $key)
    {
        $data = [
            "Name" => $name,
            "Website" => $website,
            "SupportEmail" => $supportEmail,
            "Country" => $country,
        ];
        $response = self::make(
            Adtechmedia_Config::get('api_end_point') . 'atm-admin/property/create',
            'PUT',
            ['X-Api-Key' => $key],
            $data,
            ['BuildPath', 'Id']
        );


        if ($response && isset($response['BuildPath']) && isset($response['Id'])) {

            return ['BuildPath' => $response['BuildPath'], 'Id' => $response['Id']];
        } else {
            return false;
        }
    }

    /**
     * @param $url
     * @param string $method
     * @param array $headers
     * @param array $body
     * @param array $exceptedParams
     * @return array|bool|mixed|object
     */
    public static function make($url, $method = 'GET', $headers = [], $body = [], $exceptedParams = [])
    {
        $headers = array_merge(['Content-Type' => 'application/json'], $headers);

        $minDelay = Adtechmedia_Config::get('minDelay');
        $factor = Adtechmedia_Config::get('factor');
        $maxTries = Adtechmedia_Config::get('maxTries');
        $tries = 0;
        $delay = $minDelay;

        if ($method == 'GET') {
            if (count($body) > 0) {
                $url .= '?' . http_build_query($body);
                $body = null;
            }
        } else {
            $body = json_encode($body);
        }
        while ($tries < $maxTries) {

            $response = wp_remote_request(
                $url,
                ['method' => $method, 'timeout' => 10, 'headers' => $headers, 'body' => $body]
            );
            if (self::checkResponse($response, $exceptedParams)) {
                return json_decode($response['body'], true);
            }
            $tries++;
            $delay *= $factor;
            usleep($delay);
        }
        return false;
    }

    /**
     * @param $response
     * @param $params
     * @return bool
     */
    private static function checkResponse($response, $params)
    {
        //echo '<pre>'.date('h:i:s') . "\n" .  print_r($response). '</pre>';
        if (is_wp_error($response)) {
            /*if (WP_DEBUG) {
                echo '<pre>' . print_r($response->get_error_message(), true) . '</pre>';
            }*/
            return false;
        }
        if (isset($response['body'])) {
            $body = json_decode($response['body'], true);
        } else {
            return false;
        }
        foreach ($params as $key) {
            if (!isset($body[$key])) {
                return false;
            }
        }
        return true;
    }
}