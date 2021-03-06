<?php

namespace DotykackaPHPApiClient\Service;

use DotykackaPHPApiClient\Object\Tag;
use DotykackaPHPApiClient\Response\Error;
use DotykackaPHPApiClient\ServiceBase;

class TagService extends ServiceBase
{
    /**
     * @param int    $cloudId
     * @param string $tagtype
     * @param Tag    $tag
     *
     * @return Tag|Error
     */
    public function createTag($cloudId, $tagtype, Tag $tag)
    {
        $response = $this->apiClient->sendRequest(
                'POST',
                'api/tag/'.$cloudId.'/'.$tagtype.'/create',
                array(),
                (string) $tag
        );

        if (isset($response['error'])) {
            return new Error($response['error']);
        }

        $responseObject = new Tag($response);

        return $responseObject;
    }

    /**
     * @param int $cloudId
     * @param int $id
     *
     * @return Tag|Error
     */
    public function getTag($cloudId, $id)
    {
        $response = $this->apiClient->sendRequest(
                'GET',
                'api/tag/'.$cloudId.'/'.$id
        );

        if (isset($response['error'])) {
            return new Error($response['error']);
        }

        $responseObject = new Tag($response);

        return $responseObject;
    }

    /**
     * @param int         $cloudId
     * @param int|null    $limit
     * @param int|null    $offset
     * @param string|null $sort
     *
     * @return Tag[]|Error
     */
    public function getAllTagsForCloud($cloudId, $limit = null, $offset = null, $sort = null)
    {
        $params = array(
                'limit'  => $limit,
                'offset' => $offset,
                'sort'   => $sort,
        );

        $response = $this->apiClient->sendRequest(
                'GET',
                'api/tag/'.$cloudId,
                $params
        );

        if (isset($response['error'])) {
            return new Error($response['error']);
        }

        $list = array();

        foreach ($response as $item) {
            $responseObject = new Tag($item);
            $list[] = $responseObject;
        }

        return $list;
    }
}
