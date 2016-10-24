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
     * @param $pledgedType
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
        $currency,
        $pledgedType
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
                'revenueMethod' => $revenueMethod,
                'ads' => ['relatedVideoCb' => "function (onReady) { onReady('$adsVideo') }"],
                'styles' => [
                    'main' => 'LmF0bS10YXJnZXRlZC1jb250YWluZXIgewogIGRpc3BsYXk6IG5vbmU7CiAgdG9wOiA0OHB4OwogIHotaW5kZXg6IDk5OTk7CiAgdHJhbnNpdGlvbjogdG9wIDAuMnMgY3ViaWMtYmV6aWVyKDAsIDEsIDEsIDEpOwogIC13ZWJraXQtdHJhbnNpdGlvbjogdG9wIDAuMnMgY3ViaWMtYmV6aWVyKDAsIDEsIDEsIDEpOyB9CiAgLmF0bS10YXJnZXRlZC1jb250YWluZXIubW9kYWwtc2hvd24gewogICAgZGlzcGxheTogYmxvY2s7IH0KICAucmliYm9uLXZpc2libGUgLmF0bS10YXJnZXRlZC1jb250YWluZXIgewogICAgdG9wOiAxMjlweDsgfQoKLmF0bS10YXJnZXRlZC1tb2RhbCB7CiAgYmFja2dyb3VuZDogI2ZmZjsKICBib3JkZXI6IDFweCBzb2xpZCAjZDNkM2QzOwogIGJvcmRlci1yYWRpdXM6IDlweDsKICBib3gtc2l6aW5nOiBib3JkZXItYm94OwogIGZvbnQtc2l6ZTogMTZweDsKICBmb250LWZhbWlseTogIm55dC1jaGVsdGVuaGFtIiwgZ2VvcmdpYSwgInRpbWVzIG5ldyByb21hbiIsIHRpbWVzLCBzZXJpZjsgfQogIC5hdG0tdGFyZ2V0ZWQtbW9kYWwgLmF0bS1oZWFkLW1vZGFsIC5hdG0tbW9kYWwtYm9keSBwIHsKICAgIGZvbnQtc2l6ZTogMTZweDsKICAgIGZvbnQtZmFtaWx5OiAibnl0LWNoZWx0ZW5oYW0iLCBnZW9yZ2lhLCAidGltZXMgbmV3IHJvbWFuIiwgdGltZXMsIHNlcmlmOyB9CiAgLmF0bS10YXJnZXRlZC1tb2RhbCAuYXRtLWhlYWQtbW9kYWwgLmF0bS1tb2RhbC1ib2R5IC5wYXktaGVscC1ibG9jayBwIHsKICAgIGZvbnQtc2l6ZTogMTRweDsgfQogICAgLmF0bS10YXJnZXRlZC1tb2RhbCAuYXRtLWhlYWQtbW9kYWwgLmF0bS1tb2RhbC1ib2R5IC5wYXktaGVscC1ibG9jayBwIGEgewogICAgICBmb250LXNpemU6IDEzcHg7CiAgICAgIGRpc3BsYXk6IGlubGluZS1ibG9jazsgfQogIC5hdG0tdGFyZ2V0ZWQtbW9kYWwgYSB7CiAgICBjb2xvcjogIzMyNjg5MTsgfQoKLmNvbnRyaWItcHJpY2UgewogIGZvbnQtc2l6ZTogMTRweDsgfQoKLmF0bS1iYXNlLW1vZGFsIC5hdG0tbWFpbiB7CiAgZm9udC1zaXplOiAxNnB4OwogIGxpbmUtaGVpZ2h0OiAxN3B4OyB9CiAgLmF0bS1iYXNlLW1vZGFsIC5hdG0tbWFpbiAucGxlZGdlLWJvdHRvbSBzbWFsbCB7CiAgICBmb250LXNpemU6IDE0cHg7IH0KCi5hdG0tYnV0dG9uIHsKICBiYWNrZ3JvdW5kOiAjNjI4OGE1OyB9CiAgLmF0bS1idXR0b24ucGxlZGdlLXRhcmdldGVkLCAuYXRtLWJ1dHRvbi5yZWZ1bmQtdGFyZ2V0ZWQgewogICAgYmFja2dyb3VuZDogIzYyODhhNTsgfQogICAgLmF0bS1idXR0b24ucGxlZGdlLXRhcmdldGVkOmhvdmVyLCAuYXRtLWJ1dHRvbi5yZWZ1bmQtdGFyZ2V0ZWQ6aG92ZXIgewogICAgICBiYWNrZ3JvdW5kOiAjNGQ2ZTg3OyB9CiAgLmF0bS1idXR0b246aG92ZXIgewogICAgYmFja2dyb3VuZDogIzRkNmU4NzsgfQoKLnVubG9jay1idG4gewogIGJhY2tncm91bmQ6ICM2Mjg4YTU7CiAgZm9udC1mYW1pbHk6ICJueXQtY2hlbHRlbmhhbSIsIGdlb3JnaWEsICJ0aW1lcyBuZXcgcm9tYW4iLCB0aW1lcywgc2VyaWY7IH0KLnVubG9jay1idG46aG92ZXIgewogICAgY29sb3I6ICNkMWQxZDE7Cn0KLm1vb2QtYmxvY2staW5mbyB7CiAgZm9udC1zaXplOiAxNnB4OwogIGZvbnQtZmFtaWx5OiAibnl0LWNoZWx0ZW5oYW0iLCBnZW9yZ2lhLCAidGltZXMgbmV3IHJvbWFuIiwgdGltZXMsIHNlcmlmOyB9CgoucGF5LWhlbHAtc20sCi5jbG9zZS1jb25uZWN0IHsKICBmb250LXNpemU6IDEzcHg7IH0KCi5zaGFyZS1ibG9jayAuc2hhcmV0b29scy1tZW51IHsKICBtYXJnaW4tdG9wOiAxMHB4OyB9Cgouc2hhcmUtYmxvY2staW5uZXIgLnNoYXJldG9vbDpsYXN0LWNoaWxkIHsKICBtYXJnaW46IDA7IH0KLnNoYXJlLWJsb2NrLWlubmVyIC5zaGFyZXRvb2wuZmFjZWJvb2stc2hhcmV0b29sIGE6aG92ZXIgewogIGJhY2tncm91bmQ6ICMzQjU5OTg7IH0KLnNoYXJlLWJsb2NrLWlubmVyIC5zaGFyZXRvb2wudHdpdHRlci1zaGFyZXRvb2wgYTpob3ZlciB7CiAgYmFja2dyb3VuZDogIzQwOTlGRjsgfQouc2hhcmUtYmxvY2staW5uZXIgLnNoYXJldG9vbC5lbWFpbC1zaGFyZXRvb2wgYTpob3ZlciwgLnNoYXJlLWJsb2NrLWlubmVyIC5zaGFyZXRvb2wuc2hvdy1hbGwtc2hhcmV0b29sIGE6aG92ZXIgewogIGJhY2tncm91bmQ6ICM2NjY2NjY7IH0KLnNoYXJlLWJsb2NrLWlubmVyIC5zaGFyZXRvb2wgYSB7CiAgd2lkdGg6IDI1cHg7CiAgaGVpZ2h0OiAyNXB4OwpkaXNwbGF5OiBibG9jazsKICBiYWNrZ3JvdW5kOiByZ2JhKDAsIDAsIDAsIDAuOCk7CiAgY29sb3I6ICNmZmY7CiAgYm9yZGVyLXJhZGl1czogNTAlOwogIHRleHQtYWxpZ246IGNlbnRlcjsgfQogIC5zaGFyZS1ibG9jay1pbm5lciAuc2hhcmV0b29sIGEgaSB7CiAgICBmb250LXNpemU6IDEzcHg7IApsaW5lLWhlaWdodDogMjVweDt9Ci5hdG0tYmFzZS1tb2RhbCAuYXRtLW1haW4gLnNoYXJlLWJsb2NrIC5zaGFyZXRvb2xzLW1lbnUgLnNoYXJldG9vbCB7CiAgICBkaXNwbGF5OiBpbmxpbmUtYmxvY2s7Cn0KQG1lZGlhIChtYXgtd2lkdGg6IDE2NDlweCkgewogIC5hdG0tdGFyZ2V0ZWQtbW9kYWwgewogICAgbWFyZ2luLWxlZnQ6IC0zMHB4OyB9IH0KQG1lZGlhIChtYXgtd2lkdGg6IDEyNzlweCkgewogIC5hdG0tdGFyZ2V0ZWQtbW9kYWwgewogICAgd2lkdGg6IDY2MHB4OyB9IH0KQG1lZGlhIChtYXgtd2lkdGg6IDExOTlweCkgewogIC5hdG0tdGFyZ2V0ZWQtbW9kYWwgewogICAgbWFyZ2luLWxlZnQ6IC0xNXB4OyB9IH0KQG1lZGlhIChtYXgtd2lkdGg6IDExNTRweCkgewogIC5hdG0tdGFyZ2V0ZWQtbW9kYWwgewogICAgd2lkdGg6IDYzMHB4OyB9IH0KQG1lZGlhIChtaW4td2lkdGg6IDc2NXB4KSBhbmQgKG1heC13aWR0aDogMTAxOXB4KSB7CiAgLmF0bS10YXJnZXRlZC1tb2RhbCB7CiAgICB3aWR0aDogNzA1cHg7CiAgICBtYXJnaW4tbGVmdDogMDsgfSB9CkBtZWRpYSAobWF4LXdpZHRoOiA3NjRweCkgewogIC5hdG0tdGFyZ2V0ZWQtY29udGFpbmVyIHsKICAgIHdpZHRoOiAxMDAlOyB9CgogIC5hdG0tdGFyZ2V0ZWQtbW9kYWwgewogICAgd2lkdGg6IDU0MHB4OwogICAgbWFyZ2luLWxlZnQ6IDA7CiAgICBsZWZ0OiA0NXB4ICFpbXBvcnRhbnQ7CiAgICBwb3NpdGlvbjogYWJzb2x1dGU7IH0gfQpAbWVkaWEgKG1heC13aWR0aDogNTk5cHgpIHsKICAuYXRtLXRhcmdldGVkLW1vZGFsIHsKICAgIHdpZHRoOiAxMDAlOwogICAgbGVmdDogMCAhaW1wb3J0YW50OyB9IH0KLmF0bS10YXJnZXRlZC1tb2RhbCAuYXRtLWhlYWQtbW9kYWwgLmF0bS1tb2RhbC1oZWFkaW5nIHsKd2lkdGg6IDEwMHB4OwpoZWlnaHQ6IDUwMHB4Owp9Ci5hdG0tbW9kYWwtaGVhZGluZyA+IGRpdnsKcG9zaXRpb246IHJlbGF0aXZlOwp9Ci5hdG0tbW9kYWwtaGVhZGluZyAuYXRtLWhlYWRpbmctaW5mb3sKICAgIHRyYW5zZm9ybTogcm90YXRlKC05MGRlZyk7CiAgICB0cmFuc2Zvcm0tb3JpZ2luOiBsZWZ0IHRvcCAwOwogICAgaGVpZ2h0OiAyMXB4OwogICAgd2lkdGg6IDQyNXB4OwogICAgcG9zaXRpb246IGFic29sdXRlOwogICAgYm90dG9tOiAwOwogICAgZGlzcGxheTogaW5saW5lLXRhYmxlOwp9Ci5hdG0tbW9kYWwtaGVhZGluZyAuYXZhdGFyLXNtewpwb3NpdGlvbjogYWJzb2x1dGU7CiAgICB0b3A6IDhweDsKfQ=='
                ],
                "payment" => [
                    "price" => $price,
                    "pledged" => $paymentPledged,
                    "currency" => $currency,
                    "pledgedType" => $pledgedType,
                ],
                "templates"=>["modalComponent"=>"PGRpdiBjbGFzcz0iYXRtLXRhcmdldGVkLW1vZGFsIj4KICAgIDxzbG90IG5hbWU9ImNvbnRlbnQiPgogICAgICAgIDxkaXYgY2xhc3M9ImF0bS1ub3RpZmljYXRpb25zLWNvbnRhaW5lciI+CiAgICAgICAgICAgIDxub3RpZmljYXRpb25zPjwvbm90aWZpY2F0aW9ucz4KICAgICAgICA8L2Rpdj4KICAgICAgICA8ZGl2IGNsYXNzPSJhdG0taGVhZC1tb2RhbCI+CiAgICAgICAgICAgIDxkaXYgdi1pZj0iIXNob3dNb2RhbEJvZHkgfHwgc21hbGwiIGNsYXNzPSJhdG0tbW9kYWwtaGVhZGluZyI+CiAgICAgICAgICAgICAgICA8ZGl2IGNsYXNzPSJmbGV4LXJvdyBhbGlnbi1jZW50ZXIiPgogICAgICAgICAgICAgICAgICAgIDxkaXYgY2xhc3M9ImZsZXgtaXRlbS0xIGF2YXRhci1zbSI+CiAgICAgICAgICAgICAgICAgICAgICAgIDxhdXRob3Igc21hbGw9InRydWUiIHYtYmluZDphdXRob3I9ImF1dGhvciI+PC9hdXRob3I+CiAgICAgICAgICAgICAgICAgICAgPC9kaXY+CiAgICAgICAgICAgICAgICAgICAgPGRpdiB2LWJpbmQ6Y2xhc3M9IlsgJ2F0bS1oZWFkaW5nLWluZm8nLCB7ICdmbGV4LWl0ZW0tMTAnOiAhc21hbGwsICdmbGV4LWl0ZW0tMTEnOiBzbWFsbCB9IF0iPgogICAgICAgICAgICAgICAgICAgICAgICA8c2xvdCBuYW1lPSJoZWFkaW5nIj48L3Nsb3Q+CiAgICAgICAgICAgICAgICAgICAgPC9kaXY+CiAgICAgICAgICAgICAgICAgICAgPGRpdiB2LWlmPSIhc21hbGwgJiYgIXNob3dNb2RhbEJvZHkiIGNsYXNzPSJmbGV4LWl0ZW0tMSB0ZXh0LXJpZ2h0Ij4KICAgICAgICAgICAgICAgICAgICAgICAgPGkgdi1vbjpjbGljay5zdG9wLnByZXZlbnQ9InNob3dNb2RhbEJvZHkgPSAhc2hvd01vZGFsQm9keSIgY2xhc3M9ImF0bS1vcGVuLW1vZGFsIGF0bS1vcGVuLW1vZGFsLWFjdGlvbiBmYSBmYS1hbmdsZS1jaXJjbGVkLWRvd24iIGFyaWEtaGlkZGVuPSJ0cnVlIj48L2k+CiAgICAgICAgICAgICAgICAgICAgPC9kaXY+CiAgICAgICAgICAgICAgICA8L2Rpdj4KICAgICAgICAgICAgPC9kaXY+CiAgICAgICAgICAgIDxkaXYgdi1pZj0ic2hvd01vZGFsQm9keSAmJiAhc21hbGwiIGNsYXNzPSJhdG0tbW9kYWwtYm9keSI+CiAgICAgICAgICAgICAgICA8ZGl2IGNsYXNzPSJhdG0tYmFzZS1tb2RhbCI+CiAgICAgICAgICAgICAgICAgICAgPGRpdiBjbGFzcz0iYXRtLXNpZGViYXItbGVmdCI+CiAgICAgICAgICAgICAgICAgICAgICAgIDxzbG90IG5hbWU9InNpZGViYXJMZWZ0Ij4KICAgICAgICAgICAgICAgICAgICAgICAgICAgIDxhdXRob3Igdi1iaW5kOmF1dGhvcj0iYXV0aG9yIj48L2F1dGhvcj4KICAgICAgICAgICAgICAgICAgICAgICAgPC9zbG90PgogICAgICAgICAgICAgICAgICAgIDwvZGl2PgogICAgICAgICAgICAgICAgICAgIDxkaXYgY2xhc3M9ImF0bS1tYWluIj4KICAgICAgICAgICAgICAgICAgICAgICAgPHNsb3QgbmFtZT0ibWFpbiI+PC9zbG90PgogICAgICAgICAgICAgICAgICAgIDwvZGl2PgogICAgICAgICAgICAgICAgICAgIDxkaXYgY2xhc3M9ImF0bS1wYXkgYXRtLW1haW4tYWRkaXRpb24iPgogICAgICAgICAgICAgICAgICAgICAgICA8c2xvdCBuYW1lPSJhZGRpdGlvbiI+PC9zbG90PgogICAgICAgICAgICAgICAgICAgIDwvZGl2PgogICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgPC9kaXY+CiAgICAgICAgICAgIDwvZGl2PgogICAgICAgICAgICA8ZGl2IHYtaWY9IiFub0Zvb3RlciIgY2xhc3M9ImF0bS1mb290ZXIiPgogICAgICAgICAgICAgICAgICAgICAgICA8c2xvdCBuYW1lPSJmb290ZXIiPjwvc2xvdD4KICAgICAgICAgICAgPC9kaXY+CiAgICAgICAgPC9kaXY+CiAgICA8L3Nsb3Q+CjwvZGl2Pgo="],
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