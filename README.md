Hue PHP Toolkit
=====================

* Author: Thorne Melcher (GitHub: ExistentialEnso)
* License: LGPL v3 (more permissive commercial licensing available for a fee on request)
* Version: 0.2.1

Toolkit to make working with the Philips Hue light system easier in PHP, featuring a heavily object-oriented design
with a focus on code readability.

To dive in, all you need to do is pass the the bridges IP address and an admin username to the constructor for Bridge.
If you have not setup a user account with your bridge, refer to the "Getting Started" part of Philips' API guide.

```
   $bridge = new \hue\models\Bridge("192.168.1.99", "admin");
```

Which allows you to easily manipulate your lights via PHP. For instance, you can turn off all of your lights with just
one simple line:

```
  $bridge->setAllOff();
```

Or you can turn them all on to basic white at full brightness using the default state:

```
   $state = new \hue\models\State();
   $bridge->setAllToState($state);
```

States using our toolkit can even be setup by passing a color name!
( **Note**: grays and cyans are not well supported by Hue -- even in the official app.)

```
   $state->setNamedColor("dark red"); // Red at low brightness
```

Hexcodes too!

```
    $ state->setHexCode("#550000"); // Also red at low brightness
```

### Version History

#### v0.2.1 (Released 8/14/13)
* Added TEMP_ convenience constants to LightState to represent three common temps of consumer light bulbs, as well as the max/min supported by the API.
* Added getColorTemperatureK() and setColorTemperatureK() as alternatives for those who want to work in Kelvin instead of mired
* Fixed some minor bugs.

#### v0.2 (Released 8/14/13)
* Added ->setHexCode() to LightState which approximates a light color from an HTML/CSS hex code (e.g. #FF0000)
* Added ->setNamedColor() to LightState which sets the lights to any of the standard 141 web named colors (some work better than others)
* Fixed some minor bugs.