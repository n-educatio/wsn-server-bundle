WebSocket Notification Server Bundle
==========
![alt travis](https://travis-ci.org/n-educatio/wsn-server-bundle.svg?branch=master)

Integration of [wsn-server](https://github.com/n-educatio/wsn-server) into Symfony2 framework. It provides a service that pushes messages into  wsn-server.

### Requirements
Check out requirements section of [wsn-server](https://github.com/n-educatio/wsn-server)


### Installation

Require it via composer:
```
{
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/n-educatio/wsn-server-bundle.git"
    }
  ],
  "require": {
    "neducatio/wsn-server-bundle": "dev-master"
  }
}
```

Add bundle to AppKernel.php
```
  $bundles = array(
    // ...
    new Neducatio\WebSocketNotificationBundle\NeducatioWebSocketNotificationBundle(),
    // ...
  );
```

### Configuration
```
neducatio_web_socket_notification:
    parameters:
        host: 127.0.0.1
        port: 5556
        websocket-port: 8080

    services:
        logger:
            class: Neducatio\WebSocketNotification\Common\Logger
```

Check out configuration section of [wsn-server](https://github.com/n-educatio/wsn-server) 


### Usage

##### Starting server
```
app/console neducatio:wsn-server:run
```

##### Pushing
```
$container->get()->push($channel, $data);
```
**$chanel** is a string that holds channel's (topic's) name, **$data** is everyting that can be serialized to JSON (via json_encode).
