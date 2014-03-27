<?php

namespace Aws\Api\Serializer;

use Aws\Api\Model;
use Aws\Api\Operation;
use Aws\Api\StructureShape;

/**
 * Serializes requests for the REST-JSON protocol.
 * @internal
 */
class RestJson extends Rest
{
    /** @var JsonBody */
    private $jsonFormatter;

    /**
     * @param string   $endpoint      Endpoint to connect to
     * @param Model    $api           Service API description
     * @param JsonBody $jsonFormatter Optional JSON formatter to use
     */
    public function __construct(
        $endpoint,
        Model $api,
        JsonBody $jsonFormatter = null
    ) {
        parent::__construct($endpoint, $api);
        $this->jsonFormatter = $jsonFormatter ?: new JsonBody($api);
    }

    protected function payload(
        Operation $operation,
        $memberName,
        StructureShape $member,
        array $args
    ) {
        return $this->jsonFormatter->build(
            $member,
            isset($args[$memberName]) ? $args[$memberName] : []
        );
    }

    protected function structBody(
        Operation $operation,
        array $bodyMembers
    ) {
        return $this->jsonFormatter->build($operation['input'], $bodyMembers);
    }
}