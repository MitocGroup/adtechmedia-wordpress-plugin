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
            Adtechmedia_Config::get('api_end_point') . 'atm-admin/content/create',
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
            $data
            ,
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
        $key
    ) {

        $data = [
            "Id" => $id,
            "ConfigDefaults" => [
                "content" => [
                    'container' => $container,
                    'selector' => $selector,
                    'lock' => 'blur+scramble',
                    'authorCb' => "function(onReady) {
					var fullName = '$authorName';
					var authorMetadata = {'avatar':'$authorAvatar'};
					onReady({
						fullName: fullName,
						avatar: authorMetadata ? authorMetadata.avatar : 'https://avatars.io/twitter/nytimes',
					});
				}",
                ],
                'revenueMethod' => 'advertising+micropayments',
                'ads' => ['relatedVideoCb' => "function (onReady) { onReady('$adsVideo') }"],
                'styles' => [
                    'main' => 'LmF0bS10YXJnZXRlZC1jb250YWluZXIgewogIGRpc3BsYXk6IG5vbmU7CiAgdG9wOiA0OHB4OwogIHRyYW5zaXRpb246IHRvcCAwLjJzIGN1YmljLWJlemllcigwLCAxLCAxLCAxKTsKICAtd2Via2l0LXRyYW5zaXRpb246IHRvcCAwLjJzIGN1YmljLWJlemllcigwLCAxLCAxLCAxKTsgfQogIC5hdG0tdGFyZ2V0ZWQtY29udGFpbmVyLm1vZGFsLXNob3duIHsKICAgIGRpc3BsYXk6IGJsb2NrOyB9CiAgLnJpYmJvbi12aXNpYmxlIC5hdG0tdGFyZ2V0ZWQtY29udGFpbmVyIHsKICAgIHRvcDogMTI5cHg7IH0KCi5hdG0tdGFyZ2V0ZWQtbW9kYWwgewogIGJhY2tncm91bmQ6ICNmZmY7CiAgYm9yZGVyOiAxcHggc29saWQgI2QzZDNkMzsKICBib3JkZXItdG9wOiBub25lOwogIGJvcmRlci1yYWRpdXM6IDAgMCA5cHggOXB4OwogIHdpZHRoOiA3MDVweDsKICBib3gtc2l6aW5nOiBib3JkZXItYm94OwogIGZvbnQtc2l6ZTogMTZweDsKICBmb250LWZhbWlseTogIm55dC1jaGVsdGVuaGFtIiwgZ2VvcmdpYSwgInRpbWVzIG5ldyByb21hbiIsIHRpbWVzLCBzZXJpZjsgfQogIC5hdG0tdGFyZ2V0ZWQtbW9kYWwgLmF0bS1oZWFkLW1vZGFsIC5hdG0tbW9kYWwtYm9keSBwIHsKICAgIGZvbnQtc2l6ZTogMTZweDsKICAgIGZvbnQtZmFtaWx5OiAibnl0LWNoZWx0ZW5oYW0iLCBnZW9yZ2lhLCAidGltZXMgbmV3IHJvbWFuIiwgdGltZXMsIHNlcmlmOyB9CiAgLmF0bS10YXJnZXRlZC1tb2RhbCAuYXRtLWhlYWQtbW9kYWwgLmF0bS1tb2RhbC1ib2R5IC5wYXktaGVscC1ibG9jayBwIHsKICAgIGZvbnQtc2l6ZTogMTRweDsgfQogICAgLmF0bS10YXJnZXRlZC1tb2RhbCAuYXRtLWhlYWQtbW9kYWwgLmF0bS1tb2RhbC1ib2R5IC5wYXktaGVscC1ibG9jayBwIGEgewogICAgICBmb250LXNpemU6IDEzcHg7CiAgICAgIGRpc3BsYXk6IGlubGluZS1ibG9jazsgfQogIC5hdG0tdGFyZ2V0ZWQtbW9kYWwgYSB7CiAgICBjb2xvcjogIzMyNjg5MTsgfQoKLmNvbnRyaWItcHJpY2UgewogIGZvbnQtc2l6ZTogMTRweDsgfQoKLmF0bS1iYXNlLW1vZGFsIC5hdG0tbWFpbiB7CiAgZm9udC1zaXplOiAxNnB4OwogIGxpbmUtaGVpZ2h0OiAxN3B4OyB9CiAgLmF0bS1iYXNlLW1vZGFsIC5hdG0tbWFpbiAucGxlZGdlLWJvdHRvbSBzbWFsbCB7CiAgICBmb250LXNpemU6IDE0cHg7IH0KCi5hdG0tYnV0dG9uIHsKICBiYWNrZ3JvdW5kOiAjNjI4OGE1OyB9CiAgLmF0bS1idXR0b24ucGxlZGdlLXRhcmdldGVkLCAuYXRtLWJ1dHRvbi5yZWZ1bmQtdGFyZ2V0ZWQgewogICAgYmFja2dyb3VuZDogIzYyODhhNTsgfQogICAgLmF0bS1idXR0b24ucGxlZGdlLXRhcmdldGVkOmhvdmVyLCAuYXRtLWJ1dHRvbi5yZWZ1bmQtdGFyZ2V0ZWQ6aG92ZXIgewogICAgICBiYWNrZ3JvdW5kOiAjNGQ2ZTg3OyB9CiAgLmF0bS1idXR0b246aG92ZXIgewogICAgYmFja2dyb3VuZDogIzRkNmU4NzsgfQoKLnVubG9jay1idG4gewogIGJhY2tncm91bmQ6ICM2Mjg4YTU7CiAgZm9udC1mYW1pbHk6ICJueXQtY2hlbHRlbmhhbSIsIGdlb3JnaWEsICJ0aW1lcyBuZXcgcm9tYW4iLCB0aW1lcywgc2VyaWY7IH0KCi5tb29kLWJsb2NrLWluZm8gewogIGZvbnQtc2l6ZTogMTZweDsKICBmb250LWZhbWlseTogIm55dC1jaGVsdGVuaGFtIiwgZ2VvcmdpYSwgInRpbWVzIG5ldyByb21hbiIsIHRpbWVzLCBzZXJpZjsgfQoKLnBheS1oZWxwLXNtLAouY2xvc2UtY29ubmVjdCB7CiAgZm9udC1zaXplOiAxM3B4OyB9Cgouc2hhcmUtYmxvY2sgLnNoYXJldG9vbHMtbWVudSB7CiAgbWFyZ2luLXRvcDogMTBweDsgfQoKLnNoYXJlLWJsb2NrLWlubmVyIC5zaGFyZXRvb2w6bGFzdC1jaGlsZCB7CiAgbWFyZ2luOiAwOyB9Ci5zaGFyZS1ibG9jay1pbm5lciAuc2hhcmV0b29sLmZhY2Vib29rLXNoYXJldG9vbCBhOmhvdmVyIHsKICBiYWNrZ3JvdW5kOiAjM0I1OTk4OyB9Ci5zaGFyZS1ibG9jay1pbm5lciAuc2hhcmV0b29sLnR3aXR0ZXItc2hhcmV0b29sIGE6aG92ZXIgewogIGJhY2tncm91bmQ6ICM0MDk5RkY7IH0KLnNoYXJlLWJsb2NrLWlubmVyIC5zaGFyZXRvb2wuZW1haWwtc2hhcmV0b29sIGE6aG92ZXIsIC5zaGFyZS1ibG9jay1pbm5lciAuc2hhcmV0b29sLnNob3ctYWxsLXNoYXJldG9vbCBhOmhvdmVyIHsKICBiYWNrZ3JvdW5kOiAjNjY2NjY2OyB9Ci5zaGFyZS1ibG9jay1pbm5lciAuc2hhcmV0b29sIGEgewogIHdpZHRoOiAyNXB4OwogIGhlaWdodDogMjVweDsKICBiYWNrZ3JvdW5kOiByZ2JhKDAsIDAsIDAsIDAuOCk7CiAgY29sb3I6ICNmZmY7CiAgYm9yZGVyLXJhZGl1czogNTAlOwogIHRleHQtYWxpZ246IGNlbnRlcjsgfQogIC5zaGFyZS1ibG9jay1pbm5lciAuc2hhcmV0b29sIGEgaSB7CiAgICBmb250LXNpemU6IDEzcHg7IH0KCkBtZWRpYSAobWF4LXdpZHRoOiAxNjQ5cHgpIHsKICAuYXRtLXRhcmdldGVkLW1vZGFsIHsKICAgIG1hcmdpbi1sZWZ0OiAtMzBweDsgfSB9CkBtZWRpYSAobWF4LXdpZHRoOiAxMjc5cHgpIHsKICAuYXRtLXRhcmdldGVkLW1vZGFsIHsKICAgIHdpZHRoOiA2NjBweDsgfSB9CkBtZWRpYSAobWF4LXdpZHRoOiAxMTk5cHgpIHsKICAuYXRtLXRhcmdldGVkLW1vZGFsIHsKICAgIG1hcmdpbi1sZWZ0OiAtMTVweDsgfSB9CkBtZWRpYSAobWF4LXdpZHRoOiAxMTU0cHgpIHsKICAuYXRtLXRhcmdldGVkLW1vZGFsIHsKICAgIHdpZHRoOiA2MzBweDsgfSB9CkBtZWRpYSAobWluLXdpZHRoOiA3NjVweCkgYW5kIChtYXgtd2lkdGg6IDEwMTlweCkgewogIC5hdG0tdGFyZ2V0ZWQtbW9kYWwgewogICAgd2lkdGg6IDcwNXB4OwogICAgbWFyZ2luLWxlZnQ6IDA7IH0gfQpAbWVkaWEgKG1heC13aWR0aDogNzY0cHgpIHsKICAuYXRtLXRhcmdldGVkLWNvbnRhaW5lciB7CiAgICB3aWR0aDogMTAwJTsgfQoKICAuYXRtLXRhcmdldGVkLW1vZGFsIHsKICAgIHdpZHRoOiA1NDBweDsKICAgIG1hcmdpbi1sZWZ0OiAwOwogICAgbGVmdDogNDVweCAhaW1wb3J0YW50OwogICAgcG9zaXRpb246IGFic29sdXRlOyB9IH0KQG1lZGlhIChtYXgtd2lkdGg6IDU5OXB4KSB7CiAgLmF0bS10YXJnZXRlZC1tb2RhbCB7CiAgICB3aWR0aDogMTAwJTsKICAgIGxlZnQ6IDAgIWltcG9ydGFudDsgfSB9Cg=='
                ],
                "payment" => [
                    "price" => $price
                ]
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
        while ($tries < $maxTries) {

            if ($method == 'GET') {
                if (count($body) > 0) {
                    $url .= '?' . http_build_query($body);
                    $body = null;
                }
            } else {
                $body = json_encode($body);
            }

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
            if (WP_DEBUG) {
                echo '<pre>' . print_r($response->get_error_message(), true) . '</pre>';
            }
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