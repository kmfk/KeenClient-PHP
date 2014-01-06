<?php

return array(
    'name'        => 'KeenIO',
    'apiVersion'  => '3.0',
    'operations'  => array(
        'getResources' => array(
            'uri'         => '/',
            'description' => 'Returns the available child resources. Currently, the only child resource is the Projects Resource.',
            'httpMethod'  => 'GET',
            'parameters'  => array(
                'masterKey' => array(
                    'location'    => 'header',
                    'description' => 'The Master Api Key',
                    'sentAs'      => 'Authorization',
                    'pattern'     => '/^([[:alnum:]])+$/',
                    'type'        => 'string',
                    'required'    => true,
                ),
            ),
        ),

        'getProjects' => array(
            'uri'         => 'projects',
            'description' => 'Returns the projects accessible to the API user, as well as links to project sub-resources for discovery.',
            'httpMethod'  => 'GET',
            'parameters'  => array(
                'masterKey' => array(
                    'location'    => 'header',
                    'description' => 'The Master API Key.',
                    'sentAs'      => 'Authorization',
                    'pattern'     => '/^([[:alnum:]])+$/',
                    'type'        => 'string',
                    'required'    => true,
                ),
            ),
        ),

        'getProject' => array(
            'uri'         => 'projects/{projectId}',
            'description' => 'GET returns detailed information about the specific project, as well as links to related resources.',
            'httpMethod'  => 'GET',
            'parameters'  => array(
                'masterKey' => array(
                    'location'    => 'header',
                    'description' => 'The Master API Key.',
                    'sentAs'      => 'Authorization',
                    'pattern'     => '/^([[:alnum:]])+$/',
                    'type'        => 'string',
                    'required'    => true,
                ),
            ),
        ),

        'getEventSchemas' => array(
            'uri'         => 'projects/{projectId}/events',
            'description' => 'GET returns schema information for all the event collections in this project, including properties and their type. It also returns links to sub-resources.',
            'httpMethod'  => 'GET',
            'parameters'  => array(
                'masterKey' => array(
                    'location'    => 'header',
                    'description' => 'The Master API Key.',
                    'sentAs'      => 'Authorization',
                    'pattern'     => '/^([[:alnum:]])+$/',
                    'type'        => 'string',
                    'required'    => true,
                ),
            ),
        ),

        'addEvent' => array(
            'uri'         => 'projects/{projectId}/events/{event_collection}',
            'description' => 'POST inserts an event into the specified collection.',
            'httpMethod'  => 'POST',
            'parameters'  => array(
                'writeKey'         => array(
                    'location'    => 'header',
                    'description' => 'The Write Key for the project.',
                    'sentAs'      => 'Authorization',
                    'pattern'     => '/^([[:alnum:]])+$/',
                    'type'        => 'string',
                    'required'    => false,
                ),
                'masterKey'        => array(
                    'location'    => 'header',
                    'description' => 'The Master Api Key',
                    'sentAs'      => 'Authorization',
                    'pattern'     => '/^([[:alnum:]])+$/',
                    'type'        => 'string',
                    'required'    => false,
                ),
                'event_collection' => array(
                    'location'    => 'uri',
                    'description' => 'The event collection.',
                    'required'    => true,
                ),
                'event_data'       => array(
                    'location' => 'body',
                    'type'     => 'array',
                    'filters'  => array('json_encode'),
                ),
            ),
        ),

        'addEvents' => array(
            'uri'         => 'projects/{projectId}/events',
            'description' => 'POST inserts multiple events in one or more collections, in a single request. The API expects a JSON object whose keys are the names of each event collection you want to insert into. Each key should point to a list of events to insert for that event collection.',
            'httpMethod'  => 'POST',
            'parameters'  => array(
                'writeKey'  => array(
                    'location'    => 'header',
                    'description' => 'The Write Key for the project.',
                    'sentAs'      => 'Authorization',
                    'pattern'     => '/^([[:alnum:]])+$/',
                    'type'        => 'string',
                    'required'    => false,
                ),
                'masterKey' => array(
                    'location'    => 'header',
                    'description' => 'The Master Api Key',
                    'sentAs'      => 'Authorization',
                    'pattern'     => '/^([[:alnum:]])+$/',
                    'type'        => 'string',
                    'required'    => false,
                ),
                'event_data' => array(
                    'location' => 'body',
                    'type'     => 'array',
                    'filters'  => array('json_encode'),
                ),
            ),
        ),

        'deleteEvents' => array(
            'uri'         => 'projects/{projectId}/events/{event_collection}',
            'description' => 'DELETE one or multiple events from a collection. You can optionally add filters, timeframe or timezone. You can delete up to 50,000 events using one method call',
            'httpMethod'  => 'DELETE',
            'parameters'  => array(
                'masterKey'        => array(
                    'location'    => 'header',
                    'description' => 'The Master API key.',
                    'sentAs'      => 'Authorization',
                    'pattern'     => '/^([[:alnum:]])+$/',
                    'type'        => 'string',
                    'required'    => true,
                ),
                'event_collection' => array(
                    'location'    => 'uri',
                    'description' => 'The event collection.',
                    'required'    => true,
                ),
                'filters'          => array(
                    'location'    => 'query',
                    'description' => 'Filters are used to narrow down the events used in an analysis request based on event property values.',
                    'type'        => 'array',
                    'filters'     => array('json_encode'),
                    'required'    => false,
                ),
                'timeframe'        => array(
                    'location'    => 'query',
                    'description' => 'A Timeframe specifies the events to use for analysis based on a window of time. If no timeframe is specified, all events will be counted.',
                    'type'        => array('string', 'array'),
                    'filters'     => array(
                        array(
                            'method' => 'KeenIO\Client\Filter\MultiTypeFiltering::encodeValue',
                            'args'   => ['@value']
                        )
                    ),
                    'required'    => false,
                ),
                'timezone'         => array(
                    'location'    => 'query',
                    'description' => 'Modifies the timeframe filters for Relative Timeframes to match a specific timezone.',
                    'type'        => 'number',
                    'required'    => false,
                ),
            ),
        ),

        'deleteEventProperties' => array(
            'uri'         => 'projects/{projectId}/events/{event_collection}/properties/{property_name}',
            'description' => 'DELETE one property for events. This only work for properties with less than 10,000 events.',
            'httpMethod'  => 'DELETE',
            'parameters'  => array(
                'writeKey'         => array(
                    'location'    => 'header',
                    'description' => 'The Write Key for the project.',
                    'sentAs'      => 'Authorization',
                    'pattern'     => '/^([[:alnum:]])+$/',
                    'type'        => 'string',
                    'required'    => false,
                ),
                'masterKey'        => array(
                    'location'    => 'header',
                    'description' => 'The Master Api Key',
                    'sentAs'      => 'Authorization',
                    'pattern'     => '/^([[:alnum:]])+$/',
                    'type'        => 'string',
                    'required'    => false,
                ),
                'event_collection' => array(
                    'location'    => 'uri',
                    'description' => 'The event collection.',
                    'required'    => true,
                ),
                'property_name'    => array(
                    'location'    => 'query',
                    'description' => 'Name of the property to delete.',
                    'type'        => 'string',
                    'required'    => true,
                ),
            ),
        ),

        'count' => array(
            'uri'         => 'projects/{projectId}/queries/count',
            'description' => 'GET returns the number of resources in the event collection matching the given criteria. The response will be a simple JSON object with one key: a numeric result.',
            'httpMethod'  => 'GET',
            'parameters'  => array(
                'readKey'          => array(
                    'location'    => 'header',
                    'description' => 'The Read Key for the project.',
                    'sentAs'      => 'Authorization',
                    'pattern'     => '/^([[:alnum:]])+$/',
                    'type'        => 'string',
                    'required'    => false,
                ),
                'masterKey'        => array(
                    'location'    => 'header',
                    'description' => 'The Master Api Key',
                    'sentAs'      => 'Authorization',
                    'pattern'     => '/^([[:alnum:]])+$/',
                    'type'        => 'string',
                    'required'    => false,
                ),
                'event_collection' => array(
                    'location'    => 'query',
                    'description' => 'The name of the event collection you are analyzing.',
                    'type'        => 'string',
                    'required'    => true,
                ),
                'filters'          => array(
                    'location'    => 'query',
                    'description' => 'Filters are used to narrow down the events used in an analysis request based on event property values.',
                    'type'        => 'array',
                    'filters'     => array('json_encode'),
                    'required'    => false,
                ),
                'timeframe'        => array(
                    'location'    => 'query',
                    'description' => 'A Timeframe specifies the events to use for analysis based on a window of time. If no timeframe is specified, all events will be counted.',
                    'type'        => array('string', 'array'),
                    'filters'     => array(
                        array(
                            'method' => 'KeenIO\Client\Filter\MultiTypeFiltering::encodeValue',
                            'args'   => ['@value']
                        )
                    ),
                    'required'    => false,
                ),
                'interval'         => array(
                    'location'    => 'query',
                    'description' => 'Intervals are used when creating a Series API call. The interval specifies the length of each sub-timeframe in a Series.',
                    'type'        => 'string',
                    'required'    => false,
                ),
                'timezone'         => array(
                    'location'    => 'query',
                    'description' => 'Modifies the timeframe filters for Relative Timeframes to match a specific timezone.',
                    'type'        => 'number',
                    'required'    => false,
                ),
                'group_by'         => array(
                    'location'    => 'query',
                    'description' => 'The group_by parameter specifies the name of a property by which you would like to group the results.',
                    'type'        => array('string', 'array'),
                    'filters'     => array(
                        array(
                            'method' => 'KeenIO\Client\Filter\MultiTypeFiltering::encodeValue',
                            'args'   => ['@value']
                        )
                    ),
                    'required'    => false,
                ),
            ),
        ),

        'countUnique' => array(
            'uri'         => 'projects/{projectId}/queries/count_unique',
            'description' => 'GET returns the number of UNIQUE resources in the event collection matching the given criteria. The response will be a simple JSON object with one key: result, which maps to the numeric result described previously.',
            'httpMethod'  => 'GET',
            'parameters'  => array(
                'readKey'          => array(
                    'location'    => 'header',
                    'description' => 'The Read Key for the project.',
                    'sentAs'      => 'Authorization',
                    'pattern'     => '/^([[:alnum:]])+$/',
                    'type'        => 'string',
                    'required'    => false,
                ),
                'masterKey'        => array(
                    'location'    => 'header',
                    'description' => 'The Master Api Key',
                    'sentAs'      => 'Authorization',
                    'pattern'     => '/^([[:alnum:]])+$/',
                    'type'        => 'string',
                    'required'    => false,
                ),
                'event_collection' => array(
                    'location'    => 'query',
                    'description' => 'The name of the event collection you are analyzing.',
                    'type'        => 'string',
                    'required'    => true,
                ),
                'target_property'  => array(
                    'location'    => 'query',
                    'description' => 'The name of the property you are analyzing.',
                    'type'        => 'string',
                    'required'    => true,
                ),
                'filters'          => array(
                    'location'    => 'query',
                    'description' => 'Filters are used to narrow down the events used in an analysis request based on event property values.',
                    'type'        => 'array',
                    'filters'     => array('json_encode'),
                    'required'    => false,
                ),
                'timeframe'        => array(
                    'location'    => 'query',
                    'description' => 'A Timeframe specifies the events to use for analysis based on a window of time. If no timeframe is specified, all events will be counted.',
                    'type'        => array('string', 'array'),
                    'filters'     => array(
                        array(
                            'method' => 'KeenIO\Client\Filter\MultiTypeFiltering::encodeValue',
                            'args'   => ['@value']
                        )
                    ),
                    'required'    => false,
                ),
                'interval'         => array(
                    'location'    => 'query',
                    'description' => 'Intervals are used when creating a Series API call. The interval specifies the length of each sub-timeframe in a Series.',
                    'type'        => 'string',
                    'required'    => false,
                ),
                'timezone'         => array(
                    'location'    => 'query',
                    'description' => 'Modifies the timeframe filters for Relative Timeframes to match a specific timezone.',
                    'type'        => 'number',
                    'required'    => false,
                ),
                'group_by'         => array(
                    'location'    => 'query',
                    'description' => 'The group_by parameter specifies the name of a property by which you would like to group the results.',
                    'type'        => array('string', 'array'),
                    'filters'     => array(
                        array(
                            'method' => 'KeenIO\Client\Filter\MultiTypeFiltering::encodeValue',
                            'args'   => ['@value']
                        )
                    ),
                    'required'    => false,
                ),
            ),
        ),

        'minimum' => array(
            'uri'         => 'projects/{projectId}/queries/minimum',
            'description' => 'GET returns the minimum numeric value for the target property in the event collection matching the given criteria. Non-numeric values are ignored. The response will be a simple JSON object with one key: result, which maps to the numeric result described previously.',
            'httpMethod'  => 'GET',
            'parameters'  => array(
                'readKey'          => array(
                    'location'    => 'header',
                    'description' => 'The Read Key for the project.',
                    'sentAs'      => 'Authorization',
                    'pattern'     => '/^([[:alnum:]])+$/',
                    'type'        => 'string',
                    'required'    => false,
                ),
                'masterKey'        => array(
                    'location'    => 'header',
                    'description' => 'The Master Api Key',
                    'sentAs'      => 'Authorization',
                    'pattern'     => '/^([[:alnum:]])+$/',
                    'type'        => 'string',
                    'required'    => false,
                ),
                'event_collection' => array(
                    'location'    => 'query',
                    'description' => 'The name of the event collection you are analyzing.',
                    'type'        => 'string',
                    'required'    => true,
                ),
                'target_property'  => array(
                    'location'    => 'query',
                    'description' => 'The name of the property you are analyzing.',
                    'type'        => 'string',
                    'required'    => true,
                ),
                'filters'          => array(
                    'location'    => 'query',
                    'description' => 'Filters are used to narrow down the events used in an analysis request based on event property values.',
                    'type'        => 'array',
                    'filters'     => array('json_encode'),
                    'required'    => false,
                ),
                'timeframe'        => array(
                    'location'    => 'query',
                    'description' => 'A Timeframe specifies the events to use for analysis based on a window of time. If no timeframe is specified, all events will be counted.',
                    'type'        => array('string', 'array'),
                    'filters'     => array(
                        array(
                            'method' => 'KeenIO\Client\Filter\MultiTypeFiltering::encodeValue',
                            'args'   => ['@value']
                        )
                    ),
                    'required'    => false,
                ),
                'interval'         => array(
                    'location'    => 'query',
                    'description' => 'Intervals are used when creating a Series API call. The interval specifies the length of each sub-timeframe in a Series.',
                    'type'        => 'string',
                    'required'    => false,
                ),
                'timezone'         => array(
                    'location'    => 'query',
                    'description' => 'Modifies the timeframe filters for Relative Timeframes to match a specific timezone.',
                    'type'        => 'number',
                    'required'    => false,
                ),
                'group_by'         => array(
                    'location'    => 'query',
                    'description' => 'The group_by parameter specifies the name of a property by which you would like to group the results.',
                    'type'        => array('string', 'array'),
                    'filters'     => array(
                        array(
                            'method' => 'KeenIO\Client\Filter\MultiTypeFiltering::encodeValue',
                            'args'   => ['@value']
                        )
                    ),
                    'required'    => false,
                ),
            ),
        ),

        'maximum' => array(
            'uri'         => 'projects/{projectId}/queries/maximum',
            'description' => 'GET returns the maximum numeric value for the target property in the event collection matching the given criteria. Non-numeric values are ignored. The response will be a simple JSON object with one key: result, which maps to the numeric result described previously.',
            'httpMethod'  => 'GET',
            'parameters'  => array(
                'readKey'          => array(
                    'location'    => 'header',
                    'description' => 'The Read Key for the project.',
                    'sentAs'      => 'Authorization',
                    'pattern'     => '/^([[:alnum:]])+$/',
                    'type'        => 'string',
                    'required'    => false,
                ),
                'masterKey'        => array(
                    'location'    => 'header',
                    'description' => 'The Master Api Key',
                    'sentAs'      => 'Authorization',
                    'pattern'     => '/^([[:alnum:]])+$/',
                    'type'        => 'string',
                    'required'    => false,
                ),
                'event_collection' => array(
                    'location'    => 'query',
                    'description' => 'The name of the event collection you are analyzing.',
                    'type'        => 'string',
                    'required'    => true,
                ),
                'target_property'  => array(
                    'location'    => 'query',
                    'description' => 'The name of the property you are analyzing.',
                    'type'        => 'string',
                    'required'    => true,
                ),
                'filters'          => array(
                    'location'    => 'query',
                    'description' => 'Filters are used to narrow down the events used in an analysis request based on event property values.',
                    'type'        => 'array',
                    'filters'     => array('json_encode'),
                    'required'    => false,
                ),
                'timeframe'        => array(
                    'location'    => 'query',
                    'description' => 'A Timeframe specifies the events to use for analysis based on a window of time. If no timeframe is specified, all events will be counted.',
                    'type'        => array('string', 'array'),
                    'filters'     => array(
                        array(
                            'method' => 'KeenIO\Client\Filter\MultiTypeFiltering::encodeValue',
                            'args'   => ['@value']
                        )
                    ),
                    'required'    => false,
                ),
                'interval'         => array(
                    'location'    => 'query',
                    'description' => 'Intervals are used when creating a Series API call. The interval specifies the length of each sub-timeframe in a Series.',
                    'type'        => 'string',
                    'required'    => false,
                ),
                'timezone'         => array(
                    'location'    => 'query',
                    'description' => 'Modifies the timeframe filters for Relative Timeframes to match a specific timezone.',
                    'type'        => 'number',
                    'required'    => false,
                ),
                'group_by'         => array(
                    'location'    => 'query',
                    'description' => 'The group_by parameter specifies the name of a property by which you would like to group the results.',
                    'type'        => array('string', 'array'),
                    'filters'     => array(
                        array(
                            'method' => 'KeenIO\Client\Filter\MultiTypeFiltering::encodeValue',
                            'args'   => ['@value']
                        )
                    ),
                    'required'    => false,
                ),
            ),
        ),

        'average' => array(
            'uri'         => 'projects/{projectId}/queries/average',
            'description' => 'GET returns the average across all numeric values for the target property in the event collection matching the given criteria. Non-numeric values are ignored. The response will be a simple JSON object with one key: result, which maps to the numeric result described previously.',
            'httpMethod'  => 'GET',
            'parameters'  => array(
                'readKey'          => array(
                    'location'    => 'header',
                    'description' => 'The Read Key for the project.',
                    'sentAs'      => 'Authorization',
                    'pattern'     => '/^([[:alnum:]])+$/',
                    'type'        => 'string',
                    'required'    => false,
                ),
                'masterKey'        => array(
                    'location'    => 'header',
                    'description' => 'The Master Api Key',
                    'sentAs'      => 'Authorization',
                    'pattern'     => '/^([[:alnum:]])+$/',
                    'type'        => 'string',
                    'required'    => false,
                ),
                'event_collection' => array(
                    'location'    => 'query',
                    'description' => 'The name of the event collection you are analyzing.',
                    'type'        => 'string',
                    'required'    => true,
                ),
                'target_property'  => array(
                    'location'    => 'query',
                    'description' => 'The name of the property you are analyzing.',
                    'type'        => 'string',
                    'required'    => true,
                ),
                'filters'          => array(
                    'location'    => 'query',
                    'description' => 'Filters are used to narrow down the events used in an analysis request based on event property values.',
                    'type'        => 'array',
                    'filters'     => array('json_encode'),
                    'required'    => false,
                ),
                'timeframe'        => array(
                    'location'    => 'query',
                    'description' => 'A Timeframe specifies the events to use for analysis based on a window of time. If no timeframe is specified, all events will be counted.',
                    'type'        => array('string', 'array'),
                    'filters'     => array(
                        array(
                            'method' => 'KeenIO\Client\Filter\MultiTypeFiltering::encodeValue',
                            'args'   => ['@value']
                        )
                    ),
                    'required'    => false,
                ),
                'interval'         => array(
                    'location'    => 'query',
                    'description' => 'Intervals are used when creating a Series API call. The interval specifies the length of each sub-timeframe in a Series.',
                    'type'        => 'string',
                    'required'    => false,
                ),
                'timezone'         => array(
                    'location'    => 'query',
                    'description' => 'Modifies the timeframe filters for Relative Timeframes to match a specific timezone.',
                    'type'        => 'number',
                    'required'    => false,
                ),
                'group_by'         => array(
                    'location'    => 'query',
                    'description' => 'The group_by parameter specifies the name of a property by which you would like to group the results.',
                    'type'        => array('string', 'array'),
                    'filters'     => array(
                        array(
                            'method' => 'KeenIO\Client\Filter\MultiTypeFiltering::encodeValue',
                            'args'   => ['@value']
                        )
                    ),
                    'required'    => false,
                ),
            ),
        ),

        'sum' => array(
            'uri'         => 'projects/{projectId}/queries/sum',
            'description' => 'GET returns the sum if all numeric values for the target property in the event collection matching the given criteria. Non-numeric values are ignored. The response will be a simple JSON object with one key: result, which maps to the numeric result described previously.',
            'httpMethod'  => 'GET',
            'parameters'  => array(
                'readKey'          => array(
                    'location'    => 'header',
                    'description' => 'The Read Key for the project.',
                    'sentAs'      => 'Authorization',
                    'pattern'     => '/^([[:alnum:]])+$/',
                    'type'        => 'string',
                    'required'    => false,
                ),
                'masterKey'        => array(
                    'location'    => 'header',
                    'description' => 'The Master Api Key',
                    'sentAs'      => 'Authorization',
                    'pattern'     => '/^([[:alnum:]])+$/',
                    'type'        => 'string',
                    'required'    => false,
                ),
                'event_collection' => array(
                    'location'    => 'query',
                    'description' => 'The name of the event collection you are analyzing.',
                    'type'        => 'string',
                    'required'    => true,
                ),
                'target_property'  => array(
                    'location'    => 'query',
                    'description' => 'The name of the property you are analyzing.',
                    'type'        => 'string',
                    'required'    => true,
                ),
                'filters'          => array(
                    'location'    => 'query',
                    'description' => 'Filters are used to narrow down the events used in an analysis request based on event property values.',
                    'type'        => 'array',
                    'filters'     => array('json_encode'),
                    'required'    => false,
                ),
                'timeframe'        => array(
                    'location'    => 'query',
                    'description' => 'A Timeframe specifies the events to use for analysis based on a window of time. If no timeframe is specified, all events will be counted.',
                    'type'        => array('string', 'array'),
                    'filters'     => array(
                        array(
                            'method' => 'KeenIO\Client\Filter\MultiTypeFiltering::encodeValue',
                            'args'   => ['@value']
                        )
                    ),
                    'required'    => false,
                ),
                'interval'         => array(
                    'location'    => 'query',
                    'description' => 'Intervals are used when creating a Series API call. The interval specifies the length of each sub-timeframe in a Series.',
                    'type'        => 'string',
                    'required'    => false,
                ),
                'timezone'         => array(
                    'location'    => 'query',
                    'description' => 'Modifies the timeframe filters for Relative Timeframes to match a specific timezone.',
                    'type'        => 'number',
                    'required'    => false,
                ),
                'group_by'         => array(
                    'location'    => 'query',
                    'description' => 'The group_by parameter specifies the name of a property by which you would like to group the results.',
                    'type'        => array('string', 'array'),
                    'filters'     => array(
                        array(
                            'method' => 'KeenIO\Client\Filter\MultiTypeFiltering::encodeValue',
                            'args'   => ['@value']
                        )
                    ),
                    'required'    => false,
                ),
            ),
        ),

        'selectUnique' => array(
            'uri'         => 'projects/{projectId}/queries/select_unique',
            'description' => 'GET returns a list of UNIQUE resources in the event collection matching the given criteria. The response will be a simple JSON object with one key: result, which maps to an array of unique property values.',
            'httpMethod'  => 'GET',
            'parameters'  => array(
                'readKey'          => array(
                    'location'    => 'header',
                    'description' => 'The Read Key for the project.',
                    'sentAs'      => 'Authorization',
                    'pattern'     => '/^([[:alnum:]])+$/',
                    'type'        => 'string',
                    'required'    => false,
                ),
                'masterKey'        => array(
                    'location'    => 'header',
                    'description' => 'The Master Api Key',
                    'sentAs'      => 'Authorization',
                    'pattern'     => '/^([[:alnum:]])+$/',
                    'type'        => 'string',
                    'required'    => false,
                ),
                'event_collection' => array(
                    'location'    => 'query',
                    'description' => 'The name of the event collection you are analyzing.',
                    'type'        => 'string',
                    'required'    => true,
                ),
                'target_property'  => array(
                    'location'    => 'query',
                    'description' => 'The name of the property you are analyzing.',
                    'type'        => 'string',
                    'required'    => true,
                ),
                'filters'          => array(
                    'location'    => 'query',
                    'description' => 'Filters are used to narrow down the events used in an analysis request based on event property values.',
                    'type'        => 'array',
                    'filters'     => array('json_encode'),
                    'required'    => false,
                ),
                'timeframe'        => array(
                    'location'    => 'query',
                    'description' => 'A Timeframe specifies the events to use for analysis based on a window of time. If no timeframe is specified, all events will be counted.',
                    'type'        => array('string', 'array'),
                    'filters'     => array(
                        array(
                            'method' => 'KeenIO\Client\Filter\MultiTypeFiltering::encodeValue',
                            'args'   => ['@value']
                        )
                    ),
                    'required'    => false,
                ),
                'interval'         => array(
                    'location'    => 'query',
                    'description' => 'Intervals are used when creating a Series API call. The interval specifies the length of each sub-timeframe in a Series.',
                    'type'        => 'string',
                    'required'    => false,
                ),
                'timezone'         => array(
                    'location'    => 'query',
                    'description' => 'Modifies the timeframe filters for Relative Timeframes to match a specific timezone.',
                    'type'        => 'number',
                    'required'    => false,
                ),
                'group_by'         => array(
                    'location'    => 'query',
                    'description' => 'The group_by parameter specifies the name of a property by which you would like to group the results.',
                    'type'        => array('string', 'array'),
                    'filters'     => array(
                        array(
                            'method' => 'KeenIO\Client\Filter\MultiTypeFiltering::encodeValue',
                            'args'   => ['@value']
                        )
                    ),
                    'required'    => false,
                ),
            ),
        ),

        'funnel' => array(
            'uri'         => 'projects/{projectId}/queries/funnel',
            'description' => 'Funnels count relevant events in succession.',
            'httpMethod'  => 'GET',
            'parameters'  => array(
                'readKey'   => array(
                    'location'    => 'header',
                    'description' => 'The Read Key for the project.',
                    'sentAs'      => 'Authorization',
                    'pattern'     => '/^([[:alnum:]])+$/',
                    'type'        => 'string',
                    'required'    => false,
                ),
                'masterKey' => array(
                    'location'    => 'header',
                    'description' => 'The Master Api Key',
                    'sentAs'      => 'Authorization',
                    'pattern'     => '/^([[:alnum:]])+$/',
                    'type'        => 'string',
                    'required'    => false,
                ),
                'steps'     => array(
                    'location'    => 'query',
                    'description' => 'A URL encoded JSON Array defining the Steps in the Funnel.',
                    'type'        => 'array',
                    'filters'     => array('json_encode'),
                    'required'    => false,
                ),
            ),
        ),

        'multiAnalysis' => array(
            'uri'         => 'projects/{projectId}/queries/multi_analysis',
            'description' => 'Multi-analysis lets you run multiple types of analysis over the same data. Performing a multi-analysis call is very similar to a Metric or a Series.',
            'httpMethod'  => 'GET',
            'parameters'  => array(
                'readKey'          => array(
                    'location'    => 'header',
                    'description' => 'The Read Key for the project.',
                    'sentAs'      => 'Authorization',
                    'pattern'     => '/^([[:alnum:]])+$/',
                    'type'        => 'string',
                    'required'    => false,
                ),
                'masterKey'        => array(
                    'location'    => 'header',
                    'description' => 'The Master Api Key',
                    'sentAs'      => 'Authorization',
                    'pattern'     => '/^([[:alnum:]])+$/',
                    'type'        => 'string',
                    'required'    => false,
                ),
                'event_collection' => array(
                    'location'    => 'query',
                    'description' => 'The name of the event collection you are analyzing.',
                    'type'        => 'string',
                    'required'    => true,
                ),
                'analyses'         => array(
                    'location'    => 'query',
                    'description' => 'A URL encoded JSON object that defines the multiple types of analyses to perform.',
                    'type'        => 'array',
                    'filters'     => array('json_encode'),
                    'required'    => true,
                ),
                'filters'          => array(
                    'location'    => 'query',
                    'description' => 'Filters are used to narrow down the events used in an analysis request based on event property values.',
                    'type'        => 'array',
                    'filters'     => array('json_encode'),
                    'required'    => false,
                ),
                'timeframe'        => array(
                    'location'    => 'query',
                    'description' => 'A Timeframe specifies the events to use for analysis based on a window of time. If no timeframe is specified, all events will be counted.',
                    'type'        => array('string', 'array'),
                    'filters'     => array(
                        array(
                            'method' => 'KeenIO\Client\Filter\MultiTypeFiltering::encodeValue',
                            'args'   => ['@value']
                        )
                    ),
                    'required'    => false,
                ),
                'interval'         => array(
                    'location'    => 'query',
                    'description' => 'Intervals are used when creating a Series API call. The interval specifies the length of each sub-timeframe in a Series.',
                    'type'        => 'string',
                    'required'    => false,
                ),
                'timezone'         => array(
                    'location'    => 'query',
                    'description' => 'Modifies the timeframe filters for Relative Timeframes to match a specific timezone.',
                    'type'        => 'number',
                    'required'    => false,
                ),
                'group_by'         => array(
                    'location'    => 'query',
                    'description' => 'The group_by parameter specifies the name of a property by which you would like to group the results.',
                    'type'        => array('string', 'array'),
                    'filters'     => array(
                        array(
                            'method' => 'KeenIO\Client\Filter\MultiTypeFiltering::encodeValue',
                            'args'   => ['@value']
                        )
                    ),
                    'required'    => false,
                ),
            ),
        ),

        'extraction' => array(
            'uri'         => 'projects/{projectId}/queries/extraction',
            'description' => 'GET creates an extraction request for full-form event data with all property values. If the query string parameter email is specified, then the extraction will be processed asynchronously and an e-mail will be sent to the specified address when it completes. The email will include a link to a downloadable CSV file. If email is omitted, then the extraction will be processed in-line and JSON results will be returned in the GET request.',
            'httpMethod'  => 'GET',
            'parameters'  => array(
                'readKey'          => array(
                    'location'    => 'header',
                    'description' => 'The Read Key for the project.',
                    'sentAs'      => 'Authorization',
                    'pattern'     => '/^([[:alnum:]])+$/',
                    'type'        => 'string',
                    'required'    => false,
                ),
                'masterKey'        => array(
                    'location'    => 'header',
                    'description' => 'The Master Api Key',
                    'sentAs'      => 'Authorization',
                    'pattern'     => '/^([[:alnum:]])+$/',
                    'type'        => 'string',
                    'required'    => false,
                ),
                'event_collection' => array(
                    'location'    => 'query',
                    'description' => 'The name of the event collection you are analyzing.',
                    'type'        => 'string',
                    'required'    => true,
                ),
                'filters'          => array(
                    'location'    => 'query',
                    'description' => 'Filters are used to narrow down the events used in an analysis request based on event property values.',
                    'type'        => 'array',
                    'filters'     => array('json_encode'),
                    'required'    => false,
                ),
                'timeframe'        => array(
                    'location'    => 'query',
                    'description' => 'A Timeframe specifies the events to use for analysis based on a window of time. If no timeframe is specified, all events will be counted.',
                    'type'        => array('string', 'array'),
                    'filters'     => array(
                        array(
                            'method' => 'KeenIO\Client\Filter\MultiTypeFiltering::encodeValue',
                            'args'   => ['@value']
                        )
                    ),
                    'required'    => false,
                ),
                'email'            => array(
                    'location'    => 'query',
                    'description' => 'Email that will be notified when your extraction is ready for download.',
                    'type'        => 'string',
                    'required'    => false,
                ),
                'latest'           => array(
                    'location'    => 'query',
                    'description' => 'Use this parameter to specifically request the most recent events added to a given collection. Extract up to 100 of your most recent events.',
                    'type'        => 'integer',
                    'required'    => false,
                ),
            ),
        ),
    ),
);
