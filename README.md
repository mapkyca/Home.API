Home.API: An Extensible API for your House
==========================================

Modern homes contain an ever increasing number of inputs and outputs - smart electricity & water meters, Current Cost monitors, WeMo sockets and a whole Smörgåsbord of X10 enabled gizmos and homebrew Raspberry Pi hardware hacks.

Wouldn't it be cool if you could control all of these from a central place? Wouldn't it be cool if you could simple expose a common API for all of these devices and talk to them using standard web technologies, lowering the bar to writing cool applications?

I think so! :)

What is it
----------

Home.API is a simple and easily extendable pluggable api, which lets you simply connect all your domotic devices together and expose their functionality through a common API. It is designed with an eye on simplicity and extensibility.

Pre-requisites
--------------

 * Apache2 with ModRewrite enabled
 * PHP 5.3+
 * CouchDB 

Installation
------------

 * Git checkout the repo on to your house server/network connected Raspberry Pi/Whatever
 * Rename htaccess_dist to .htaccess, after making the appropriate modifications (which amounts to setting the RewriteBase correctly if you're running in a subdirectory on your server)
 * Make any modifications to config/settings.php that you need, although the defaults are usually good. If you're installing to a sub directory you might have to change $CONFIG->wwwroot
 * Define your api in the various endpoint definition .conf files in dev/

Format of an endpoint definition file
-------------------------------------

You define your API by writing one or more .conf definition files which attach the various classes to an endpoint, laying out a logical hierarchy and making their public methods callable. 

A definition gives a number of starting parameters (which are passed to the class' constructor).

It is important to note that a class can be attached multiple times to different endpoints, and can contain different starting parameters (handy if you have multiples of the same devices).

Take the following hypothetical example:

```
/bedroom/light
    class \x10\DimmerLight 
    minvalue 0
    maxvalue 50
    deviceIP 192.168.0.45

/hallway/light
    class \x10\DimmerLight 
    minvalue 0
    maxvalue 100
    deviceIP 192.168.0.46
```

This defines two endpoint definitions (each separated by one or more blank lines) which define two endpoints containing a DimmerLight X10 device. In this case, I've opted to not allow the bedroom light be set above 50%.

Each of these endpoints can act independently, and in our example you might be able to execute commands like:

```
http://home.local/api/bedroom/light/currentLevel.json
```

or

```
http://home.local/api/bedroom/light/setting.json?level=20
```

or

```
http://home.local/api/hallway/light/off.json
```

Format of a plugin
------------------

 * Plugins should be put in /plugins/ in a directory structure matching the class' namespace
 * All plugins must extend \home_api\plugins\Plugin, but don't have to sit in that namespace
 * All plugins classes should be in /plugins/my/class/namespace/MyClass/start.php (see the Example plugin for an example)
 * Public methods in the class are exposed automatically, Home.API uses reflection to determine required parameters and any default values. Again, see the Example plugin.

The Dashboard
-------------

Out of the box, Home.API comes with a simple dashboard which lists all the endpoints you have defined in your config. the default plugin template will list all the exposed api calls, and allow you to call them manually. This is primarily aimed as an illustration and dev tool, but it would be a simple matter to skin this to be something far more fancy.

Licence & Copyright
-------------------

Unless stated otherwise, Home.API is (C) Marcus Povey 2013.

It is made available under the MIT licence, other licences are available
on request.

3rd Party Projects
------------------

 * Twitter Bootstrap, distributed under the Apache 2.0 license. <https://github.com/twitter/bootstrap>
 * jQuery, distributed under the MIT License. Source: https://github.com/jquery/jquery
